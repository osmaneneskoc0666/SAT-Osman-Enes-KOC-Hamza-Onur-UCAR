<?php
// Header'ı çağır (Session, DB, Güvenlik, Sidebar, HTML Başlangıcı hepsi burada)
include 'header.php';

// --- BU SAYFAYA ÖZEL İŞLEMLER ---

// Logları Çek
$loglar = $db->query("
    SELECT logs.*, kullanicilar.kullanici_adi 
    FROM logs 
    LEFT JOIN kullanicilar ON logs.kullanici_id = kullanicilar.id 
    ORDER BY logs.tarih DESC LIMIT 100
")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .log-time { color: #888; font-size: 12px; white-space: nowrap; }
    .log-user { font-weight: bold; color: #2980b9; }
    .log-action { color: #2c3e50; font-weight: 600; }
</style>

<div class="box">
    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px;">📜 Sistem Hareketleri (Son 100 İşlem)</h2>
    
    <table>
        <thead>
            <tr>
                <th>Tarih</th>
                <th>Kullanıcı</th>
                <th>İşlem</th>
                <th>Detay / IP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loglar as $log): ?>
            <tr>
                <td class="log-time">
                    <i class="far fa-clock"></i> <?php echo date("d.m.Y H:i", strtotime($log['tarih'])); ?>
                </td>
                <td class="log-user">
                    <?php echo $log['kullanici_adi'] ? $log['kullanici_adi'] : '<span style="color:#ccc;">(Silinmiş Üye)</span>'; ?>
                </td>
                <td class="log-action"><?php echo htmlspecialchars($log['islem']); ?></td>
                <td style="color:#666; font-size:13px;">
                    <?php echo htmlspecialchars($log['detay']); ?> <br>
                    <small style="color:#aaa; font-family:monospace;">IP: <?php echo $log['ip_adresi']; ?></small>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
// Footer'ı çağır (Kapanış etiketleri burada)
include 'footer.php'; 
?>