<?php
// Oturum ve Veritabanı Başlatma
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/db.php';

// GÜVENLİK DUVARI
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../giris.php");
    exit;
}

// Hangi sayfadayız?
$sayfa = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* GENEL ADMIN STİLLERİ */
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #e8ecf1; 
            margin: 0; 
            overflow-x: hidden; /* Taşmaları engelle */
        }
        
        /* SIDEBAR (Sol Menü) */
        .sidebar { 
            width: 250px; 
            background-color: #2c3e50; 
            color: white; 
            height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            padding: 20px; 
            box-sizing: border-box; 
            overflow-y: auto;
            z-index: 100;
            transition: all 0.3s ease; /* KAYMA EFEKTİ */
        }

        .sidebar h2 { color: #fff; text-align: center; margin-bottom: 30px; font-weight: 300; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; font-size: 22px; }
        .sidebar a { display: flex; align-items: center; gap: 10px; color: #b0c4de; text-decoration: none; padding: 12px 15px; margin-bottom: 5px; border-radius: 8px; transition: 0.3s; font-size: 14px; }
        .sidebar a:hover { background-color: #34495e; color: white; padding-left: 20px; }
        .sidebar a.active { background-color: #3498db; color: white; }
        .sidebar i { width: 20px; text-align: center; }

        /* MAIN CONTENT (İçerik Alanı) */
        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            box-sizing: border-box; 
            min-height: 100vh; 
            transition: all 0.3s ease; /* KAYMA EFEKTİ */
        }
        
        /* --- TOGGLE (MENÜ KAPALI) DURUMU --- */
        body.menu-kapali .sidebar {
            left: -250px; /* Ekranın dışına it */
        }
        body.menu-kapali .main-content {
            margin-left: 0; /* Tam ekran yap */
        }

        /* Menü Aç/Kapa Butonu */
        .toggle-btn {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .toggle-btn:hover { background: #34495e; }

        /* ORTAK KUTU VE TABLO STİLLERİ */
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; min-width: 600px; }
        th, td { padding: 15px 12px; border-bottom: 1px solid #eee; text-align: left; font-size: 14px; }
        th { background-color: #f8f9fa; color: #555; text-transform: uppercase; font-size: 12px; font-weight: 700; }
        tr:hover { background-color: #fcfcfc; }
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-danger { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        
        input, textarea, select { width: 100%; padding: 12px; margin: 8px 0 15px; border: 1px solid #dfe6e9; border-radius: 6px; box-sizing: border-box; font-family: inherit; font-size: 14px; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; font-size: 14px; transition: 0.2s; }
        .btn-green { background: #27ae60; color: white; } .btn-green:hover { background: #2ecc71; }
        .btn-blue { background: #3498db; color: white; } .btn-blue:hover { background: #2980b9; }
        .btn-red { background: #e74c3c; color: white; } .btn-red:hover { background: #c0392b; }
        
        @media (max-width: 768px) {
            .sidebar { left: -250px; } /* Mobilde varsayılan kapalı olsun */
            .main-content { margin-left: 0; }
            body.menu-acik .sidebar { left: 0; } /* Mobilde açınca gelsin */
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GEZİ<b>PANEL</b></h2>
        <a href="panel.php" class="<?php echo $sayfa == 'panel.php' ? 'active' : ''; ?>"><i class="fas fa-chart-line"></i> <span>Genel Bakış</span></a>
        <a href="blog_yonetimi.php" class="<?php echo $sayfa == 'blog_yonetimi.php' ? 'active' : ''; ?>"><i class="fas fa-newspaper"></i> <span>Blog Yazıları</span></a>
        <a href="blog_onay.php" class="<?php echo $sayfa == 'blog_onay.php' ? 'active' : ''; ?>"><i class="fas fa-check-circle"></i> <span>Onay Bekleyenler</span></a>
        <a href="yorum_yonetimi.php" class="<?php echo $sayfa == 'yorum_yonetimi.php' ? 'active' : ''; ?>"><i class="fas fa-comments"></i> <span>Yorumlar</span></a>
        <a href="kullanicilar.php" class="<?php echo $sayfa == 'kullanicilar.php' ? 'active' : ''; ?>"><i class="fas fa-users"></i> <span>Kullanıcılar</span></a>
        <a href="loglar.php" class="<?php echo $sayfa == 'loglar.php' ? 'active' : ''; ?>"><i class="fas fa-history"></i> <span>Log Kayıtları</span></a>
        <hr style="border:0; border-top:1px solid rgba(255,255,255,0.1); margin: 20px 0;">
        <a href="../index.php" target="_blank"><i class="fas fa-globe"></i> <span>Siteyi Görüntüle</span></a>
        <a href="cikis.php" style="color:#e74c3c;"><i class="fas fa-sign-out-alt"></i> <span>Çıkış Yap</span></a>
    </div>

    <div class="main-content">
        
        <button id="menuToggle" class="toggle-btn">
            <i class="fas fa-bars"></i> Menü
        </button>

        <script>
            const toggleBtn = document.getElementById('menuToggle');
            const body = document.body;

            // Daha önce seçim yaptıysa hatırla (Localstorage)
            if (localStorage.getItem('menuDurumu') === 'kapali') {
                body.classList.add('menu-kapali');
            }

            toggleBtn.addEventListener('click', () => {
                body.classList.toggle('menu-kapali');
                
                // Durumu kaydet ki sayfa yenilenince bozulmasın
                if (body.classList.contains('menu-kapali')) {
                    localStorage.setItem('menuDurumu', 'kapali');
                } else {
                    localStorage.setItem('menuDurumu', 'acik');
                }
            });
        </script>