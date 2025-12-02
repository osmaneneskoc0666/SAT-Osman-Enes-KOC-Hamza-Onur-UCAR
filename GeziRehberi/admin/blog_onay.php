<?php
// Çıktı tamponlamayı başlat
ob_start();

// Header'ı dahil et (DB, Güvenlik, Sidebar, HTML Başlangıcı)
include 'header.php';

// --- İŞLEM: ONAYLA ---
if (isset($_GET['onayla'])) {
    $db->prepare("UPDATE blog SET onay_durumu = 'onaylandi' WHERE id = ?")->execute([$_GET['onayla']]);
    
    // Log (Opsiyonel)
    if(function_exists('logKaydet')) logKaydet($db, "Blog Onaylandı", "ID: " . $_GET['onayla']);
    
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
    
    // Log (Opsiyonel)
    if(function_exists('logKaydet')) logKaydet($db, "Blog Reddedildi", "ID: $blog_id, Sebep: $sebep");

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

<style>
    .item { border-bottom: 1px solid #eee; padding: 20px 0; display: flex; gap: 20px; align-items: flex-start; }
    .item:last-child { border-bottom: none; }
    
    .item img { width: 120px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #eee; }
    
    .info { flex: 1; }
    .info h3 { margin: 0 0 5px; color: #2c3e50; font-size: 16px; }
    .info p { margin: 0 0 10px; font-size: 13px; color: #666; line-height: 1.4; }
    
    .meta { font-size: 12px; color: #888; background: #f9f9f9; display: inline-block; padding: 5px 10px; border-radius: 4px; }
    
    .actions { display: flex; flex-direction: column; gap: 8px; min-width: 140px; }
    
    .btn-ok { background: #27ae60; color: white; border: none; padding: 8px; border-radius: 5px; text-decoration: none; text-align: center; font-size: 13px; font-weight: bold; display: block; }
    .btn-ok:hover { background: #219150; }
    
    .btn-no { background: #e74c3c; color: white; border: none; padding: 8px; border-radius: 0 5px 5px 0; cursor: pointer; font-size: 13px; font-weight: bold; }
    .btn-no:hover { background: #c0392b; }
    
    .reject-form { display: flex; }
    .reject-input { padding: 8px; border: 1px solid #ddd; border-radius: 5px 0 0 5px; width: 100%; font-size: 12px; border-right: none; }
    
    .warning { background: #f39c12; color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; margin-left: 5px; }
</style>

<div class="box">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #eee; padding-bottom:15px; margin-bottom:15px;">
        <h2 style="margin:0; font-size:20px;">⏳ Onay Bekleyen Yazılar</h2>
    </div>

    <?php if(empty($bekleyenler)) echo "<div style='text-align:center; padding:40px; color:#999;'><i class='fas fa-check-circle' style='font-size:40px; margin-bottom:10px; display:block; color:#eee;'></i>Şu an bekleyen yazı yok, hepsi temiz!</div>"; ?>

    <?php foreach($bekleyenler as $yazi): ?>
    <div class="item">
        <img src="../<?php echo $yazi['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/120'">
        
        <div class="info">
            <h3><?php echo htmlspecialchars($yazi['baslik']); ?></h3>
            <p><?php echo htmlspecialchars($yazi['ozet']); ?></p>
            
            <div class="meta">
                <i class="fas fa-user"></i> <strong><?php echo $yazi['kullanici_adi']; ?></strong> 
                <?php if($yazi['ceza_puani'] > 0) echo "<span class='warning'>{$yazi['ceza_puani']} Ceza</span>"; ?>
                &nbsp;|&nbsp; 
                <i class="far fa-clock"></i> <?php echo date("d.m.Y H:i", strtotime($yazi['tarih'])); ?>
            </div>
        </div>
        
        <div class="actions">
            <a href="?onayla=<?php echo $yazi['id']; ?>" class="btn-ok"><i class="fas fa-check"></i> Onayla</a>
            
            <form method="POST" class="reject-form">
                <input type="hidden" name="reddet_id" value="<?php echo $yazi['id']; ?>">
                <input type="hidden" name="yazar_id" value="<?php echo $yazi['yazar_id']; ?>">
                <input type="text" name="sebep" placeholder="Red Sebebi..." required class="reject-input">
                <button type="submit" class="btn-no"><i class="fas fa-times"></i></button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php 
// Footer'ı dahil et
include 'footer.php'; 
// Tamponu boşalt
ob_end_flush();
?>