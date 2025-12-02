<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Yazıları Çek
// SADECE ONAYLANAN YAZILARI ÇEK
$yazilar = $db->query("SELECT * FROM blog WHERE onay_durumu = 'onaylandi' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?> <div class="blog-header">
    <h1>📝 Gezi Blogu</h1>
    <p>Seyahat ipuçları, rehberler ve daha fazlası.</p>
</div>

<div class="blog-container">
    <?php foreach($yazilar as $yazi): ?>
    <div class="blog-card" onclick="window.location.href='blog_detay.php?id=<?php echo $yazi['id']; ?>'">
        <div class="blog-img">
            <img src="<?php echo $yazi['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/400x250'">
        </div>
        <div class="blog-content">
            <span class="blog-date"><i class="far fa-calendar-alt"></i> <?php echo date("d.m.Y", strtotime($yazi['tarih'])); ?></span>
            <h3><?php echo htmlspecialchars($yazi['baslik']); ?></h3>
            <p><?php echo mb_substr(htmlspecialchars($yazi['ozet']), 0, 100) . '...'; ?></p>
            <a href="blog_detay.php?id=<?php echo $yazi['id']; ?>" class="read-more">Devamını Oku →</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
    .blog-header { text-align: center; padding: 60px 20px; background: #e8ecf1; margin-top: -20px; }
    .blog-header h1 { color: #228B22; font-size: 3rem; margin: 0; }
    .blog-header p { color: #666; font-size: 1.2rem; }
    
    .blog-container { max-width: 1100px; margin: 50px auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
    
    .blog-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; cursor: pointer; display: flex; flex-direction: column; }
    .blog-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    
    .blog-img { height: 200px; overflow: hidden; }
    .blog-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .blog-card:hover .blog-img img { transform: scale(1.1); }
    
    .blog-content { padding: 25px; flex: 1; display: flex; flex-direction: column; }
    .blog-date { font-size: 12px; color: #999; margin-bottom: 10px; display: block; }
    .blog-content h3 { margin: 0 0 10px; color: #2c3e50; font-size: 20px; }
    .blog-content p { color: #666; font-size: 14px; line-height: 1.6; flex: 1; }
    .read-more { color: #228B22; text-decoration: none; font-weight: bold; margin-top: 15px; font-size: 14px; }
</style>

<?php include 'includes/footer.php'; ?>