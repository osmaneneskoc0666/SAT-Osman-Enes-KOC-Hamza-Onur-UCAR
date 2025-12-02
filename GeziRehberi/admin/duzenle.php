<?php
session_start();
require_once '../includes/db.php';

// 1. GÜVENLİK
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }
if (!isset($_GET['id'])) { header("Location: panel.php"); exit; }

$id = $_GET['id'];
$mesaj = "";
$mekan_mesaj = "";

// A: ŞEHİR GÜNCELLEME
if (isset($_POST['sehir_guncelle'])) {
    $isim = $_POST['isim'];
    $plaka = $_POST['plaka_kodu'];
    $kisa = $_POST['kisa_aciklama'];
    $uzun = $_POST['detayli_aciklama'];
    $kaydedilecek_resim = $_POST['resim_url']; 

    if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] == 0) {
        $yeni_ad = "sehir_" . time() . "." . pathinfo($_FILES['dosya']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['dosya']['tmp_name'], "../images/" . $yeni_ad)) {
            $kaydedilecek_resim = "images/" . $yeni_ad;
        }
    }

    $slug = str_replace(['ı','ğ','ü','ş','ö','ç'], ['i','g','u','s','o','c'], strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $isim))));
    $stmt = $db->prepare("UPDATE sehirler SET isim=?, slug=?, plaka_kodu=?, kisa_aciklama=?, detayli_aciklama=?, resim_url=? WHERE id=?");
    if ($stmt->execute([$isim, $slug, $plaka, $kisa, $uzun, $kaydedilecek_resim, $id])) $mesaj = "✅ Şehir bilgileri güncellendi!";
}

// B: YENİ MEKAN EKLEME
if (isset($_POST['mekan_ekle'])) {
    $baslik = $_POST['baslik']; $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama']; $harita = $_POST['harita_url']; $mekan_resim = $_POST['mekan_resim_url'];

    if (isset($_FILES['mekan_dosya']) && $_FILES['mekan_dosya']['error'] == 0) {
        $yeni_mekan_ad = "mekan_" . rand(1000,9999) . "_" . time() . "." . pathinfo($_FILES['mekan_dosya']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['mekan_dosya']['tmp_name'], "../images/" . $yeni_mekan_ad)) {
            $mekan_resim = "images/" . $yeni_mekan_ad;
        }
    }
    $db->prepare("INSERT INTO sehir_detaylari (sehir_id, baslik, kategori, aciklama, resim_url, harita_url) VALUES (?, ?, ?, ?, ?, ?)")
       ->execute([$id, $baslik, $kategori, $aciklama, $mekan_resim, $harita]);
    $mekan_mesaj = "✅ Mekan eklendi!";
}

// C: MEKAN SİLME
if (isset($_GET['mekan_sil'])) {
    $db->prepare("DELETE FROM sehir_detaylari WHERE id = ?")->execute([$_GET['mekan_sil']]);
    header("Location: duzenle.php?id=$id&msg=silindi"); exit;
}

