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

// ─── VALIDATION ───
$errors = [];

if (empty($_POST['school_name'])) $errors['school_name'] = "Nom requis";
if (empty($_POST['school_subtype'])) $errors['school_subtype'] = "Type requis";
if (empty($_POST['school_email'])) $errors['school_email'] = "Email requis";
if (empty($_POST['school_phone'])) $errors['school_phone'] = "Phone requis";
if (empty($_POST['school_address'])) $errors['school_address'] = "Adresse requise";

if (empty($_POST['admin_email'])) $errors['admin_email'] = "Email admin requis";
if (empty($_POST['admin_full_name'])) $errors['admin_full_name'] = "Nom requis";

if (strlen($_POST['password'] ?? '') < 8) {
    $errors['password'] = "Mot de passe trop court";
}

if (($_POST['password'] ?? '') !== ($_POST['password_confirm'] ?? '')) {
    $errors['password_confirm'] = "Les mots de passe ne correspondent pas";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: ../views/auth/register.php");
    exit;
}

// ─── DB ───
$pdo = require BASE_PATH . '/config/database.php';

$schoolModel = new SchoolModel($pdo);
$userModel = new UserModel($pdo);

$service = new SchoolService($schoolModel, $userModel, $pdo);

// ─── CREATE USER + SCHOOL ───
$result = $service->register($_POST);

if (!empty($result['error'])) {
    $_SESSION['errors'] = $result['error'];
    $_SESSION['old'] = $_POST;
    header("Location: ../views/auth/register.php");
    exit;
}

if (empty($result['user_id'])) {
    die("Erreur critique: user_id manquant");
}

// ─── TOKEN ───
$token = bin2hex(random_bytes(32));
$expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));

$stmt = $pdo->prepare("
    INSERT INTO email_verifications (user_id, token, expires_at)
    VALUES (?, ?, ?)
");

$stmt->execute([$result['user_id'], $token, $expiresAt]);

// ─── EMAIL LINK ───
$verifyLink = "http://localhost/AfricEduc/app/views/auth/verify.php?token=" . urlencode($token);

africeduc_send_mail(
    $_POST['admin_email'],
    "Activation de votre compte AfricEduc",
    "Cliquez ici : <a href='$verifyLink'>$verifyLink</a>"
);

// ─── RESPONSE ───
$_SESSION['success'] = "Compte créé avec succès. Vérifiez votre email pour activer votre compte.";

header("Location: ../views/auth/login.php");
exit;