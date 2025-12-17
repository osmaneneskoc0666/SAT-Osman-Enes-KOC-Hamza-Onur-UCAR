<?php
session_start();
require_once 'includes/db.php';

$mesaj = "";

// Zaten giriş yapmışsa yönlendir
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php"); exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kadi = trim($_POST['username']);
    $email = trim($_POST['email']);
    $sifre = $_POST['password'];
    $sifre_tekrar = $_POST['password_confirm'];

    if (empty($kadi) || empty($email) || empty($sifre)) {
        $mesaj = "⚠️ Lütfen tüm alanları doldurun.";
    } elseif ($sifre !== $sifre_tekrar) {
        $mesaj = "❌ Şifreler uyuşmuyor!";
    } else {
        // Mükerrer Kayıt Kontrolü
        $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ? OR email = ?");
        $kontrol->execute([$kadi, $email]);
        
        if ($kontrol->rowCount() > 0) {
            $mesaj = "⚠️ Bu kullanıcı adı veya e-posta zaten kayıtlı.";
        } else {
            // KAYIT İŞLEMİ
            $yeni_sifre = md5($sifre);
            // Rastgele Doğrulama Kodu Üret (Benzersiz)
            $dogrulama_kodu = md5(uniqid(rand(), true));

            // Varsayılan: Rol='uye', Durum='aktif', Ceza=0, Doğrulama=0 (PASİF)
            $sql = "INSERT INTO kullanicilar (kullanici_adi, email, sifre, rol, hesap_durumu, ceza_puani, dogrulama_kodu, dogrulama_durumu) 
                    VALUES (?, ?, ?, 'uye', 'aktif', 0, ?, 0)";
            $stmt = $db->prepare($sql);
            
            if ($stmt->execute([$kadi, $email, $yeni_sifre, $dogrulama_kodu])) {
                
                // 📧 MAİL GÖNDERME (GEZİ TEMALI)
                if (file_exists('includes/mail_sender.php')) {
                    require_once 'includes/mail_sender.php';
                    
                    // Doğrulama Linki (Localhost yoluna dikkat et)
                    $link = "http://localhost/GeziRehberi/dogrula.php?kod=$dogrulama_kodu&email=$email";

                    $konu = "Hoş Geldin Gezgin! Hesabını Doğrula 🌍";
                    
                    // --- MAİL TASARIMI BAŞLANGICI ---
                    $icerik = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden;'>
                        <div style='background-color: #228B22; padding: 20px; text-align: center; color: white;'>
                            <h1 style='margin: 0; font-size: 24px;'>GEZİ REHBERİ</h1>
                            <p style='margin: 5px 0 0; font-size: 14px;'>Rotanı Oluştur, Dünyayı Keşfet!</p>
                        </div>
                        
                        <div style='padding: 30px; background-color: white; text-align: center;'>
                            <img src='https://cdn-icons-png.flaticon.com/512/201/201623.png' alt='Uçak' style='width: 80px; margin-bottom: 20px;'>
                            
                            <h2 style='color: #333; margin-top: 0;'>Merhaba $kadi! 👋</h2>
                            <p style='color: #666; font-size: 16px; line-height: 1.6;'>
                                Aramıza katıldığın için çok mutluyuz. Gezi Rehberi ailesi olarak yeni maceralarında yanında olmaktan heyecan duyuyoruz.
                            </p>
                            <p style='color: #666; font-size: 16px;'>
                                Hesabını aktifleştirmek ve yorum yapmaya başlamak için lütfen aşağıdaki butona tıkla:
                            </p>
                            
                            <a href='$link' style='display: inline-block; background-color: #228B22; color: white; text-decoration: none; padding: 12px 30px; border-radius: 25px; font-weight: bold; margin-top: 20px; font-size: 16px;'>Hesabımı Doğrula</a>
                            
                            <p style='color: #999; font-size: 12px; margin-top: 30px;'>
                                Eğer bu kaydı sen yapmadıysan, bu maili görmezden gelebilirsin.
                            </p>
                        </div>
                        
                        <div style='background-color: #f1f1f1; padding: 15px; text-align: center; color: #888; font-size: 12px;'>
                            &copy; 2025 Gezi Rehberi. Tüm hakları saklıdır.
                        </div>
                    </div>
                    ";
                    // --- MAİL TASARIMI BİTİŞİ ---

                    if (function_exists('mailGonder')) {
                        mailGonder($email, $kadi, $konu, $icerik);
                    }
                }

                // Kullanıcıyı Bilgilendir
                $mesaj = "✅ Kayıt başarılı! Lütfen e-posta adresine giden linke tıkla ve hesabını onayla.";
            } else {
                $mesaj = "❌ Bir hata oluştu.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Aramıza Katıl</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ... Eski CSS kodların buraya gelecek (turuncu/yeşil tema hangisini istiyorsan) ... */
        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: 'Poppins', sans-serif; }
        .main-wrapper { display: flex; background: white; border-radius: 15px; box-shadow: 0 15px 50px rgba(0,0,0,0.1); width: 900px; height: 600px; overflow: hidden; }
        .image-side { flex: 1; background: #e8f5e9; position: relative; display:flex; align-items:center; justify-content:center; } /* Yeşil Tema */
        .image-side img { width: 200px; }
        .login-side { flex: 1; padding: 40px; display: flex; flex-direction: column; justify-content: center; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; font-size: 13px; color:#555; margin-bottom:5px;}
        .form-group input { width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; box-sizing:border-box;}
        .login-button { width: 100%; padding: 12px; background: #228B22; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top:10px;}
        .register-link { text-align: center; margin-top: 15px; font-size: 13px; }
        .error-msg { background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center; font-size: 13px; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="image-side">
            <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" alt="Gezi">
        </div>
        <div class="login-side">
            <h2>Gezgin Ol</h2>
            <?php if($mesaj): ?>
                <div class="error-msg"><?php echo $mesaj; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group"><label>Kullanıcı Adı</label><input type="text" name="username" required></div>
                <div class="form-group"><label>E-posta</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Şifre</label><input type="password" name="password" required></div>
                <div class="form-group"><label>Şifre (Tekrar)</label><input type="password" name="password_confirm" required></div>
                <button type="submit" class="login-button">Kayıt Ol</button>
                <div class="register-link">Zaten üye misin? <a href="giris.php" style="color:#228B22; font-weight:bold;">Giriş Yap</a></div>
            </form>
        </div>
    </div>
</body>
</html>