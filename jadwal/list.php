<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$data = $db->koneksi->query("SELECT j.id, d.nama AS dosen, m.nama AS matkul, j.waktu, j.ruang FROM tbl_jadwal j JOIN tbl_dosen d ON d.kd_dosen = j.kd_dosen JOIN tbl_matkul m ON m.kd_matkul = j.kd_matkul ORDER BY j.id");
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Jadwal</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary btn-sm" onclick="loadPage('jadwal','form.php')">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th><th>Dosen</th><th>Mata Kuliah</th><th>Waktu</th><th>Ruang</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($r = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($r['dosen']) ?></td>
                                <td><?= htmlspecialchars($r['matkul']) ?></td>
                                <td><?= htmlspecialchars($r['waktu']) ?></td>
                                <td><?= htmlspecialchars($r['ruang']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('jadwal','form.php',{key:'<?= $r['id'] ?>'})">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusData('jadwal','<?= $r['id'] ?>')">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
