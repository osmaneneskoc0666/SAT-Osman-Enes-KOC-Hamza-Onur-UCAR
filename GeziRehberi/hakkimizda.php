<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 
?>

<style>
    /* Hero Banner */
    .media-hero {
        position: relative;
        height: 400px;
        overflow: hidden;
        margin-top: -20px; /* Navbar boşluğunu dengele */
    }
    .media-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .media-hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .media-hero-overlay h1 {
        color: white;
        font-size: 3.5rem;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }

    /* İçerik Düzeni */
    .media-content-wrapper {
        display: flex;
        max-width: 1200px;
        margin: 50px auto;
        gap: 40px;
        padding: 0 20px;
    }

    /* Sol Menü (Sidebar) */
    .media-sidebar {
        flex: 0 0 250px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: fit-content;
        position: sticky;
        top: 100px;
    }
    .media-sidebar a {
        display: block;
        padding: 12px 15px;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #eee;
        transition: 0.3s;
        font-weight: 500;
    }
    .media-sidebar a:last-child { border-bottom: none; }
    .media-sidebar a:hover {
        background-color: #f8f9fa;
        color: #228B22;
        padding-left: 20px;
    }

    /* Ana İçerik */
    .media-main-content {
        flex: 1;
    }
    .media-section {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }
    .media-section h2 {
        color: #228B22;
        border-bottom: 3px solid #eee;
        padding-bottom: 10px;
        margin-top: 0;
    }
    .media-section p {
        line-height: 1.8;
        color: #555;
        font-size: 16px;
    }

    /* Alt Menü (Mobilde görünür olabilir, şimdilik gizleyelim veya stil verelim) */
    .media-sub-nav { display: none; } /* Sidebar olduğu için gerek yok */

    @media (max-width: 768px) {
        .media-content-wrapper { flex-direction: column; }
        .media-sidebar { position: static; width: 100%; }
        .media-hero h1 { font-size: 2.5rem; }
    }
</style>

<div class="media-hero">
    <img src="images/hakkimizda.png" onerror="this.src='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1742'" alt="Hakkımızda" class="media-hero-img">
    <div class="media-hero-overlay">
        <h1>Medya Merkezi</h1>
    </div>
</div>

<div class="media-content-wrapper">
    
    <aside class="media-sidebar">
        <a href="#hakkinda"><i class="fas fa-info-circle"></i> Sitemiz Hakkında</a>
        <a href="#yatirim"><i class="fas fa-chart-line"></i> Yatırımcı İlişkileri</a>
        <a href="#kaynaklar"><i class="fas fa-folder-open"></i> Kaynaklar</a>
        <a href="#iletisim"><i class="fas fa-envelope"></i> Bize Ulaşın</a>
        <a href="#basinda"><i class="fas fa-newspaper"></i> Basında Biz</a>
        <a href="#kariyer"><i class="fas fa-briefcase"></i> Kariyer</a>
    </aside>

    <main class="media-main-content">
        
        <section id="hakkinda" class="media-section">
            <h2>Sitemiz Hakkında</h2>
            <p>Türkiye'nin en büyük dijital şehir tanıtım platformlarından biri olarak, her ay milyonlarca gezgine, şehirleri keşfetmeleri ve unutulmaz anılar biriktirmeleri için ilham veriyoruz. Platformumuz, kullanıcı dostu arayüzü ve zengin içerikleriyle Türkiye'nin dört bir yanındaki gezginler ve yerel işletmeler arasında köprü kurmaktadır.</p>
            <p>Yaklaşık 500 bin yorum ve değerlendirmeyle, gezginler için en doğru ve güncel bilgileri sunmaktayız. İster bir otel rezervasyonu, ister yerel bir lezzet deneyimi, isterse eşsiz bir tur planı olsun, tüm seyahat ihtiyaçlarınızı tek bir platformda karşılıyoruz. Sizin için vazgeçilmez bir seyahat arkadaşı olmak için buradayız!</p>
        </section>

        <section id="yatirim" class="media-section">
            <h2>Yatırımcı İlişkileri</h2>
            <p>Yatırımcılarımız ve iş ortaklarımızla şeffaf ve güçlü ilişkiler kurmaya önem veriyoruz. Sürekli büyüyen pazar payımız ve yenilikçi yaklaşımlarımızla sektörde lider konumumuzu pekiştirmekteyiz. Yatırımcılarımız için düzenli raporlar, finansal tablolar ve geleceğe yönelik stratejik hedeflerimizi içeren güncel bilgileri bu bölümde bulabilirsiniz.</p>
            <p>Gelecek dönemdeki büyüme potansiyelimiz ve sürdürülebilir iş modelimiz hakkında daha fazla bilgi edinmek için lütfen yatırımcı sunumlarımızı ve yıllık raporlarımızı inceleyin.</p>
        </section>

        <section id="kaynaklar" class="media-section">
            <h2>Kaynaklar</h2>
            <p>Medya ve basın mensupları için kapsamlı bir kaynak merkezi sunuyoruz. Burada yüksek çözünürlüklü logolarımızı, marka kılavuzlarımızı, basın bültenlerimizi ve şirketimizin hikayesini anlatan görselleri bulabilirsiniz.</p>
            <div style="margin-top:20px;">
                <button class="orta-buton" style="font-size:14px; padding:10px 20px;">📂 Basın Kitini İndir</button>
            </div>
        </section>

        <section id="iletisim" class="media-section">
            <h2>Bize Ulaşın</h2>
            <p>Medya, basın veya iş birliği talepleriniz için aşağıdaki iletişim bilgilerini kullanabilirsiniz.</p>
            <div style="background:#f9f9f9; padding:20px; border-left:5px solid #228B22; margin-top:15px;">
                <p><strong><i class="fas fa-envelope"></i> E-posta:</strong> hamza-enes@gmail.com</p>
                <p><strong><i class="fas fa-phone"></i> Telefon:</strong> +90 538 653 47 65 - +90 543 255 19 48</p>
                <p><strong><i class="fas fa-map-marker-alt"></i> Adres:</strong> Mahallesi, Sokak No: ***, Ankara, Türkiye</p>
            </div>
        </section>

    </main>
</div>

<?php include 'includes/footer.php'; ?>