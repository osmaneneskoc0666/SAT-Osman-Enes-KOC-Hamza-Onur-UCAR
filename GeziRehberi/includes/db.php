<?php
// includes/db.php
$host = 'localhost';
$dbname = 'gezi_rehberi_db';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
// LOG KAYDETME FONKSİYONU
function logKaydet($db, $islem, $detay = "") {
    if (isset($_SESSION['user_id'])) {
        $uid = $_SESSION['user_id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $stmt = $db->prepare("INSERT INTO logs (kullanici_id, islem, detay, ip_adresi) VALUES (?, ?, ?, ?)");
        $stmt->execute([$uid, $islem, $detay, $ip]);
    }
}
?>