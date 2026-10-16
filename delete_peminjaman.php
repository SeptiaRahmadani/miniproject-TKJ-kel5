<?php
include "koneksi.php";
require_once "auth.php";
auth_wajib_peran('guru');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: peminjaman.php");
    exit;
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    header("Location: peminjaman.php");
    exit;
}

try {
    $statement = mysqli_prepare($koneksi, "DELETE FROM peminjaman WHERE id = ?");
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    header("Location: peminjaman.php");
    exit;
} catch (mysqli_sql_exception $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gagal Menghapus Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card">
        <h2>Data peminjaman gagal dihapus</h2>
        <p class="alert-error">Terjadi kesalahan saat menghapus data. Silakan coba lagi.</p>
        <a href="peminjaman.php">Kembali ke data peminjaman</a>
    </div>
</body>
</html>
