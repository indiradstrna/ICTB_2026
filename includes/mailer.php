<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../vendor/autoload.php";

/**
 * Kirim email reset password menggunakan PHPMailer + SMTP Gmail.
 * Ganti SMTP_USER dan SMTP_PASS dengan akun Gmail pengirim konferensi.
 *
 * @param string $to      Alamat email tujuan
 * @param string $subject Subjek email
 * @param string $body    Isi email (plain text)
 * @return bool
 */
function sendMail(string $to, string $subject, string $body): bool
{
    // ── KONFIGURASI SMTP ─────────────────────────────────────────────────────
    define("SMTP_HOST",     "smtp.gmail.com");
    define("SMTP_PORT",     587);
    define("SMTP_USER",     "ictb@biotrop.org");   // ← Ganti dengan email pengirim
    define("SMTP_PASS",     "xxxx xxxx xxxx xxxx"); // ← Ganti dengan App Password Gmail
    define("SMTP_FROM_NAME","ICTB 2026 Secretariat");
    // ─────────────────────────────────────────────────────────────────────────

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = "UTF-8";

        $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->isHTML(false);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
