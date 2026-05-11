<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

function africeduc_send_mail(string $to, string $subject, string $htmlBody): array
{
    $mail = new PHPMailer(true);

    try {

        // SMTP Mailtrap
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;

        $mail->Username = 'd3d33bc8fc8087';
        $mail->Password = 'eea1fa0904aae9';

        $mail->Port = 2525;

        // sender
        $mail->setFrom('noreply@africeduc.com', 'AfricEduc');
        $mail->addAddress($to);

        // content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;

        $mail->send();

        return ['success' => true];

    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $mail->ErrorInfo
        ];
    }
}
