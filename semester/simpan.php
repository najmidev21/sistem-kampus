<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$v_kd_semester = (int) $_POST['kd_semester'];
$v_semester = $_POST['semester'];

try {
    if ($_POST['mode'] == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_semester (kd_semester, semester) VALUES (?, ?)");
        $stmt->bind_param("is", $v_kd_semester, $v_semester);
    } else {
        $pk_lama = (int) $_POST['pk_lama'];
        $stmt = $k->prepare("UPDATE tbl_semester SET kd_semester=?, semester=? WHERE kd_semester=?");
        $stmt->bind_param("isi", $v_kd_semester, $v_semester, $pk_lama);
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
