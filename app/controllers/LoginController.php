<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/SchoolModel.php';
require_once __DIR__ . '/../services/UserService.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userModel = new UserModel($pdo);

$authService = new AuthService($userModel);

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember_me']);

    $old['email'] = $email;

    // validation simple
    if (empty($email)) $errors['email'] = "L'email est requis";
    if (empty($password)) $errors['password'] = "Le mot de passe est requis";

    if (empty($errors)) {
        $result = $authService->login($email, $password, $remember);

        if ($result['success']) {
            // redirection selon le rôlee
            switch ($result['role']) {
                case 'super_admin':
                    header("Location: /AfricEduc/public/index.php?url=dashboard_super_admin");
                    break;
                case 'admin':
                     header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
                    break;
                case 'agent':
                    header("Location: /AfricEduc/public/index.php?url=dashboard_agent");
                    break;
                default:
                    header("Location: /AfricEduc/index.php");
            }
            exit;
        } else {
            $errors = $result['errors'];
        }
    }

    // ❌ IMPORTANT : stocker erreurs et old et redirect
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;

    header("Location: ../views/auth/login.php");
    exit;
}