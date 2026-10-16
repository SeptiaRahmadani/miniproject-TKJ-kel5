<?php
include "koneksi.php";
require_once "auth.php";
auth_wajib_peran('guru');

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $merk = trim($_POST['merk'] ?? '');
    $total_stok = filter_var($_POST['total_stok'] ?? '', FILTER_VALIDATE_INT);
    $kondisi = trim($_POST['kondisi'] ?? '');

    if ($nama_alat === '' || $merk === '' || $kondisi === '' || $total_stok === false || $total_stok < 0) {
        $error = "Lengkapi semua data dan masukkan stok berupa bilangan bulat nol atau lebih.";
    } else {
        try {
            $statement = mysqli_prepare($koneksi, "INSERT INTO data_alat (nama_alat, merk, total_stok, kondisi) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($statement, "ssis", $nama_alat, $merk, $total_stok, $kondisi);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            header("Location: index.php");
            exit;
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $error = "Data alat gagal disimpan. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
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
            <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group"><label for="nama_alat">Nama Alat</label><input type="text" name="nama_alat" id="nama_alat" required placeholder="Masukkan nama alat"></div>
            <div class="form-group"><label for="merk">Merk</label><input type="text" name="merk" id="merk" required placeholder="Masukkan merk"></div>
            <div class="form-group"><label for="total_stok">Total Stok</label><input type="number" name="total_stok" id="total_stok" min="0" step="1" required placeholder="Masukkan total stok"></div>
            <div class="form-group"><label for="kondisi">Kondisi</label><input type="text" name="kondisi" id="kondisi" required placeholder="Contoh: Baik"></div>
            <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Simpan Data</button><a href="index.php">Batal</a></div>
        </form>
    </div>
</body>
</html>