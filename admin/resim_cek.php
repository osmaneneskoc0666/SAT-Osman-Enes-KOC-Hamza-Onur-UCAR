<?php
// admin/resim_cek.php
require_once '../includes/db.php'; // Veritabanı bağlantısı

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resim_url = $_POST['url']; // İnternetteki resim linki
    $dosya_adi = $_POST['isim']; // Kaydederken vereceğimiz isim (örn: ankara_kalesi)
    
    // Klasör yolu (uploads/images klasörünün olduğundan emin ol)
    $hedef_klasor = "../images/";
    
    // Dosya uzantısını bul (jpg, png vs)
    $uzanti = pathinfo($resim_url, PATHINFO_EXTENSION);
    if(!$uzanti) $uzanti = 'jpg'; // Bulamazsa jpg varsay
    
    // Yeni dosya yolu
    $yeni_dosya_adi = $dosya_adi . "_" . time() . "." . $uzanti;
    $kayit_yolu = $hedef_klasor . $yeni_dosya_adi;

    // 1. RESMİ İNTERNETTEN İNDİR
    $resim_verisi = file_get_contents($resim_url);

    if ($resim_verisi) {
        // 2. DOSYAYI KLASÖRE KAYDET
        file_put_contents($kayit_yolu, $resim_verisi);
        
        // 3. VERİTABANI GÜNCELLEME SORGUSU (Örnek: ID'si 1 olan şehrin resmini güncelle)
        // Burada hangi şehre ekleyeceğini seçmen lazım, örnek olarak ID 1 yaptım.
        // Geliştirmek istersen forma "Şehir Seç" kutusu ekleyebilirsin.
        
        $mesaj = "✅ Resim başarıyla indirildi ve <b>images/$yeni_dosya_adi</b> olarak kaydedildi!";
        
        // ÖRNEK: Veritabanına yazdırmak istersen:
        // $db->prepare("UPDATE sehir_detaylari SET resim_url = ? WHERE id = ?")->execute(["images/$yeni_dosya_adi", 5]);
        
    } else {
        $mesaj = "❌ Resim indirilemedi. Linki kontrol et.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Resim Çekici</title>
    <style>
        body { font-family: sans-serif; padding: 50px; text-align: center; background: #f4f4f4; }
        form { background: white; padding: 40px; border-radius: 10px; display: inline-block; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input { padding: 10px; width: 300px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #228B22; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1a6f1a; }
    </style>
</head>
<body>

    <h2>📸 İnternetten Resim Çekip Kaydet</h2>
    
    <?php if($mesaj) echo "<p>$mesaj</p>"; ?>

    <form method="POST">
        <label>İnternet Resim Linki (URL):</label><br>
        <input type="text" name="url" placeholder="https://site.com/resim.jpg" required><br>
        
        <label>Dosya Adı Ne Olsun?:</label><br>
        <input type="text" name="isim" placeholder="ornegin_kiz_kulesi" required><br>
        
        <button type="submit">İndir ve Kaydet</button>
    </form>

</body>
</html>