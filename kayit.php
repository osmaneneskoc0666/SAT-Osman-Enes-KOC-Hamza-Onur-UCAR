<?php
session_start();
require_once 'includes/db.php';

$mesaj = "";

// Eğer zaten giriş yapmışsa direkt ana sayfaya at
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
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
        // Kullanıcı var mı kontrol et
        $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ? OR email = ?");
        $kontrol->execute([$kadi, $email]);
        
        if ($kontrol->rowCount() > 0) {
            $mesaj = "⚠️ Bu kullanıcı adı veya e-posta zaten kayıtlı.";
        } else {
            // Kayıt İşlemi
            $yeni_sifre = md5($sifre);
            // Varsayılan rol 'uye', hesap durumu 'aktif', ceza puanı 0
            $ekle = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre, rol, hesap_durumu, ceza_puani) VALUES (?, ?, ?, 'uye', 'aktif', 0)");
            
            if ($ekle->execute([$kadi, $email, $yeni_sifre])) {
                // Başarılı! Girişe yönlendir
                header("Location: giris.php?kayit=basarili");
                exit;
            } else {
                $mesaj = "❌ Bir hata oluştu, lütfen tekrar deneyin.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aramıza Katıl</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* GİRİŞ SAYFASIYLA AYNI STİLLER */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { 
            background-color: #f0f2f5; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            overflow: hidden; 
        }

        .main-wrapper { 
            display: flex; 
            background-color: white; 
            border-radius: 15px; 
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1); 
            width: 900px; 
            height: 600px; /* Kayıt formu uzun olduğu için boyu biraz artırdık */
            overflow: hidden; 
        }

        /* SOL TARAF: ANİMASYON ALANI (TURUNCU TEMA) */
        .image-side { 
            flex: 1; 
            background-color: #fff3e0; /* Giriş sayfasından farklı olsun diye açık turuncu yaptım */
            position: relative; 
            overflow: hidden; 
        }
        
        .image-side img { 
            position: absolute; 
            width: 180px; 
            top: 20px; 
            left: 20px; 
        }

        /* SAĞ TARAF: FORM ALANI */
        .login-side { 
            flex: 1; 
            padding: 40px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        }

        h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 26px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; font-size: 13px; }
        .form-group input { width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; transition: 0.3s; font-size: 14px; }
        .form-group input:focus { border-color: #e67e22; outline: none; } /* Turuncu odak rengi */
        
        .login-button { width: 100%; padding: 12px; background-color: #e67e22; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; margin-top: 10px; }
        .login-button:hover { background-color: #d35400; transform: translateY(-2px); }
        
        .register-link { text-align: center; margin-top: 15px; font-size: 13px; color: #666; }
        .register-link a { color: #e67e22; font-weight: bold; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        .error-msg { background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center; font-size: 13px; border-left: 5px solid #ef5350; }

        /* MOBİL UYUM */
        @media (max-width: 768px) {
            .main-wrapper { flex-direction: column; width: 90%; height: auto; }
            .image-side { height: 100px; display: flex; justify-content: center; align-items: center; }
            .image-side img { position: static; width: 80px; }
            .login-side { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="image-side" id="imageSide"> 
            <img id="kayitResmi" src="images/kayit_resmi.png" onerror="this.src='https://cdn-icons-png.flaticon.com/512/9985/9985702.png'" alt="Kayıt Görseli"> 
        </div>

        <div class="login-side">
            <h2>Aramıza Katıl</h2>
            
            <?php if($mesaj): ?>
                <div class="error-msg"><i class="fas fa-exclamation-triangle"></i> <?php echo $mesaj; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Kullanıcı Adı</label>
                    <input type="text" name="username" required placeholder="Örn: gezgin_ali">
                </div>

                <div class="form-group">
                    <label>E-posta Adresi</label>
                    <input type="email" name="email" required placeholder="ornek@email.com">
                </div>
                
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" name="password" required placeholder="******">
                </div>

                <div class="form-group">
                    <label>Şifre (Tekrar)</label>
                    <input type="password" name="password_confirm" required placeholder="******">
                </div>
                
                <button type="submit" class="login-button">Kayıt Ol</button>
                
                <div class="register-link">
                    Zaten üye misin? <a href="giris.php">Giriş Yap</a>
                </div>
                <div class="register-link">
                    <a href="index.php" style="color:#777;">← Siteye Dön</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const resim = document.getElementById('kayitResmi');
        const kapsayici = document.getElementById('imageSide');

        if (window.innerWidth > 768) { 
            const padding = 20;
            let x = padding;
            let y = padding;
            
            // Hızlar ve yönler (Rastgele başlasın)
            let hizX = (Math.random() * 2) + 1.5; 
            let hizY = (Math.random() * 2) + 1.5;

            function hareketEttir() {
                x += hizX;
                y += hizY;

                const resimGenisligi = resim.offsetWidth;
                const resimYuksekligi = resim.offsetHeight;
                const kapsayiciGenisligi = kapsayici.clientWidth;
                const kapsayiciYuksekligi = kapsayici.clientHeight;

                // Sağ Duvar
                if (x + resimGenisligi >= kapsayiciGenisligi - padding) {
                    hizX = -Math.abs(hizX);
                    x = kapsayiciGenisligi - resimGenisligi - padding;
                } 
                // Sol Duvar
                else if (x <= padding) {
                    hizX = Math.abs(hizX);
                    x = padding;
                }

                // Alt Duvar
                if (y + resimYuksekligi >= kapsayiciYuksekligi - padding) {
                    hizY = -Math.abs(hizY);
                    y = kapsayiciYuksekligi - resimYuksekligi - padding;
                }
                // Üst Duvar
                else if (y <= padding) {
                    hizY = Math.abs(hizY);
                    y = padding;
                }

                resim.style.left = x + 'px';
                resim.style.top = y + 'px';

                requestAnimationFrame(hareketEttir);
            }

            // Resmi yüklenince başlat (Bazen resim geç yüklenirse boyut 0 gelir)
            if (resim.complete) {
                hareketEttir();
            } else {
                resim.onload = hareketEttir;
            }
        }
    </script>

</body>
</html>