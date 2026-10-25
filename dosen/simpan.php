<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$v_kd_dosen = (int) $_POST['kd_dosen'];
$v_nama = $_POST['nama'];
$v_alamat = $_POST['alamat'];

try {
    if ($_POST['mode'] == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_dosen (kd_dosen, nama, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $v_kd_dosen, $v_nama, $v_alamat);
    } else {
        $pk_lama = (int) $_POST['pk_lama'];
        $stmt = $k->prepare("UPDATE tbl_dosen SET kd_dosen=?, nama=?, alamat=? WHERE kd_dosen=?");
        $stmt->bind_param("issi", $v_kd_dosen, $v_nama, $v_alamat, $pk_lama);
    }
    $stmt->execute();
    echo "ok";
} catch (mysqli_sql_exception $e) {
    switch ($e->getCode()) {
        case 1062:
            echo "Gagal: kode/NIM tersebut sudah dipakai.";
            break;
        case 1452:
            echo "Gagal: data yang dipilih tidak valid.";
            break;
        case 1451:
            echo "Gagal: data ini masih dipakai di tabel lain.";
            break;
        default:
            echo "Gagal menyimpan: " . $e->getMessage();
    }
}
