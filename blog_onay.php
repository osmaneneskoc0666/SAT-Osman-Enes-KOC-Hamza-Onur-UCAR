<?php
ob_start();
include 'header.php'; 

// --- İŞLEM 1: ONAYLA ---
if (isset($_GET['onayla'])) {
    $id = $_GET['onayla'];
    $db->prepare("UPDATE blog SET onay_durumu = 'onaylandi' WHERE id = ?")->execute([$id]);
    header("Location: blog_onay.php?msg=onaylandi"); 
    exit;
}

// --- İŞLEM 2: REDDET VE CEZA VER ---
if (isset($_POST['reddet_id'])) {
    $blog_id = $_POST['reddet_id'];
    $yazar_id = $_POST['yazar_id'];
    $sebep = $_POST['sebep'];

    // 1. Yazıyı Reddet
    $db->prepare("UPDATE blog SET onay_durumu = 'reddedildi', red_sebebi = ? WHERE id = ?")->execute([$sebep, $blog_id]);

    // 2. Ceza Puanı Ekle
    $db->prepare("UPDATE kullanicilar SET ceza_puani = ceza_puani + 1 WHERE id = ?")->execute([$yazar_id]);

    // 3. Hesap Askıya Alma (3 ceza puanı)
    $uye = $db->query("SELECT ceza_puani FROM kullanicilar WHERE id = $yazar_id")->fetch(PDO::FETCH_ASSOC);
    if ($uye && $uye['ceza_puani'] >= 3) {
        $db->prepare("UPDATE kullanicilar SET hesap_durumu = 'askida' WHERE id = ?")->execute([$yazar_id]);
    }

    header("Location: blog_onay.php?msg=reddedildi"); 
    exit;
}

// ONAY BEKLEYENLERİ ÇEK
$bekleyenler = $db->query("
    SELECT blog.*, kullanicilar.kullanici_adi, kullanicilar.ceza_puani 
    FROM blog 
    JOIN kullanicilar ON blog.yazar_id = kullanicilar.id 
    WHERE blog.onay_durumu = 'onay_bekliyor' 
    ORDER BY blog.tarih DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .approval-card {
        background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 20px;
        border: 1px solid #f0f0f0; transition: transform 0.2s;
    }
    .approval-card:hover { transform: translateY(-2px); }
    .approval-img { width: 120px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #eee; }
    .approval-content { flex: 1; }
    .approval-content h3 { margin: 0 0 8px 0; font-size: 18px; color: #2c3e50; font-weight: 700; }
    .approval-content p { margin: 0 0 10px 0; color: #7f8c8d; font-size: 14px; line-height: 1.4; }
    .approval-meta { font-size: 12px; color: #95a5a6; font-weight: 500; background: #f8f9fa; display: inline-block; padding: 4px 10px; border-radius: 4px; }
    .approval-actions { display: flex; flex-direction: column; gap: 10px; align-items: flex-end; min-width: 260px; }
    .btn-approve-big { background-color: #27ae60; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; width: 100%; text-align: center; text-decoration: none; font-size: 14px; display: block; box-sizing: border-box; }
    .btn-approve-big:hover { background-color: #219150; }
    .reject-group { display: flex; width: 100%; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .reject-input { flex: 1; padding: 10px; border: 1px solid #e74c3c; border-right: none; border-radius: 6px 0 0 6px; outline: none; font-size: 13px; margin: 0; }
    .btn-reject-icon { background-color: #e74c3c; color: white; border: none; padding: 0 18px; border-radius: 0 6px 6px 0; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; }
    .btn-reject-icon:hover { background-color: #c0392b; }
    .warning-badge { color: #e74c3c; background: #ffebee; padding: 2px 6px; border-radius: 4px; font-weight: bold; }
</style>

<div class="box" style="background:transparent; box-shadow:none; padding:0;">
    <h2 style="color:#2c3e50; font-weight:600; margin-bottom:20px; border-bottom:none;">
        <i class="fas fa-hourglass-half" style="color:#f39c12;"></i> Onay Bekleyen Yazılar
    </h2>

    <?php if(empty($bekleyenler)): ?>
        <div style="background:white; padding:50px; text-align:center; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.05);">
            <i class="fas fa-check-circle" style="font-size:60px; color:#2ecc71; margin-bottom:20px; opacity:0.8;"></i>
            <h3 style="color:#2c3e50; margin:0;">Her Şey Temiz!</h3>
            <p style="color:#95a5a6; margin-top:10px;">Şu an onay bekleyen blog yazısı bulunmuyor.</p>
        </div>
    <?php endif; ?>

    <?php foreach($bekleyenler as $yazi): ?>
        <div class="approval-card">
            <img src="../<?php echo !empty($yazi['resim_url']) ? htmlspecialchars($yazi['resim_url']) : 'images/default.jpg'; ?>" 
                 class="approval-img" 
                 onerror="this.src='https://via.placeholder.com/120?text=Resim+Yok'">

            <div class="approval-content">
                <h3><?php echo htmlspecialchars($yazi['baslik']); ?></h3>
                <p><?php echo htmlspecialchars(mb_substr($yazi['ozet'], 0, 100)) . '...'; ?></p>
                
                <div class="approval-meta">
                    <i class="fas fa-user"></i> <?php echo $yazi['kullanici_adi']; ?> 
                    <?php if($yazi['ceza_puani'] > 0): ?>
                        <span class="warning-badge"><?php echo $yazi['ceza_puani']; ?> Ceza</span>
                    <?php endif; ?>
                    &nbsp;|&nbsp;
                    <i class="far fa-clock"></i> <?php echo date("d.m.Y H:i", strtotime($yazi['tarih'])); ?>
                </div>
            </div>

            <div class="approval-actions">
                <a href="?onayla=<?php echo $yazi['id']; ?>" class="btn-approve-big"><i class="fas fa-check"></i> Onayla</a>

                <form method="POST" class="reject-group">
                    <input type="hidden" name="reddet_id" value="<?php echo $yazi['id']; ?>">
                    <input type="hidden" name="yazar_id" value="<?php echo $yazi['yazar_id']; ?>">
                    <input type="text" name="sebep" class="reject-input" placeholder="Red Sebebi..." required>
                    <button type="submit" class="btn-reject-icon" title="Reddet ve Ceza Ver"><i class="fas fa-times"></i></button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php 
include 'footer.php'; 
ob_end_flush();
?>