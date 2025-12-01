<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }
if (!isset($_GET['id'])) { header("Location: panel.php"); exit; }

$id = $_GET['id'];
$mesaj = "";
$mekan_mesaj = "";

// A: ŞEHİR GÜNCELLE
if (isset($_POST['sehir_guncelle'])) {
    $isim = $_POST['isim'];
    $plaka = $_POST['plaka_kodu']; // YENİ
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
    if ($stmt->execute([$isim, $slug, $plaka, $kisa, $uzun, $kaydedilecek_resim, $id])) $mesaj = "✅ Güncellendi!";
}

// B: MEKAN EKLE
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

// C: MEKAN SİL
if (isset($_GET['mekan_sil'])) {
    $db->prepare("DELETE FROM sehir_detaylari WHERE id = ?")->execute([$_GET['mekan_sil']]);
    header("Location: duzenle.php?id=$id&msg=silindi"); exit;
}

$sehir = $db->query("SELECT * FROM sehirler WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
$mekanlar = $db->query("SELECT * FROM sehir_detaylari WHERE sehir_id = $id ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Düzenle: <?php echo htmlspecialchars($sehir['isim']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e8ecf1; padding: 40px; margin: 0; }
        .container { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px; }
        .box { background: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; }
        input, textarea, select { width: 100%; padding: 12px; margin: 5px 0 15px; border: 1px solid #dfe6e9; border-radius: 6px; box-sizing: border-box; }
        label { font-size: 12px; font-weight: bold; color: #7f8c8d; }
        .btn-update { background-color: #3498db; color: white; border: none; padding: 12px; width: 100%; font-weight: bold; cursor: pointer; border-radius:6px;}
        .btn-add { background-color: #27ae60; color: white; border: none; padding: 12px; width: 100%; font-weight: bold; cursor: pointer; border-radius:6px;}
        .mekan-item { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 10px 0; }
        .mekan-item img { width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 6px; }
    </style>
</head>
<body>
    <a href="panel.php" style="display:block; margin-bottom:20px; text-decoration:none; color:#555;">← Panele Dön</a>
    <div class="container">
        <div class="box">
            <h2>✏️ Şehir Bilgileri</h2>
            <?php if($mesaj) echo "<p style='color:green'>$mesaj</p>"; ?>
            <form method="POST" enctype="multipart/form-data">
                <div style="display:grid; grid-template-columns: 2fr 1fr; gap:10px;">
                    <div><label>Şehir Adı</label><input type="text" name="isim" value="<?php echo htmlspecialchars($sehir['isim']); ?>"></div>
                    <div><label>Plaka</label><input type="number" name="plaka_kodu" value="<?php echo htmlspecialchars($sehir['plaka_kodu']); ?>"></div>
                </div>
                <label>Slogan</label><input type="text" name="kisa_aciklama" value="<?php echo htmlspecialchars($sehir['kisa_aciklama']); ?>">
                <label>Resim (Dosya veya Link)</label>
                <input type="file" name="dosya">
                <input type="text" name="resim_url" value="<?php echo htmlspecialchars($sehir['resim_url']); ?>">
                <label>Açıklama</label><textarea name="detayli_aciklama" rows="6"><?php echo htmlspecialchars($sehir['detayli_aciklama']); ?></textarea>
                <button type="submit" name="sehir_guncelle" class="btn-update">Güncelle</button>
            </form>
        </div>

        <div>
            <div class="box" style="border-top: 4px solid #27ae60;">
                <h2>➕ Yeni Mekan</h2>
                <?php if($mekan_mesaj) echo "<p style='color:green'>$mekan_mesaj</p>"; ?>
                <form method="POST" enctype="multipart/form-data">
                    <label>Mekan Adı</label><input type="text" name="baslik" required>
                    <label>Kategori</label>
                    <select name="kategori">
                        <option value="gezi">🏛️ Gezi</option><option value="restoran">🍽️ Restoran</option><option value="kuafor">✂️ Kuaför</option>
                    </select>
                    <label>Açıklama</label><input type="text" name="aciklama" required>
                    <label>Resim (Dosya veya Link)</label>
                    <input type="file" name="mekan_dosya">
                    <input type="text" name="mekan_resim_url">
                    <label>Harita Linki</label><input type="text" name="harita_url">
                    <button type="submit" name="mekan_ekle" class="btn-add">Ekle</button>
                </form>
            </div>

            <div class="box">
                <h2>📋 Mekanlar</h2>
                <?php foreach ($mekanlar as $mekan): ?>
                <div class="mekan-item">
                    <img src="../<?php echo $mekan['resim_url']; ?>" onerror="this.src='../images/default.jpg'">
                    <div style="flex:1;">
                        <strong><?php echo $mekan['baslik']; ?></strong><br>
                        <small style="color:#888;"><?php echo $mekan['aciklama']; ?></small>
                    </div>
                    <a href="?id=<?php echo $id; ?>&mekan_sil=<?php echo $mekan['id']; ?>" style="color:red; text-decoration:none;">Sil</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>