<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$mode = 'tambah';
$d = ['kd_matkul' => '', 'nama' => '', 'sks' => ''];

if (isset($_GET['key'])) {
    $stmt = $db->koneksi->prepare("SELECT * FROM tbl_matkul WHERE kd_matkul = ?");
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
    <h1 class="h3 mb-4 text-gray-800"><?= $mode == 'edit' ? 'Edit' : 'Tambah' ?> Mata Kuliah</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-ajax" action="matkul/simpan.php" method="POST" data-modul="matkul">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <input type="hidden" name="pk_lama" value="<?= $d['kd_matkul'] ?>">

                <div class="form-group">
                    <label>Kode Matkul</label>
                    <input type="number" name="kd_matkul" class="form-control"
                        value="<?= $d['kd_matkul'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Matkul</label>
                    <input type="text" name="nama" class="form-control" maxlength="50"
                        value="<?= htmlspecialchars($d['nama']) ?>" required>
                </div>
                <div class="form-group">
                    <label>SKS (contoh: 2 sks)</label>
                    <input type="text" name="sks" class="form-control" maxlength="10"
                        value="<?= htmlspecialchars($d['sks']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="loadPage('matkul')">Batal</button>
            </form>
        </div>
    </div>
</div>
