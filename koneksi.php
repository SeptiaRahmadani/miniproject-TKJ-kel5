<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "data_peminjaman_alat";
$koneksi = mysqli_connect($host, $username, $password, $database);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

