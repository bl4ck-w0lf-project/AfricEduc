<?php
// app/controllers/PasswordController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../services/UserService.php';

class PasswordController
{
    private $pdo;
    private $userModel;
    private $authService;

    public function __construct($pdo)
    {
        if (session_status() === PHP_SESSION_NONE) {
           session_start();
        }
        
        $this->pdo = $pdo;
        $this->userModel = new UserModel($this->pdo);
        $this->authService = new AuthService($this->userModel);
    }

    public function showForgotForm()
    {
        // Afficher la vue forgot_password.php
        require_once __DIR__ . '/../views/auth/forgot_password.php';
        exit;
    }

    public function handleForgot()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $email  = trim($_POST['email'] ?? '');
        $errors = [];

        if ($email === '') {
            $errors['email'] = "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Adresse email invalide.";
        }

        if (!empty($errors)) {
            $_SESSION['forgot_errors'] = $errors;
            $_SESSION['forgot_old'] = ['email' => $email];
            header('Location: /AfricEduc/app/views/auth/forgot_password.php');
            exit;
        }

        $result = $this->authService->sendPasswordResetLink($email);

        if (isset($result['error'])) {
            $_SESSION['forgot_errors'] = ['global' => $result['error']];
            header('Location: /AfricEduc/app/views/auth/forgot_password.php');
            exit;
        }

        $_SESSION['forgot_success'] = true;
        header('Location: /AfricEduc/app/views/auth/forgot_password.php');
        exit;
    }

    public function handleReset()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $rawToken = trim($_POST['token'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['password_confirm'] ?? '';

        $result = $this->authService->resetPassword($rawToken, $password, $confirm);

        // 🔴 CAS ERREURS
        if (isset($result['errors'])) {
            $_SESSION['reset_errors'] = $result['errors'];
        }

        // 🔴 CAS ERROR SIMPLE
        if (isset($result['error'])) {
            $_SESSION['reset_errors'] = [
                'global' => $result['error']
            ];
        }

        if (isset($_SESSION['reset_errors'])) {
            header('Location: /AfricEduc/app/views/auth/reset_password.php?token=' . urlencode($rawToken));
            exit;
        }

        // 🟢 SUCCESS
        $_SESSION['reset_success'] = true;
        header('Location: /AfricEduc/app/views/auth/login.php?reset=1');
        exit;
    }
}