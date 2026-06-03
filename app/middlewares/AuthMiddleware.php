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
            header("Location: /AfricEduc/public/index.php?url=dashboard_" . $_SESSION['user_role']);
            exit;
        }
    }
}