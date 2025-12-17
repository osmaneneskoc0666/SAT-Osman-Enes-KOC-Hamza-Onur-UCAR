<?php
session_start();
require_once 'includes/db.php'; 

// Kullanıcı giriş kontrolü
if (!isset($_SESSION['logged_in'])) {
    header("Location: giris.php");
    exit;
}

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST['baslik'];
    $ozet   = $_POST['ozet'];
    $icerik = $_POST['icerik'];
    $yazar_id = $_SESSION['id'] ?? $_SESSION['user_id']; 

    $resim_url = "";

    // 1. Dosya Yükleme
    if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] == 0) {
        $uzanti = strtolower(pathinfo($_FILES['dosya']['name'], PATHINFO_EXTENSION));
        $izinli = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($uzanti, $izinli)) {
            $yeni_ad = "blog_" . uniqid() . "." . $uzanti;
            if (!is_dir('images')) mkdir('images');
            
            if (move_uploaded_file($_FILES['dosya']['tmp_name'], "images/" . $yeni_ad)) {
                $resim_url = "images/" . $yeni_ad;
            }
        }
    } elseif (!empty($_POST['resim_link'])) {
        $resim_url = $_POST['resim_link'];
    }

    // 2. DB'ye Ekleme (DÜZELTİLDİ: 'rota' kategorisi eklendi)
    // Artık bu formdan gelen her şey 'rota' olarak etiketlenecek.
    $sql = "INSERT INTO blog (baslik, ozet, icerik, resim_url, yazar_id, tarih, onay_durumu, kategori) VALUES (?, ?, ?, ?, ?, NOW(), 'onay_bekliyor', 'rota')";
    $stmt = $db->prepare($sql);
    
    if ($stmt->execute([$baslik, $ozet, $icerik, $resim_url, $yazar_id])) {
        $mesaj = '<div class="alert success">✅ Rotanız başarıyla gönderildi! Editör onayından sonra "Sizin Rotanız" bölümünde yayınlanacaktır.</div>';
    } else {
        $mesaj = '<div class="alert error">❌ Bir hata oluştu. Lütfen tekrar deneyin.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sizin Keşfettiğiniz Yerler</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #98fb98; margin: 0; }
        .navbar { background: #228B22; padding: 15px 30px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; font-size: 14px; }
        .container { max-width: 800px; margin: 60px auto; background: white; padding: 50px; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0; display: flex; align-items: center; gap: 10px; }
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; font-size: 13px; text-transform: uppercase; }
        input[type="text"], textarea { width: 100%; padding: 15px; margin-top: 8px; border: 2px solid #f0f0f0; border-radius: 10px; background: #fff; box-sizing: border-box; transition: 0.3s; font-family: inherit; }
        input:focus, textarea:focus { outline: none; border-color: #228B22; background: #f9fff9; }
        .file-area { border: 2px dashed #ddd; padding: 25px; border-radius: 10px; margin-top: 8px; text-align: center; background: #fafafa; }
        button { width: 100%; background-color: #228B22; color: white; padding: 18px; border: none; border-radius: 50px; font-size: 16px; cursor: pointer; margin-top: 30px; font-weight: bold; transition: 0.3s; }
        button:hover { background-color: #1e7e1e; transform: translateY(-3px); }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 25px; font-weight: bold; font-size: 14px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="navbar">
    <div style="font-weight:bold; font-size:20px;"><i class="fas fa-paper-plane"></i> GEZİ REHBERİ</div>
    <div>
        <a href="index.php"><b>Ana Sayfa</b></a>
    </div>
</div>

<div class="container">
    <?php echo $mesaj; ?>
    <h2><i class="fas fa-edit" style="color:#228B22;"></i>Kullanıcıların Keşifleri</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Rota Başlığı</label>
        <input type="text" name="baslik" placeholder="Örn: Kapadokya'da Balon Turu Deneyimi" required>

        <label>Kısa Özet</label>
        <input type="text" name="ozet" placeholder="Okuyucuyu çekecek kısa bir cümle..." required>

        <label>Kapak Resmi</label>
        <div class="file-area">
            <input type="file" name="dosya" style="border:none; background:transparent;">
            <div style="margin: 10px 0; font-size: 11px; color:#aaa; font-weight:bold;">- VEYA -</div>
            <input type="text" name="resim_link" placeholder="https://... (Resim Linki Yapıştır)">
        </div>

        <label>Rota Detayları</label>
        <textarea name="icerik" rows="10" placeholder="Tüm detayları buraya yazın..." required></textarea>

        <button type="submit"><i class="fas fa-paper-plane"></i> Rotayı Gönder</button>
    </form>
</div>

</body>
</html>