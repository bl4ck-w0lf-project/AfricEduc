<?php
class AuthService {
    private UserModel $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function login(string $email, string $password, bool $remember = false): array {
        $user = $this->userModel->findByEmail($email);

        // utilisateur inexistant ou mot de passe incorrect
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return [
                'success' => false,
                'errors' => ['password' => 'Email ou mot de passe incorrect']
            ];
        }

        // 🚨 VERIFICATsION STATUT COMPTE
        if ($user['status'] !== 'active') {
            return [
                'success' => false,
                'errors' => ['password' => 'Compte inactif. Contactez l’administration']
            ];
        }

        // session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];

        if ($remember) {
            setcookie(
                'remember_me',
                $user['id'],
                time() + (30 * 24 * 60 * 60),
                '/',
                '',
                true,
                true
            );
        }

        return [
            'success' => true,
            'role' => $user['role']
        ];
    }

    // ── Colle ces méthodes dans ta classe UserService existante ───────────────

/**
 * Génère le token, le stocke et envoie l'email de reset.
 */
public function sendPasswordResetLink(string $email): array
{
    $email = trim(strtolower($email));

    $user = $this->userModel->findByEmailForReset($email);

    if (!$user) {
        // Réponse neutre : on ne révèle pas si le compte existe
        // (anti-énumération). On ne fait rien mais on répond success.
        return ['success' => true];
    }

    // Token brut (envoyé dans l'URL) + hash (stocké en DB)
    $rawToken  = bin2hex(random_bytes(32));       // 64 chars
    $tokenHash = hash('sha256', $rawToken);
    $expiresAt = date('Y-m-d H:i:s', time() + 3600); // +1 heure

    $created = $this->userModel->createPasswordResetToken(
        $email,
        $tokenHash,
        $expiresAt
    );

    if (!$created) {
        return ['error' => 'Erreur interne. Réessayez plus tard.'];
    }

    // Construit l'URL absolue de reset
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'];              // ex: localhost ou africeduc.com
    $base     = $protocol . '://' . $host;

    // Le fichier reset_password.php est à la racine du projet
    $resetUrl = $base . '/reset_password.php?token=' . $rawToken;

    require_once __DIR__ . '/../helpers/PasswordResetMailer.php';
    $mailer = new PasswordResetMailer();
    $sent   = $mailer->sendResetLink($email, $resetUrl);

    if (!$sent) {
        return ['error' => "Impossible d'envoyer l'email. Réessayez plus tard."];
    }

    return ['success' => true];
}

/**
 * Vérifie le token et met à jour le mot de passe.
 */
public function resetPassword(string $rawToken, string $newPassword, string $confirm): array
{
    $errors = [];

    if ($rawToken === '') {
        $errors['global'] = 'Token manquant ou invalide.';
        return ['errors' => $errors];
    }

    if (strlen($newPassword) < 8) {
        $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }

    if ($newPassword !== $confirm) {
        $errors['password_confirm'] = 'Les mots de passe ne correspondent pas.';
    }

    if (!empty($errors)) {
        return ['errors' => $errors];
    }

    $tokenHash = hash('sha256', $rawToken);
    $row = $this->userModel->findValidResetToken($tokenHash);

    if (!$row) {
        $errors['global'] = 'Ce lien est invalide ou a expiré. Faites une nouvelle demande.';
        return ['errors' => $errors];
    }

    $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
    $this->userModel->updatePasswordByEmail($row['email'], $hashed);
    $this->userModel->deleteResetTokensByEmail($row['email']); // invalide le token

    return ['success' => true];
}
}
?>
