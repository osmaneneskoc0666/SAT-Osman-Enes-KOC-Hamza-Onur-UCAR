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
    // Sayfaya özel CSS'leri çekmek için
    $current_page = basename($_SERVER['PHP_SELF']);
    if($current_page == 'ankara.php') {
        echo '<link rel="stylesheet" href="css/ankara.css">';
    }
    if($current_page == 'hakkimizda.php') {
        echo '<link rel="stylesheet" href="css/hakkimizda.css">';
    }
  ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

  <div class="navbar">
    
    <div class="logo">
        <a href="index.php">
            <span style="font-size: 28px; font-weight: 900; color: #fff; letter-spacing: 1px;">GEZİ</span>
            <span style="font-size: 28px; font-weight: 900; color: #ffc107; letter-spacing: 1px;">REHBERİ</span>
            <i class="fas fa-route" style="color: #ffc107; font-size: 24px;"></i> 
        </a>
    </div>

    <div class="main-menu">
        <a href="hakkimizda.php">Hakkında</a> 
        <a href="blog.php">Blog</a> <a href="index.php#populer">Popüler Yerler</a>
        <a href="index.php#upload-area">Fotoğraf Paylaş</a>
        <a href="index.php#Seferler">Turlar</a>
        <a href="yazi_ekle.php">Yazı Gönder</a>
    </div>

    <div class="auth-buttons">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            
            <div class="user-menu">
                <span class="user-name">
                    <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                
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