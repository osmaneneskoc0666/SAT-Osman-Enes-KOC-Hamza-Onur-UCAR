<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if ($_SESSION['user_role'] == 'admin') {
        logKaydet($db, "Giriş Yaptı", "Başarılı giriş");
        header("Location: admin/panel.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$hata_mesaji = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $girdi = $_POST['username'];
    $sifre = md5($_POST['password']);

    $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE (kullanici_adi = :girdi OR email = :girdi) AND sifre = :sifre");
    $stmt->execute([':girdi' => $girdi, ':sifre' => $sifre]);
    $uye = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($uye) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $uye['id'];
        $_SESSION['user_name'] = $uye['kullanici_adi'];
        $_SESSION['user_role'] = $uye['rol'];

        if ($uye['rol'] == 'admin') {
            header("Location: admin/panel.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $hata_mesaji = "Kullanıcı adı, e-posta veya şifre yanlış!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* SIFIRLAMA VE GENEL AYARLAR */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { 
            background-color: #254e25ff; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            overflow: hidden; /* Animasyon dışarı taşmasın */
        }

        /* ANA KAPSAYICI */
        .main-wrapper { 
            display: flex; 
            background-color: white; 
            border-radius: 15px; 
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1); 
            width: 900px; 
            height: 550px; 
            overflow: hidden; 
        }

        /* SOL TARAF: ANİMASYON ALANI */
        .image-side { 
            flex: 1; 
            background-color: #e8ecf1; 
            position: relative; 
            overflow: hidden; /* Resim dışarı taşmasın */
        }
        
        .image-side img { 
            position: absolute; 
            width: 180px; /* Resim boyutu */
            top: 20px; 
            left: 20px; 
        }

        /* SAĞ TARAF: FORM ALANI */
        .login-side { 
            flex: 1; 
            padding: 50px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        }

        h2 { text-align: center; color: #333; margin-bottom: 30px; font-size: 28px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; font-size: 14px; }
        .form-group input { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; transition: 0.3s; font-size: 14px; }
        .form-group input:focus { border-color: #228B22; outline: none; }
        
        .login-button { width: 100%; padding: 14px; background-color: #228B22; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; }
        .login-button:hover { background-color: #1a6f1a; transform: translateY(-2px); }
        
        .register-link { text-align: center; margin-top: 15px; font-size: 13px; color: #666; }
        .register-link a { color: #228B22; font-weight: bold; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        .error-msg { background-color: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 14px; border-left: 5px solid #ef5350; }

        /* MOBİL UYUM */
        @media (max-width: 768px) {
            .main-wrapper { flex-direction: column; width: 90%; height: auto; }
            .image-side { height: 150px; display: flex; justify-content: center; align-items: center; }
            .image-side img { position: static; width: 100px; } /* Mobilde animasyonu durdur */
            .login-side { padding: 30px; }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="image-side" id="imageSide"> 
            <img id="hareketliResim" src="images/panel resmi.png" alt="Türkiye"> 
        </div>

        <div class="login-side">
            <h2>Giriş Yap</h2>
            
            <?php if($hata_mesaji): ?>
                <div class="error-msg"><i class="fas fa-exclamation-triangle"></i> <?php echo $hata_mesaji; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Kullanıcı Adı veya E-posta</label>
                    <input type="text" name="username" required placeholder="Giriş bilginiz...">
                </div>
                
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" name="password" required placeholder="******">
                </div>
                
                <button type="submit" class="login-button">Giriş Yap</button>
                
                <div class="register-link">
                    Hesabın yok mu? <a href="kayit.php">Hemen Kayıt Ol</a>
                </div>
                <div class="register-link">
                    <a href="index.php" style="color:#777;">← Siteye Dön</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const resim = document.getElementById('hareketliResim');
        const kapsayici = document.getElementById('imageSide');

        if (window.innerWidth > 768) { // Sadece bilgisayarda çalışsın
            const padding = 20;
            let x = padding;
            let y = padding;
            
            // Hızları biraz artırdım ki daha canlı olsun
            let hizX = 2; 
            let hizY = 2;

            function hareketEttir() {
                x += hizX;
                y += hizY;

                const resimGenisligi = resim.offsetWidth;
                const resimYuksekligi = resim.offsetHeight;
                const kapsayiciGenisligi = kapsayici.clientWidth;
                const kapsayiciYuksekligi = kapsayici.clientHeight;

                // Sağ Duvara Çarpma
                if (x + resimGenisligi >= kapsayiciGenisligi - padding) {
                    hizX = -Math.abs(hizX);
                    x = kapsayiciGenisligi - resimGenisligi - padding;
                } 
                // Sol Duvara Çarpma
                else if (x <= padding) {
                    hizX = Math.abs(hizX);
                    x = padding;
                }

                // Alt Duvara Çarpma
                if (y + resimYuksekligi >= kapsayiciYuksekligi - padding) {
                    hizY = -Math.abs(hizY);
                    y = kapsayiciYuksekligi - resimYuksekligi - padding;
                }
                // Üst Duvara Çarpma
                else if (y <= padding) {
                    hizY = Math.abs(hizY);
                    y = padding;
                }

                resim.style.left = x + 'px';
                resim.style.top = y + 'px';

                requestAnimationFrame(hareketEttir);
            }

            // Başlat
            requestAnimationFrame(hareketEttir);
        }
    </script>

</body>
</html>