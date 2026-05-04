<?php


session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/mailer.php';

class AuthController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../config/database.php';
        $this->pdo = $pdo;
    }

    // ============================================================
    //  ROUTER PRINCIPAL
    // ============================================================
    public function handle(string $action): void
    {
        // CSRF vérifié uniquement pour les actions POST sensibles
        // get_csrf est exempt (c'est lui qui génère le token)
        $csrfExempt = ['get_csrf', 'verify_email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !in_array($action, $csrfExempt)) {
            $this->verifyCsrf();
        }

        switch ($action) {
            case 'register':        $this->register();       break;
            case 'login':           $this->login();          break;
            case 'logout':          $this->logout();         break;
            case 'forgot_password':
            case 'forgot':          $this->forgotPassword(); break;
            case 'reset_password':
            case 'reset':           $this->resetPassword();  break;
            case 'verify_email':    $this->verifyEmail();    break;
            case 'get_csrf':        $this->getCsrfToken();   break;
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

        // --- Validations complètes ---
        $errors = [];

        if (empty($schoolName)) {
            $errors['school_name'] = 'Le nom de l\'établissement est requis.';
        }

        // Sous-type OBLIGATOIRE
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

            // Token vérification email (24h)
            $token     = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + 86400);

            $this->pdo->exec('
                CREATE TABLE IF NOT EXISTS email_verifications (
                    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    user_id    INT UNSIGNED NOT NULL,
                    token      VARCHAR(64)  NOT NULL UNIQUE,
                    expires_at DATETIME     NOT NULL,
                    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    CONSTRAINT fk_ev_user FOREIGN KEY (user_id)
                        REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ');

            $stmt = $this->pdo->prepare('
                INSERT INTO email_verifications (user_id, token, expires_at)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)
            ');
            $stmt->execute([$userId, $token, $expiresAt]);

            $this->pdo->commit();

            $mailSent = Mailer::sendVerificationEmail($adminEmail, $adminName, $token);

            $this->json([
                'success'   => true,
                'message'   => 'Compte créé ! Vérifiez votre boîte email pour confirmer votre adresse.',
                'mail_sent' => $mailSent,
                'redirect'  => '../pages/email_sent.html'
            ]);

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('[EduManager][Auth][register] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Veuillez réessayer.'], 500);
        }
    }

    // ============================================================
    //  ACTION : login
    // ============================================================
    private function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.'], 405);
        }

        $email    = $this->sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']) || !empty($_POST['remember_me']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
            $this->json(['success' => false, 'message' => 'Email ou mot de passe invalide.'], 422);
        }

        if ($this->isLoginBlocked($email)) {
            $this->json([
                'success' => false,
                'message' => 'Compte temporairement bloqué après plusieurs tentatives échouées. Réessayez dans 15 minutes.'
            ], 429);
        }

        $stmt = $this->pdo->prepare('
            SELECT u.id, u.school_id, u.name, u.email, u.password, u.role, u.status,
                   s.status AS school_status, s.name AS school_name
            FROM users u
            LEFT JOIN schools s ON s.id = u.school_id
            WHERE u.email = ?
            LIMIT 1
        ');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->recordFailedAttempt($email);
            usleep(random_int(100000, 300000));
            $this->json(['success' => false, 'message' => 'Email ou mot de passe incorrect.'], 401);
        }

        if ($user['role'] === 'admin' && $user['status'] === 'inactive') {
            $this->json([
                'success' => false,
                'message' => 'Votre compte n\'est pas encore activé. Vérifiez votre boîte email.'
            ], 403);
        }

        if ($user['role'] !== 'super_admin') {
            if ($user['school_status'] === 'suspended') {
                $this->json(['success' => false, 'message' => 'Votre établissement est suspendu. Contactez le support.'], 403);
            }
            if ($user['school_status'] === 'inactive') {
                $this->json(['success' => false, 'message' => 'Votre établissement n\'est pas encore activé.'], 403);
            }
        }

        $this->clearFailedAttempts($email);
        session_regenerate_id(true);

        $_SESSION['user_id']     = (int)$user['id'];
        $_SESSION['role']        = $user['role'];
        $_SESSION['school_id']   = $user['school_id'] ? (int)$user['school_id'] : null;
        $_SESSION['name']        = $user['name'];
        $_SESSION['email']       = $user['email'];
        $_SESSION['school_name'] = $user['school_name'] ?? 'EduManager';
        $_SESSION['logged_in']   = true;
        $_SESSION['login_time']  = time();

        if ($remember) {
            $cookieToken = bin2hex(random_bytes(32));
            setcookie('edu_remember', $cookieToken, time() + (30 * 86400), '/', '', isset($_SERVER['HTTPS']), true);
        }

        $stmt = $this->pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
        $stmt->execute([$user['id']]);

        $redirectMap = [
            'super_admin' => '../pages/dashboard_superadmin.html',
            'admin'       => '../pages/dashboard_admin.html',
            'agent'       => '../pages/dashboard_agent.html',
        ];
        $redirect = $redirectMap[$user['role']] ?? '../pages/login.html';

        if ($user['role'] === 'admin') {
            $stmt = $this->pdo->prepare('SELECT id FROM school_settings WHERE school_id = ? LIMIT 1');
            $stmt->execute([$user['school_id']]);
            if (!$stmt->fetch()) {
                $redirect = '../../pages/setup_school.html';
            }
        }

        $this->json(['success' => true, 'role' => $user['role'], 'name' => $user['name'], 'redirect' => $redirect]);
    }

    // ============================================================
    //  ACTION : logout
    // ============================================================
    private function logout(): void
    {
        if (isset($_COOKIE['edu_remember'])) {
            setcookie('edu_remember', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        $this->json(['success' => true, 'redirect' => '../pages/login.html']);
    }

    // ============================================================
    //  ACTION : forgot_password
    // ============================================================
    private function forgotPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.'], 405);
        }

        $email = $this->sanitize($_POST['email'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Adresse email invalide.'], 422);
        }

        $successMsg = 'Si cet email existe dans notre système, un lien de réinitialisation vous a été envoyé.';

        $stmt = $this->pdo->prepare('SELECT id, name FROM users WHERE email = ? AND status = \'active\' LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            usleep(random_int(200000, 500000));
            $this->json(['success' => true, 'message' => $successMsg]);
        }

        try {
            $this->pdo->exec('
                CREATE TABLE IF NOT EXISTS password_resets (
                    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    email      VARCHAR(150) NOT NULL,
                    token      VARCHAR(64)  NOT NULL UNIQUE,
                    expires_at DATETIME     NOT NULL,
                    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    KEY idx_pr_email (email)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ');

            $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE email = ?');
            $stmt->execute([$email]);

            $token     = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);

            $stmt = $this->pdo->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)');
            $stmt->execute([$email, $token, $expiresAt]);

            Mailer::sendPasswordResetEmail($email, $user['name'], $token);

            $this->json(['success' => true, 'message' => $successMsg]);

        } catch (PDOException $e) {
            error_log('[EduManager][Auth][forgot_password] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Réessayez.'], 500);
        }
    }

    // ============================================================
    //  ACTION : reset_password
    // ============================================================
    private function resetPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.'], 405);
        }

        $token        = $this->sanitize($_POST['token']            ?? '');
        $password     = $_POST['password']         ?? '';
        $passwordConf = $_POST['password_confirm'] ?? '';

        $errors = [];
        if (empty($token))               $errors['token']            = 'Token manquant ou invalide.';
        if (strlen($password) < 8)       $errors['password']         = 'Minimum 8 caractères requis.';
        if ($password !== $passwordConf) $errors['password_confirm'] = 'Les mots de passe ne correspondent pas.';

        if (!empty($errors)) {
            $this->json(['success' => false, 'errors' => $errors], 422);
        }

        try {
            $stmt = $this->pdo->prepare('
                SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1
            ');
            $stmt->execute([$token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reset) {
                $this->json(['success' => false, 'message' => 'Ce lien est invalide ou a expiré. Faites une nouvelle demande.'], 400);
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            $stmt = $this->pdo->prepare('UPDATE users SET password = ?, updated_at = NOW() WHERE email = ?');
            $stmt->execute([$hashedPassword, $reset['email']]);

            $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE token = ?');
            $stmt->execute([$token]);

            $this->json(['success' => true, 'message' => 'Mot de passe modifié avec succès !', 'redirect' => '../pages/login.html']);

        } catch (PDOException $e) {
            error_log('[EduManager][Auth][reset_password] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Réessayez.'], 500);
        }
    }

    // ============================================================
    //  ACTION : verify_email
    // ============================================================
    private function verifyEmail(): void
    {
        $token = $this->sanitize($_GET['token'] ?? $_POST['token'] ?? '');

        if (empty($token)) {
            $this->json(['success' => false, 'message' => 'Token manquant.'], 400);
        }

        try {
            $stmt = $this->pdo->prepare('
                SELECT ev.user_id, u.school_id
                FROM email_verifications ev
                JOIN users u ON u.id = ev.user_id
                WHERE ev.token = ? AND ev.expires_at > NOW()
                LIMIT 1
            ');
            $stmt->execute([$token]);
            $verification = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$verification) {
                $this->json(['success' => false, 'message' => 'Ce lien est invalide ou a expiré.'], 400);
            }

            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('UPDATE users SET status = \'active\' WHERE id = ?');
            $stmt->execute([$verification['user_id']]);

            $stmt = $this->pdo->prepare('UPDATE schools SET status = \'active\' WHERE id = ?');
            $stmt->execute([$verification['school_id']]);

            $stmt = $this->pdo->prepare('DELETE FROM email_verifications WHERE token = ?');
            $stmt->execute([$token]);

            $this->pdo->commit();

            $this->json([
                'success'  => true,
                'message'  => 'Email confirmé ! Vous pouvez maintenant vous connecter.',
                'redirect' => '../pages/login.html?verified=1'
            ]);

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('[EduManager][Auth][verify_email] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Réessayez.'], 500);
        }
    }

    // ============================================================
    //  ACTION : get_csrf
    //  Génère et retourne un token CSRF frais
    //  Appelé en GET au chargement du formulaire
    // ============================================================
    private function getCsrfToken(): void
    {
        // Régénérer un token frais à chaque appel
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $this->json(['csrf_token' => $_SESSION['csrf_token']]);
    }

    // ============================================================
    //  HELPERS PRIVÉS
    // ============================================================

    /**
     * Vérifier le token CSRF
     * Lu dans POST['csrf_token'] ou dans le header HTTP X-CSRF-Token
     */
    private function verifyCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

        if (
            empty($_SESSION['csrf_token']) ||
            empty($token) ||
            !hash_equals($_SESSION['csrf_token'], $token)
        ) {
            $this->json(['success' => false, 'message' => 'Token de sécurité invalide. Rechargez la page.'], 403);
        }

        // Régénérer après usage (one-time token)
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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

    private function isLoginBlocked(string $email): bool
    {
        $key = 'login_attempts_' . md5($email);
        if (!isset($_SESSION[$key])) return false;
        $attempts = $_SESSION[$key];
        if ($attempts['count'] >= 5) {
            if (time() - $attempts['last_attempt'] < 900) return true;
            unset($_SESSION[$key]);
        }
        return false;
    }

    private function recordFailedAttempt(string $email): void
    {
        $key = 'login_attempts_' . md5($email);
        if (!isset($_SESSION[$key])) $_SESSION[$key] = ['count' => 0, 'last_attempt' => time()];
        $_SESSION[$key]['count']++;
        $_SESSION[$key]['last_attempt'] = time();
    }

    private function clearFailedAttempts(string $email): void
    {
        unset($_SESSION['login_attempts_' . md5($email)]);
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
$controller = new AuthController();
$action     = $_POST['action'] ?? $_POST['auth_action'] ?? $_GET['action'] ?? '';
$controller->handle($action);
