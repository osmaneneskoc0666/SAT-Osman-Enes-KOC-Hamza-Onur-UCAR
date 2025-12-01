<?php
require_once 'includes/db.php';
include 'includes/header.php';

$sehir_slug = $_GET['isim'] ?? '';
$sehir = null;
$mekanlar = [];

if ($sehir_slug) {
    // 1. Şehir Bilgisi
    $stmt = $db->prepare("SELECT * FROM sehirler WHERE slug = :slug");
    $stmt->execute([':slug' => $sehir_slug]);
    $sehir = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($sehir) {
        // 2. Mekan Detayları
        $stmt_detay = $db->prepare("SELECT * FROM sehir_detaylari WHERE sehir_id = :id ORDER BY id DESC");
        $stmt_detay->execute([':id' => $sehir['id']]);
        $mekanlar = $stmt_detay->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!$sehir) {
    echo "<div style='text-align:center; padding:150px 20px;'>
            <h2 style='color:#e74c3c;'>😔 Şehir bulunamadı.</h2>
            <p>Aradığınız şehir henüz sistemimize eklenmemiş olabilir.</p>
            <a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#228B22; color:white; text-decoration:none; border-radius:5px;'>Ana Sayfaya Dön</a>
          </div>";
    include 'includes/footer.php';
    exit;
}
?>

<style>
    .city-hero { width: 100%; height: 450px; background-size: cover; background-position: center; position: relative; margin-top: -20px; }
    .city-overlay { width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7)); display: flex; align-items: center; justify-content: center; }
    .city-overlay h1 { color: white; font-size: 60px; text-transform: uppercase; letter-spacing: 3px; text-shadow: 0 5px 20px rgba(0,0,0,0.6); margin: 0; text-align: center; padding: 0 20px; }
    .city-content-wrapper { max-width: 1100px; margin: 0 auto; padding: 50px 20px; }
    .about-section { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 40px; margin-top: -80px; position: relative; z-index: 5; }
    .about-section h2 { color: #228B22; border-bottom: 3px solid #228B22; display: inline-block; padding-bottom: 5px; margin-top: 0; }
    .about-section p { font-size: 16px; line-height: 1.8; color: #555; }
    .quick-links { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 50px; text-align: center; border: 1px solid #e9ecef; }
    .links-container { display: flex; justify-content: center; gap: 30px; margin-top: 15px; flex-wrap: wrap; }
    .link-item { text-decoration: none; color: #333; font-weight: bold; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: 0.3s; }
    .link-item i { font-size: 24px; color: #228B22; background: white; padding: 15px; border-radius: 50%; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: 0.3s; }
    .link-item:hover i { background: #228B22; color: white; transform: translateY(-5px); }
    .category-title { font-size: 24px; color: #2c3e50; border-left: 5px solid #228B22; padding-left: 15px; margin: 50px 0 25px; }
    .destinations-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
    .destination-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); cursor: pointer; transition: transform 0.3s, box-shadow 0.3s; }
    .destination-card:hover { transform: translateY(-7px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .card-image { height: 200px; overflow: hidden; }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .destination-card:hover .card-image img { transform: scale(1.1); }
    .card-content { padding: 20px; }
    .card-content h4 { margin: 0 0 10px; color: #2c3e50; font-size: 18px; }
    .short-desc { color: #7f8c8d; font-size: 13px; margin: 0; font-style: italic; }
    
    /* MODAL */
    .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); backdrop-filter: blur(5px); }
    .modal-content { background-color: #fefefe; margin: 5% auto; padding: 30px; border-radius: 15px; width: 90%; max-width: 600px; position: relative; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.5); animation: slideDown 0.4s ease; }
    @keyframes slideDown { from {transform: translateY(-50px); opacity: 0;} to {transform: translateY(0); opacity: 1;} }
    .close-btn { position: absolute; top: 15px; right: 20px; color: #aaa; font-size: 30px; font-weight: bold; cursor: pointer; transition: 0.2s; }
    .close-btn:hover { color: #e74c3c; }
    #modalImg { width: 100%; height: 300px; object-fit: cover; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    #modalTitle { color: #228B22; margin-bottom: 15px; font-size: 24px; }
    #modalDesc { color: #555; line-height: 1.6; margin-bottom: 30px; text-align: left; font-size: 15px; }
    .map-btn { display: inline-flex; align-items: center; gap: 10px; background-color: #4285F4; color: white; padding: 12px 30px; text-decoration: none; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 15px rgba(66, 133, 244, 0.4); transition: 0.3s; }
    .map-btn:hover { background-color: #3367d6; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(66, 133, 244, 0.6); }
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
        <h3>Hızlı Erişim</h3>
        <div class="links-container">
            <a href="#restoran" class="link-item"><i class="fas fa-utensils"></i> Restoran</a>
            <a href="#gezi" class="link-item"><i class="fas fa-landmark"></i> Tarih/Gezi</a>
            <a href="#kuafor" class="link-item"><i class="fas fa-cut"></i> Kuaför</a>
        </div>
    </div>

    <?php
    function mekanlariListele($mekanlar, $kategori, $baslik) {
        $filtreli = array_filter($mekanlar, function($m) use ($kategori) { return $m['kategori'] === $kategori; });
        if (empty($filtreli)) return;

        echo "<h2 id='$kategori' class='category-title'>$baslik</h2>";
        echo "<div class='destinations-grid'>";
        
        foreach ($filtreli as $mekan) {
            $img = $mekan['resim_url'] ? $mekan['resim_url'] : 'https://via.placeholder.com/400x300?text=Resim+Yok';
            $js_baslik = htmlspecialchars($mekan['baslik'], ENT_QUOTES);
            $js_aciklama = htmlspecialchars($mekan['aciklama'], ENT_QUOTES);
            $js_map = $mekan['harita_url'] ? $mekan['harita_url'] : 'https://maps.google.com';
            $js_img = $img;

            echo "
            <div class='destination-card' onclick=\"openModal('$js_baslik', '$js_aciklama', '$js_map', '$js_img')\">
                <div class='card-image'><img src='$img' alt='{$mekan['baslik']}'></div>
                <div class='card-content'>
                    <h4>{$mekan['baslik']}</h4>
                    <p class='short-desc'>Detaylar için tıklayın...</p>
                </div>
            </div>";
        }
        echo "</div>";
    }

    mekanlariListele($mekanlar, 'gezi', '🏛️ Gezi Ve Tarih');
    mekanlariListele($mekanlar, 'restoran', '🍽️ Popüler Restoranlar');
    mekanlariListele($mekanlar, 'kuafor', '✂️ Popüler Kuaförler');
    ?>

</div>

<div id="infoModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">×</span>
        <img id="modalImg" src="" alt="">
        <h2 id="modalTitle"></h2>
        <p id="modalDesc"></p>
        <a id="modalMapBtn" href="#" target="_blank" class="map-btn"><i class="fas fa-map-marked-alt"></i> Haritada Göster</a>
    </div>
</div>

<script>
    const modal = document.getElementById("infoModal");
    const modalImg = document.getElementById("modalImg");
    const modalTitle = document.getElementById("modalTitle");
    const modalDesc = document.getElementById("modalDesc");
    const modalMapBtn = document.getElementById("modalMapBtn");

    function openModal(title, desc, mapUrl, imgUrl) {
        modalTitle.innerText = title; modalDesc.innerText = desc; modalImg.src = imgUrl; modalMapBtn.href = mapUrl;
        modal.style.display = "block"; document.body.style.overflow = "hidden";
    }
    function closeModal() { modal.style.display = "none"; document.body.style.overflow = "auto"; }
    window.onclick = function(event) { if (event.target == modal) closeModal(); }
    document.addEventListener('keydown', function(event) { if (event.key === "Escape") closeModal(); });
</script>

<?php include 'includes/footer.php'; ?>