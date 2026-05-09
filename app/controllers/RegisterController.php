<?php

session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/mailer.php';

class RegisterController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../config/database.php';
        $this->pdo = $pdo;
    }

    // ============================================================
    //  ROUTER
    // ============================================================
    public function handle(string $action): void
    {
        

        switch ($action) {
            case 'register':     $this->register();     break;
            case 'verify_email': $this->verifyEmail();  break;
            
            default:
                $this->json(['success' => false, 'message' => 'Action invalide.'], 400);
        }
    }

    // ============================================================
    //  ACTION : register
    // ============================================================
    private function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.'], 405);
        }

        // --- Récupération et sanitisation ---
        $schoolName   = $this->sanitize($_POST['school_name']    ?? '');
        $schoolSub    = $this->sanitize($_POST['school_subtype']  ?? $_POST['school_sub_type'] ?? '');
        $schoolEmail  = $this->sanitize($_POST['school_email']   ?? '');
        $schoolPhone  = $this->sanitize($_POST['school_phone']   ?? '');
        $schoolAddr   = $this->sanitize($_POST['school_address'] ?? '');
        $adminName    = $this->sanitize($_POST['admin_full_name'] ?? $_POST['admin_name'] ?? '');
        $adminEmail   = $this->sanitize($_POST['admin_email']    ?? '');
        $password     = $_POST['password']         ?? '';
        $passwordConf = $_POST['password_confirm'] ?? '';

        // --- Validations ---
        $errors = [];

        if (empty($schoolName)) {
            $errors['school_name'] = 'Le nom de l\'établissement est requis.';
        }

        if (empty($schoolSub)) {
            $errors['school_subtype'] = 'Veuillez indiquer si l\'établissement est public ou privé.';
        } elseif (!in_array($schoolSub, ['public', 'prive'], true)) {
            $errors['school_subtype'] = 'Sous-type invalide (public ou privé).';
        }

        if (empty($schoolEmail)) {
            $errors['school_email'] = 'L\'email de l\'établissement est requis.';
        } elseif (!filter_var($schoolEmail, FILTER_VALIDATE_EMAIL)) {
            $errors['school_email'] = 'Email de l\'établissement invalide.';
        }

        if (empty($adminName)) {
            $errors['admin_full_name'] = 'Votre nom complet est requis.';
        }

        if (empty($adminEmail)) {
            $errors['admin_email'] = 'L\'email de connexion est requis.';
        } elseif (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            $errors['admin_email'] = 'Email de connexion invalide.';
        }

        if (empty($password)) {
            $errors['password'] = 'Le mot de passe est requis.';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }

        if (empty($passwordConf)) {
            $errors['password_confirm'] = 'La confirmation du mot de passe est requise.';
        } elseif ($password !== $passwordConf) {
            $errors['password_confirm'] = 'Les mots de passe ne correspondent pas.';
        }

        if (!empty($errors)) {
            $this->json(['success' => false, 'errors' => $errors], 422);
        }

        // --- Unicité des emails ---
        $stmt = $this->pdo->prepare('SELECT id FROM schools WHERE email = ? LIMIT 1');
        $stmt->execute([$schoolEmail]);
        if ($stmt->fetch()) {
            $this->json(['success' => false, 'errors' => [
                'school_email' => 'Cet email d\'établissement est déjà utilisé.'
            ]], 422);
        }

        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$adminEmail]);
        if ($stmt->fetch()) {
            $this->json(['success' => false, 'errors' => [
                'admin_email' => 'Cet email de connexion est déjà utilisé.'
            ]], 422);
        }

        // --- Transaction : créer école + admin ---
        try {
            $this->pdo->beginTransaction();

            $slug = $this->generateSlug($schoolName);

            $stmt = $this->pdo->prepare('
                INSERT INTO schools (name, subtype, email, phone, address, slug, status)
                VALUES (?, ?, ?, ?, ?, ?, \'inactive\')
            ');
            $stmt->execute([
                $schoolName,
                $schoolSub,
                $schoolEmail,
                $schoolPhone ?: null,
                $schoolAddr  ?: null,
                $slug
            ]);
            $schoolId = (int)$this->pdo->lastInsertId();

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            $stmt = $this->pdo->prepare('
                INSERT INTO users (school_id, name, email, password, role, status)
                VALUES (?, ?, ?, ?, \'admin\', \'inactive\')
            ');
            $stmt->execute([$schoolId, $adminName, $adminEmail, $hashedPassword]);
            $userId = (int)$this->pdo->lastInsertId();

            
            $stmt->execute([$userId, $token, $expiresAt]);

            $this->pdo->commit();


            $this->json([
                'success'   => true,
                'message'   => 'Compte créé ! Vérifiez votre boîte email pour confirmer votre adresse.',
                
                'redirect'  => '../pages/email_sent.html'
            ]);

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('[africeduc][Register] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Veuillez réessayer.'], 500);
        }
    }

    
    
    private function generateSlug(string $name): string
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        $slug = substr($slug, 0, 80);

        $baseSlug = $slug;
        $counter  = 1;
        do {
            $stmt = $this->pdo->prepare('SELECT id FROM schools WHERE slug = ? LIMIT 1');
            $stmt->execute([$slug]);
            if (!$stmt->fetch()) break;
            $slug = $baseSlug . '-' . $counter++;
        } while (true);

        return $slug;
    }

    private function sanitize(string $value): string
    {
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    private function json(array $data, int $statusCode = 200): never
    {
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

// ============================================================
//  POINT D'ENTRÉE
// ============================================================
$controller = new RegisterController();
$action     = $_POST['action'] ?? $_POST['auth_action'] ?? $_GET['action'] ?? '';
$controller->handle($action);
