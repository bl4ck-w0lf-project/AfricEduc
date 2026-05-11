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
}
?>
