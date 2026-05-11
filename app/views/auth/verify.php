<?php

session_start();

$pdo = require '../../config/database.php';

$token = trim($_GET['token'] ?? '');

if (!$token) {
    die("Token invalide");
}

// chercher token
$stmt = $pdo->prepare("
    SELECT *
    FROM email_verifications
    WHERE token = ? AND expires_at > NOW()
    LIMIT 1
");

$stmt->execute([$token]);
$verification = $stmt->fetch();

if (!$verification) {
    die("Lien invalide ou expiré");
}

// activer user
$stmt = $pdo->prepare("
    UPDATE users
    SET status = 'active', email_verified_at = NOW()
    WHERE id = ?
");

$stmt->execute([$verification['user_id']]);

// supprimer token
$stmt = $pdo->prepare("
    DELETE FROM email_verifications WHERE token = ?
");

$stmt->execute([$token]);

$_SESSION['success'] = "Compte activé avec succès. Vous pouvez vous connecter.";

header("Location: login.php");
exit;
