<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$data = $db->koneksi->query("SELECT * FROM tbl_dosen ORDER BY kd_dosen");
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Dosen</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary btn-sm" onclick="loadPage('dosen','form.php')">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th><th>Kode Dosen</th><th>Nama</th><th>Alamat</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($r = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($r['kd_dosen']) ?></td>
                                <td><?= htmlspecialchars($r['nama']) ?></td>
                                <td><?= htmlspecialchars($r['alamat']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('dosen','form.php',{key:'<?= $r['kd_dosen'] ?>'})">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusData('dosen','<?= $r['kd_dosen'] ?>')">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
