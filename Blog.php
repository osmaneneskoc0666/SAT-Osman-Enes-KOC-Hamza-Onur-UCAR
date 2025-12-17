<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// 1. URL'den hangi sekmede olduğumuzu al
$aktif_tab = isset($_GET['tab']) ? $_GET['tab'] : 'blog';

// 2. Kategoriye göre filtreleme yap (TEK TABLO MANTIĞI)
if ($aktif_tab == 'rotalar') {
    // Sadece 'rota' kategorisindekileri çek
    $baslik_yazisi = "Sizin Rotanız";
    $aciklama_yazisi = "Gezginlerin kendi kaleminden dökülen rota önerileri.";
    $sql = "SELECT * FROM blog WHERE onay_durumu = 'onaylandi' AND kategori = 'rota' ORDER BY id DESC";
} else {
    // 'rota' OLMAYAN her şeyi (Genel blog yazılarını) çek
    $baslik_yazisi = "Gezi Blogu";
    $aciklama_yazisi = "Seyahat ipuçları, rehberler ve daha fazlası.";
    // kategori != 'rota' diyerek rota olmayanları alıyoruz
    $sql = "SELECT * FROM blog WHERE onay_durumu = 'onaylandi' AND kategori != 'rota' ORDER BY id DESC";
}

try {
    $yazilar = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $yazilar = [];
    echo "<p style='text-align:center; color:red;'>Veritabanı hatası: " . $e->getMessage() . "</p>";
}
?> 

<div class="blog-header">
    <h1>📝 <?php echo $baslik_yazisi; ?></h1>
    <p><?php echo $aciklama_yazisi; ?></p>
    
    <div class="toggle-buttons">
        <a href="?tab=blog" class="toggle-btn <?php echo $aktif_tab == 'blog' ? 'active' : ''; ?>">
            <i class="fas fa-book-open"></i> Gezi Blogu
        </a>
        <a href="?tab=rotalar" class="toggle-btn <?php echo $aktif_tab == 'rotalar' ? 'active' : ''; ?>">
            <i class="fas fa-map-marked-alt"></i> Sizin Rotanız
        </a>
    </div>
</div>

<div class="blog-container">
    <?php if (count($yazilar) > 0): ?>
        <?php foreach($yazilar as $yazi): ?>
        <div class="blog-card" onclick="window.location.href='blog_detay.php?id=<?php echo $yazi['id']; ?>&tab=<?php echo $aktif_tab; ?>'">
            <div class="blog-img">
                <img src="<?php echo $yazi['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/400x250?text=Resim+Yok'">
            </div>
            <div class="blog-content">
                <span class="blog-date">
                    <i class="far fa-calendar-alt"></i> 
                    <?php echo date("d.m.Y", strtotime($yazi['tarih'])); ?>
                </span>
                
                <h3><?php echo htmlspecialchars($yazi['baslik']); ?></h3>
                
                <p><?php 
                    $metin = !empty($yazi['ozet']) ? $yazi['ozet'] : $yazi['icerik'];
                    echo mb_substr(strip_tags($metin), 0, 100) . '...'; 
                ?></p>
                
                <a href="blog_detay.php?id=<?php echo $yazi['id']; ?>&tab=<?php echo $aktif_tab; ?>" class="read-more">
                    Devamını Oku →
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-content">
            <i class="far fa-sad-tear"></i>
            <p>Henüz bu kategoride yayınlanmış bir yazı yok.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .blog-header { text-align: center; padding: 60px 20px 80px 20px; background: #f4f7f6; border-bottom: 1px solid #ddd; margin-top: -20px; }
    .blog-header h1 { color: #228B22; font-size: 3rem; margin: 0; font-weight: 800; }
    .blog-header p { color: #666; font-size: 1.2rem; margin-top: 10px; }
    
    .toggle-buttons { display: flex; justify-content: center; gap: 20px; margin-top: 30px; }
    .toggle-btn { padding: 12px 35px; font-size: 1.1rem; font-weight: 600; text-decoration: none; color: #228B22; border: 2px solid #228B22; border-radius: 50px; background: white; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; }
    .toggle-btn.active, .toggle-btn:hover { background: #228B22; color: white; box-shadow: 0 4px 15px rgba(34, 139, 34, 0.3); transform: translateY(-2px); }

    .blog-container { max-width: 1200px; margin: -40px auto 50px auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; position: relative; z-index: 2; }
    
    .blog-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; cursor: pointer; display: flex; flex-direction: column; border: 1px solid #eee; }
    .blog-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    
    .blog-img { height: 200px; overflow: hidden; }
    .blog-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .blog-card:hover .blog-img img { transform: scale(1.1); }
    
    .blog-content { padding: 25px; flex: 1; display: flex; flex-direction: column; }
    .blog-date { font-size: 13px; color: #999; margin-bottom: 10px; display: block; }
    .blog-content h3 { margin: 0 0 10px; color: #2c3e50; font-size: 20px; font-weight: 700; }
    .blog-content p { color: #666; font-size: 14px; line-height: 1.6; flex: 1; margin-bottom: 15px; }
    
    .read-more { color: #228B22; text-decoration: none; font-weight: bold; font-size: 14px; }
    .read-more:hover { text-decoration: underline; }

    .no-content { grid-column: 1 / -1; text-align: center; padding: 50px; color: #999; font-size: 1.2rem; }
    .no-content i { font-size: 3rem; margin-bottom: 15px; display: block; color: #ccc; }
    
    @media (max-width: 600px) {
        .blog-header h1 { font-size: 2rem; }
        .toggle-buttons { flex-direction: column; align-items: center; }
        .toggle-btn { width: 100%; justify-content: center; }
    }
</style>

<?php include 'includes/footer.php'; ?>