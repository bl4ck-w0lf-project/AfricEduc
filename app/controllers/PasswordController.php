<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../services/UserService.php';

session_start();

$pdo       = Database::getConnection();
$userModel = new UserModel($pdo);
$service   = new UserService($userModel);

$action = $_GET['action'] ?? '';

match ($action) {
    'forgot' => handleForgot($service),
    'reset'  => handleReset($service),
    default  => http_response_code(404),
};

// ──────────────────────────────────────────────────────────────────────────────

function handleForgot(UserService $service): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        return;
    }

    $email  = trim($_POST['email'] ?? '');
    $errors = [];

    // Validation
    if ($email === '') {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Adresse email invalide.";
    }

    if (!empty($errors)) {
        $_SESSION['forgot_errors'] = $errors;
        $_SESSION['forgot_old']    = ['email' => $email];
        header('Location: /app/views/auth/forgot_password.php');
        exit;
    }

    $result = $service->sendPasswordResetLink($email);

    if (isset($result['error'])) {
        $_SESSION['forgot_errors'] = ['global' => $result['error']];
        $_SESSION['forgot_old']    = ['email' => $email];
        header('Location: /app/views/auth/forgot_password.php');
        exit;
    }

    $_SESSION['forgot_success'] = true;
    header('Location: /app/views/auth/forgot_password.php');
    exit;
}

function handleReset(UserService $service): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        return;
    }

    $rawToken = trim($_POST['token']            ?? '');
    $password = $_POST['password']              ?? '';
    $confirm  = $_POST['password_confirm']      ?? '';

    $result = $service->resetPassword($rawToken, $password, $confirm);

    if (isset($result['errors'])) {
        $_SESSION['reset_errors'] = $result['errors'];
        // On remet le token dans l'URL pour repré-remplir le champ caché
        header('Location: /app/views/auth/reset_password.php?token='
               . urlencode($rawToken));
        exit;
    }

    $_SESSION['reset_success'] = true;
    header('Location: /app/views/auth/login.php?reset=1');
    exit;
}