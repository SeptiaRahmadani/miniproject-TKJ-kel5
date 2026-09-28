<?php
include "koneksi.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama_alat = trim($_POST['nama_alat']);
    $merk = trim($_POST['merk']);
    $total_stok = (int) $_POST['total_stok'];
    $kondisi = trim($_POST['kondisi']);

    $query = "INSERT INTO data_alat (nama_alat, merk, total_stok, kondisi) VALUES ('$nama_alat', '$merk', '$total_stok', '$kondisi')";
    $hasil = mysqli_query($koneksi, $query);

    if ($hasil) {
        header("Location: index.php");
        exit;
    }

    $error = "Error: " . mysqli_error($koneksi);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Alat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card">
        <h2>Tambah Data Alat</h2>
        <?php if (!empty($error)): ?>
            <p class="alert-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group"><label for="nama_alat">Nama Alat</label><input type="text" name="nama_alat" id="nama_alat" required placeholder="Masukkan nama alat"></div>
            <div class="form-group"><label for="merk">Merk</label><input type="text" name="merk" id="merk" required placeholder="Masukkan merk"></div>
            <div class="form-group"><label for="total_stok">Total Stok</label><input type="number" name="total_stok" id="total_stok" required placeholder="Masukkan total stok"></div>
            <div class="form-group"><label for="kondisi">Kondisi</label><input type="text" name="kondisi" id="kondisi" required placeholder="Contoh: Baik"></div>
            <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Simpan Data</button><a href="index.php">Batal</a></div>
        </form>
    </div>
</body>
</html>
