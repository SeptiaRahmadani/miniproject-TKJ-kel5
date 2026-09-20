<?php
include "koneksi.php";
$query = "SELECT * FROM data_alat";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daftar Ghibli Studio</title>
        </head>
        <body>
        <a href="index.php" class="button">Kembali</a>
        </body>
</html>