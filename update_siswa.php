<?php
include "koneksi.php";

$error = "";

// 1. Cek apakah ada parameter ID di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: siswa.php");
    exit;
}

$id = (int) $_GET['id'];

// 2. Ambil data siswa yang akan di-update berdasarkan ID
$query_cek = "SELECT * FROM data_siswa WHERE id = $id";
$result = mysqli_query($koneksi, $query_cek);
$row = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan di database
if (!$row) {
    header("Location: siswa.php");
    exit;
}

// 3. Proses penyimpanan saat tombol form diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas      = trim($_POST['kelas']);
    $JK         = trim($_POST['JK']);
    $No_hp      = trim($_POST['No_hp']);

    // Query SQL untuk update data siswa
    $query_update = "UPDATE data_siswa SET nama_siswa = '$nama_siswa', kelas = '$kelas', JK = '$JK', No_hp = '$No_hp' WHERE id = $id";
    $hasil = mysqli_query($koneksi, $query_update);

    if ($hasil) {
        // Jika berhasil, arahkan kembali ke halaman data siswa
        header("Location: siswa.php");
        exit;
    } else {
        $error = "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card">
        <h2>Update Data Siswa</h2>
        
        <?php if (!empty($error)): ?>
            <p class="alert-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" value="<?php echo htmlspecialchars($row['nama_siswa'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" name="kelas" id="kelas" value="<?php echo htmlspecialchars($row['kelas'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="JK">Jenis Kelamin</label>
                <input type="text" name="JK" id="JK" value="<?php echo htmlspecialchars($row['JK'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="No_hp">No HP</label>
                <input type="text" name="No_hp" id="No_hp" value="<?php echo htmlspecialchars($row['No_hp'] ?? ''); ?>" required>
            </div>
            
            <div class="form-actions">
                <button class="btn btn-primary" type="submit" name="update">Simpan Perubahan</button>
                <a href="siswa.php">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>