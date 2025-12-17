<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function mailGonder($aliciEmail, $aliciAd, $konu, $mesaj) {
    $mail = new PHPMailer(true);

    try {
        // SUNUCU AYARLARI (GMAIL ÖRNEĞİ)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eneskocak273@gmail.com'; // BURAYI DEĞİŞTİR
        $mail->Password   = 'ohszomkmcmppmjtz';      // BURAYI DEĞİŞTİR (Normal şifre değil!)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // ALICI VE GÖNDEREN
        $mail->setFrom('eneskocak273@gmail.com', 'Gezi Rehberi');
        $mail->addAddress($aliciEmail, $aliciAd);

        // İÇERİK
        $mail->isHTML(true);
        $mail->Subject = $konu;
        $mail->Body    = $mesaj;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false; // Hata: {$mail->ErrorInfo}
    }
}
?>