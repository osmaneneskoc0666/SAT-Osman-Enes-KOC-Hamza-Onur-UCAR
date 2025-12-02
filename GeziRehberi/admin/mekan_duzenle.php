<?php
session_start();
require_once '../includes/db.php';

// 1. GÜVENLİK
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../giris.php");
    exit;
}

// 2. ID KONTROLÜ
if (!isset($_GET['id'])) {
    header("Location: panel.php");
    exit;
}

$id = $_GET['id'];
$mesaj = "";

// Mevcut mekan verisini çek
$stmt = $db->prepare("SELECT * FROM sehir_detaylari WHERE id = :id");
$stmt->execute([':id' => $id]);
$mekan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mekan) die("Mekan bulunamadı!");

$sehir_id = $mekan['sehir_id']; // Güncelleme bitince geri döneceğimiz şehir ID'si

// 3. GÜNCELLEME İŞLEMİ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST['baslik'];
    $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama'];
    $harita = $_POST['harita_url'];
    $resim = $_POST['mekan_resim_url']; // Link kutusundaki veri

    // Dosya Yükleme (Eğer yeni dosya seçildiyse)
    if (isset($_FILES['mekan_dosya']) && $_FILES['mekan_dosya']['error'] == 0) {
        $uzanti = strtolower(pathinfo($_FILES['mekan_dosya']['name'], PATHINFO_EXTENSION));
        $yeni_ad = "mekan_" . rand(1000,9999) . "_" . time() . "." . $uzanti;
        
        if (move_uploaded_file($_FILES['mekan_dosya']['tmp_name'], "../images/" . $yeni_ad)) {
            $resim = "images/" . $yeni_ad;
        }
    }

    $sql = "UPDATE sehir_detaylari SET baslik=?, kategori=?, aciklama=?, harita_url=?, resim_url=? WHERE id=?";
    $stmt = $db->prepare($sql);
    
    if ($stmt->execute([$baslik, $kategori, $aciklama, $harita, $resim, $id])) {
        // Başarılıysa Şehir Düzenleme sayfasına geri dön
        header("Location: duzenle.php?id=$sehir_id&msg=mekan_guncellendi");
        exit;
    } else {
        $mesaj = "❌ Güncelleme başarısız.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mekan Düzenle</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e8ecf1; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .edit-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 90%; max-width: 600px; }
        h2 { color: #2c3e50; text-align: center; margin-top: 0; border-bottom: 2px solid #f0f2f5; padding-bottom: 20px; }
        
        input, select { width: 100%; padding: 12px; margin: 8px 0 15px; border: 1px solid #dfe6e9; border-radius: 6px; box-sizing: border-box; font-family: inherit; font-size: 14px; }
        label { font-size: 13px; font-weight: bold; color: #7f8c8d; }
        
        .btn-update { background-color: #f39c12; color: white; border: none; padding: 15px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-update:hover { background-color: #d35400; }
        
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-weight: bold; }
        .btn-cancel:hover { color: #333; }

        .current-img { width: 100px; height: 60px; object-fit: cover; border-radius: 5px; margin-bottom: 10px; display: block; }
    </style>
</head>
<body>

    <div class="edit-box">
        <h2>🛠️ Mekanı Düzenle</h2>
        
        <?php if($mesaj) echo "<p style='color:red; text-align:center;'>$mesaj</p>"; ?>

        <form method="POST" enctype="multipart/form-data">
            
            <label>Mekan Adı</label>
            <input type="text" name="baslik" value="<?php echo htmlspecialchars($mekan['baslik']); ?>" required>
            
            <label>Kategori</label>
            <select name="kategori">
                <option value="gezi" <?php if($mekan['kategori']=='gezi') echo 'selected'; ?>>🏛️ Gezi / Tarih</option>
                <option value="restoran" <?php if($mekan['kategori']=='restoran') echo 'selected'; ?>>🍽️ Restoran</option>
                <option value="kuafor" <?php if($mekan['kategori']=='kuafor') echo 'selected'; ?>>✂️ Kuaför</option>
            </select>
            
            <label>Kısa Açıklama</label>
            <input type="text" name="aciklama" value="<?php echo htmlspecialchars($mekan['aciklama']); ?>" required>
            
            <label>Mekan Resmi</label>
            <div style="background:#f9f9f9; padding:10px; border-radius:6px; margin-bottom:15px;">
                <img src="../<?php echo htmlspecialchars($mekan['resim_url']); ?>" class="current-img">
                <input type="file" name="mekan_dosya">
                <input type="text" name="mekan_resim_url" value="<?php echo htmlspecialchars($mekan['resim_url']); ?>" placeholder="veya Link">
            </div>

            <label>Harita Linki</label>
            <input type="text" name="harita_url" value="<?php echo htmlspecialchars($mekan['harita_url']); ?>">
            
            <button type="submit" class="btn-update">💾 Güncelle</button>
            <a href="duzenle.php?id=<?php echo $sehir_id; ?>" class="btn-cancel">İptal Et ve Geri Dön</a>
        </form>
    </div>

</body>
</html>