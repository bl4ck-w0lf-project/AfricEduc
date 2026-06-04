<?php

class LogoutController {

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $flash = "Déconnexion réussie !!!";

        // 🧹 vider session
        $_SESSION = [];

        // 🧨 détruire session
        session_destroy();

        

        // 🍪 supprimer cookie session (propre)
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_start();
        $_SESSION['flash_success'] = "Déconnexion réussie !!!";

        // 🔥 redirection finale
        header("Location: /AfricEduc/public/index.php?url=login");
        exit;
    }
}