<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$mode = 'tambah';
$d = ['kd_semester' => '', 'semester' => ''];

if (isset($_GET['key'])) {
    $stmt = $db->koneksi->prepare("SELECT * FROM tbl_semester WHERE kd_semester = ?");
    $stmt->bind_param("i", $_GET['key']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        $d = $row;
        $mode = 'edit';
    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $mode == 'edit' ? 'Edit' : 'Tambah' ?> Semester</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-ajax" action="semester/simpan.php" method="POST" data-modul="semester">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <input type="hidden" name="pk_lama" value="<?= $d['kd_semester'] ?>">

                <div class="form-group">
                    <label>Kode Semester</label>
                    <input type="number" name="kd_semester" class="form-control"
                        value="<?= $d['kd_semester'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Semester (contoh: Ganjil 2022/2023)</label>
                    <input type="text" name="semester" class="form-control" maxlength="30"
                        value="<?= htmlspecialchars($d['semester']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="loadPage('semester')">Batal</button>
            </form>
        </div>
    </div>
</div>
