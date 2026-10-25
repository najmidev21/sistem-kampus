<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$mode = 'tambah';
$d = ['id' => '', 'nim' => '', 'id_jadwal' => '', 'kd_semester' => ''];

if (isset($_GET['key'])) {
    $stmt = $db->koneksi->prepare("SELECT * FROM tbl_krs WHERE id = ?");
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
    <h1 class="h3 mb-4 text-gray-800"><?= $mode == 'edit' ? 'Edit' : 'Tambah' ?> KRS</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-ajax" action="krs/simpan.php" method="POST" data-modul="krs">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <input type="hidden" name="pk_lama" value="<?= $d['id'] ?>">

                <div class="form-group">
                    <label>Mahasiswa</label>
                    <select name="nim" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $opt = $db->koneksi->query("SELECT nim AS v, CONCAT(nim, ' - ', nama) AS t FROM tbl_mahasiswa ORDER BY nim");
                        while ($o = $opt->fetch_assoc()) { ?>
                            <option value="<?= $o['v'] ?>" <?= $d['nim'] == $o['v'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['t']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jadwal</label>
                    <select name="id_jadwal" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $opt = $db->koneksi->query("SELECT j.id AS v, CONCAT(m.nama, ' - ', d.nama, ' (', j.waktu, ', ', j.ruang, ')') AS t FROM tbl_jadwal j JOIN tbl_matkul m ON m.kd_matkul = j.kd_matkul JOIN tbl_dosen d ON d.kd_dosen = j.kd_dosen ORDER BY m.nama");
                        while ($o = $opt->fetch_assoc()) { ?>
                            <option value="<?= $o['v'] ?>" <?= $d['id_jadwal'] == $o['v'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['t']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Semester</label>
                    <select name="kd_semester" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $opt = $db->koneksi->query("SELECT kd_semester AS v, semester AS t FROM tbl_semester ORDER BY kd_semester DESC");
                        while ($o = $opt->fetch_assoc()) { ?>
                            <option value="<?= $o['v'] ?>" <?= $d['kd_semester'] == $o['v'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['t']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="loadPage('krs')">Batal</button>
            </form>
        </div>
    </div>
</div>
