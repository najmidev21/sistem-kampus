<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$k = $db->koneksi;

$mode     = $_POST['mode'];
$id       = (int) $_POST['pk_lama'];
$username = trim($_POST['username']);
$password = $_POST['password'];

if ($username == '') {
    exit("Gagal: username wajib diisi.");
}
if ($mode == 'tambah' && $password == '') {
    exit("Gagal: password wajib diisi.");
}

try {
    // username tidak boleh sama dengan user lain
    $cek = $k->prepare("SELECT id FROM tbl_user WHERE username = ? AND id <> ?");
    $cek->bind_param("si", $username, $id);
    $cek->execute();
    if ($cek->get_result()->num_rows > 0) {
        exit("Gagal: username tersebut sudah dipakai.");
    }

    if ($mode == 'tambah') {
        $stmt = $k->prepare("INSERT INTO tbl_user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
    } else {
        // ambil username lama untuk memperbarui session jika user mengedit dirinya sendiri
        $lama = $k->prepare("SELECT username FROM tbl_user WHERE id = ?");
        $lama->bind_param("i", $id);
        $lama->execute();
        $rowLama = $lama->get_result()->fetch_assoc();

        if ($password == '') {
            $stmt = $k->prepare("UPDATE tbl_user SET username=? WHERE id=?");
            $stmt->bind_param("si", $username, $id);
        } else {
            $stmt = $k->prepare("UPDATE tbl_user SET username=?, password=? WHERE id=?");
            $stmt->bind_param("ssi", $username, $password, $id);
        }
        $stmt->execute();

        if ($rowLama && $rowLama['username'] == $_SESSION['username']) {
            $_SESSION['username'] = $username;
        }
    }
    echo "ok";
} catch (mysqli_sql_exception $e) {
    echo "Gagal menyimpan: " . $e->getMessage();
}
