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

$htmlBody = "
<div style='font-family: Arial, sans-serif; background:#f4f4f7; padding:30px;'>
  
  <div style='max-width:600px;margin:auto;background:white;border-radius:12px;padding:30px;box-shadow:0 10px 30px rgba(0,0,0,0.08)'>

    <!-- HEADER -->
    <h1 style='text-align:center;color:#7300e9;margin-bottom:10px;'>
      AfricEduc 🎓
    </h1>

    <h2 style='text-align:center;color:#333;'>
      Confirmation de votre compte
    </h2>

    <!-- MESSAGE -->
    <p style='font-size:15px;color:#555;line-height:1.6;margin-top:20px;'>
      Merci d’avoir créé un compte sur <strong>AfricEduc</strong>.
    </p>

    <p style='font-size:15px;color:#555;line-height:1.6;'>
      Pour activer votre compte et accéder à la plateforme, vous devez confirmer votre adresse email.
      Sans cette validation, votre compte restera <strong>inactif</strong>.
    </p>

    <!-- BUTTON -->
    <div style='text-align:center;margin:30px 0;'>
      <a href='$verifyLink'
         style='background:#7300e9;color:white;padding:14px 25px;
         text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
        ✔ Activer mon compte
      </a>
    </div>

    <!-- FOOTER -->
    <p style='font-size:12px;color:#888;text-align:center;'>
      Si le bouton ne fonctionne pas, copiez ce lien :<br>
      <a href='$verifyLink' style='color:#7300e9;'>$verifyLink</a>
    </p>

  </div>

  <p style='text-align:center;font-size:11px;color:#aaa;margin-top:15px;'>
    © AfricEduc - Tous droits réservés
  </p>

</div>
";

$mailResult = africeduc_send_mail(
    $_POST['admin_email'],
    "Activation de votre compte AfricEduc",
    $htmlBody
);

$_SESSION['registered_email'] = $_POST['admin_email'];
$_SESSION['mail_sent'] = $mailResult['success'] ?? false;

if (!$mailResult['success']) {
    $_SESSION['mail_error'] = $mailResult['message'] ?? 'Erreur inconnue lors de l’envoi';
}

// ─── RESPONSE ───
$_SESSION['success'] = "Compte créé avec succès. Vérifiez votre email pour activer votre compte.";

header("Location: ../views/auth/registration_success.php");
exit;