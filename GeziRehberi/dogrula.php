<?php
require_once 'includes/db.php';

// Linkten gelen kod ve maili al
if (isset($_GET['kod']) && isset($_GET['email'])) {
    $kod = $_GET['kod'];
    $email = $_GET['email'];

    // Bu koda sahip ve henüz doğrulanmamış (0) kullanıcıyı ara
    $stmt = $db->prepare("SELECT id, kullanici_adi FROM kullanicilar WHERE email = ? AND dogrulama_kodu = ? AND dogrulama_durumu = 0");
    $stmt->execute([$email, $kod]);
    $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($kullanici) {
        // KULLANICI BULUNDU!
        // 1. Hesabı onayla (dogrulama_durumu = 1)
        // 2. Kodu temizle (Güvenlik için, tekrar kullanılamasın)
        $update = $db->prepare("UPDATE kullanicilar SET dogrulama_durumu = 1, dogrulama_kodu = '' WHERE id = ?");
        $update->execute([$kullanici['id']]);
        
        // BAŞARILI EKRANI
        $baslik = "Tebrikler " . htmlspecialchars($kullanici['kullanici_adi']) . "! 🎉";
        $mesaj = "Hesabın başarıyla doğrulandı. Artık özgürce yorum yapabilir ve puan verebilirsin.";
        $ikon = "✅";
        $renk = "#228B22"; // Yeşil
    } else {
        // HATA EKRANI (Kod yanlış veya zaten doğrulanmış)
        $baslik = "Hata Oluştu 😔";
        $mesaj = "Bu doğrulama linki geçersiz veya daha önce kullanılmış.";
        $ikon = "❌";
        $renk = "#e74c3c"; // Kırmızı
    }
} else {
    // Kod yoksa anasayfaya at
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hesap Doğrulama</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; max-width: 400px; width: 90%; }
        .icon { font-size: 60px; margin-bottom: 20px; display: block; }
        h1 { color: <?php echo $renk; ?>; margin: 0 0 15px; font-size: 24px; }
        p { color: #666; font-size: 16px; line-height: 1.6; margin-bottom: 30px; }
        .btn { background-color: <?php echo $renk; ?>; color: white; text-decoration: none; padding: 12px 30px; border-radius: 25px; font-weight: bold; transition: 0.3s; display: inline-block; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="card">
        <span class="icon"><?php echo $ikon; ?></span>
        <h1><?php echo $baslik; ?></h1>
        <p><?php echo $mesaj; ?></p>
        <a href="giris.php" class="btn">Giriş Yap</a>
    </div>

</body>
</html>