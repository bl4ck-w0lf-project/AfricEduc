<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PasswordResetMailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $this->mail = new PHPMailer(true);
        $m = $this->mail;

        $m->isSMTP();
        $m->Host       = MAIL_HOST;
        $m->SMTPAuth   = true;
        $m->Username   = MAIL_USERNAME;
        $m->Password   = MAIL_PASSWORD;
        $m->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $m->Port       = MAIL_PORT;
        $m->CharSet    = 'UTF-8';
        $m->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
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
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head><meta charset="UTF-8"></head>
        <body style="margin:0;padding:0;background:#f4f4f7;font-family:Arial,sans-serif;">
          <table width="100%" cellpadding="0" cellspacing="0"
                 style="background:#f4f4f7;padding:40px 16px;">
            <tr><td align="center">
              <table width="560" cellpadding="0" cellspacing="0"
                     style="background:#fff;border-radius:20px;overflow:hidden;
                            box-shadow:0 4px 24px rgba(115,0,233,.12);">
                <tr>
                  <td style="background:linear-gradient(135deg,#7300e9,#9c40ff);
                             padding:32px 40px;text-align:center;">
                    <span style="color:#fff;font-size:24px;font-weight:700;">
                      Afric<span style="color:#99fbe3;">Educ</span>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td style="padding:40px 40px 32px;">
                    <h1 style="margin:0 0 12px;font-size:22px;color:#1e1b4b;font-weight:700;">
                      Réinitialisation de mot de passe
                    </h1>
                    <p style="margin:0 0 8px;color:#475569;font-size:15px;line-height:1.6;">
                      Vous avez demandé à réinitialiser votre mot de passe AfricEduc.
                    </p>
                    <p style="margin:0 0 28px;color:#475569;font-size:15px;line-height:1.6;">
                      Cliquez sur le bouton ci-dessous. Ce lien est valable
                      <strong>1 heure</strong> et ne peut être utilisé qu'une seule fois.
                    </p>
                    <a href="{$safe}"
                       style="display:inline-block;background:#7300e9;color:#fff;
                              text-decoration:none;padding:14px 32px;border-radius:12px;
                              font-weight:600;font-size:15px;">
                      Choisir un nouveau mot de passe
                    </a>
                    <p style="margin:28px 0 0;color:#94a3b8;font-size:13px;line-height:1.6;">
                      Si vous n'avez pas fait cette demande, ignorez cet email.
                      Votre mot de passe ne sera pas modifié.
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="border-top:1px solid #f1f5f9;padding:20px 40px;
                             text-align:center;color:#94a3b8;font-size:12px;">
                    &copy; {$year} AfricEduc &mdash; Ne pas répondre à cet email.
                  </td>
                </tr>
              </table>
            </td></tr>
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
