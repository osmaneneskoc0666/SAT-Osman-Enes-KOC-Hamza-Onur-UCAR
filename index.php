<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

  <h1 class="main-heading"><b>🧭 Rotamız Neresi?</b></h1> 
  
  <div class="search-flex-wrapper">
    <div class="search-container">
        <div class="search-box">
            <span class="search-icon"><i class="fas fa-search"></i></span> 
            <input type="text" id="city-input" placeholder="Şehir veya mekan ara..." autocomplete="off">
            <button class="orta-buton">Keşfet</button> 
        </div>
        <div id="autocomplete-list"></div>
    </div>
  </div>

  <div class="slideshow-container">
    <img class="slide-img active" src="https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=2071" alt="Şehir Manzarası">
    
    <img class="slide-img" src="" alt="Şehir Manzarası">
  </div>

  <div class="travel-section" id="populer">
    <div class="section-header">
        <h2>En Çok Sevilen Yerler</h2>
    </div>

    <div class="cards-wrapper">
        <button class="nav-arrow arrow-left" id="left-arrow">←</button>
        <div class="cards-container" id="travel-cards-container">
            <?php
            try {
                $query = $db->query("SELECT * FROM sehirler ORDER BY id DESC");
                $sehirler = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($sehirler) {
                    foreach ($sehirler as $sehir) {
                        $resim = $sehir['resim_url'] ? $sehir['resim_url'] : 'https://via.placeholder.com/300x200';
                        ?>
                        <div class="travel-card" onclick="window.location.href='sehir.php?isim=<?php echo $sehir['slug']; ?>'">
                            <div class="card-image">
                                <img src="<?php echo $resim; ?>" alt="<?php echo htmlspecialchars($sehir['isim']); ?>">
                            </div>
                            <div class="card-content">
                                <p class="location-detail"><i class="fas fa-map-marker-alt"></i> Türkiye</p>
                                <h3><?php echo htmlspecialchars($sehir['isim']); ?></h3>
                                <p class="description"><?php echo htmlspecialchars($sehir['kisa_aciklama']); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p style="padding:20px; color:#666;">Henüz şehir eklenmedi.</p>';
                }
            } catch (PDOException $e) { echo 'Hata: ' . $e->getMessage(); }
            ?>
        </div>
        <button class="nav-arrow arrow-right" id="right-arrow">→</button>
    </div>
  </div>

  <div class="dynamic-banner-wrapper">
      <div class="banner-image-block">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070" alt="Yemek">
      </div>
      <div class="banner-text-block">
        <h4>Tadına Doyulmaz Lezzetler</h4>
        <p>En iyi yerel yemekleri deneyimleyin ve damak zevkinize hitap eden lezzetleri keşfedin.</p>
        <p>Doğanın sunduğu en güzel manzaralar ve huzur dolu doğal güzellikler ruhunuzu dinlendirecek.</p>
      </div>
  </div>

  <div class="upload-area" id="upload-area">
      <h2>📸 Fotoğraflarını Paylaş</h2>
      <p>Deneyimlerini bizimle paylaş!</p>
      <input type="file" id="image-upload" accept="image/*" multiple>
      <label for="image-upload" class="upload-label">
          <i class="fas fa-cloud-upload-alt"></i> Resim Seç
      </label>
      <div class="uploaded-images-container" id="uploaded-images"></div>
  </div>
  
  <div class="video-player-section" id="Seferler">
      <h2>Her köşede sizi bekleyen eşsiz deneyimler</h2>
      <div class="video-container">
        <video id="v1" src="" muted playsinline poster="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=1000"></video>
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:white; font-size:20px; text-shadow:0 0 10px black; text-align:center;">
            (Videolar eklendiğinde oynayacak)
        </div>
      </div>
  </div>

<?php include 'includes/footer.php'; ?>