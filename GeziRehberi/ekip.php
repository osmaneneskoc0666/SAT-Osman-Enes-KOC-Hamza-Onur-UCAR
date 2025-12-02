<?php
// Header'ı dahil et
include 'includes/header.php';
?>

<div class="about-container">
    
    <div class="about-header">
        <h1>Biz Kimiz?</h1>
        <p>
            Yozgat Bozok Üniversitesi Bilgisayar Programcılığı öğrencileri olarak, 
            Türkiye'nin güzelliklerini dijital dünyaya taşıyoruz. Amacımız, gezginlere 
            rehberlik etmek ve unutulmaz rotalar sunmak.
        </p>
    </div>

    <div class="mission-vision">
        <div class="vision-card">
            <h2><i class="fas fa-bullseye"></i> Misyonumuz</h2>
            <p>Seyahat etmeyi seven herkes için güvenilir, güncel ve kullanıcı dostu bir rehber oluşturmak. Teknolojiyi doğa ile buluşturmak.</p>
        </div>
        <div class="vision-card">
            <h2><i class="fas fa-eye"></i> Vizyonumuz</h2>
            <p>Türkiye'nin en kapsamlı ve en çok tercih edilen dijital gezi platformu olmak. Gezginlerin bir numaralı yol arkadaşı haline gelmek.</p>
        </div>
    </div>

    <div class="team-section">
        <h2>Kurucu Ekip</h2>
        
        <div class="team-cards-wrapper">
            
            <div class="team-card">
                <img src="images/hamza.jpg" onerror="this.src='https://ui-avatars.com/api/?name=Hamza+Onur&background=228B22&color=fff&size=128'" class="profile-img" alt="Hamza Onur">
                
                <h3>Hamza Onur UÇAR</h3>
                <div class="title">Frontend Developer</div>
                <p class="bio">
                    Arayüz tasarımı ve kullanıcı deneyimi (UX/UI) konularında uzman. 
                    Sitenin görsel dünyasının mimarı.
                </p>
            </div>

            <div class="team-card">
                <img src="images/enes.jpg" onerror="this.src='https://ui-avatars.com/api/?name=Osman+Enes&background=333&color=fff&size=128'" class="profile-img" alt="Osman Enes">
                
                <h3>Osman Enes KOÇ</h3>
                <div class="title">Backend Developer</div>
                <p class="bio">
                    Veritabanı yönetimi ve sunucu taraflı işlemlerin uzmanı. 
                    Sistemin güvenliğinden sorumlu.
                </p>
            </div>

        </div>

        <div style="margin-top:60px;">
            <img src="images/beraber.jpg" style="max-width:100%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
        </div>

    </div>
</div>

<?php 
// Footer'ı dahil et
include 'includes/footer.php'; 
?>