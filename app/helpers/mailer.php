<?php
/**
 * Envoi d'e-mails — africeduc
 * Remplacez par SMTP (PHPMailer, Symfony Mailer, etc.) en production.
 */

declare(strict_types=1);

/**
 * @return array{success: bool, message?: string}
 */
function africeduc_send_mail(string $to, string $subject, string $htmlBody, ?string $textBody = null): array
{
    $from = getenv('MAIL_FROM') ?: 'noreply@africeduc.local';
    $app = getenv('APP_NAME') ?: 'africeduc';

    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $app . ' <' . $from . '>',
        'X-Mailer: PHP/' . PHP_VERSION,
    ];

    $ok = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $htmlBody, implode("\r\n", $headers));

    if (!$ok && getenv('MAIL_LOG_ONLY') === '1') {
        error_log('[africeduc mailer] To: ' . $to . ' | Subject: ' . $subject);
        return ['success' => true, 'message' => 'Log only mode'];
    }

    return $ok
        ? ['success' => true]
        : ['success' => false, 'message' => "Impossible d'envoyer l'e-mail (vérifiez la config serveur)."];
}
