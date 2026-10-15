<?php
include "koneksi.php";
$query = "SELECT * FROM data_siswa";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card" style="text-align: center;">
        <h2>Data Siswa</h2>
        <p>Perubahan data siswa sudah tersimpan di sistem.</p>
        <a href="siswa.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
    </div>
</body>
</html>