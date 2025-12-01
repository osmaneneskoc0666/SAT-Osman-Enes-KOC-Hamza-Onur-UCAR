<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }

// Logları Çek (Kullanıcı adlarıyla birleştirerek - JOIN)
$loglar = $db->query("
    SELECT logs.*, kullanicilar.kullanici_adi 
    FROM logs 
    LEFT JOIN kullanicilar ON logs.kullanici_id = kullanicilar.id 
    ORDER BY logs.tarih DESC LIMIT 100
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sistem Logları</title>
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
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; font-size: 14px; }
        th { background-color: #f8f9fa; color: #555; }
        
        .log-time { color: #888; font-size: 12px; }
        .log-user { font-weight: bold; color: #2980b9; }
        .log-action { color: #2c3e50; font-weight: 600; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>GEZİ<b>PANEL</b></h2>
        <a href="panel.php"><i class="fas fa-home"></i> Genel Bakış</a>
        <a href="kullanicilar.php"><i class="fas fa-users"></i> Kullanıcılar</a>
        <a href="loglar.php" style="background:#34495e; color:white;"><i class="fas fa-history"></i> Log Kayıtları</a>
        <a href="../index.php" target="_blank"><i class="fas fa-globe"></i> Siteyi Görüntüle</a>
    </div>

    <div class="main-content">
        <div class="box">
            <h2>📜 Sistem Hareketleri (Son 100 İşlem)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Kullanıcı</th>
                        <th>İşlem</th>
                        <th>Detay / IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loglar as $log): ?>
                    <tr>
                        <td class="log-time"><?php echo date("d.m.Y H:i", strtotime($log['tarih'])); ?></td>
                        <td class="log-user">
                            <?php echo $log['kullanici_adi'] ? $log['kullanici_adi'] : '<span style="color:#ccc;">(Silinmiş Üye)</span>'; ?>
                        </td>
                        <td class="log-action"><?php echo $log['islem']; ?></td>
                        <td style="color:#666; font-size:13px;">
                            <?php echo $log['detay']; ?> <br>
                            <small style="color:#aaa;">IP: <?php echo $log['ip_adresi']; ?></small>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>