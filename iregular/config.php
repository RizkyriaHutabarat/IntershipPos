<?php
$host = "localhost"; // atau nama host lain
$user = "root"; // username MySQL
$password = ""; // password MySQL
$database = "iregularitas"; // ganti sesuai nama database yang kamu buat

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
