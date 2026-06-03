<?php
require_once '../config/database.php';
require_once '../models/UserModel.php';
require_once '../models/SchoolModel.php';
require_once '../services/UserService.php';

session_start();

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
                    header("Location: /AfricEduc/app/views/superadmin/dashboard_superadmin.php");
                    break;
                case 'admin':
                    header("Location: /AfricEduc/app/controllers/DashboardAdminController.php");
                    break;
                case 'agent':
                    header("Location: /AfricEduc/app/views/agents/dashboard_agent.php");
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