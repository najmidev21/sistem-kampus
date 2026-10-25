<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$mode = 'tambah';
$d = ['kd_dosen' => '', 'nama' => '', 'alamat' => ''];

if (isset($_GET['key'])) {
    $stmt = $db->koneksi->prepare("SELECT * FROM tbl_dosen WHERE kd_dosen = ?");
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
    <h1 class="h3 mb-4 text-gray-800"><?= $mode == 'edit' ? 'Edit' : 'Tambah' ?> Dosen</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-ajax" action="dosen/simpan.php" method="POST" data-modul="dosen">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <input type="hidden" name="pk_lama" value="<?= $d['kd_dosen'] ?>">

                <div class="form-group">
                    <label>Kode Dosen</label>
                    <input type="number" name="kd_dosen" class="form-control"
                        value="<?= $d['kd_dosen'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" maxlength="50"
                        value="<?= htmlspecialchars($d['nama']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" maxlength="255"
                        value="<?= htmlspecialchars($d['alamat']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="loadPage('dosen')">Batal</button>
            </form>
        </div>
    </div>
</div>
