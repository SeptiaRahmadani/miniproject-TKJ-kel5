<?php
include "koneksi.php";
$id = isset($_GET['id']) ? $_GET['id'] : 0;
if (isset($_POST['submit'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];
    $JK = $_POST['JK']; 
    $No_hp = $_POST['No_hp'];
    $query_siswa = "UPDATE data_siswa SET nama_siswa='$nama_siswa', kelas='$kelas', JK='$JK', No_hp='$No_hp' WHERE id='$id'";
    mysqli_query($koneksi, $query_siswa);
    header("Location: tampil.php");
    exit;
    }  
    $query_siswa = "SELECT * FROM data_siswa WHERE id='$id'";
    $hasil = mysqli_query($koneksi, $query_siswa);
    $data_siswa = mysqli_fetch_assoc($hasil);
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-card">
    <h2>Update Data Siswa</h2>
    <form action="" method="POST">
        <div class="form-group"><label for="nama_siswa">Nama Siswa</label><input type="text" id="nama_siswa" name="nama_siswa" value="<?php echo htmlspecialchars($data_siswa['nama_siswa']); ?>" required></div>
        <div class="form-group"><label for="kelas">Kelas</label><input type="text" id="kelas" name="kelas" value="<?php echo htmlspecialchars($data_siswa['kelas']); ?>" required></div>
        <div class="form-group"><label for="JK">Jenis Kelamin</label><input type="text" id="JK" name="JK" value="<?php echo htmlspecialchars($data_siswa['JK']); ?>" required></div>
        <div class="form-group"><label for="No_hp">No HP</label><input type="text" id="No_hp" name="No_hp" value="<?php echo htmlspecialchars($data_siswa['No_hp']); ?>" required></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Simpan Perubahan</button><a href="index.php">Batal</a></div>
    </form>
</div>
</body>
</html>