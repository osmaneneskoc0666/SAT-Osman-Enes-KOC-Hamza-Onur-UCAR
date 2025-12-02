<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Güvenlik: Giriş yapmamışsa anasayfaya at
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$mesaj = "";

// 1. KULLANICI BİLGİLERİNİ ÇEK
$stmt = $db->prepare("SELECT * FROM kullanicilar WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. İSTATİSTİKLER (Yorum Sayısı)
$yorum_sayisi = $db->query("SELECT COUNT(*) FROM yorumlar WHERE uye_id = $user_id")->fetchColumn();

// 3. ŞİFRE GÜNCELLEME İŞLEMİ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sifre_guncelle'])) {
    $mevcut_sifre = md5($_POST['mevcut_sifre']);
    $yeni_sifre = $_POST['yeni_sifre'];
    $yeni_tekrar = $_POST['yeni_tekrar'];

    // Eski şifre doğru mu?
    if ($mevcut_sifre !== $user['sifre']) {
        $mesaj = "<div class='alert error'>❌ Mevcut şifreniz yanlış!</div>";
    } 
    // Yeni şifreler uyuşuyor mu?
    elseif ($yeni_sifre !== $yeni_tekrar) {
        $mesaj = "<div class='alert error'>⚠️ Yeni şifreler birbiriyle uyuşmuyor.</div>";
    }
    // Şifre uzunluğu kontrolü
    elseif (strlen($yeni_sifre) < 6) {
        $mesaj = "<div class='alert error'>⚠️ Şifre en az 6 karakter olmalı.</div>";
    } 
    else {
        // Güncelle
        $yeni_hash = md5($yeni_sifre);
        $update = $db->prepare("UPDATE kullanicilar SET sifre = ? WHERE id = ?");
        if ($update->execute([$yeni_hash, $user_id])) {
            $mesaj = "<div class='alert success'>✅ Şifreniz başarıyla güncellendi!</div>";
        }
    }
}
?>

<style>
    body { background-color: #f4f7f6; }
    .profile-wrapper { max-width: 900px; margin: 50px auto; display: flex; gap: 30px; padding: 0 20px; }
    
    /* SOL KART (Profil Özeti) */
    .profile-card { flex: 1; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); text-align: center; height: fit-content; }
    .avatar-img { width: 120px; height: 120px; border-radius: 50%; border: 4px solid #f0f2f5; margin-bottom: 15px; }
    .user-title { font-size: 20px; color: #333; margin: 0 0 5px; font-weight: 800; }
    .user-role { background: #228B22; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
    .admin-role { background: #f1c40f; color: #333; }
    
    .stats-row { display: flex; justify-content: space-around; margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee; }
    .stat-item strong { display: block; font-size: 18px; color: #333; }
    .stat-item span { font-size: 13px; color: #777; }

    /* SAĞ KART (Ayarlar) */
    .settings-card { flex: 2; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .section-title { font-size: 18px; color: #2c3e50; border-bottom: 2px solid #f0f2f5; padding-bottom: 15px; margin-bottom: 20px; font-weight: 700; }
    
    .info-group { margin-bottom: 20px; }
    .info-group label { display: block; font-weight: bold; color: #555; margin-bottom: 8px; font-size: 13px; }
    .info-value { font-size: 15px; color: #333; padding: 10px; background: #f9f9f9; border-radius: 6px; border: 1px solid #eee; }
    
    /* Form */
    .form-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 15px; box-sizing: border-box; }
    .btn-save { background: #228B22; color: white; border: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.3s; }
    .btn-save:hover { background: #1a6f1a; }

    /* Uyarılar */
    .alert { padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
    .alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    /* Mobil */
    @media (max-width: 768px) { .profile-wrapper { flex-direction: column; } }
</style>

<div class="profile-wrapper">
    
    <div class="profile-card">
        <img src="https://ui-avatars.com/api/?name=<?php echo $user['kullanici_adi']; ?>&background=228B22&color=fff&size=150" class="avatar-img">
        
        <h2 class="user-title"><?php echo htmlspecialchars($user['kullanici_adi']); ?></h2>
        
        <?php if($user['rol'] == 'admin'): ?>
            <span class="user-role admin-role">Yönetici</span>
        <?php else: ?>
            <span class="user-role">Gezgin Üye</span>
        <?php endif; ?>

        <div class="stats-row">
            <div class="stat-item">
                <strong><?php echo $yorum_sayisi; ?></strong>
                <span>Yorum</span>
            </div>
            <div class="stat-item">
                <strong style="color: <?php echo $user['ceza_puani'] > 0 ? 'red' : '#333'; ?>">
                    <?php echo $user['ceza_puani']; ?>
                </strong>
                <span>Ceza Puanı</span>
            </div>
        </div>
        
        <div style="margin-top:20px; font-size:12px; color:#aaa;">
            Kayıt Tarihi: <?php echo date("d.m.Y", strtotime($user['kayit_tarihi'] ?? 'now')); ?>
        </div>
    </div>

    <div class="settings-card">
        
        <h3 class="section-title">📝 Hesap Bilgileri</h3>
        <div class="info-group">
            <label>E-Posta Adresi</label>
            <div class="info-value">
                <?php echo htmlspecialchars($user['email']); ?> 
                <?php if($user['dogrulama_durumu'] == 1): ?>
                    <span style="color:#228B22; font-size:12px; float:right;">✔ Doğrulanmış</span>
                <?php else: ?>
                    <span style="color:#e74c3c; font-size:12px; float:right;">❌ Doğrulanmamış</span>
                <?php endif; ?>
            </div>
        </div>

        <h3 class="section-title" style="margin-top:40px;">🔒 Şifre Değiştir</h3>
        <?php echo $mesaj; ?>
        
        <form method="POST">
            <label style="font-size:13px; font-weight:bold; color:#555;">Mevcut Şifre</label>
            <input type="password" name="mevcut_sifre" class="form-input" required>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="font-size:13px; font-weight:bold; color:#555;">Yeni Şifre</label>
                    <input type="password" name="yeni_sifre" class="form-input" required>
                </div>
                <div>
                    <label style="font-size:13px; font-weight:bold; color:#555;">Yeni Şifre (Tekrar)</label>
                    <input type="password" name="yeni_tekrar" class="form-input" required>
                </div>
            </div>

            <button type="submit" name="sifre_guncelle" class="btn-save">Şifreyi Güncelle</button>
        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>