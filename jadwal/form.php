<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$mode = 'tambah';
$d = ['id' => '', 'kd_dosen' => '', 'kd_matkul' => '', 'waktu' => '', 'ruang' => ''];

if (isset($_GET['key'])) {
    $stmt = $db->koneksi->prepare("SELECT * FROM tbl_jadwal WHERE id = ?");
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
    <h1 class="h3 mb-4 text-gray-800"><?= $mode == 'edit' ? 'Edit' : 'Tambah' ?> Jadwal</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-ajax" action="jadwal/simpan.php" method="POST" data-modul="jadwal">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <input type="hidden" name="pk_lama" value="<?= $d['id'] ?>">

                <div class="form-group">
                    <label>Dosen</label>
                    <select name="kd_dosen" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $opt = $db->koneksi->query("SELECT kd_dosen AS v, nama AS t FROM tbl_dosen ORDER BY nama");
                        while ($o = $opt->fetch_assoc()) { ?>
                            <option value="<?= $o['v'] ?>" <?= $d['kd_dosen'] == $o['v'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['t']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Mata Kuliah</label>
                    <select name="kd_matkul" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $opt = $db->koneksi->query("SELECT kd_matkul AS v, CONCAT(nama, ' (', sks, ')') AS t FROM tbl_matkul ORDER BY nama");
                        while ($o = $opt->fetch_assoc()) { ?>
                            <option value="<?= $o['v'] ?>" <?= $d['kd_matkul'] == $o['v'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['t']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Waktu (contoh: 19.00-20.00 WIB)</label>
                    <input type="text" name="waktu" class="form-control" maxlength="50"
                        value="<?= htmlspecialchars($d['waktu']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Ruang (contoh: V. 601)</label>
                    <input type="text" name="ruang" class="form-control" maxlength="50"
                        value="<?= htmlspecialchars($d['ruang']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="loadPage('jadwal')">Batal</button>
            </form>
        </div>
    </div>
</div>
