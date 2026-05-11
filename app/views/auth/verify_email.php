<?php

define('BASE_PATH', dirname(__DIR__, 2));

$pdo = require BASE_PATH . '/config/database.php';

session_start();

// 1. Check token
$token = $_GET['token'] ?? null;

if (!$token) {
    $_SESSION['error'] = "Token invalide.";
    header("Location: login.php");
    exit;
}

// 2. Find token in DB
$stmt = $pdo->prepare("
    SELECT * FROM email_verifications
    WHERE token = ?
    LIMIT 1
");

$stmt->execute([$token]);
$record = $stmt->fetch();

if (!$record) {
    $_SESSION['error'] = "Lien invalide ou expiré.";
    header("Location: login.php");
    exit;
}

// 3. Check expiration
if (strtotime($record['expires_at']) < time()) {
    $_SESSION['error'] = "Lien expiré.";
    header("Location: login.php");
    exit;
}

// 4. Activate user
$pdo->prepare("
    UPDATE users
    SET email_verified_at = NOW(), status = 'active'
    WHERE id = ?
")->execute([$record['user_id']]);

// 5. Delete token
$pdo->prepare("
    DELETE FROM email_verifications
    WHERE id = ?
")->execute([$record['id']]);

// 6. Success message
$_SESSION['success'] = "Compte activé avec succès. Vous pouvez vous connecter.";

header("Location: login.php");
exit;
