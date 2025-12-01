<?php
session_start();
require_once '../includes/db.php';

// Güvenlik
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../giris.php"); exit; }

// SİLME İŞLEMİ
if (isset($_GET['sil'])) {
    $db->prepare("DELETE FROM blog WHERE id = ?")->execute([$_GET['sil']]);
    header("Location: blog_yonetimi.php?msg=silindi"); exit;
}

// EKLEME İŞLEMİ
$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST['baslik'];
    $ozet = $_POST['ozet'];
    $icerik = $_POST['icerik'];
    $resim = $_POST['resim_url'];

    // Dosya Yükleme
    if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] == 0) {
        $yeni_ad = "blog_" . time() . "." . pathinfo($_FILES['dosya']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['dosya']['tmp_name'], "../images/" . $yeni_ad)) {
            $resim = "images/" . $yeni_ad;
        }
    }

    $sql = "INSERT INTO blog (baslik, ozet, icerik, resim_url) VALUES (?, ?, ?, ?)";
    if ($db->prepare($sql)->execute([$baslik, $ozet, $icerik, $resim])) {
        $mesaj = "✅ Yazı yayınlandı!";
    }
}

$yazilar = $db->query("SELECT * FROM blog ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Blog Yönetimi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e8ecf1; margin: 0; display: flex; }
        .sidebar { width: 250px; background-color: #2c3e50; color: white; height: 100vh; position: fixed; padding: 20px; }
        .sidebar a { display: block; color: #b0c4de; text-decoration: none; padding: 15px; border-radius: 8px; margin-bottom: 10px; }
        .sidebar a:hover { background-color: #34495e; color: white; }
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #dfe6e9; border-radius: 6px; }
        .btn-add { background-color: #27ae60; color: white; border: none; padding: 12px; width: 100%; font-weight: bold; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
        .alert { padding: 10px; background: #d4edda; color: #155724; margin-bottom: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>GEZİ<b>PANEL</b></h2>
        <a href="panel.php"><i class="fas fa-home"></i> Şehirler</a>
        <a href="blog_yonetimi.php" style="background:#34495e; color:white;"><i class="fas fa-newspaper"></i> Blog Yazıları</a>
        <a href="../index.php" target="_blank"><i class="fas fa-globe"></i> Siteyi Görüntüle</a>
    </div>

    <div class="main-content">
        <div class="box">
            <h2>✍️ Yeni Yazı Yaz</h2>
            <?php if($mesaj) echo "<div class='alert'>$mesaj</div>"; ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="baslik" placeholder="Yazı Başlığı" required>
                <input type="text" name="ozet" placeholder="Kısa Özet (Kartta görünecek)" required>
                <textarea name="icerik" rows="10" placeholder="Yazının tamamı..." required></textarea>
                
                <p style="font-size:12px; margin-bottom:5px;">Kapak Resmi:</p>
                <input type="file" name="dosya">
                <input type="text" name="resim_url" placeholder="veya Link Yapıştır">
                
                <button type="submit" class="btn-add">Yayınla</button>
            </form>
        </div>

        <div class="box">
            <h2>📋 Tüm Yazılar</h2>
            <table>
                <thead><tr><th>ID</th><th>Resim</th><th>Başlık</th><th>Tarih</th><th>İşlem</th></tr></thead>
                <tbody>
                    <?php foreach ($yazilar as $yazi): ?>
                    <tr>
                        <td>#<?php echo $yazi['id']; ?></td>
                        <td><img src="../<?php echo $yazi['resim_url']; ?>" style="width:50px; height:30px; object-fit:cover;"></td>
                        <td><?php echo $yazi['baslik']; ?></td>
                        <td><?php echo date("d.m.Y", strtotime($yazi['tarih'])); ?></td>
                        <td><a href="?sil=<?php echo $yazi['id']; ?>" style="color:red;" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>