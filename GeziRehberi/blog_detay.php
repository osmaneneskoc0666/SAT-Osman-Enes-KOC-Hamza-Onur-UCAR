<?php
require_once 'includes/db.php';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;
$yazi = $db->query("SELECT * FROM blog WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

if(!$yazi) { echo "<h2 style='text-align:center; padding:100px;'>Yazı bulunamadı!</h2>"; include 'includes/footer.php'; exit; }

// Okunma sayısını artır
$db->query("UPDATE blog SET okunma_sayisi = okunma_sayisi + 1 WHERE id = $id");
?>

<div class="article-container">
    <div class="article-header">
        <h1><?php echo $yazi['baslik']; ?></h1>
        <div class="meta">
            <span><i class="far fa-calendar"></i> <?php echo date("d.m.Y", strtotime($yazi['tarih'])); ?></span>
            <span><i class="far fa-eye"></i> <?php echo $yazi['okunma_sayisi']; ?> Okunma</span>
        </div>
    </div>

    <img src="<?php echo $yazi['resim_url']; ?>" class="main-img">

    <div class="article-body">
        <?php echo nl2br(htmlspecialchars($yazi['icerik'])); ?>
    </div>
    
    <a href="blog.php" class="back-btn">← Tüm Yazılara Dön</a>
</div>

<style>
    .article-container { max-width: 800px; margin: 50px auto; padding: 0 20px; background: white; border-radius: 15px; box-shadow: 0 5px 30px rgba(0,0,0,0.05); padding-bottom: 50px; }
    .article-header { text-align: center; padding: 40px 0 20px; }
    .article-header h1 { font-size: 2.5rem; color: #2c3e50; margin-bottom: 15px; }
    .meta { color: #888; font-size: 14px; }
    .meta span { margin: 0 10px; }
    
    .main-img { width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 40px; }
    
    .article-body { font-size: 18px; line-height: 1.8; color: #444; margin-bottom: 40px; }
    
    .back-btn { display: inline-block; padding: 10px 20px; background: #e8ecf1; color: #333; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
    .back-btn:hover { background: #d1d8e0; }
</style>

<?php include 'includes/footer.php'; ?>