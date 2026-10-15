<?php
include "koneksi.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas = trim($_POST['kelas']);
    $JK = trim($_POST['JK']);
    $No_hp = trim($_POST['No_hp']);

    $query = "INSERT INTO data_siswa (nama_siswa, kelas, JK, No_hp) VALUES ('$nama_siswa', '$kelas', '$JK', '$No_hp')";
    $hasil = mysqli_query($koneksi, $query);

    if ($hasil) {
        header("Location: siswa.php");
        exit;
    }

    $error = "Error: " . mysqli_error($koneksi);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card">
        <h2>Tambah Data Siswa</h2>
        <?php if (!empty($error)): ?>
            <p class="alert-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group"><label for="nama_siswa">Nama Siswa</label><input type="text" name="nama_siswa" id="nama_siswa" required placeholder="Masukkan nama siswa"></div>
            <div class="form-group"><label for="kelas">Kelas</label><input type="text" name="kelas" id="kelas" required placeholder="Masukkan kelas"></div>
            <div class="form-group"><label for="JK">Jenis Kelamin</label><input type="text" name="JK" id="JK" required placeholder="Contoh: Laki-laki"></div>
            <div class="form-group"><label for="No_Hp">No Hp</label><input type="text" name="No_Hp" id="No_Hp" required placeholder="Masukkan nomor hp"></div>
            <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Simpan Data</button><a href="index.php">Batal</a></div>
        </form>
    </div>
</body>
</html>
n