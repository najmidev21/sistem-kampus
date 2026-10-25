<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$data = $db->koneksi->query("SELECT * FROM tbl_matkul ORDER BY kd_matkul");
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Mata Kuliah</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary btn-sm" onclick="loadPage('matkul','form.php')">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th><th>Kode Matkul</th><th>Nama</th><th>SKS</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($r = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($r['kd_matkul']) ?></td>
                                <td><?= htmlspecialchars($r['nama']) ?></td>
                                <td><?= htmlspecialchars($r['sks']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('matkul','form.php',{key:'<?= $r['kd_matkul'] ?>'})">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusData('matkul','<?= $r['kd_matkul'] ?>')">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
