<?php
/**
 * Connexion PDO — africeduc
 * Variables d'environnement (recommandé) : DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET
 */

declare(strict_types=1);

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbName = getenv('DB_NAME') ?: 'africeduc';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbCharset = getenv('DB_CHARSET') ?: 'utf8mb4';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $dbHost, $dbName, $dbCharset);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de connexion à la base de données.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
