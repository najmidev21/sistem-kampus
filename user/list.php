<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$data = $db->koneksi->query("SELECT id, username FROM tbl_user ORDER BY id");
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data User</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary btn-sm" onclick="loadPage('user','form.php')">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th><th>Username</th><th>Password</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($r = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?= htmlspecialchars($r['username']) ?>
                                    <?php if ($r['username'] == $_SESSION['username']) { ?>
                                        <span class="badge badge-success">sedang login</span>
                                    <?php } ?>
                                </td>
                                <td>••••••</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('user','form.php',{key:'<?= $r['id'] ?>'})">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusData('user','<?= $r['id'] ?>')">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
