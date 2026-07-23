<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

/**
 * Envoi d'email via SMTP avec configuration depuis .env
 * 
 * @param string $to Destinataire
 * @param string $subject Sujet
 * @param string $htmlBody Corps HTML
 * @return array ['success' => bool, 'message' => string]
 */
function africeduc_send_mail(string $to, string $subject, string $htmlBody): array
{
    $mail = new PHPMailer(true);

    try {
        // === CONFIGURATION SMTP depuis .env ===
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'] ?? 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'] ?? 'd3d33bc8fc8087';
        $mail->Password = $_ENV['SMTP_PASSWORD'] ?? 'eea1fa0904aae9';
        
        // Gestion du secure (tls ou ssl)
        $secure = $_ENV['SMTP_SECURE'] ?? 'tls';
        if ($secure === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ($secure === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }
        
        $mail->Port = (int)($_ENV['SMTP_PORT'] ?? 587);
        
        // === DEBUG (0 = off, 1 = client, 2 = client+serveur) ===
        $mail->SMTPDebug = 0;
        
        // === EXPÉDITEUR ===
        $mail->setFrom(
            $_ENV['MAIL_FROM'] ?? 'noreply@africeduc.com',
            $_ENV['MAIL_FROM_NAME'] ?? 'AfricEduc'
        );
        $mail->addReplyTo(
            $_ENV['MAIL_FROM'] ?? 'noreply@africeduc.com',
            $_ENV['MAIL_FROM_NAME'] ?? 'AfricEduc'
        );
        
        // === DESTINATAIRE ===
        $mail->addAddress($to);
        
        
        // === CONTENU ===
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = strip_tags($htmlBody);
        
        // === ENVOI ===
        $mail->send();
        
        return [
            'success' => true,
            'message' => 'Email envoyé avec succès'
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $mail->ErrorInfo
        ];
    }
}