<?php
session_start();
require_once 'includes/db.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Bu mail adresi var mı?
    $stmt = $db->prepare("SELECT id, kullanici_adi FROM kullanicilar WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Rastgele kod üret
        $kod = md5(uniqid(rand(), true));

        // Kodu veritabanına kaydet
        $update = $db->prepare("UPDATE kullanicilar SET sifirlama_kodu = ? WHERE id = ?");
        
        if ($update->execute([$kod, $user['id']])) {
            // MAİL GÖNDER
            if (file_exists('includes/mail_sender.php')) {
                require_once 'includes/mail_sender.php';
                
                $link = "http://localhost/GeziRehberi/sifre_sifirla.php?kod=$kod&email=$email"; // KLASÖR ADINI KONTROL ET
                $konu = "Şifre Sıfırlama Talebi 🔒";
                
                $icerik = "
                <div style='font-family:Arial; background:#f9f9f9; padding:20px; border-radius:10px; text-align:center;'>
                    <h2 style='color:#228B22;'>Şifreni mi Unuttun?</h2>
                    <p>Merhaba <strong>{$user['kullanici_adi']}</strong>,</p>
                    <p>Hesabın için bir şifre sıfırlama talebi aldık. Aşağıdaki butona tıklayarak yeni şifreni oluşturabilirsin.</p>
                    <br>
                    <a href='$link' style='background:#228B22; color:white; padding:12px 25px; text-decoration:none; border-radius:25px; font-weight:bold;'>Şifremi Sıfırla</a>
                    <br><br>
                    <small style='color:#888;'>Bu işlemi sen yapmadıysan, bu maili dikkate alma.</small>
                </div>";

                if (mailGonder($email, $user['kullanici_adi'], $konu, $icerik)) {
                    $mesaj = "<div class='alert success'>✅ Sıfırlama bağlantısı e-posta adresine gönderildi.</div>";
                } else {
                    $mesaj = "<div class='alert error'>❌ Mail gönderilemedi.</div>";
                }
            }
        }
    } else {
        // Güvenlik gereği "Böyle bir mail yok" demek yerine aynısını diyoruz (veya uyarı verebilirsin)
        $mesaj = "<div class='alert error'>⚠️ Bu e-posta adresi sistemde kayıtlı değil.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Şifremi Unuttum</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        h2 { color: #333; margin-bottom: 20px; }
        p { color: #666; font-size: 14px; margin-bottom: 25px; }
        input { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; box-sizing: border-box; margin-bottom: 20px; }
        input:focus { border-color: #228B22; outline: none; }
        .btn { width: 100%; padding: 12px; background: #228B22; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px; }
        .btn:hover { background: #1a6f1a; }
        .back-link { display: block; margin-top: 15px; color: #777; text-decoration: none; font-size: 14px; }
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: left; }
        .alert.success { background: #d4edda; color: #155724; }
        .alert.error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color:#228B22;"><i class="fas fa-lock"></i> Şifremi Unuttum</h2>
        <p>Hesabına ait e-posta adresini gir, sana sıfırlama bağlantısı gönderelim.</p>
        
        <?php echo $mesaj; ?>

        <form method="POST">
            <input type="email" name="email" required placeholder="E-posta adresin">
            <button type="submit" class="btn">Gönder</button>
        </form>
        
        <a href="giris.php" class="back-link">← Giriş Ekranına Dön</a>
    </div>
</body>
</html>