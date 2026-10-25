<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;
$data = $db->koneksi->query("SELECT k.id, k.nim, mh.nama AS mahasiswa, m.nama AS matkul, d.nama AS dosen, j.waktu, s.semester FROM tbl_krs k JOIN tbl_mahasiswa mh ON mh.nim = k.nim JOIN tbl_jadwal j ON j.id = k.id_jadwal JOIN tbl_matkul m ON m.kd_matkul = j.kd_matkul JOIN tbl_dosen d ON d.kd_dosen = j.kd_dosen JOIN tbl_semester s ON s.kd_semester = k.kd_semester ORDER BY k.id");
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data KRS</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary btn-sm" onclick="loadPage('krs','form.php')">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th><th>NIM</th><th>Mahasiswa</th><th>Mata Kuliah</th><th>Dosen</th><th>Waktu</th><th>Semester</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($r = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($r['nim']) ?></td>
                                <td><?= htmlspecialchars($r['mahasiswa']) ?></td>
                                <td><?= htmlspecialchars($r['matkul']) ?></td>
                                <td><?= htmlspecialchars($r['dosen']) ?></td>
                                <td><?= htmlspecialchars($r['waktu']) ?></td>
                                <td><?= htmlspecialchars($r['semester']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('krs','form.php',{key:'<?= $r['id'] ?>'})">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hapusData('krs','<?= $r['id'] ?>')">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
