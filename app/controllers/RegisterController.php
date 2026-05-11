<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/models/UserModel.php';
require_once BASE_PATH . '/models/SchoolModel.php';
require_once BASE_PATH . '/services/SchoolService.php';
require_once BASE_PATH . '/helpers/mailer.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/auth/register.php");
    exit;
}

$errors = [];

// ─── Validation serveur ───
if (empty($_POST['school_name'])) {
    $errors['school_name'] = "Nom requis";
}

if (empty($_POST['school_subtype'])) {
    $errors['school_subtype'] = "Veuillez choisir un type d'établissement";
}

if (empty($_POST['school_email'])) {
    $errors['school_email'] = "Email requis";
}

if (empty($_POST['school_phone'])) {
    $errors['school_phone'] = "Phone requis";
}

if (empty($_POST['school_address'])) {
    $errors['school_address'] = "Adresse requis";
}

if (empty($_POST['admin_email'])) {
    $errors['admin_email'] = "Email admin requis";
}

if (empty($_POST['admin_full_name'])) {
    $errors['admin_full_name'] = "Nom complet admin requis";
}

if (strlen($_POST['password'] ?? '') < 8) {
    $errors['password'] = "Mot de passe trop court";
}

if (($_POST['password'] ?? '') !== ($_POST['password_confirm'] ?? '')) {
    $errors['password_confirm'] = "Les mots de passe ne correspondent pas";
}

// ─── Si erreurs ───
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;

    header("Location: ../views/auth/register.php");
    exit;
}


$pdo = require BASE_PATH . '/config/database.php';

$schoolModel = new SchoolModel($pdo);
$userModel = new UserModel($pdo);

$service = new SchoolService($schoolModel, $userModel, $pdo);

$result = $service->register($_POST);

if (!empty($result['error'])) {
    $_SESSION['errors'] = $result['error'];
    $_SESSION['old'] = $_POST;

    header("Location: ../views/auth/register.php");
    exit;
}

$_SESSION['success'] = "Compte créé avec succès";

header("Location: ../views/auth/login.php");
exit;