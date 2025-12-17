<?php
// Session (Oturum) başlatma komutu EN ÜSTTE olmalı
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Şehir Rehberi</title>
  
  <link rel="stylesheet" href="css/hamza.css">
  
  <?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    
    if($current_page == 'ankara.php') {
        echo '<link rel="stylesheet" href="css/ankara.css">';
    }
    
    // Ekip ve Hakkımızda için özel stil
    if($current_page == 'ekip.php' || $current_page == 'hakkimizda.php') {
        echo '<link rel="stylesheet" href="css/ekip.css">';
    }
  ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <style>
.main-menu a {
    color: white;
    text-decoration: none; 
    padding: 10px 0; 
    margin: 0 25px; 
    position: relative;
    font-weight: bold; 
    transition: all 0.3s ease-out; 
}
.main-menu a::after {
    content: '';
    position: absolute;
    width: 0; 
    height: 3px;
    bottom: 0;
    left: 0;
    background-color: #ffeb3b; 
    transition: width 0.3s ease-out;
}
.main-menu a:hover {
    color: #ffeb3b;

    transform: none; 
}
.main-menu a:hover::after {
    width: 100%; 
}
    
      /* Kullanıcı Menüsü Stilleri */
      .user-menu { display: flex; align-items: center; gap: 15px; }
      
      .profile-link {
          text-decoration: none; color: white; font-weight: bold;
          display: flex; align-items: center; gap: 8px;
          transition: 0.3s; padding: 5px 10px; border-radius: 20px;
      }
      .profile-link:hover {
          background-color: rgba(255, 255, 255, 0.2);
          text-shadow: 0 0 5px rgba(255,255,255,0.5);
      }

      .btn-panel, .btn-logout { color: white; font-size: 18px; transition: 0.3s; }
      .btn-panel:hover { color: #f1c40f; } /* Sarı */
      .btn-logout:hover { color: #e74c3c; } /* Kırmızı */
      
      /* LOGO STİLİ (Resimsiz) */
      .digital-logo {
          display: flex; align-items: center; gap: 10px;
          text-decoration: none;
      }
      .digital-logo i {
          font-size: 32px; color: #ffc107; /* Uçak ikonu sarı */
          filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
      }
      .logo-text { line-height: 1; display:flex; flex-direction:column; }
      .logo-main { font-size: 24px; font-weight: 900; color: #fff; letter-spacing: 1px; text-transform: uppercase; }
      .logo-sub { font-size: 12px; font-weight: 700; color: #ffc107; letter-spacing: 4px; text-align: justify; }
      /* Linklerin üzerine gelince SARI olsun */
.footer-col a:hover {
    color: #ffeb3b !important; /* Parlak Sarı */
    transform: translateX(5px); /* Hafif sağa kayma efekti */
}


  </style>
</head>
<body>

  <div class="navbar">
    
    <div class="logo">
        <a href="index.php" class="digital-logo">
            <i class="fas fa-paper-plane"></i> <div class="logo-text">
                <span class="logo-main">GEZİ REHBERİ</span>
                <span class="logo-sub">ROTANIZ NERESİ</span>
            </div>
        </a>
    </div>

    <div class="main-menu">
        <a href="hakkimizda.php">Hakkında</a> 
        <a href="blog.php">Blog</a> 
        <a href="index.php#populer">Popüler Yerler</a>
        <a href="yazi_ekle.php">Yazı Gönder</a>
        <a href="sizin rotanız.php">Sizin Rotanız</a>
    </div>

    <div class="auth-buttons">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            
            <div class="user-menu">
                <a href="profil.php" class="profile-link" title="Profilime Git">
                    <i class="fas fa-user-circle" style="font-size: 20px;"></i> 
                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </a>
                
                <?php if($_SESSION['user_role'] == 'admin'): ?>
                    <a href="admin/panel.php" class="btn-panel" title="Yönetim Paneli"><i class="fas fa-cog"></i></a>
                <?php endif; ?>

                <a href="admin/cikis.php" class="btn-logout" title="Çıkış Yap"><i class="fas fa-sign-out-alt"></i></a>
            </div>

        <?php else: ?>
            <a href="giris.php" class="login-button">Giriş Yap</a>
        <?php endif; ?>
    </div>

  </div>