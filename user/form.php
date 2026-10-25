<?php
session_start();
if (!isset($_SESSION['status'])) exit('Akses ditolak');
include "../db.php";
$db = new db;

$mode = 'tambah';
$d = ['id' => '', 'username' => ''];

if (isset($_GET['key'])) {
    $stmt = $db->koneksi->prepare("SELECT id, username FROM tbl_user WHERE id = ?");
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
    <h1 class="h3 mb-4 text-gray-800"><?= $mode == 'edit' ? 'Edit' : 'Tambah' ?> User</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-ajax" action="user/simpan.php" method="POST" data-modul="user">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <input type="hidden" name="pk_lama" value="<?= $d['id'] ?>">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" maxlength="50"
                        value="<?= htmlspecialchars($d['username']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <?php if ($mode == 'edit') { ?>
                        <input type="password" name="password" class="form-control" maxlength="255"
                            placeholder="Kosongkan jika password tidak diubah">
                    <?php } else { ?>
                        <input type="password" name="password" class="form-control" maxlength="255" required>
                    <?php } ?>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="loadPage('user')">Batal</button>
            </form>
        </div>
    </div>
</div>
