<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$v_nim = (int) $_POST['nim'];
$v_nama = $_POST['nama'];
$v_alamat = $_POST['alamat'];
$v_jurusan = $_POST['jurusan'];

try {
    if ($_POST['mode'] == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_mahasiswa (nim, nama, alamat, jurusan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $v_nim, $v_nama, $v_alamat, $v_jurusan);
    } else {
        $pk_lama = (int) $_POST['pk_lama'];
        $stmt = $k->prepare("UPDATE tbl_mahasiswa SET nim=?, nama=?, alamat=?, jurusan=? WHERE nim=?");
        $stmt->bind_param("isssi", $v_nim, $v_nama, $v_alamat, $v_jurusan, $pk_lama);
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
