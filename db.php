<?php

class db {
    public $koneksi;

    function __construct()
    {
        // Error SQL dilempar sebagai exception (sama di PHP 7 & PHP 8),
        // supaya bisa ditangkap try/catch di simpan.php dan hapus.php.
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->koneksi = new mysqli("localhost", "root", "", "db_pelatihan");
            $this->koneksi->set_charset("utf8mb4");
        } catch (mysqli_sql_exception $e) {
            die("Koneksi database gagal: " . $e->getMessage()
                . "<br>Pastikan MySQL di XAMPP sudah Start dan database <b>db_pelatihan</b> sudah ada.");
        }
    }

    function get_user($username, $password)
    {
        $stmt = $this->koneksi->prepare(
            "SELECT * FROM tbl_user WHERE username = ? AND password = ?"
        );
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->get_result();
    }
}

?>
