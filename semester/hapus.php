<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$key = (int) $_POST['key'];

try {
    $stmt = $db->koneksi->prepare("DELETE FROM tbl_semester WHERE kd_semester = ?");
    $stmt->bind_param("i", $key);
    $stmt->execute();
    echo "ok";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "Data tidak bisa dihapus karena masih dipakai di tabel lain.";
    } else {
        echo "Gagal menghapus: " . $e->getMessage();
    }
}
