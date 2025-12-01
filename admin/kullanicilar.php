<?php
session_start();
require_once '../includes/db.php';

// Güvenlik
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }

// --- İŞLEMLER ---

// 1. SİLME
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    // Kendini silemezsin
    if ($id != $_SESSION['user_id']) {
        $db->prepare("DELETE FROM kullanicilar WHERE id = ?")->execute([$id]);
        logKaydet($db, "Kullanıcı Silindi", "Silinen ID: $id");
        header("Location: kullanicilar.php?msg=silindi"); exit;
    }
}

// 2. DURUM DEĞİŞTİR (BANLA / AÇ)
if (isset($_GET['durum_degis'])) {
    $id = $_GET['durum_degis'];
    $yeni_durum = $_GET['yap']; // 'aktif' veya 'askida'
    
    if ($id != $_SESSION['user_id']) {
        $db->prepare("UPDATE kullanicilar SET hesap_durumu = ? WHERE id = ?")->execute([$yeni_durum, $id]);
        logKaydet($db, "Hesap Durumu Değişti", "ID: $id, Durum: $yeni_durum");
        header("Location: kullanicilar.php?msg=guncellendi"); exit;
    }
}

// 3. YETKİ DEĞİŞTİR (ADMİN YAP / ÜYE YAP)
if (isset($_GET['rol_degis'])) {
    $id = $_GET['rol_degis'];
    $yeni_rol = $_GET['yap']; // 'admin' veya 'uye'
    
    if ($id != $_SESSION['user_id']) {
        $db->prepare("UPDATE kullanicilar SET rol = ? WHERE id = ?")->execute([$yeni_rol, $id]);
        logKaydet($db, "Yetki Değişti", "ID: $id, Yeni Rol: $yeni_rol");
        header("Location: kullanicilar.php?msg=rol_degisti"); exit;
    }
}

// LİSTELEME
$uyeler = $db->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Yönetimi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e8ecf1; display: flex; margin: 0; }
        .sidebar { width: 250px; background-color: #2c3e50; color: white; height: 100vh; position: fixed; padding: 20px; box-sizing: border-box; }
        .sidebar a { display: block; color: #b0c4de; text-decoration: none; padding: 15px; margin-bottom: 5px; border-radius: 5px; }
        .sidebar a:hover { background-color: #34495e; color: white; }
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
        th { background-color: #f8f9fa; color: #777; font-size: 13px; text-transform: uppercase; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; color: white; }
        .badge.admin { background: #8e44ad; }
        .badge.uye { background: #3498db; }
        .badge.aktif { background: #27ae60; }
        .badge.askida { background: #c0392b; }

        .btn-action { text-decoration: none; font-size: 18px; margin-right: 10px; transition: 0.3s; }
        .btn-ban { color: #e67e22; }
        .btn-unban { color: #27ae60; }
        .btn-del { color: #e74c3c; }
        .btn-key { color: #f1c40f; } /* Yetki butonu */
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>GEZİ<b>PANEL</b></h2>
        <a href="panel.php"><i class="fas fa-home"></i> Genel Bakış</a>
        <a href="kullanicilar.php" style="background:#34495e; color:white;"><i class="fas fa-users"></i> Kullanıcılar</a>
        <a href="loglar.php"><i class="fas fa-history"></i> Log Kayıtları</a>
        <a href="../index.php" target="_blank"><i class="fas fa-globe"></i> Siteyi Görüntüle</a>
    </div>

    <div class="main-content">
        <div class="box">
            <h2>👥 Kullanıcı Yönetimi</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı Adı</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Durum</th>
                        <th>Ceza P.</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($uyeler as $uye): ?>
                    <tr>
                        <td>#<?php echo $uye['id']; ?></td>
                        <td><strong><?php echo $uye['kullanici_adi']; ?></strong></td>
                        <td><?php echo $uye['email']; ?></td>
                        <td><span class="badge <?php echo $uye['rol']; ?>"><?php echo strtoupper($uye['rol']); ?></span></td>
                        <td><span class="badge <?php echo $uye['hesap_durumu']; ?>"><?php echo strtoupper($uye['hesap_durumu']); ?></span></td>
                        <td style="text-align:center;"><?php echo $uye['ceza_puani']; ?></td>
                        <td>
                            <?php if ($uye['id'] != $_SESSION['user_id']): // Kendine işlem yapama ?>
                                
                                <?php if($uye['rol'] == 'uye'): ?>
                                    <a href="?rol_degis=<?php echo $uye['id']; ?>&yap=admin" class="btn-action btn-key" title="Admin Yap"><i class="fas fa-crown"></i></a>
                                <?php else: ?>
                                    <a href="?rol_degis=<?php echo $uye['id']; ?>&yap=uye" class="btn-action btn-key" title="Üye Yap"><i class="fas fa-user"></i></a>
                                <?php endif; ?>

                                <?php if($uye['hesap_durumu'] == 'aktif'): ?>
                                    <a href="?durum_degis=<?php echo $uye['id']; ?>&yap=askida" class="btn-action btn-ban" title="Hesabı Askıya Al"><i class="fas fa-ban"></i></a>
                                <?php else: ?>
                                    <a href="?durum_degis=<?php echo $uye['id']; ?>&yap=aktif" class="btn-action btn-unban" title="Engeli Kaldır"><i class="fas fa-check-circle"></i></a>
                                <?php endif; ?>

                                <a href="?sil=<?php echo $uye['id']; ?>" class="btn-action btn-del" onclick="return confirm('Bu kullanıcıyı tamamen silmek istiyor musunuz?')" title="Sil"><i class="fas fa-trash"></i></a>

                            <?php else: ?>
                                <span style="color:#aaa; font-size:12px;">(Siz)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>