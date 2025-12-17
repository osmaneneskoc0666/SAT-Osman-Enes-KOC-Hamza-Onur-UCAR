<?php
// Çıktı tamponlamayı başlat
ob_start();

// Header'ı dahil et (DB, Güvenlik, Sidebar, HTML Başlangıcı)
include 'header.php';

// --- İŞLEM 1: DURUM DEĞİŞTİR (GİZLE / YAYINLA) ---
if (isset($_GET['durum'])) {
    $id = $_GET['id'];
    $yeni_durum = $_GET['durum']; // 'onayli' veya 'gizli'
    $db->prepare("UPDATE yorumlar SET durum = ? WHERE id = ?")->execute([$yeni_durum, $id]);
    header("Location: yorum_yonetimi.php?msg=ok"); exit;
}

// --- İŞLEM 2: SİL ---
if (isset($_GET['sil'])) {
    $db->prepare("DELETE FROM yorumlar WHERE id = ?")->execute([$_GET['sil']]);
    header("Location: yorum_yonetimi.php?msg=silindi"); exit;
}

// --- İŞLEM 3: CEZA VER (STRIKE) ---
if (isset($_GET['ceza_ver'])) {
    $yorum_id = $_GET['ceza_ver'];
    $uye_id = $_GET['uye_id'];

    // 1. Yorumu Gizle
    $db->prepare("UPDATE yorumlar SET durum = 'gizli' WHERE id = ?")->execute([$yorum_id]);

    // 2. Ceza Puanı Ekle
    $db->prepare("UPDATE kullanicilar SET ceza_puani = ceza_puani + 1 WHERE id = ?")->execute([$uye_id]);

    // 3. Ban Kontrolü
    $uye = $db->query("SELECT ceza_puani FROM kullanicilar WHERE id = $uye_id")->fetch(PDO::FETCH_ASSOC);
    if ($uye['ceza_puani'] >= 3) {
        $db->prepare("UPDATE kullanicilar SET hesap_durumu = 'askida' WHERE id = ?")->execute([$uye_id]);
    }

    header("Location: yorum_yonetimi.php?msg=ceza_verildi"); exit;
}

// YORUMLARI ÇEK
$yorumlar = $db->query("
    SELECT y.*, k.kullanici_adi, k.ceza_puani, m.baslik as mekan_adi 
    FROM yorumlar y
    JOIN kullanicilar k ON y.uye_id = k.id
    JOIN sehir_detaylari m ON y.mekan_id = m.id
    ORDER BY y.tarih DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .comment-card { border: 1px solid #eee; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #fff; transition:0.3s; }
    .comment-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    
    .c-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 10px; }
    .user-info { font-weight: bold; color: #2980b9; }
    .place-info { color: #555; font-size: 14px; background: #f0f2f5; padding: 2px 8px; border-radius: 4px; }
    .date { font-size: 12px; color: #aaa; }
    
    .c-body { font-size: 15px; color: #333; line-height: 1.6; }
    .stars { color: #f1c40f; letter-spacing: 2px; margin-bottom: 5px; display: block; }
    
    .c-footer { margin-top: 15px; display: flex; gap: 10px; justify-content: flex-end; }
    
    .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: bold; transition:0.2s; display:inline-flex; align-items:center; gap:5px; }
    .btn-hide { background: #f39c12; color: white; }
    .btn-show { background: #27ae60; color: white; }
    .btn-del { background: #e74c3c; color: white; }
    .btn-ban { background: #2c3e50; color: white; }
    .btn:hover { opacity: 0.9; transform: translateY(-2px); }

    .status-badge { font-size: 11px; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; font-weight: bold; }
    .st-onayli { background: #d4edda; color: #155724; }
    .st-gizli { background: #f8d7da; color: #721c24; }
    .strike-badge { background: #c0392b; color: white; font-size: 10px; padding: 2px 5px; border-radius: 3px; margin-left: 5px; }
</style>

<div class="box">
    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px;">💬 Son Yapılan Yorumlar</h2>
    
    <?php if(empty($yorumlar)) echo "<p style='color:#999; text-align:center;'>Henüz yorum yok.</p>"; ?>

    <?php foreach ($yorumlar as $y): ?>
    <div class="comment-card" style="<?php echo $y['durum']=='gizli' ? 'opacity:0.6; background:#fff5f5;' : ''; ?>">
        <div class="c-header">
            <div>
                <span class="user-info">
                    <i class="fas fa-user"></i> <?php echo $y['kullanici_adi']; ?>
                    <?php if($y['ceza_puani'] > 0) echo "<span class='strike-badge'>{$y['ceza_puani']} Ceza</span>"; ?>
                </span>
                <span style="margin: 0 10px; color:#ddd;">|</span>
                <span class="place-info"><i class="fas fa-map-marker-alt"></i> <?php echo $y['mekan_adi']; ?></span>
            </div>
            <div style="text-align:right;">
                <span class="status-badge <?php echo 'st-'.$y['durum']; ?>">
                    <?php echo $y['durum'] == 'onayli' ? 'YAYINDA' : 'GİZLENDİ'; ?>
                </span>
                <span class="date"><?php echo date("d.m.Y H:i", strtotime($y['tarih'])); ?></span>
            </div>
        </div>

        <div class="c-body">
            <span class="stars"><?php echo str_repeat('★', $y['puan']) . str_repeat('☆', 5-$y['puan']); ?></span>
            <?php echo nl2br(htmlspecialchars($y['yorum'])); ?>
        </div>

        <div class="c-footer">
            <?php if($y['durum'] == 'onayli'): ?>
                <a href="?id=<?php echo $y['id']; ?>&durum=gizli" class="btn btn-hide">
                    <i class="fas fa-eye-slash"></i> Gizle
                </a>
            <?php else: ?>
                <a href="?id=<?php echo $y['id']; ?>&durum=onayli" class="btn btn-show">
                    <i class="fas fa-eye"></i> Yayınla
                </a>
            <?php endif; ?>

            <a href="?ceza_ver=<?php echo $y['id']; ?>&uye_id=<?php echo $y['uye_id']; ?>" class="btn btn-ban" onclick="return confirm('Kullanıcıya ceza puanı verilecek ve yorum gizlenecek. Onaylıyor musun?')">
                <i class="fas fa-gavel"></i> Ceza Ver
            </a>

            <a href="?sil=<?php echo $y['id']; ?>" class="btn btn-del" onclick="return confirm('Bu yorum tamamen silinecek?')">
                <i class="fas fa-trash"></i> Sil
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php 
// Footer'ı dahil et
include 'footer.php'; 
// Tamponu boşalt
ob_end_flush();
?>