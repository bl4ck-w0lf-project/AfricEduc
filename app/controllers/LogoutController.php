<?php

class LogoutController
{
    public function index()
    {
        session_start();

        session_unset();
        session_destroy();

        header("Location: /AfricEduc/public/index.php?url=login");
        exit;
    }
}