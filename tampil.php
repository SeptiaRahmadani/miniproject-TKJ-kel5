<?php
include "koneksi.php";
$query = "SELECT * FROM peminjaman";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>