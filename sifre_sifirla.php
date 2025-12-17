<?php
require_once 'includes/db.php';

$mesaj = "";
$kod = $_GET['kod'] ?? '';
$email = $_GET['email'] ?? '';
$formu_goster = false;

// 1. KOD KONTROLÜ
if ($kod && $email) {
    $stmt = $db->prepare("SELECT id FROM kullanicilar WHERE email = ? AND sifirlama_kodu = ?");
    $stmt->execute([$email, $kod]);
    
    if ($stmt->rowCount() > 0) {
        $formu_goster = true;
    } else {
        $mesaj = "<div class='alert error'>❌ Bu bağlantı geçersiz veya daha önce kullanılmış.</div>";
    }
} else {
    header("Location: index.php"); exit;
}

// 2. ŞİFREYİ GÜNCELLEME
if ($_SERVER["REQUEST_METHOD"] == "POST" && $formu_goster) {
    $yeni_sifre = $_POST['password'];
    $tekrar = $_POST['re_password'];

    // --- GÜVENLİK KONTROLLERİ ---
    if ($yeni_sifre !== $tekrar) {
        $mesaj = "<div class='alert error'>⚠️ Şifreler uyuşmuyor.</div>";
    } elseif (strlen($yeni_sifre) < 8) {
        $mesaj = "<div class='alert error'>⚠️ Şifre en az 8 karakter olmalı.</div>";
    } elseif (!preg_match("/[a-z]/", $yeni_sifre)) {
        $mesaj = "<div class='alert error'>⚠️ Şifre en az 1 küçük harf içermeli.</div>";
    } elseif (!preg_match("/[A-Z]/", $yeni_sifre)) {
        $mesaj = "<div class='alert error'>⚠️ Şifre en az 1 büyük harf içermeli.</div>";
    } else {
        $hash_sifre = md5($yeni_sifre);
        $update = $db->prepare("UPDATE kullanicilar SET sifre = ?, sifirlama_kodu = NULL WHERE email = ?");
        
        if ($update->execute([$hash_sifre, $email])) {
            $mesaj = "<div class='alert success'>🎉 Şifreniz başarıyla değiştirildi! Yönlendiriliyorsunuz...</div>";
            $formu_goster = false; 
            header("refresh:3;url=giris.php"); 
        } else {
            $mesaj = "<div class='alert error'>Bir hata oluştu.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Şifre Belirle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        
        /* Input Grubu (Göz ikonunu konumlandırmak için) */
        .input-group { position: relative; margin-bottom: 15px; }
        
        input { width: 100%; padding: 12px; padding-right: 40px; /* İkon için yer aç */ border: 2px solid #eee; border-radius: 8px; box-sizing: border-box; }
        input:focus { border-color: #228B22; outline: none; }
        
        /* Göz İkonu Stili */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            cursor: pointer;
            z-index: 10;
        }
        .toggle-password:hover { color: #333; }

        .btn { width: 100%; padding: 12px; background: #228B22; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px; }
        .btn:hover { background: #1a6f1a; }
        
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 13px; text-align: left; }
        .alert.success { background: #d4edda; color: #155724; }
        .alert.error { background: #f8d7da; color: #721c24; }
        .info-text { font-size: 12px; color: #666; margin-bottom: 15px; text-align: left; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color:#228B22;">Yeni Şifre</h2>
        
        <?php echo $mesaj; ?>

        <?php if ($formu_goster): ?>
        <form method="POST">
            <div class="info-text">
                ℹ️ Şifreniz en az <strong>8 karakter</strong>, <strong>1 büyük harf</strong> ve <strong>1 küçük harf</strong> içermelidir.
            </div>
            
            <div class="input-group">
                <input type="password" name="password" id="pass1" required placeholder="Yeni Şifreniz">
                <i class="fas fa-eye toggle-password" onclick="sifreGoster('pass1', this)"></i>
            </div>

            <div class="input-group">
                <input type="password" name="re_password" id="pass2" required placeholder="Şifre Tekrar">
                <i class="fas fa-eye toggle-password" onclick="sifreGoster('pass2', this)"></i>
            </div>

            <button type="submit" class="btn">Şifreyi Kaydet</button>
        </form>
        <?php else: ?>
            <?php if(strpos($mesaj, 'Geçersiz') !== false): ?>
                <a href="sifremi_unuttum.php" style="color:#228B22; font-weight:bold; text-decoration:none;">Tekrar kod iste</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
        function sifreGoster(inputId, icon) {
            const input = document.getElementById(inputId);
            
            if (input.type === "password") {
                input.type = "text"; // Şifreyi aç
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash"); // İkonu çizik göz yap
            } else {
                input.type = "password"; // Şifreyi gizle
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye"); // İkonu normal göz yap
            }
        }
    </script>

</body>
</html>