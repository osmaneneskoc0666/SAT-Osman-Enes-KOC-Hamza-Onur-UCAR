<?php
session_start();
require_once '../includes/db.php';

// 1. GÜVENLİK
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }

// 2. SİLME
if (isset($_GET['sil'])) {
    $sil_id = $_GET['sil'];
    $db->prepare("DELETE FROM sehirler WHERE id = ?")->execute([$sil_id]);
    
    header("Location: panel.php?msg=silindi"); exit;
}

// 3. EKLEME (PLAKA EKLENDİ)
$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = $_POST['isim'];
    $plaka = $_POST['plaka_kodu']; // YENİ
    $kisa = $_POST['kisa_aciklama'];
    $uzun = $_POST['detayli_aciklama'];
    $resim = $_POST['resim_url'];
    
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $isim)));
    $slug = str_replace(['ı','ğ','ü','ş','ö','ç'], ['i','g','u','s','o','c'], $slug);

    $sql = "INSERT INTO sehirler (isim, slug, plaka_kodu, kisa_aciklama, detayli_aciklama, resim_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$isim, $slug, $plaka, $kisa, $uzun, $resim])) {
        $mesaj = "✅ $isim başarıyla eklendi!";
    } else {
        $mesaj = "❌ Hata oluştu.";
    }
}

// 4. VERİ ÇEKME
$sehir_sayisi = $db->query("SELECT COUNT(*) FROM sehirler")->fetchColumn();
$mekan_sayisi = $db->query("SELECT COUNT(*) FROM sehir_detaylari")->fetchColumn();
$uye_sayisi = $db->query("SELECT COUNT(*) FROM kullanicilar WHERE rol='uye'")->fetchColumn();
$sehirler = $db->query("SELECT * FROM sehirler ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e8ecf1; margin: 0; display: flex; }
        .sidebar { width: 250px; background-color: #2c3e50; color: white; height: 100vh; position: fixed; padding: 20px; box-sizing: border-box; }
        .sidebar h2 { color: #fff; text-align: center; margin-bottom: 40px; font-weight: 300; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; }
        .sidebar a { display: block; color: #b0c4de; text-decoration: none; padding: 15px; border-radius: 8px; margin-bottom: 10px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #34495e; color: #fff; padding-left: 20px; }
        .main-content { margin-left: 250px; padding: 40px; width: 100%; box-sizing: border-box; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 40px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; }
        .panel-box { background: white; padding: 35px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); margin-bottom: 30px; }
        input, textarea { width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #dfe6e9; border-radius: 8px; box-sizing: border-box; font-family: inherit; }
        .btn-add { background-color: #27ae60; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 18px; border-bottom: 1px solid #f1f2f6; }
        th { background-color: #f8f9fa; color: #7f8c8d; font-size: 13px; text-transform: uppercase; }
        .btn-edit { color: #3498db; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-del { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .alert { padding: 15px; background-color: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px; }
    </style>
    
</head>
<body>
    <div class="sidebar">
        <h2>GEZİ<b>PANEL</b></h2>
        <a href="panel.php" class="active"><i class="fas fa-chart-line"></i> Genel Bakış</a>
        <a href="kullanicilar.php"><i class="fas fa-users"></i> Kullanıcılar</a>
        <a href="loglar.php"><i class="fas fa-history"></i> Log Kayıtları</a>
        <a href="../index.php" target="_blank"><i class="fas fa-globe"></i> Siteyi Görüntüle</a>
        <a href="blog_onay.php"><i class="fas fa-check-circle"></i> Onay Bekleyenler</a>
        <a href="cikis.php" style="color:#e74c3c; margin-top:50px;"><i class="fas fa-sign-out-alt"></i> Çıkış</a>
    </div>

    <div class="main-content">
        <div class="stats-grid">
            <div class="card"><h3><?php echo $sehir_sayisi; ?></h3><p>ŞEHİR</p></div>
            <div class="card"><h3><?php echo $mekan_sayisi; ?></h3><p>MEKAN</p></div>
            <div class="card"><h3><?php echo $uye_sayisi; ?></h3><p>ÜYE</p></div>
        </div>

        <div class="panel-box">
            <h2>🌍 Yeni Rota Ekle</h2>
            <?php if($mesaj): ?><div class="alert"><?php echo $mesaj; ?></div><?php endif; ?>
            <form method="POST">
                <div style="display:grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                    <input type="text" name="isim" placeholder="Şehir Adı (Örn: İzmir)" required>
                    <input type="number" name="plaka_kodu" placeholder="Plaka (35)" required>
                </div>
                <input type="text" name="kisa_aciklama" placeholder="Slogan (Örn: Ege'nin incisi)" required>
                <input type="text" name="resim_url" placeholder="Resim Linki (https://...)" required>
                <textarea name="detayli_aciklama" rows="6" placeholder="Detaylı bilgi..." required></textarea>
                <button type="submit" class="btn-add">Kaydet</button>
            </form>
        </div>

        <div class="panel-box">
            <h2>📋 Şehirler</h2>
            <table>
                <thead><tr><th>ID</th><th>Resim</th><th>Şehir</th><th>Plaka</th><th>İşlem</th></tr></thead>
                <tbody>
                    <?php foreach ($sehirler as $sehir): ?>
                    <tr>
                        <td>#<?php echo $sehir['id']; ?></td>
                        <td><img src="<?php echo $sehir['resim_url']; ?>" style="width:50px; height:35px; border-radius:4px;"></td>
                        <td><strong><?php echo $sehir['isim']; ?></strong></td>
                        <td><?php echo str_pad($sehir['plaka_kodu'], 2, '0', STR_PAD_LEFT); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $sehir['id']; ?>" class="btn-edit">Düzenle</a>
                            <a href="?sil=<?php echo $sehir['id']; ?>" class="btn-del" onclick="return confirm('Silinsin mi?')">Sil</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>