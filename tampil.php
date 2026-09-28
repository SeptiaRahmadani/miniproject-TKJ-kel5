<?php
include "koneksi.php";
$query = "SELECT * FROM data_alat";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alat Tersimpan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card" style="text-align: center;">
        <h2>Data Berhasil Disimpan</h2>
        <p>Perubahan inventaris sudah tersimpan di sistem.</p>
        <a href="index.php" class="btn btn-primary">Kembali ke Inventaris</a>
    </div>
</body>
</html>