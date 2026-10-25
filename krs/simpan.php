<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$v_nim = (int) $_POST['nim'];
$v_id_jadwal = (int) $_POST['id_jadwal'];
$v_kd_semester = (int) $_POST['kd_semester'];

try {
    if ($_POST['mode'] == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_krs (nim, id_jadwal, kd_semester) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $v_nim, $v_id_jadwal, $v_kd_semester);
    } else {
        $pk_lama = (int) $_POST['pk_lama'];
        $stmt = $k->prepare("UPDATE tbl_krs SET nim=?, id_jadwal=?, kd_semester=? WHERE id=?");
        $stmt->bind_param("iiii", $v_nim, $v_id_jadwal, $v_kd_semester, $pk_lama);
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
