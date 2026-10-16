<?php
include "koneksi.php";

$error = "";

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    header("Location: siswa.php");
    exit;
}

$query_cek = "SELECT *, No_hp AS no_hp FROM data_siswa WHERE id = $id";
$result = mysqli_query($koneksi, $query_cek);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: siswa.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama_siswa = trim($_POST['nama_siswa'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $JK = trim($_POST['JK'] ?? '');
    $No_hp = trim($_POST['No_hp'] ?? '');

    if ($nama_siswa === '' || $kelas === '' || $JK === '' || $No_hp === '') {
        $error = "Semua data siswa wajib diisi.";
    } else {
        try {
            $query_update = "UPDATE data_siswa SET nama_siswa = ?, kelas = ?, JK = ?, No_hp = ? WHERE id = ?";
            $statement = mysqli_prepare($koneksi, $query_update);
            mysqli_stmt_bind_param($statement, "ssssi", $nama_siswa, $kelas, $JK, $No_hp, $id);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            header("Location: siswa.php");
            exit;
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $error = "Perubahan data siswa gagal disimpan. Silakan coba lagi.";
        }
    }

    $row['nama_siswa'] = $nama_siswa;
    $row['kelas'] = $kelas;
    $row['JK'] = $JK;
    $row['no_hp'] = $No_hp;
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
            <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" value="<?php echo htmlspecialchars((string) ($row['nama_siswa'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" name="kelas" id="kelas" value="<?php echo htmlspecialchars((string) ($row['kelas'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="JK">Jenis Kelamin</label>
                <input type="text" name="JK" id="JK" value="<?php echo htmlspecialchars((string) ($row['JK'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="No_hp">No HP</label>
                <input type="text" name="No_hp" id="No_hp" value="<?php echo htmlspecialchars((string) ($row['no_hp'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="form-actions">
                <button class="btn btn-primary" type="submit" name="update">Simpan Perubahan</button>
                <a href="siswa.php">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>