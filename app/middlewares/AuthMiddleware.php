<?php
class AuthMiddleware
{
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /AfricEduc/public/index.php?url=login");
            exit;
        }
    }

    public static function role($role)
    {
        self::check();

        if (($_SESSION['user_role'] ?? null) !== $role) {
            http_response_code(403);
            die("Accès refusé");
        }
    }
}
?>