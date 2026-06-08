<?php

class LogoutController {

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ✅ 1. flash AVANT destruction
        $_SESSION['flash_success'] = "Déconnexion réussie 👋";

        // 🔥 2. rediriger AVANT de tuer la session
        $flash = $_SESSION['flash_success'];

        session_write_close(); // sécurise les données

        // 🧨 destroy session propre
        session_start();
        $_SESSION = [];
        session_destroy();

        // 🍪 cookie session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // 🔥 IMPORTANT : passer flash via GET (le plus fiable)
        header("Location: /AfricEduc/public/index.php?url=login&flash=1");
        exit;
    }
}