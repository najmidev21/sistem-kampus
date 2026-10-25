<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$data = $db->koneksi->query("SELECT * FROM tbl_mahasiswa ORDER BY nim");
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Mahasiswa</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary btn-sm" onclick="loadPage('mahasiswa','form.php')">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th><th>NIM</th><th>Nama</th><th>Alamat</th><th>Jurusan</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($r = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($r['nim']) ?></td>
                                <td><?= htmlspecialchars($r['nama']) ?></td>
                                <td><?= htmlspecialchars($r['alamat']) ?></td>
                                <td><?= htmlspecialchars($r['jurusan']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('mahasiswa','form.php',{key:'<?= $r['nim'] ?>'})">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusData('mahasiswa','<?= $r['nim'] ?>')">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
