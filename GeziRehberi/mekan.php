<?php
require_once 'includes/db.php';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;
$mesaj = "";

// 1. YORUM GÖNDERME
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['yorum_yap'])) {
    if (!isset($_SESSION['logged_in'])) { header("Location: giris.php"); exit; }
    $puan = $_POST['puan'];
    $yorum_metni = htmlspecialchars($_POST['yorum']);
    $uye_id = $_SESSION['user_id'];
    $db->prepare("INSERT INTO yorumlar (mekan_id, uye_id, puan, yorum) VALUES (?, ?, ?, ?)")->execute([$id, $uye_id, $puan, $yorum_metni]);
    header("Location: mekan.php?id=$id&msg=ok"); exit;
}

// 2. MEKAN BİLGİSİ
$stmt = $db->prepare("SELECT d.*, s.isim as sehir_adi, s.slug as sehir_slug FROM sehir_detaylari d JOIN sehirler s ON d.sehir_id = s.id WHERE d.id = :id");
$stmt->execute([':id' => $id]);
$mekan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mekan) { echo "<div style='padding:100px; text-align:center;'>Mekan bulunamadı.</div>"; include 'includes/footer.php'; exit; }

// 3. YORUMLAR VE PUANLAMA
$yorumlar = $db->prepare("SELECT y.*, k.kullanici_adi FROM yorumlar y JOIN kullanicilar k ON y.uye_id = k.id WHERE y.mekan_id = ? AND y.durum = 'onayli' ORDER BY y.tarih DESC");
$yorumlar->execute([$id]);
$tum_yorumlar = $yorumlar->fetchAll(PDO::FETCH_ASSOC);

// --- İSTATİSTİK HESAPLAMA (YENİ) ---
$toplam_puan = 0;
$yildiz_dagilimi = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]; // Sayaçları sıfırla

foreach($tum_yorumlar as $y) {
    $toplam_puan += $y['puan'];
    $yildiz_dagilimi[$y['puan']]++; // Hangi puandan kaç tane var say
}

$yorum_sayisi = count($tum_yorumlar);
$ortalama = $yorum_sayisi > 0 ? round($toplam_puan / $yorum_sayisi, 1) : 0;

// Yüzdelik hesaplama fonksiyonu
function yuzde($adet, $toplam) {
    if ($toplam == 0) return 0;
    return ($adet / $toplam) * 100;
}

function yildiz($p) {
    $s = ''; for($i=1;$i<=5;$i++) $s .= ($i<=$p) ? '●' : '○'; return $s;
}
?>

