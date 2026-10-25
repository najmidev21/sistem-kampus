<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$key = (int) $_POST['key'];

try {
    $stmt = $k->prepare("SELECT username FROM tbl_user WHERE id = ?");
    $stmt->bind_param("i", $key);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row) {
        exit("Data tidak ditemukan.");
    }
    if ($row['username'] == $_SESSION['username']) {
        exit("User yang sedang login tidak bisa dihapus.");
    }

    $stmt = $k->prepare("DELETE FROM tbl_user WHERE id = ?");
    $stmt->bind_param("i", $key);
    $stmt->execute();
    echo "ok";
} catch (mysqli_sql_exception $e) {
    echo "Gagal menghapus: " . $e->getMessage();
}
