<?php
session_start();
require_once '../includes/db.php';

// Güvenlik
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }

// --- İŞLEM: ONAYLA ---
if (isset($_GET['onayla'])) {
    $db->prepare("UPDATE blog SET onay_durumu = 'onaylandi' WHERE id = ?")->execute([$_GET['onayla']]);
    header("Location: blog_onay.php?msg=onaylandi"); exit;
}

// --- İŞLEM: REDDET VE CEZA VER ---
if (isset($_POST['reddet_id'])) {
    $blog_id = $_POST['reddet_id'];
    $yazar_id = $_POST['yazar_id'];
    $sebep = $_POST['sebep'];

    // 1. Yazıyı Reddedildi Olarak İşaretle
    $db->prepare("UPDATE blog SET onay_durumu = 'reddedildi', red_sebebi = ? WHERE id = ?")->execute([$sebep, $blog_id]);

    // 2. Yazara Ceza Puanı Ekle (+1)
    $db->prepare("UPDATE kullanicilar SET ceza_puani = ceza_puani + 1 WHERE id = ?")->execute([$yazar_id]);

    // 3. Ceza Puanını Kontrol Et (3 olduyse hesabı askıya al)
    $uye = $db->query("SELECT ceza_puani FROM kullanicilar WHERE id = $yazar_id")->fetch(PDO::FETCH_ASSOC);
    if ($uye['ceza_puani'] >= 3) {
        $db->prepare("UPDATE kullanicilar SET hesap_durumu = 'askida' WHERE id = ?")->execute([$yazar_id]);
    }

    header("Location: blog_onay.php?msg=reddedildi"); exit;
}

// Onay Bekleyenleri Çek
$bekleyenler = $db->query("
    SELECT blog.*, kullanicilar.kullanici_adi, kullanicilar.ceza_puani 
    FROM blog 
    JOIN kullanicilar ON blog.yazar_id = kullanicilar.id 
    WHERE blog.onay_durumu = 'onay_bekliyor' 
    ORDER BY blog.tarih DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Blog Onay Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #e8ecf1; padding: 40px; }
        .box { background: white; padding: 30px; border-radius: 10px; max-width: 900px; margin: 0 auto; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .item { border-bottom: 1px solid #eee; padding: 20px 0; display: flex; gap: 20px; }
        .item img { width: 100px; height: 70px; object-fit: cover; border-radius: 5px; }
        .info { flex: 1; }
        .actions { display: flex; flex-direction: column; gap: 5px; }
        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; color: white; text-decoration: none; font-size: 13px; text-align: center; }
        .btn-ok { background: #27ae60; }
        .btn-no { background: #e74c3c; }
        .warning { background: #f39c12; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; }
    </style>
</head>
<body>
    <div class="box">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #eee; padding-bottom:15px;">
            <h2>⏳ Onay Bekleyen Yazılar</h2>
            <a href="panel.php" style="text-decoration:none; color:#555;">← Panele Dön</a>
        </div>

        <?php if(empty($bekleyenler)) echo "<p style='text-align:center; padding:30px; color:#999;'>Şu an bekleyen yazı yok.</p>"; ?>

        <?php foreach($bekleyenler as $yazi): ?>
        <div class="item">
            <img src="../<?php echo $yazi['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/100'">
            <div class="info">
                <h3 style="margin:0; color:#2c3e50;"><?php echo $yazi['baslik']; ?></h3>
                <p style="margin:5px 0; font-size:13px; color:#666;"><?php echo $yazi['ozet']; ?></p>
                <div style="font-size:12px; color:#888;">
                    Yazar: <strong><?php echo $yazi['kullanici_adi']; ?></strong> 
                    <?php if($yazi['ceza_puani'] > 0) echo "<span class='warning'>{$yazi['ceza_puani']} Ceza Puanı</span>"; ?>
                </div>
            </div>
            <div class="actions">
                <a href="?onayla=<?php echo $yazi['id']; ?>" class="btn btn-ok">✅ Onayla</a>
                
                <form method="POST" style="display:flex; gap:5px;">
                    <input type="hidden" name="reddet_id" value="<?php echo $yazi['id']; ?>">
                    <input type="hidden" name="yazar_id" value="<?php echo $yazi['yazar_id']; ?>">
                    <input type="text" name="sebep" placeholder="Red Sebebi..." required style="padding:5px; border:1px solid #ddd; border-radius:5px; width:120px;">
                    <button type="submit" class="btn btn-no">🚫 Reddet</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>