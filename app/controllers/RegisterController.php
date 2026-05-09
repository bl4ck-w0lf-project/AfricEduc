<?php

declare(strict_types=1);

session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../config/database.php';

/**
 * RegisterController
 *
 * Responsabilité unique : créer un compte (établissement + admin).
 * Aucune logique de session, vérification email ou reset password ici.
 */
final class RegisterController
{
    private const MIN_PASSWORD_LENGTH = 8;
    private const BCRYPT_COST         = 12;
    private const SLUG_MAX_LENGTH     = 80;

    public function __construct(private readonly PDO $pdo) {}

    // ----------------------------------------------------------------
    //  Point d'entrée unique
    // ----------------------------------------------------------------
    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort('Méthode non autorisée.', 405);
        }

        $this->register();
    }

    // ----------------------------------------------------------------
    //  Inscription
    // ----------------------------------------------------------------
    private function register(): void
    {
        $data   = $this->collectInput();
        $errors = $this->validate($data);

        if ($errors !== []) {
            $this->json(['success' => false, 'errors' => $errors], 422);
        }

        $this->assertEmailsAreUnique($data['school_email'], $data['admin_email'], $data['school_name']);
        $this->createAccount($data);
    }

    // ----------------------------------------------------------------
    //  Collecte et sanitisation des entrées
    // ----------------------------------------------------------------
    private function collectInput(): array
    {
        return [
            'school_name'      => $this->sanitize($_POST['school_name']    ?? ''),
            // school_subtype est canonique ; school_sub_type accepté pour rétrocompat
            'school_sub'       => $this->sanitize($_POST['school_subtype'] ?? $_POST['school_sub_type'] ?? ''),
            'school_email'     => $this->sanitize($_POST['school_email']   ?? ''),
            'school_phone'     => $this->sanitize($_POST['school_phone']   ?? ''),
            'school_address'      => $this->sanitize($_POST['school_address'] ?? ''),
            'admin_name'       => $this->sanitize($_POST['admin_full_name'] ?? ''),
            'admin_email'      => $this->sanitize($_POST['admin_email']    ?? ''),
            'password'         => $_POST['password']         ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
        ];
    }

    // ----------------------------------------------------------------
    //  Validation : retourne un tableau d'erreurs (vide = OK)
    // ----------------------------------------------------------------
    private function validate(array $d): array
    {
        $errors = [];

        if ($d['school_name'] === '') {
            $errors['school_name'] = "Le nom de l'établissement est requis.";
        }

        if ($d['school_sub'] === '') {
            $errors['school_sub'] = "Veuillez indiquer si l'établissement est public ou privé.";
        } elseif (!in_array($d['school_sub'], ['public', 'prive'], true)) {
            $errors['school_sub'] = 'Sous-type invalide : choisissez "public" ou "prive".';
        }

        if ($d['school_email'] === '') {
            $errors['school_email'] = "L'email de l'établissement est requis.";
        } elseif (!filter_var($d['school_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['school_email'] = "Email de l'établissement invalide.";
        }

        if ($d['school_phone'] === '') {
            $errors['school_phone'] = "Le numéro de téléphone de l'établissement est requis.";
        } 

        if ($d['school_address'] === '') {
            $errors['school_address'] = "L'adresse complète de l'établissement est requis.";
        } 

        if ($d['admin_name'] === '') {
            $errors['admin_name'] = 'Votre nom complet est requis.';
        }

        if ($d['admin_email'] === '') {
            $errors['admin_email'] = "L'email de connexion est requis.";
        } elseif (!filter_var($d['admin_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['admin_email'] = 'Email de connexion invalide.';
        }

        if ($d['password'] === '') {
            $errors['password'] = 'Le mot de passe est requis.';
        } elseif (strlen($d['password']) < self::MIN_PASSWORD_LENGTH) {
            $errors['password'] = sprintf(
                'Le mot de passe doit contenir au moins %d caractères.',
                self::MIN_PASSWORD_LENGTH
            );
        }

        if ($d['password_confirm'] === '') {
            $errors['password_confirm'] = 'La confirmation du mot de passe est requise.';
        } elseif ($d['password'] !== $d['password_confirm']) {
            $errors['password_confirm'] = 'Les mots de passe ne correspondent pas.';
        }

        return $errors;
    }

    // ----------------------------------------------------------------
    //  Unicité des emails — répond directement si conflit
    // ----------------------------------------------------------------
    private function assertEmailsAreUnique(string $schoolEmail, string $adminEmail, string $schoolName): void
    {

         $stmt = $this->pdo->prepare('SELECT id FROM schools WHERE name = ? LIMIT 1');
         $stmt->execute([$schoolName]);
         if ($stmt->fetch()) {
             $this->json(['success' => false, 'errors' => [
                 'school_name' => "Ce nom d'établissement est déjà utilisé.",
             ]], 422);
         }

        $stmt = $this->pdo->prepare('SELECT id FROM schools WHERE email = ? LIMIT 1');
        $stmt->execute([$schoolEmail]);
        if ($stmt->fetch()) {
            $this->json(['success' => false, 'errors' => [
                'school_email' => "Cet email d'établissement est déjà utilisé.",
            ]], 422);
        }

        

        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$adminEmail]);
        if ($stmt->fetch()) {
            $this->json(['success' => false, 'errors' => [
                'admin_email' => 'Cet email de connexion est déjà utilisé.',
            ]], 422);
        }
    }

    // ----------------------------------------------------------------
    //  Transaction : school + admin user
    // ----------------------------------------------------------------
    private function createAccount(array $d): void
    {
        try {
            $this->pdo->beginTransaction();

            $slug = $this->generateUniqueSlug($d['school_name']);

            $stmt = $this->pdo->prepare('
                INSERT INTO schools (name, subtype, email, phone, address, slug, status)
                VALUES (:name, :subtype, :email, :phone, :address, :slug, \'inactive\')
            ');
            $stmt->execute([
                ':name'    => $d['school_name'],
                ':subtype' => $d['school_sub'],
                ':email'   => $d['school_email'],
                ':phone'   => $d['school_phone'] !== '' ? $d['school_phone'] : null,
                ':address' => $d['school_address']  !== '' ? $d['school_address']  : null,
                ':slug'    => $slug,
            ]);
            $schoolId = (int) $this->pdo->lastInsertId();

            $hashedPassword = password_hash(
                $d['password'],
                PASSWORD_BCRYPT,
                ['cost' => self::BCRYPT_COST]
            );

            $stmt = $this->pdo->prepare('
                INSERT INTO users (school_id, name, email, password, role, status)
                VALUES (:school_id, :name, :email, :password, \'admin\', \'inactive\')
            ');
            $stmt->execute([
                ':school_id' => $schoolId,
                ':name'      => $d['admin_name'],
                ':email'     => $d['admin_email'],
                ':password'  => $hashedPassword,
            ]);

            $this->pdo->commit();

            $this->json([
                'success'  => true,
                'message'  => 'Compte créé avec succès ! Consultez votre boîte email pour activer votre compte.',
                'redirect' => '../../auth/login.php',
            ]);

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('[africeduc][RegisterController] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Veuillez réessayer.'], 500);
        }
    }

    // ----------------------------------------------------------------
    //  Génère un slug unique (ex : "lycee-moderne", "lycee-moderne-2")
    // ----------------------------------------------------------------
    private function generateUniqueSlug(string $name): string
    {
        $base = substr(
            trim(
                preg_replace(
                    '/[^a-z0-9]+/',
                    '-',
                    strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name) ?: $name)
                ),
                '-'
            ),
            0,
            self::SLUG_MAX_LENGTH
        );

        $slug    = $base;
        $counter = 1;
        $stmt    = $this->pdo->prepare('SELECT id FROM schools WHERE slug = ? LIMIT 1');

        while (true) {
            $stmt->execute([$slug]);
            if (!$stmt->fetch()) {
                break;
            }
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    // ----------------------------------------------------------------
    //  Helpers
    // ----------------------------------------------------------------
    private function sanitize(string $value): string
    {
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    private function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    private function abort(string $message, int $status): never
    {
        $this->json(['success' => false, 'message' => $message], $status);
    }
}

// ----------------------------------------------------------------
//  Bootstrap — $pdo est injecté par config/database.php
// ----------------------------------------------------------------
/** @var PDO $pdo */
$controller = new RegisterController($pdo);
$controller->handle();