<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location:login.php");
    exit;
}

include "db.php";
$db = new db;

// ringkasan jumlah data untuk halaman awal
function hitung($db, $tabel)
{
    $row = $db->koneksi->query("SELECT COUNT(*) AS jml FROM $tabel")->fetch_assoc();
    return $row['jml'];
}

$ringkasan = [
    ['Mahasiswa',   hitung($db, 'tbl_mahasiswa'), 'mahasiswa', 'fa-user-graduate',      'primary'],
    ['Dosen',       hitung($db, 'tbl_dosen'),     'dosen',     'fa-chalkboard-teacher', 'success'],
    ['Mata Kuliah', hitung($db, 'tbl_matkul'),    'matkul',    'fa-book',               'info'],
    ['Semester',    hitung($db, 'tbl_semester'),  'semester',  'fa-calendar-alt',       'secondary'],
    ['Jadwal',      hitung($db, 'tbl_jadwal'),    'jadwal',    'fa-clock',              'warning'],
    ['KRS',         hitung($db, 'tbl_krs'),       'krs',       'fa-clipboard-list',     'danger'],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Dashboard</title>

    <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="asset/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="asset/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3">Nur Najmi Laila Putri <sup>^^</sup></div>
            </a>
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Interface</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i><span>Master</span>
                </a>
                <div id="collapseTwo" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Master Data</h6>
                        <a class="collapse-item menu-link" href="#" data-modul="mahasiswa">Mahasiswa</a>
                        <a class="collapse-item menu-link" href="#" data-modul="dosen">Dosen</a>
                        <a class="collapse-item menu-link" href="#" data-modul="matkul">Matkul</a>
                        <a class="collapse-item menu-link" href="#" data-modul="semester">Semester</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i><span>Transaksi</span>
                </a>
                <div id="collapseUtilities" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Transaksi:</h6>
                        <a class="collapse-item menu-link" href="#" data-modul="jadwal">Jadwal</a>
                        <a class="collapse-item menu-link" href="#" data-modul="krs">KRS</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pengaturan</div>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#" data-modul="user">
                    <i class="fas fa-fw fa-users-cog"></i><span>User</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= htmlspecialchars($_SESSION['username']) ?>
                                </span>
                                <i class="fas fa-user-circle fa-lg text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End Topbar -->

                <!-- Konten dinamis -->
                <div id="contentData">
                    <div class="container-fluid">
                        <h1 class="h3 mb-4 text-gray-800">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

                        <div class="row">
                            <?php foreach ($ringkasan as $r) { ?>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <a href="#" class="menu-link text-decoration-none" data-modul="<?= $r[2] ?>">
                                        <div class="card border-left-<?= $r[4] ?> shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-<?= $r[4] ?> text-uppercase mb-1">
                                                            <?= $r[0] ?>
                                                        </div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $r[1] ?> data</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas <?= $r[3] ?> fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto"><span>Copyright &copy; App Pelatihan 2026</span></div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="asset/vendor/jquery/jquery.min.js"></script>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="asset/js/sb-admin-2.min.js"></script>

    <script>
        // muat halaman modul ke area konten
        function loadPage(modul, file, params) {
            file = file || 'list.php';
            $.get(modul + '/' + file, params || {})
                .done(function (data) {
                    $('#contentData').html(data);
                })
                .fail(function (xhr) {
                    alert('Gagal memuat ' + modul + '/' + file + ' (error ' + xhr.status + '). Pastikan file-nya sudah dibuat.');
                });
        }

        // klik menu sidebar
        $(document).on('click', '.menu-link', function (e) {
            e.preventDefault();
            loadPage($(this).data('modul'));
        });

        // submit semua form CRUD lewat AJAX
        $(document).on('submit', '.form-ajax', function (e) {
            e.preventDefault();
            var f = $(this);
            $.post(f.attr('action'), f.serialize(), function (res) {
                if ($.trim(res) === 'ok') {
                    loadPage(f.data('modul'));
                } else {
                    alert(res);
                }
            });
        });

        // hapus data
        function hapusData(modul, key) {
            if (!confirm('Yakin hapus data ini?')) return;
            $.post(modul + '/hapus.php', { key: key }, function (res) {
                if ($.trim(res) === 'ok') {
                    loadPage(modul);
                } else {
                    alert(res);
                }
            });
        }
    </script>
</body>

</html>
