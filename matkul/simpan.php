<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$v_kd_matkul = (int) $_POST['kd_matkul'];
$v_nama = $_POST['nama'];
$v_sks = $_POST['sks'];

try {
    if ($_POST['mode'] == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_matkul (kd_matkul, nama, sks) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $v_kd_matkul, $v_nama, $v_sks);
    } else {
        $pk_lama = (int) $_POST['pk_lama'];
        $stmt = $k->prepare("UPDATE tbl_matkul SET kd_matkul=?, nama=?, sks=? WHERE kd_matkul=?");
        $stmt->bind_param("issi", $v_kd_matkul, $v_nama, $v_sks, $pk_lama);
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
