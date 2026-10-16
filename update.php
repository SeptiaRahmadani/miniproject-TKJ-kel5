<?php
include "koneksi.php";
$error = "";
$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);

if ($id === false || $id < 1) {
    header("Location: index.php");
    exit;
}

$query_alat = "SELECT * FROM data_alat WHERE id = $id";
$hasil = mysqli_query($koneksi, $query_alat);
$data_alat = mysqli_fetch_assoc($hasil);

if (!$data_alat) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $merk = trim($_POST['merk'] ?? '');
    $total_stok = filter_var($_POST['total_stok'] ?? '', FILTER_VALIDATE_INT);
    $kondisi = trim($_POST['kondisi'] ?? '');

    if ($nama_alat === '' || $merk === '' || $kondisi === '' || $total_stok === false || $total_stok < 0) {
        $error = "Lengkapi semua data dan masukkan stok berupa bilangan bulat nol atau lebih.";
    } else {
        try {
            $statement = mysqli_prepare($koneksi, "UPDATE data_alat SET nama_alat = ?, merk = ?, total_stok = ?, kondisi = ? WHERE id = ?");
            mysqli_stmt_bind_param($statement, "ssisi", $nama_alat, $merk, $total_stok, $kondisi, $id);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            header("Location: index.php");
            exit;
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $error = "Perubahan data alat gagal disimpan. Silakan coba lagi.";
        }
    }

    $data_alat['nama_alat'] = $nama_alat;
    $data_alat['merk'] = $merk;
    $data_alat['total_stok'] = $total_stok === false ? '' : $total_stok;
    $data_alat['kondisi'] = $kondisi;
}
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
    <?php if ($error !== ''): ?>
        <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-group"><label for="nama_alat">Nama Alat</label><input type="text" id="nama_alat" name="nama_alat" value="<?php echo htmlspecialchars((string) $data_alat['nama_alat'], ENT_QUOTES, 'UTF-8'); ?>" required></div>
        <div class="form-group"><label for="merk">Merk</label><input type="text" id="merk" name="merk" value="<?php echo htmlspecialchars((string) $data_alat['merk'], ENT_QUOTES, 'UTF-8'); ?>" required></div>
        <div class="form-group"><label for="total_stok">Total Stok</label><input type="number" id="total_stok" name="total_stok" min="0" step="1" value="<?php echo htmlspecialchars((string) $data_alat['total_stok'], ENT_QUOTES, 'UTF-8'); ?>" required></div>
        <div class="form-group"><label for="kondisi">Kondisi</label><input type="text" id="kondisi" name="kondisi" value="<?php echo htmlspecialchars((string) $data_alat['kondisi'], ENT_QUOTES, 'UTF-8'); ?>" required></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Simpan Perubahan</button><a href="index.php">Batal</a></div>
    </form>
</div>
</body>
</html>