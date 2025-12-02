<?php
require_once 'includes/db.php';
include 'includes/header.php';

// 1. POPÜLER ŞEHİRLERİ ÇEK (Rastgele 10 tane çekelim ki kaydırma işe yarasın)
$sehirler = $db->query("SELECT * FROM sehirler ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

// 2. SON BLOG YAZILARINI ÇEK
$bloglar = $db->query("SELECT * FROM blog WHERE onay_durumu = 'onaylandi' ORDER BY tarih DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="text-align:center; padding: 40px 20px;">
    <h1 class="main-heading">Rotanız Neresi?</h1>
    
    <div class="search-flex-wrapper">
        <form action="sehir.php" method="GET" class="search-container">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Nereye gitmek istersiniz? (Örn: Ankara, İzmir)" autocomplete="off">
                <button type="button" class="orta-buton" onclick="searchCity()">Keşfet</button>
            </div>
        </form>
    </div>

<div class="slideshow-container">
        <img id="slideshow-image" src="images/slider1.jpg" alt="Manzara" style="opacity: 1;">
    </div>
</div>

<div id="populer" class="travel-section">
    <div class="section-header">
        <h2>🔥 Popüler Rotalar</h2>
    </div>

    <div class="cards-wrapper">
        <div class="nav-arrow arrow-left" onclick="scrollCards('left')">
            <i class="fas fa-chevron-left"></i>
        </div>

        <div class="cards-container" id="populerContainer">
            <?php foreach($sehirler as $sehir): ?>
            <div class="travel-card" onclick="window.location.href='sehir.php?isim=<?php echo $sehir['slug']; ?>'" style="cursor:pointer; min-width: 250px;">
                <div class="card-image">
                    <img src="<?php echo $sehir['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/300x200'">
                </div>
                <div class="card-content">
                    <div class="location-detail"><i class="fas fa-map-marker-alt"></i> Türkiye</div>
                    <h3><?php echo $sehir['isim']; ?></h3>
                    <p class="description"><?php echo mb_substr($sehir['kisa_aciklama'], 0, 50) . '...'; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="nav-arrow arrow-right" onclick="scrollCards('right')">
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>
</div>

<div class="travel-section" style="background-color:#fff; padding-top:40px; padding-bottom:40px; border-radius:15px; margin-top:40px;">
    <div class="section-header">
        <h2>✍️ Seyahat Günlükleri</h2>
        <a href="blog.php" style="color:#228B22; text-decoration:none; font-weight:bold;">Tümünü Gör →</a>
    </div>

    <div class="cards-wrapper">
        <div class="cards-container">
            <?php foreach($bloglar as $yazi): ?>
            <div class="travel-card" onclick="window.location.href='blog_detay.php?id=<?php echo $yazi['id']; ?>'" style="cursor:pointer; min-width: 300px;">
                <div class="card-image">
                    <img src="<?php echo $yazi['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/300x200'">
                </div>
                <div class="card-content">
                    <div class="location-detail"><i class="far fa-calendar-alt"></i> <?php echo date("d.m.Y", strtotime($yazi['tarih'])); ?></div>
                    <h3><?php echo htmlspecialchars($yazi['baslik']); ?></h3>
                    <p class="description"><?php echo mb_substr($yazi['ozet'], 0, 60) . '...'; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- 1. SLIDER MANTIĞI (GÜVENLİ VERSİYON) ---
        const imgElement = document.getElementById('slideshow-image');
        
        if (imgElement) { // Eğer resim alanı sayfada varsa çalıştır
            // Sadece YEREL resimler kullanıyoruz (İnternet hatasına karşı)
            // Lütfen images klasörüne slider1.jpg, slider2.jpg vb. koyduğundan emin ol.
            const images = [
                'images/slider1.jpg', 
                'images/slider2.jpg',
                'images/slider3.jpg' 
            ];
            
            let currentIndex = 0;

            function changeImage() {
                imgElement.style.opacity = 0; // Soldur
                
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % images.length;
                    imgElement.src = images[currentIndex];
                    
                    // Resim yüklenmese bile 100ms sonra görünür yap (Takılmayı önler)
                    setTimeout(() => { imgElement.style.opacity = 1; }, 100);
                    
                }, 500); 
            }

            // 4 Saniyede bir değiştir
            setInterval(changeImage, 4000);
        }


        // --- 2. YORUM FİLTRELEME (SADECE VARSA ÇALIŞIR) ---
        const searchInput = document.getElementById('yorumAra');
        
        if (searchInput) { // <-- BU KONTROL HAYAT KURTARIR
            const cards = document.querySelectorAll('.review-card');
            const noResult = document.getElementById('noResult');

            searchInput.addEventListener('input', function() {
                const term = this.value.toLocaleLowerCase('tr');
                let visibleCount = 0;

                cards.forEach(card => {
                    const text = card.textContent.toLocaleLowerCase('tr');
                    if(text.includes(term)) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if(noResult) {
                    noResult.style.display = (visibleCount === 0) ? 'block' : 'none';
                }
            });
        }


        // --- 3. ŞEHİR ARAMA (HER SAYFADA OLABİLİR) ---
        const citySearchInput = document.getElementById('searchInput');
        const citySearchBtn = document.querySelector('.orta-buton');

        if (citySearchInput && citySearchBtn) {
            function searchCity() {
                const input = citySearchInput.value.trim();
                if(input) {
                    const slug = input.toLowerCase()
                        .replace(/ı/g, 'i').replace(/ğ/g, 'g').replace(/ü/g, 'u')
                        .replace(/ş/g, 's').replace(/ö/g, 'o').replace(/ç/g, 'c')
                        .replace(/\s+/g, '-');
                    window.location.href = 'sehir.php?isim=' + slug;
                } else {
                    alert("Lütfen bir şehir adı girin.");
                }
            }

            citySearchBtn.addEventListener('click', searchCity);
            
            citySearchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); searchCity(); }
            });
        }

    });
</script>

<?php include 'includes/footer.php'; ?>