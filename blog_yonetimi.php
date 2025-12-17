<?php
// Çıktı tamponlamayı başlat
ob_start();

// Header'ı dahil et (DB, Güvenlik, Sidebar, HTML Başlangıcı)
include 'header.php';

// --- İŞLEMLER ---

// 1. SİLME İŞLEMİ
if (isset($_GET['sil'])) {
    $sil_id = $_GET['sil'];
    
    // Önce resmi klasörden silelim (İsteğe bağlı ama temizlik için iyi)
    $resim_bul = $db->prepare("SELECT resim_url FROM blog WHERE id = ?");
    $resim_bul->execute([$sil_id]);
    $eski_resim = $resim_bul->fetchColumn();
    
    if ($eski_resim && file_exists("../" . $eski_resim)) {
        unlink("../" . $eski_resim); // Dosyayı sil
    }

    $db->prepare("DELETE FROM blog WHERE id = ?")->execute([$sil_id]);
    
    if(function_exists('logKaydet')) logKaydet($db, "Blog Silindi", "Silinen ID: $sil_id");
    
    header("Location: blog_yonetimi.php?msg=silindi"); exit;
}

// 2. EKLEME İŞLEMİ
$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST['baslik'];
    $ozet = $_POST['ozet'];
    $icerik = $_POST['icerik'];
    $resim = $_POST['resim_url'];

    // Dosya Yükleme
    if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] == 0) {
        $uzanti = strtolower(pathinfo($_FILES['dosya']['name'], PATHINFO_EXTENSION));
        // Dosya adı çakışmasını önlemek için benzersiz isim
        $yeni_ad = "blog_" . uniqid() . "." . $uzanti;
        
        if (move_uploaded_file($_FILES['dosya']['tmp_name'], "../images/" . $yeni_ad)) {
            $resim = "images/" . $yeni_ad;
        }
    }

    $sql = "INSERT INTO blog (baslik, ozet, icerik, resim_url, tarih) VALUES (?, ?, ?, ?, NOW())";
    if ($db->prepare($sql)->execute([$baslik, $ozet, $icerik, $resim])) {
        $mesaj = "<div class='alert alert-success'>✅ Yazı başarıyla yayınlandı!</div>";
        if(function_exists('logKaydet')) logKaydet($db, "Blog Eklendi", "Başlık: $baslik");
    } else {
        $mesaj = "<div class='alert alert-danger'>❌ Bir hata oluştu.</div>";
    }
}

// YAZILARI ÇEK
$yazilar = $db->query("SELECT * FROM blog ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="box">
    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px;">✍️ Yeni Yazı Yaz</h2>
    
    <?php echo $mesaj; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <label style="font-weight:bold; font-size:13px; color:#555;">Başlık</label>
        <input type="text" name="baslik" placeholder="Yazı Başlığı Girin" required>
        
        <label style="font-weight:bold; font-size:13px; color:#555;">Özet (Kartta görünecek)</label>
        <input type="text" name="ozet" placeholder="Kısa bir açıklama..." required>
        
        <label style="font-weight:bold; font-size:13px; color:#555;">İçerik</label>
        <textarea name="icerik" rows="10" placeholder="Yazının tamamını buraya yazın..." required></textarea>
        
        <div style="background:#f9f9f9; padding:15px; border-radius:8px; margin-bottom:15px; border:1px solid #eee;">
            <p style="font-size:13px; font-weight:bold; margin:0 0 10px 0;">📸 Kapak Resmi</p>
            <input type="file" name="dosya" style="padding:5px;">
            <input type="text" name="resim_url" placeholder="veya Resim Linki Yapıştır" style="margin-top:10px;">
        </div>
        
        <button type="submit" class="btn btn-green"><i class="fas fa-paper-plane"></i> Yayınla</button>
    </form>
</div>

<div class="box">
    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px;">📋 Yayınlanan Yazılar</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Resim</th>
                <th>Başlık</th>
                <th>Tarih</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yazilar as $yazi): ?>
            <tr>
                <td>#<?php echo $yazi['id']; ?></td>
                <td>
                    <img src="../<?php echo $yazi['resim_url']; ?>" style="width:60px; height:40px; object-fit:cover; border-radius:4px; border:1px solid #ddd;" onerror="this.src='https://via.placeholder.com/60'">
                </td>
                <td><strong><?php echo $yazi['baslik']; ?></strong></td>
                <td style="color:#777; font-size:13px;"><?php echo date("d.m.Y", strtotime($yazi['tarih'])); ?></td>
                <td>
                    <a href="?sil=<?php echo $yazi['id']; ?>" class="btn btn-red" style="padding:5px 10px; font-size:12px;" onclick="return confirm('Bu yazıyı silmek istediğine emin misin?')">
                        <i class="fas fa-trash"></i> Sil
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
// Footer'ı dahil et
include 'footer.php'; 
// Tamponu boşalt
ob_end_flush();
?>