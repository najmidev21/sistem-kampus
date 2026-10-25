<?php
include "db.php";
session_start();
$db = new db;
$pesan = '';

if (isset($_POST['login'])) {
    $data = $db->get_user($_POST['username'], $_POST['password']);
    if ($data->num_rows > 0) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['status'] = true;
        header('location:dashboard.php');
        exit;
    } else {
        $pesan = 'username atau password salah';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Login</title>

    <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="asset/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-9 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form class="user" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                        name="username" placeholder="username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        name="password" placeholder="Password" required>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit"
                                    name="login">Login</button>
                            </form>
                            <?php if ($pesan != '') { ?>
                                <div class="alert alert-danger mt-3 mb-0"><?= $pesan ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="asset/vendor/jquery/jquery.min.js"></script>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="asset/js/sb-admin-2.min.js"></script>
</body>

</html>