// VERİLERİ ÇEK
$sehir = $db->query("SELECT * FROM sehirler WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
$mekanlar = $db->query("SELECT * FROM sehir_detaylari WHERE sehir_id = $id ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Düzenle: <?php echo htmlspecialchars($sehir['isim']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e8ecf1; padding: 40px; margin: 0; box-sizing: border-box; }
        .container { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px; }
        
        /* Kutu Stilleri */
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        h2 { margin-top: 0; border-bottom: 2px solid #f0f2f5; padding-bottom: 15px; color: #2c3e50; font-size: 18px; display:flex; align-items:center; gap:10px; }
        
        /* Form Elemanları */
        input, textarea, select { width: 100%; padding: 12px; margin: 5px 0 15px; border: 1px solid #dfe6e9; border-radius: 6px; box-sizing: border-box; font-family: inherit; font-size: 14px; }
        input:focus, textarea:focus { border-color: #3498db; outline: none; }
        label { font-size: 12px; font-weight: bold; color: #7f8c8d; margin-left: 2px; }
        
        /* Butonlar */
        .btn-update { background-color: #3498db; color: white; border: none; padding: 12px; width: 100%; font-weight: bold; cursor: pointer; border-radius:6px; transition:0.3s; }
        .btn-update:hover { background-color: #2980b9; }
        .btn-add { background-color: #27ae60; color: white; border: none; padding: 12px; width: 100%; font-weight: bold; cursor: pointer; border-radius:6px; transition:0.3s; }
        .btn-add:hover { background-color: #2ecc71; }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #555; font-weight: bold; }
        .back-link:hover { color: #222; }

        /* Dosya Seçim Alanı */
        .file-wrapper { background:#f9fbfd; padding:15px; border:2px dashed #dfe6e9; border-radius:8px; text-align:center; }
        
        /* Mekan Listesi Tasarımı */
        .mekan-item { 
            display: flex; align-items: center; 
            background: #fff; border: 1px solid #eee; 
            padding: 15px; border-radius: 8px; margin-bottom: 10px; 
            transition: 0.3s; 
        }
        .mekan-item:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-color: #ddd; transform: translateY(-2px); }
        .mekan-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px; border: 1px solid #eee; }
        
        .mekan-info { flex: 1; }
        .mekan-info h4 { margin: 0 0 5px; color: #2c3e50; font-size: 15px; }
        .mekan-info small { color: #888; display: block; font-size: 12px; }
        
        /* Renkli Rozetler */
        .badge { display:inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight:bold; color:white; letter-spacing: 0.5px; margin-bottom:3px; }
        .bg-gezi { background-color: #e67e22; }
        .bg-restoran { background-color: #e74c3c; }
        .bg-kuafor { background-color: #9b59b6; }

        /* Yuvarlak İkon Butonlar */
        .actions { display: flex; gap: 8px; }
        .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.2s; font-size: 14px; }
        .btn-icon.edit { background: #e3f2fd; color: #3498db; }
        .btn-icon.edit:hover { background: #3498db; color: white; }
        .btn-icon.del { background: #ffebee; color: #e74c3c; }
        .btn-icon.del:hover { background: #e74c3c; color: white; }

        .alert { padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px; font-size: 14px; border-left:4px solid #28a745; }
        
        @media (max-width: 900px) { .container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <a href="panel.php" class="back-link"><i class="fas fa-arrow-left"></i> Panele Dön</a>

    <div class="container">
        
        <div>
            <div class="box">
                <h2><i class="fas fa-city"></i> Şehir Bilgileri</h2>
                <?php if($mesaj) echo "<div class='alert'>$mesaj</div>"; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:10px;">
                        <div><label>Şehir Adı</label><input type="text" name="isim" value="<?php echo htmlspecialchars($sehir['isim']); ?>" required></div>
                        <div><label>Plaka</label><input type="number" name="plaka_kodu" value="<?php echo htmlspecialchars($sehir['plaka_kodu']); ?>" required></div>
                    </div>
                    
                    <label>Slogan</label>
                    <input type="text" name="kisa_aciklama" value="<?php echo htmlspecialchars($sehir['kisa_aciklama']); ?>">
                    
                    <label>Şehir Resmi</label>
                    <div class="file-wrapper">
                        <img src="../<?php echo htmlspecialchars($sehir['resim_url']); ?>" style="width:100%; height:150px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
                        <input type="file" name="dosya">
                        <input type="text" name="resim_url" value="<?php echo htmlspecialchars($sehir['resim_url']); ?>" placeholder="veya Link" style="margin-bottom:0;">
                    </div>
                    
                    <label>Detaylı Açıklama</label>
                    <textarea name="detayli_aciklama" rows="8"><?php echo htmlspecialchars($sehir['detayli_aciklama']); ?></textarea>
                    
                    <button type="submit" name="sehir_guncelle" class="btn-update"><i class="fas fa-save"></i> Güncelle</button>
                </form>
            </div>
        </div>

        <div>
            <div class="box" style="border-top: 4px solid #27ae60;">
                <h2><i class="fas fa-plus-circle"></i> Yeni Mekan Ekle</h2>
                <?php if($mekan_mesaj) echo "<div class='alert'>$mekan_mesaj</div>"; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <div>
                            <label>Mekan Adı</label><input type="text" name="baslik" required>
                        </div>
                        <div>
                            <label>Kategori</label>
                            <select name="kategori">
                                <option value="gezi">🏛️ Gezi</option>
                                <option value="restoran">🍽️ Restoran</option>
                                <option value="kuafor">✂️ Kuaför</option>
                            </select>
                        </div>
                    </div>
                    
                    <label>Kısa Açıklama</label><input type="text" name="aciklama" required>
                    
                    <label>Resim</label>
                    <div style="background:#f9f9f9; padding:5px; border-radius:5px; margin-bottom:10px;">
                        <input type="file" name="mekan_dosya">
                        <input type="text" name="mekan_resim_url" placeholder="veya Link" style="margin-bottom:0;">
                    </div>
                    
                    <label>Harita Linki</label><input type="text" name="harita_url" placeholder="https://goo.gl/maps/...">
                    
                    <button type="submit" name="mekan_ekle" class="btn-add"><i class="fas fa-plus"></i> Ekle</button>
                </form>
            </div>

            <div class="box">
                <h2><i class="fas fa-list"></i> Mekanlar Listesi</h2>
                <?php if(empty($mekanlar)) echo "<p style='color:#999; text-align:center;'>Henüz mekan yok.</p>"; ?>

                <?php foreach ($mekanlar as $mekan): ?>
                <div class="mekan-item">
                    <img src="../<?php echo $mekan['resim_url'] ? $mekan['resim_url'] : 'images/default.jpg'; ?>" onerror="this.src='https://via.placeholder.com/60'">
                    
                    <div class="mekan-info">
                        <h4><?php echo $mekan['baslik']; ?></h4>
                        
                        <?php 
                            $bg = 'bg-gezi';
                            if($mekan['kategori']=='restoran') $bg='bg-restoran';
                            if($mekan['kategori']=='kuafor') $bg='bg-kuafor';
                        ?>
                        <span class="badge <?php echo $bg; ?>"><?php echo strtoupper($mekan['kategori']); ?></span>
                        
                        <small><?php echo mb_substr($mekan['aciklama'], 0, 40) . '...'; ?></small>
                    </div>
                    
                    <div class="actions">
                        <a href="mekan_duzenle.php?id=<?php echo $mekan['id']; ?>" class="btn-icon edit" title="Düzenle">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="?id=<?php echo $id; ?>&mekan_sil=<?php echo $mekan['id']; ?>" class="btn-icon del" onclick="return confirm('Silinsin mi?')" title="Sil">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</body>
</html>