<div class="trip-wrapper">
    
    <div class="trip-header">
        <h1><?php echo $mekan['baslik']; ?></h1>
        <div class="meta-row">
            <span class="bubbles"><?php echo yildiz(round($ortalama)); ?></span>
            <span class="review-count"><?php echo $ortalama; ?> (<?php echo $yorum_sayisi; ?> yorum)</span>
            <span class="category">#1 <?php echo $mekan['sehir_adi']; ?> içindeki <?php echo strtoupper($mekan['kategori']); ?></span>
        </div>
        <div class="action-icons">
            <button><i class="fas fa-share"></i></button>
            <button><i class="fas fa-pen"></i></button>
            <button><i class="far fa-heart"></i></button>
        </div>
    </div>

    <div class="trip-nav">
        <a href="#hakkinda" class="active">Hakkında</a>
        <a href="#bolge">Bölge</a>
        <a href="#yorumlar">Yorumlar</a>
    </div>

    <div class="trip-content">
        
        <div class="main-col">
            
            <div class="hero-image">
                <img src="<?php echo $mekan['resim_url']; ?>" onerror="this.src='https://via.placeholder.com/800x400'">
                <div class="badge-year"><i class="fas fa-certificate"></i> 2025</div>
            </div>

            <div id="hakkinda" class="section">
                <h2>Hakkında</h2>
                <div class="about-rating">
                    <span class="bubbles-green"><?php echo yildiz(round($ortalama)); ?></span>
                    <strong><?php echo $ortalama; ?> Mükemmel</strong>
                </div>
                <p class="desc"><?php echo nl2br($mekan['aciklama']); ?></p>
                <a href="#" class="read-more">Devamını okuyun</a>
            </div>

            <div class="section">
                <h3><?php echo $mekan['baslik']; ?> ve diğer öne çıkan deneyimler</h3>
                <div class="tours-grid">
                    <div class="tour-card">
                        <img src="https://images.unsplash.com/photo-1549525797-047b4d930263?q=80&w=300">
                        <div class="tour-body">
                            <h4>Özel Rehberli Şehir Turu</h4>
                            <div class="bubbles-sm">●●●●○ (12)</div>
                            <p>Süre: 4 s • Ücretsiz iptal</p>
                            <div class="price">₺1.250 ile başlayan fiyatlarla</div>
                            <button class="btn-reserve">Rezervasyon yaptırın</button>
                        </div>
                    </div>
                    <div class="tour-card">
                        <img src="https://images.unsplash.com/photo-1647528097682-9602377b2437?q=80&w=300">
                        <div class="tour-body">
                            <h4>Tam Gün Yemekli Gezi</h4>
                            <div class="bubbles-sm">●●●●● (45)</div>
                            <p>Süre: 6 s • Ücretsiz iptal</p>
                            <div class="price">₺2.500 ile başlayan fiyatlarla</div>
                            <button class="btn-reserve">Rezervasyon yaptırın</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="bolge" class="section">
                <h3>Bölge</h3>
                <p><strong>Adres:</strong> <?php echo $mekan['sehir_adi']; ?> Merkez, Türkiye</p>
                <div class="map-preview">
                    <iframe width="100%" height="300" style="border:0; border-radius:12px;" src="https://www.google.com/maps/search/Kayseri+Kalesi3<?php echo urlencode($mekan['baslik']); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                </div>
            </div>

            <div id="yorumlar" class="section">
                <div class="reviews-header">
                    <div>
                        <h3>Yorumlar</h3>
                        <div class="rating-big">
                            <span class="score"><?php echo str_replace('.', ',', $ortalama); ?></span>
                            <div>
                                <div class="bubbles-green big"><?php echo yildiz(round($ortalama)); ?></div>
                                <span class="count"><?php echo $yorum_sayisi; ?> yorum</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rating-bars">
                        <div class="bar-row">
                            <span>Mükemmel</span>
                            <div class="bar"><div class="fill" style="width:<?php echo yuzde($yildiz_dagilimi[5], $yorum_sayisi); ?>%"></div></div>
                            <span><?php echo $yildiz_dagilimi[5]; ?></span>
                        </div>
                        <div class="bar-row">
                            <span>İyi</span>
                            <div class="bar"><div class="fill" style="width:<?php echo yuzde($yildiz_dagilimi[4], $yorum_sayisi); ?>%"></div></div>
                            <span><?php echo $yildiz_dagilimi[4]; ?></span>
                        </div>
                        <div class="bar-row">
                            <span>Ortalama</span>
                            <div class="bar"><div class="fill" style="width:<?php echo yuzde($yildiz_dagilimi[3], $yorum_sayisi); ?>%"></div></div>
                            <span><?php echo $yildiz_dagilimi[3]; ?></span>
                        </div>
                        <div class="bar-row">
                            <span>Kötü</span>
                            <div class="bar"><div class="fill" style="width:<?php echo yuzde($yildiz_dagilimi[2], $yorum_sayisi); ?>%"></div></div>
                            <span><?php echo $yildiz_dagilimi[2]; ?></span>
                        </div>
                        <div class="bar-row">
                            <span>Berbat</span>
                            <div class="bar"><div class="fill" style="width:<?php echo yuzde($yildiz_dagilimi[1], $yorum_sayisi); ?>%"></div></div>
                            <span><?php echo $yildiz_dagilimi[1]; ?></span>
                        </div>
                    </div>
                </div>

                <div class="review-filters">
                    <button class="btn-filter"><i class="fas fa-sliders-h"></i> Filtreler (1)</button>
                    <input type="text" id="yorumAra" placeholder="Yorumlarda ara..." class="search-input">
                    <a href="#yorum-yaz-form" class="btn-write">Yorum yazın</a>
                </div>

                <div class="reviews-list" id="yorumListesi">
                    <?php foreach($tum_yorumlar as $y): ?>
                    <div class="review-card">
                        <div class="user-profile">
                            <img src="https://ui-avatars.com/api/?name=<?php echo $y['kullanici_adi']; ?>&background=random" class="avatar">
                            <div>
                                <strong><?php echo $y['kullanici_adi']; ?></strong>
                                <small>2 katkı</small>
                            </div>
                        </div>
                        <div class="review-text">
                            <div class="bubbles-green"><?php echo yildiz($y['puan']); ?></div>
                            <span class="review-date"><?php echo date("M Y", strtotime($y['tarih'])); ?> • Arkadaşlar</span>
                            <p class="comment-content"><?php echo nl2br(htmlspecialchars($y['yorum'])); ?></p>
                            <a href="#" class="read-more">Devamını okuyun</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div id="noResult" style="display:none; text-align:center; padding:20px; color:#777;">Aradığınız kelimeye uygun yorum bulunamadı.</div>
                </div>

                <div id="yorum-yaz-form" style="margin-top:30px; background:#f9f9f9; padding:20px; border-radius:10px;">
                    <?php if(isset($_SESSION['logged_in'])): ?>
                        <h4>Deneyimini Paylaş</h4>
                        <form method="POST">
                            <select name="puan" style="padding:10px; margin-bottom:10px;">
                                <option value="5">5 - Mükemmel</option>
                                <option value="4">4 - İyi</option>
                                <option value="3">3 - Ortalama</option>
                                <option value="2">2 - Kötü</option>
                                <option value="1">1 - Berbat</option>
                            </select>
                            <textarea name="yorum" rows="4" style="width:100%; padding:10px; border:1px solid #ddd;" placeholder="Yorumunuz..."></textarea>
                            <button type="submit" name="yorum_yap" class="btn-reserve" style="margin-top:10px;">Gönder</button>
                        </form>
                    <?php else: ?>
                        <p>Yorum yazmak için <a href="giris.php" style="color:#00aa6c; font-weight:bold;">Giriş Yap</a></p>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <div class="side-col">
            <div class="hours-box">
                <h4>Çalışma saatleri</h4>
                <p style="color:#00aa6c; font-weight:bold; font-size:14px;">Şu anda açık</p>
                <div style="display:flex; justify-content:space-between; font-size:14px; margin-top:5px;">
                    <span>Salı</span> <span>08:30 - 19:00</span>
                </div>
            </div>
            
            <div class="qa-box">
                <h4>Sorular ve Yanıtlar (13)</h4>
                <p>Merhaba, müze pandemi sürecinde açık mı?</p>
                <a href="#" style="font-weight:bold; color:#000;">Tümünü gör</a>
                <button class="btn-ask">Soru Sor</button>
            </div>
        </div>

    </div>
