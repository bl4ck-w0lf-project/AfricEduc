<?php
require_once '../models/UserModel.php';
require_once '../models/SchoolModel.php';
require_once '../services/SchoolService.php';
require_once '../helpers/mailer.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../public/register.php");
    exit;
}

$errors = [];

// ─── Validation serveur ───
if (empty($_POST['school_name'])) {
    $errors['school_name'] = "Nom requis";
}

if (empty($_POST['admin_email'])) {
    $errors['admin_email'] = "Email requis";
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

    header("Location: ../../public/register.php");
    exit;
}

// ─── Appel service (logique métier propre MVC) ───
$service = new SchoolService();

$result = $service->createSchool($_POST);

if (!$result['success']) {
    $_SESSION['errors'] = $result['errors'];
    header("Location: ../../public/register.php");
    exit;
}

// ─── Succès ───
$_SESSION['success'] = "Compte créé avec succès";

header("Location: ../../public/login.php");
exit;