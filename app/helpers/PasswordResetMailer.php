<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class PasswordResetMailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $m = $this->mail;

        // === CONFIGURATION SMTP depuis .env ===
        $m->isSMTP();
        $m->Host = $_ENV['SMTP_HOST'] ?? 'sandbox.smtp.mailtrap.io';
        $m->SMTPAuth = true;
        $m->Username = $_ENV['SMTP_USERNAME'] ?? 'd3d33bc8fc8087';
        $m->Password = $_ENV['SMTP_PASSWORD'] ?? 'eea1fa0904aae9';
        
        // Gestion du secure (tls ou ssl)
        $secure = $_ENV['SMTP_SECURE'] ?? 'tls';
        if ($secure === 'tls') {
            $m->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ($secure === 'ssl') {
            $m->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }
        
        $m->Port = (int)($_ENV['SMTP_PORT'] ?? 2525);
        $m->CharSet = 'UTF-8';
        
        // === EXPÉDITEUR ===
        $m->setFrom(
            $_ENV['MAIL_FROM'] ?? 'no-reply@africeduc.com',
            $_ENV['MAIL_FROM_NAME'] ?? 'AfricEduc'
        );
    }

    public function sendResetLink(string $toEmail, string $resetUrl): bool
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Réinitialisation de votre mot de passe AfricEduc';
            $this->mail->Body    = $this->buildHtml($resetUrl);
            $this->mail->AltBody = $this->buildText($resetUrl);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log('[PasswordResetMailer] ' . $this->mail->ErrorInfo);
            return false;
        }
    }

    private function buildHtml(string $resetUrl): string
    {
        $safe = htmlspecialchars($resetUrl, ENT_QUOTES, 'UTF-8');
        $year = date('Y');
        $hour = (int)date('H');
        
        // Message de bienvenue personnalisé selon l'heure
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Bonjour ';
            $greetingMessage = 'Nous espérons que vous passez une excellente matinée !';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'Bonsoir';
            $greetingMessage = 'Nous espérons que votre journée se déroule bien !';
        } elseif ($hour >= 18 && $hour < 22) {
            $greeting = 'Bonsoir ';
            $greetingMessage = 'Nous espérons que vous avez passé une belle journée !';
        } else {
            $greeting = 'Bonsoir ';
            $greetingMessage = 'Nous espérons que vous passez une bonne soirée !';
        }
        
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Réinitialisation de mot de passe - AfricEduc</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
                * { margin: 0; padding: 0; box-sizing: border-box; }
            </style>
        </head>
        <body style="margin:0;padding:0;background:#f0f2f5;font-family:'Inter',Arial,sans-serif;line-height:1.6;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f2f5;padding:40px 16px;">
                <tr>
                    <td align="center">
                        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.08);max-width:600px;width:100%;">
                            <!-- HEADER avec dégradé amélioré -->
                            <tr>
                                <td style="background:linear-gradient(135deg,#7300e9 0%,#9c40ff 100%);padding: 40px 40px 24px 40px;text-align:center;position:relative;">
                                    <span style="color:#ffffff;font-size:28px;font-weight:700;letter-spacing:-0.5px;position:relative;z-index:1;text-shadow:0 2px 15px rgba(0,0,0,0.1);">
                                        AfricEduc
                                    </span>
                                    <p style="color:rgba(255,255,255,0.9);font-size:16px;margin-top:4px;font-weight:400;letter-spacing:0.5px;position:relative;z-index:1;text-transform:uppercase;opacity:0.9;">
                                        Solution de gestion scolaire
                                    </p>
                                </td>
                            </tr>
                            
                            <!-- CONTENU PRINCIPAL -->
                            <tr>
                                <td style="padding:40px 40px 32px;">
                                    <!-- Message de bienvenue personnalisé -->
                                    <div style="padding:16px 20px;margin-bottom:28px;">
                                        <p style="margin:0;color:#1e1b4b;font-size:18px;font-weight:600;">
                                            {$greeting}
                                        </p>
                                        <p style="margin:4px 0 0;color:#475569;font-size:14px;">
                                            {$greetingMessage}
                                        </p>
                                    </div>
                                    
                                    <h1 style="margin:0 0 8px;font-size:24px;color:#1e1b4b;font-weight:700;letter-spacing:-0.3px;">
                                        Réinitialisation de mot de passe
                                    </h1>
                                    
                                    <p style="margin:0 0 6px;color:#475569;font-size:15px;line-height:1.7;">
                                        Vous avez demandé à réinitialiser votre mot de passe pour votre compte <strong style="color:#7300e9;">AfricEduc</strong>.
                                    </p>
                                    
                                    <p style="margin:0 0 28px;color:#475569;font-size:15px;line-height:1.7;">
                                        Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe.
                                        <br>
                                        <span style="display:inline-block;margin-top:4px;background:#fef3c7;color:#92400e;font-size:13px;padding:4px 12px;border-radius:8px;font-weight:500;">
                                             Ce lien expire dans 1 heure
                                        </span>
                                    </p>
                                    
                                    <!-- Bouton CTA amélioré -->
                                    <div style="text-align:center;margin:0 0 28px;">
                                        <a href="{$safe}"
                                          style="display:inline-block;background:linear-gradient(135deg,#7300e9 0%,#9c40ff 100%);
                                                  color:#ffffff;text-decoration:none;padding:16px 48px;border-radius:14px;
                                                  font-weight:600;font-size:16px;box-shadow:0 4px 20px rgba(115,0,233,0.35);
                                                  transition:all 0.3s ease;border:none;cursor:pointer;
                                                  letter-spacing:0.3px;">
                                             Choisir un nouveau mot de passe
                                        </a>
                                    </div>
                                    
                                    <!-- Message de sécurité -->
                                    <div style="background:#f8fafc;border-radius:12px;padding:16px 20px;border:1px solid #e2e8f0;">
                                        <p style="margin:0;color:#64748b;font-size:13px;line-height:1.6;display:flex;align-items:flex-start;gap:10px;">
                                            <span style="display:inline-block;font-size:18px;"></span>
                                            <span>
                                                <strong style="color:#1e1b4b;">Ce lien est sécurisé</strong><br>
                                                Si vous n'avez pas fait cette demande, ignorez cet email. 
                                                Votre mot de passe ne sera pas modifié.
                                            </span>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- FOOTER -->
                            <tr>
                                <td style="border-top:1px solid #f1f5f9;padding:24px 40px 28px;text-align:center;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="text-align:center;color:#94a3b8;font-size:12px;">
                                                <p style="margin:0 0 8px;font-weight:500;color:#64748b;">
                                                    AfricEduc — La solution de gestion scolaire
                                                </p>
                                                <p style="margin:0;color:#94a3b8;font-size:12px;">
                                                    &copy; {$year} AfricEduc. Tous droits réservés.
                                                </p>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }

    private function buildText(string $resetUrl): string
    {
        return "Réinitialisez votre mot de passe AfricEduc :\n\n"
             . $resetUrl
             . "\n\nCe lien expire dans 1 heure.\n"
             . "Si vous n'êtes pas à l'origine de cette demande, ignorez ce message.";
    }
}