</div>

<style>
    body { background-color: #fff; color: #000; font-family: 'Poppins', sans-serif; }
    .trip-wrapper { max-width: 1100px; margin: 0 auto; padding: 20px; }
    .trip-header h1 { font-size: 32px; font-weight: 800; margin-bottom: 5px; }
    .meta-row { display: flex; align-items: center; gap: 10px; font-size: 14px; margin-bottom: 20px; }
    .bubbles { color: #00aa6c; font-size: 14px; letter-spacing: -1px; }
    .category { text-decoration: underline; color: #333; }
    .action-icons button { background: white; border: 1px solid #000; border-radius: 50%; width: 35px; height: 35px; cursor: pointer; margin-right: 5px; transition:0.2s; }
    .action-icons button:hover { background: #f2f2f2; }
    .trip-nav { border-bottom: 1px solid #e0e0e0; margin-bottom: 30px; display: flex; gap: 30px; }
    .trip-nav a { text-decoration: none; color: #333; font-weight: 600; padding-bottom: 15px; border-bottom: 3px solid transparent; }
    .trip-nav a.active { border-bottom: 3px solid #000; }
    .trip-content { display: flex; gap: 40px; }
    .main-col { flex: 2; }
    .side-col { flex: 1; }
    .hero-image { position: relative; height: 400px; border-radius: 12px; overflow: hidden; margin-bottom: 40px; }
    .hero-image img { width: 100%; height: 100%; object-fit: cover; }
    .badge-year { position: absolute; bottom: 15px; left: 15px; background: white; color: #00aa6c; font-weight: bold; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
    .section { margin-bottom: 50px; border-bottom: 1px solid #f0f0f0; padding-bottom: 30px; }
    h2, h3 { font-size: 24px; font-weight: 800; margin-bottom: 15px; }
    .desc { font-size: 16px; line-height: 1.6; color: #333; }
    .read-more { font-weight: bold; color: #000; text-decoration: underline; font-size: 14px; cursor: pointer; }
    .tours-grid { display: flex; gap: 20px; overflow-x: auto; padding-bottom: 10px; }
    .tour-card { border: 1px solid #e0e0e0; border-radius: 12px; min-width: 250px; overflow: hidden; }
    .tour-card img { width: 100%; height: 150px; object-fit: cover; }
    .tour-body { padding: 15px; }
    .tour-body h4 { margin: 0 0 5px 0; font-size: 16px; font-weight: 700; line-height: 1.3; }
    .price { font-weight: bold; margin: 10px 0; font-size: 14px; }
    .btn-reserve { background: #00aa6c; color: white; width: 100%; padding: 10px; border: none; border-radius: 20px; font-weight: bold; cursor: pointer; transition: 0.3s; }
    .btn-reserve:hover { background: #008f5d; }
    .reviews-header { display: flex; gap: 30px; margin-bottom: 20px; }
    .rating-big .score { font-size: 48px; font-weight: 800; line-height: 1; }
    .rating-bars { flex: 1; font-size: 13px; }
    .bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 5px; }
    .bar { flex: 1; height: 12px; background: #f0f0f0; border-radius: 6px; overflow: hidden; }
    .bar .fill { height: 100%; background: #00aa6c; }
    .review-filters { display: flex; gap: 10px; margin-bottom: 20px; }
    .btn-filter { background: white; border: 1px solid #000; padding: 10px 20px; border-radius: 20px; font-weight: bold; cursor: pointer; }
    .search-input { flex: 1; border: 1px solid #ccc; border-radius: 20px; padding: 10px 20px; outline:none; }
    .btn-write { background: #000; color: white; padding: 10px 20px; border-radius: 20px; font-weight: bold; text-decoration: none; display: flex; align-items: center; }
    .review-card { display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #f0f0f0; padding-bottom: 20px; }
    .avatar { width: 40px; height: 40px; border-radius: 50%; }
    .review-text p { font-size: 15px; margin: 10px 0; }
    .bubbles-green { color: #00aa6c; font-size: 14px; letter-spacing: -1px; }
    .hours-box, .qa-box { border: 1px solid #e0e0e0; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .btn-ask { width: 100%; border: 1px solid #000; background: white; padding: 10px; border-radius: 20px; font-weight: bold; margin-top: 10px; cursor: pointer; }
    @media (max-width: 768px) {
        .trip-content { flex-direction: column; }
        .reviews-header { flex-direction: column; }
        .trip-header h1 { font-size: 24px; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // FİLTRELEME
        const searchInput = document.getElementById('yorumAra');
        const cards = document.querySelectorAll('.review-card');
        const noResult = document.getElementById('noResult');

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                const term = this.value.toLocaleLowerCase('tr');
                let visibleCount = 0;

                cards.forEach(card => {
                    // Yorum metnini al
                    const text = card.querySelector('.comment-content').textContent.toLocaleLowerCase('tr');
                    if(text.includes(term)) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                noResult.style.display = (visibleCount === 0) ? 'block' : 'none';
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>