<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

// Giriş yapmamışsa yönlendir
if (!isset($_SESSION['logged_in'])) { header("Location: giris.php"); exit; }

// Hesap Durumu Kontrolü
$user_id = $_SESSION['user_id'];
$user = $db->query("SELECT * FROM kullanicilar WHERE id = $user_id")->fetch(PDO::FETCH_ASSOC);

if ($user['hesap_durumu'] == 'askida') {
    echo "<div style='text-align:center; padding:150px; color:#e74c3c;'>
            <i class='fas fa-ban' style='font-size:50px; margin-bottom:20px;'></i>
            <h2>Hesabınız Askıya Alındı!</h2>
            <p>Kural ihlalleri nedeniyle şu an içerik ekleyemezsiniz.</p>
          </div>";
    include 'includes/footer.php';
    exit;
}

$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST['baslik'];
    $ozet = $_POST['ozet'];
    $icerik = $_POST['icerik'];
    $resim = $_POST['resim_url'];

    if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] == 0) {
        $yeni_ad = "blog_" . time() . "_" . rand(100,999) . "." . pathinfo($_FILES['dosya']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['dosya']['tmp_name'], "images/" . $yeni_ad)) {
            $resim = "images/" . $yeni_ad;
        }
    }

    $sql = "INSERT INTO blog (yazar_id, baslik, ozet, icerik, resim_url, onay_durumu) VALUES (?, ?, ?, ?, ?, 'onay_bekliyor')";
    if ($db->prepare($sql)->execute([$user_id, $baslik, $ozet, $icerik, $resim])) {
        $mesaj = "✅ Yazınız editör onayına gönderildi!";
    }
}
?>

<style>
    /* SAYFA GENELİ */
    body { background-color: #aaffb4ff; } /* Arka plan hafif gri */
    
    .content-wrapper { max-width: 800px; margin: 50px auto; padding: 0 20px; }
    
    /* FORM KUTUSU (BEYAZ KART) */
    .form-box { 
        background: #ffffff; 
        padding: 50px; 
        border-radius: 15px; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.08); /* Yumuşak gölge */
    }
    
    .form-box h2 { 
        color: #2c3e50; 
        border-bottom: 2px solid #f0f2f5; 
        padding-bottom: 20px; 
        margin-top: 0;
        font-size: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* LABEL (ETİKETLER) */
    label { 
        font-weight: 600; 
        color: #34495e; 
        display: block; 
        margin-bottom: 8px; 
        margin-top: 25px; 
        font-size: 14px;
    }

    /* INPUT VE TEXTAREA (GİRİŞ KUTULARI) */
    input[type="text"], textarea, input[type="file"] {
        width: 100%;
        padding: 15px;
        border: 2px solid #eef2f3; /* Çok açık gri kenarlık */
        border-radius: 10px;
        background-color: #f9fbfd; /* 👇 KUTU RENGİNİ BURADAN AYIRDIK */
        font-family: 'Poppins', sans-serif;
        color: #333;
        font-size: 15px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    /* TIKLANINCA (FOCUS) */
    input:focus, textarea:focus {
        background-color: #ffffff; /* Tıklayınca beyaz olsun */
        border-color: #228B22; /* Kenarlık Yeşil olsun */
        box-shadow: 0 0 0 4px rgba(34, 139, 34, 0.1); /* Yeşil hare */
        outline: none;
    }

    /* BUTON */
    .btn-gonder {
        background-color: #228B22;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        margin-top: 30px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        width: 100%;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(34, 139, 34, 0.3);
    }
    .btn-gonder:hover {
        background-color: #1a6f1a;
        transform: translateY(-2px);
    }

    /* UYARI MESAJI */
    .success-msg {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        border-left: 5px solid #28a745;
        margin-bottom: 20px;
        font-weight: 500;
    }
</style>

<div class="content-wrapper">
    <div class="form-box">
        <h2><i class="fas fa-pen-nib" style="color:#228B22;"></i> Blog Yazısı Gönder</h2>
        
        <?php if($mesaj) echo "<div class='success-msg'>$mesaj</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            
            <label>Yazı Başlığı</label>
            <input type="text" name="baslik" required placeholder="Örn: Kapadokya'da Balon Turu Deneyimi">

            <label>Kısa Özet (Vitrinde görünecek)</label>
            <input type="text" name="ozet" required placeholder="Okuyucuyu çekecek kısa bir cümle...">

            <label>Kapak Resmi</label>
            <div style="background:#f9fbfd; padding:15px; border-radius:10px; border:2px dashed #eef2f3;">
                <input type="file" name="dosya" style="border:none; padding:0; background:transparent;">
                <div style="margin:10px 0; text-align:center; color:#aaa; font-size:12px;">VEYA</div>
                <input type="text" name="resim_url" placeholder="https://... (Resim Linki Yapıştır)">
            </div>

            <label>İçerik (Detaylı Yazı)</label>
            <textarea name="icerik" rows="12" required placeholder="Tüm detayları buraya yazın..."></textarea>

            <button type="submit" class="btn-gonder"><i class="fas fa-paper-plane"></i> Yazıyı Gönder</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>