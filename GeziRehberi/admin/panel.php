<?php
// Çıktı tamponlamayı başlat (Yönlendirme hatalarını engeller)
ob_start();

// Header'ı çağır (DB, Session, Güvenlik, Sidebar, HTML Başlangıcı)
include 'header.php';

// --- İŞLEMLER ---

// 1. SİLME
if (isset($_GET['sil'])) {
    $sil_id = $_GET['sil'];
    $db->prepare("DELETE FROM sehirler WHERE id = ?")->execute([$sil_id]);
    
    // Log kaydı (Opsiyonel)
    if(function_exists('logKaydet')) logKaydet($db, "Şehir Silindi", "Silinen ID: $sil_id");

    header("Location: panel.php?msg=silindi"); exit;
}

// 2. EKLEME
$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = $_POST['isim'];
    $plaka = $_POST['plaka_kodu'];
    $kisa = $_POST['kisa_aciklama'];
    $uzun = $_POST['detayli_aciklama'];
    $resim = $_POST['resim_url'];
    
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $isim)));
    $slug = str_replace(['ı','ğ','ü','ş','ö','ç'], ['i','g','u','s','o','c'], $slug);

    $sql = "INSERT INTO sehirler (isim, slug, plaka_kodu, kisa_aciklama, detayli_aciklama, resim_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$isim, $slug, $plaka, $kisa, $uzun, $resim])) {
        $mesaj = "✅ $isim başarıyla eklendi!";
        if(function_exists('logKaydet')) logKaydet($db, "Şehir Eklendi", "Eklenen: $isim");
    } else {
        $mesaj = "❌ Hata oluştu.";
    }
}

// 3. VERİ ÇEKME
$sehir_sayisi = $db->query("SELECT COUNT(*) FROM sehirler")->fetchColumn();
$mekan_sayisi = $db->query("SELECT COUNT(*) FROM sehir_detaylari")->fetchColumn();
$uye_sayisi = $db->query("SELECT COUNT(*) FROM kullanicilar WHERE rol='uye'")->fetchColumn();
$sehirler = $db->query("SELECT * FROM sehirler ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; margin-bottom: 40px; }
    .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; transition: 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .card h3 { font-size: 32px; margin: 0; color: #2c3e50; font-weight: 800; }
    .card p { margin: 0; color: #7f8c8d; font-size: 14px; font-weight: bold; letter-spacing: 1px; }
    
    .btn-add { background-color: #27ae60; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s; }
    .btn-add:hover { background-color: #219150; }
    
    .btn-edit { color: #3498db; text-decoration: none; font-weight: bold; margin-right: 10px; }
    .btn-del { color: #e74c3c; text-decoration: none; font-weight: bold; }
</style>

<div class="stats-grid">
    <div class="card" style="border-left: 5px solid #27ae60;">
        <div><h3><?php echo $sehir_sayisi; ?></h3><p>ŞEHİR</p></div>
        <i class="fas fa-city" style="font-size: 40px; color: #27ae60; opacity: 0.3;"></i>
    </div>
    <div class="card" style="border-left: 5px solid #3498db;">
        <div><h3><?php echo $mekan_sayisi; ?></h3><p>MEKAN</p></div>
        <i class="fas fa-map-marker-alt" style="font-size: 40px; color: #3498db; opacity: 0.3;"></i>
    </div>
    <div class="card" style="border-left: 5px solid #f39c12;">
        <div><h3><?php echo $uye_sayisi; ?></h3><p>ÜYE</p></div>
        <i class="fas fa-users" style="font-size: 40px; color: #f39c12; opacity: 0.3;"></i>
    </div>
</div>

<div class="box">
    <h2>🌍 Yeni Rota Ekle</h2>
    <?php if($mesaj): ?><div class="alert alert-success"><?php echo $mesaj; ?></div><?php endif; ?>
    
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

<div class="box">
    <h2>📋 Şehirler</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Resim</th>
                <th>Şehir</th>
                <th>Plaka</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sehirler as $sehir): ?>
            <tr>
                <td>#<?php echo $sehir['id']; ?></td>
                <td><img src="../<?php echo $sehir['resim_url']; ?>" style="width:50px; height:35px; border-radius:4px; object-fit:cover;"></td>
                <td><strong><?php echo $sehir['isim']; ?></strong></td>
                <td><?php echo str_pad($sehir['plaka_kodu'], 2, '0', STR_PAD_LEFT); ?></td>
                <td>
                    <a href="duzenle.php?id=<?php echo $sehir['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i> Düzenle</a>
                    <a href="?sil=<?php echo $sehir['id']; ?>" class="btn-del" onclick="return confirm('Silinsin mi?')"><i class="fas fa-trash"></i> Sil</a>
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