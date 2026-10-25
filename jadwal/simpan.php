<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$v_kd_dosen = (int) $_POST['kd_dosen'];
$v_kd_matkul = (int) $_POST['kd_matkul'];
$v_waktu = $_POST['waktu'];
$v_ruang = $_POST['ruang'];

try {
    if ($_POST['mode'] == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_jadwal (kd_dosen, kd_matkul, waktu, ruang) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $v_kd_dosen, $v_kd_matkul, $v_waktu, $v_ruang);
    } else {
        $pk_lama = (int) $_POST['pk_lama'];
        $stmt = $k->prepare("UPDATE tbl_jadwal SET kd_dosen=?, kd_matkul=?, waktu=?, ruang=? WHERE id=?");
        $stmt->bind_param("iissi", $v_kd_dosen, $v_kd_matkul, $v_waktu, $v_ruang, $pk_lama);
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
