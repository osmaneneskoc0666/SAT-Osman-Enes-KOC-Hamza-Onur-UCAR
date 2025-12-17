<?php
session_start();
require_once '../includes/db.php';

// Çıkış Logu
logKaydet($db, "Çıkış Yaptı", "Oturum sonlandırıldı");

session_destroy();
header("Location: ../giris.php");
exit;
?>