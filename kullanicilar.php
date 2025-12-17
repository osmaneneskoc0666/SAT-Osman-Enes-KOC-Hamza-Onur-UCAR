<?php
// Çıktı tamponlamayı başlat (Yönlendirme hatalarını önler)
ob_start();

// Header'ı dahil et (DB, Session, Güvenlik, Sidebar, HTML Başlangıcı)
include 'header.php';

// --- İŞLEMLER ---

// 1. SİLME
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    if ($id != $_SESSION['user_id']) {
        $db->prepare("DELETE FROM kullanicilar WHERE id = ?")->execute([$id]);
        // logKaydet fonksiyonu header.php içindeki db.php'den geliyor
        if(function_exists('logKaydet')) logKaydet($db, "Kullanıcı Silindi", "Silinen ID: $id");
        header("Location: kullanicilar.php?msg=silindi"); exit;
    }
}

// 2. DURUM DEĞİŞTİR (BANLA / AÇ)
if (isset($_GET['durum_degis'])) {
    $id = $_GET['durum_degis'];
    $yeni_durum = $_GET['yap']; 
    
    if ($id != $_SESSION['user_id']) {
        $db->prepare("UPDATE kullanicilar SET hesap_durumu = ? WHERE id = ?")->execute([$yeni_durum, $id]);
        if(function_exists('logKaydet')) logKaydet($db, "Hesap Durumu Değişti", "ID: $id, Durum: $yeni_durum");
        header("Location: kullanicilar.php?msg=guncellendi"); exit;
    }
}

// 3. YETKİ DEĞİŞTİR (ADMİN YAP / ÜYE YAP)
if (isset($_GET['rol_degis'])) {
    $id = $_GET['rol_degis'];
    $yeni_rol = $_GET['yap']; 
    
    if ($id != $_SESSION['user_id']) {
        $db->prepare("UPDATE kullanicilar SET rol = ? WHERE id = ?")->execute([$yeni_rol, $id]);
        if(function_exists('logKaydet')) logKaydet($db, "Yetki Değişti", "ID: $id, Yeni Rol: $yeni_rol");
        header("Location: kullanicilar.php?msg=rol_degisti"); exit;
    }
}

// LİSTELEME
$uyeler = $db->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; color: white; text-transform: uppercase; }
    .badge.admin { background: #8e44ad; }
    .badge.uye { background: #3498db; }
    .badge.aktif { background: #27ae60; }
    .badge.askida { background: #c0392b; }

    .btn-action { text-decoration: none; font-size: 16px; margin-right: 8px; transition: 0.2s; display:inline-block; }
    .btn-action:hover { transform: scale(1.1); }
    .btn-ban { color: #e67e22; }
    .btn-unban { color: #27ae60; }
    .btn-del { color: #e74c3c; }
    .btn-key { color: #f1c40f; } 
</style>

<div class="box">
    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px;">👥 Kullanıcı Yönetimi</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kullanıcı Adı</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Durum</th>
                <th>Ceza P.</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uyeler as $uye): ?>
            <tr>
                <td>#<?php echo $uye['id']; ?></td>
                <td><strong><?php echo $uye['kullanici_adi']; ?></strong></td>
                <td><?php echo $uye['email']; ?></td>
                <td><span class="badge <?php echo $uye['rol']; ?>"><?php echo $uye['rol']; ?></span></td>
                <td><span class="badge <?php echo $uye['hesap_durumu']; ?>"><?php echo $uye['hesap_durumu']; ?></span></td>
                <td style="text-align:center; font-weight:bold; color:<?php echo $uye['ceza_puani']>0 ? 'red':'#333'; ?>;">
                    <?php echo $uye['ceza_puani']; ?>
                </td>
                <td>
                    <?php if ($uye['id'] != $_SESSION['user_id']): // Kendine işlem yapama ?>
                        
                        <?php if($uye['rol'] == 'uye'): ?>
                            <a href="?rol_degis=<?php echo $uye['id']; ?>&yap=admin" class="btn-action btn-key" title="Admin Yap"><i class="fas fa-crown"></i></a>
                        <?php else: ?>
                            <a href="?rol_degis=<?php echo $uye['id']; ?>&yap=uye" class="btn-action btn-key" title="Üye Yap"><i class="fas fa-user"></i></a>
                        <?php endif; ?>

                        <?php if($uye['hesap_durumu'] == 'aktif'): ?>
                            <a href="?durum_degis=<?php echo $uye['id']; ?>&yap=askida" class="btn-action btn-ban" title="Hesabı Askıya Al"><i class="fas fa-ban"></i></a>
                        <?php else: ?>
                            <a href="?durum_degis=<?php echo $uye['id']; ?>&yap=aktif" class="btn-action btn-unban" title="Engeli Kaldır"><i class="fas fa-check-circle"></i></a>
                        <?php endif; ?>

                        <a href="?sil=<?php echo $uye['id']; ?>" class="btn-action btn-del" onclick="return confirm('Bu kullanıcıyı tamamen silmek istiyor musunuz?')" title="Sil"><i class="fas fa-trash"></i></a>

                    <?php else: ?>
                        <span style="color:#aaa; font-size:12px; font-style:italic;">(Siz)</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
// Footer'ı dahil et (Kapanış etiketleri)
include 'footer.php'; 
// Tampon çıktısını gönder
ob_end_flush();
?>