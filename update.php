<?php
include "koneksi.php";
$id = isset($_GET['id']) ? $_GET['id'] : 0;
if (isset($_POST['submit'])) {
    $nama_alat = $_POST['nama_alat'];
    $merk = $_POST['merk'];
    $total_stok = $_POST['total_stok']; 
    $kondisi = $_POST['kondisi'];
    $query_alat = "UPDATE data_alat SET nama_alat='$nama_alat', merk='$merk', total_stok='$total_stok', kondisi='$kondisi' WHERE id='$id'";
    mysqli_query($koneksi, $query_alat);
    header("Location: tampil.php");
    exit;
    }  
    $query_alat = "SELECT * FROM data_alat WHERE id='$id'";
    $hasil = mysqli_query($koneksi, $query_alat);
    $data_alat = mysqli_fetch_assoc($hasil);
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Alat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-card">
    <h2>Update Data Alat</h2>
    <form action="" method="POST">
        <div class="form-group"><label for="nama_alat">Nama Alat</label><input type="text" id="nama_alat" name="nama_alat" value="<?php echo htmlspecialchars($data_alat['nama_alat']); ?>" required></div>
        <div class="form-group"><label for="merk">Merk</label><input type="text" id="merk" name="merk" value="<?php echo htmlspecialchars($data_alat['merk']); ?>" required></div>
        <div class="form-group"><label for="total_stok">Total Stok</label><input type="number" id="total_stok" name="total_stok" value="<?php echo htmlspecialchars($data_alat['total_stok']); ?>" required></div>
        <div class="form-group"><label for="kondisi">Kondisi</label><input type="text" id="kondisi" name="kondisi" value="<?php echo htmlspecialchars($data_alat['kondisi']); ?>" required></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Simpan Perubahan</button><a href="index.php">Batal</a></div>
    </form>
</div>
</body>
</html>