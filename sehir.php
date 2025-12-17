<?php
require_once 'includes/db.php';
include 'includes/header.php';

$sehir_slug = $_GET['isim'] ?? '';
$sehir = null;
$mekanlar = [];

if ($sehir_slug) {
    $stmt = $db->prepare("SELECT * FROM sehirler WHERE slug = :slug");
    $stmt->execute([':slug' => $sehir_slug]);
    $sehir = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($sehir) {
        $stmt_detay = $db->prepare("SELECT * FROM sehir_detaylari WHERE sehir_id = :id ORDER BY id DESC");
        $stmt_detay->execute([':id' => $sehir['id']]);
        $mekanlar = $stmt_detay->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!$sehir) {
    echo "<div style='text-align:center; padding:150px 20px;'>
            <h2 style='color:#e74c3c;'>😔 Şehir bulunamadı.</h2>
            <a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#228B22; color:white; text-decoration:none; border-radius:5px;'>Ana Sayfaya Dön</a>
          </div>";
    include 'includes/footer.php'; exit;
}
?>

<style>
    /* Hero Alanı */
    .city-hero { width: 100%; height: 500px; background-size: cover; background-position: center; position: relative; margin-top: -20px; }
    .city-overlay { width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.8)); display: flex; align-items: flex-end; justify-content: center; padding-bottom: 60px; }
    .city-overlay h1 { color: white; font-size: 70px; font-weight: 800; text-shadow: 2px 4px 15px rgba(0,0,0,0.7); margin: 0; letter-spacing: 2px; }

    /* İçerik Alanı */
    .city-content-wrapper { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
    .about-section { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 40px; margin-top: -60px; position: relative; z-index: 5; border-top: 5px solid #228B22; }
    .about-section h2 { color: #2c3e50; margin-top: 0; font-size: 28px; }
    .about-section p { font-size: 16px; line-height: 1.8; color: #555; }

    /* Hızlı Erişim */
    .quick-links { display: flex; gap: 15px; margin-bottom: 50px; overflow-x: auto; padding-bottom: 10px; }
    .link-item { background: white; padding: 15px 25px; border-radius: 30px; text-decoration: none; color: #333; font-weight: 600; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #eee; white-space: nowrap; transition: 0.3s; display: flex; align-items: center; gap: 10px; }
    .link-item i { color: #228B22; font-size: 18px; }
    .link-item:hover { background: #228B22; color: white; border-color: #228B22; transform: translateY(-3px); }
    .link-item:hover i { color: white; }

    /* Kategori Başlıkları */
    .category-header { font-size: 24px; color: #2c3e50; margin: 50px 0 25px; padding-bottom: 10px; border-bottom: 2px solid #eee; display: flex; align-items: center; gap: 10px; }
    .category-header::before { content: ''; display: block; width: 6px; height: 24px; background-color: #00aa6c; border-radius: 3px; }

    /* Kart Listesi */
    .places-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
    
    .place-card { background: white; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; }
    .place-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); border-color: #00aa6c; }
    
    .place-img { height: 200px; position: relative; overflow: hidden; }
    .place-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .place-card:hover .place-img img { transform: scale(1.05); }
    
    .place-cat { position: absolute; top: 15px; left: 15px; background: rgba(0, 0, 0, 0.7); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; letter-spacing: 1px; }
    
    .place-info { padding: 20px; flex: 1; display: flex; flex-direction: column; }
    .place-info h4 { margin: 0 0 10px; font-size: 18px; color: #333; font-weight: 700; }
    
    .place-rating { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .bubbles { color: #00aa6c; font-size: 14px; letter-spacing: 1px; }
    .review-count { font-size: 12px; color: #777; }
    
    .place-desc { font-size: 14px; color: #666; line-height: 1.5; margin-bottom: 20px; flex: 1; }
    
    .place-footer { border-top: 1px solid #f0f0f0; padding-top: 15px; text-align: right; }
    .read-btn { font-size: 14px; font-weight: bold; color: #2c3e50; transition: 0.2s; }
    .place-card:hover .read-btn { color: #00aa6c; padding-right: 5px; }

    @media (max-width: 768px) {
        .city-hero h1 { font-size: 40px; }
        .places-list { grid-template-columns: 1fr; }
    }
</style>

<?php $hero_img = $sehir['resim_url'] ? $sehir['resim_url'] : 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=2000'; ?>
<div class="city-hero" style="background-image: url('<?php echo $hero_img; ?>');">
    <div class="city-overlay">
        <h1><?php echo htmlspecialchars($sehir['isim']); ?></h1>
    </div>
</div>

<div class="city-content-wrapper">
    
    <div class="about-section">
        <h2>(<?php echo str_pad($sehir['plaka_kodu'], 2, '0', STR_PAD_LEFT); ?>) Hakkında</h2>
        <p><?php echo nl2br(htmlspecialchars($sehir['detayli_aciklama'])); ?></p>
    </div>

    <div class="quick-links">
        <a href="#gezi" class="link-item"><i class="fas fa-landmark"></i> Gezilecek Yerler</a>
        <a href="#restoran" class="link-item"><i class="fas fa-utensils"></i> Restoranlar</a>
        <a href="#kuafor" class="link-item"><i class="fas fa-cut"></i> Kuaförler</a>
    </div>

    <?php
    function mekanlariListele($mekanlar, $kategori, $baslik) {
        global $db;

        // Kategoriyi Filtrele
        $filtreli = array_filter($mekanlar, function($m) use ($kategori) {
            return $m['kategori'] === $kategori;
        });

        if (empty($filtreli)) return;

        // Başlığı Yazdır
        echo "<h3 id='$kategori' class='category-header'>$baslik</h3>";
        echo "<div class='places-list'>";
        
        foreach ($filtreli as $mekan) {
            // Puan Hesapla
            $stmt = $db->prepare("SELECT AVG(puan) as ortalama, COUNT(*) as sayi FROM yorumlar WHERE mekan_id = ?");
            $stmt->execute([$mekan['id']]);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            $puan = round($stats['ortalama'], 1) ?: 0;
            $yorum_sayisi = $stats['sayi'];

            // Resim
            $img = $mekan['resim_url'] ? $mekan['resim_url'] : 'https://via.placeholder.com/300x200?text=Resim+Yok';

            // Yıldızlar
            $yildizlar = '';
            for($i=1; $i<=5; $i++) { $yildizlar .= ($i <= $puan) ? '●' : '○'; }

            // Kart HTML
            echo "
            <div class='place-card' onclick=\"window.location.href='mekan.php?id={$mekan['id']}'\">
                <div class='place-img'>
                    <img src='$img' alt='{$mekan['baslik']}'>
                    <span class='place-cat'>".strtoupper($mekan['kategori'])."</span>
                </div>
                
                <div class='place-info'>
                    <h4>{$mekan['baslik']}</h4>
                    
                    <div class='place-rating'>
                        <span class='bubbles'>$yildizlar</span>
                        <span class='review-count'>$puan ($yorum_sayisi yorum)</span>
                    </div>

                    <p class='place-desc'>".mb_substr($mekan['aciklama'], 0, 90)."...</p>
                    
                    <div class='place-footer'>
                        <span class='read-btn'>İncele <i class='fas fa-arrow-right'></i></span>
                    </div>
                </div>
            </div>";
        }
        echo "</div>";
    }

    // Fonksiyonları Çağır (İşte burası eksikti!)
    mekanlariListele($mekanlar, 'gezi', '🏛️ Gezilecek Yerler');
    mekanlariListele($mekanlar, 'restoran', '🍽️ Popüler Restoranlar');
    mekanlariListele($mekanlar, 'kuafor', '✂️ Kuaför ve Güzellik');
    ?>

</div>

<?php include 'includes/footer.php'; ?>