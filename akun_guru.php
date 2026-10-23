<?php
include "koneksi.php";
require_once "auth.php";
$pengguna = auth_wajib_peran('guru');

if (empty($_SESSION['token_akun_guru'])) {
    $_SESSION['token_akun_guru'] = bin2hex(random_bytes(32));
}

$pesan = isset($_GET['dibuat']) ? "Akun guru berhasil dibuat." : '';
$jenis_pesan = 'success';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) && is_string($_POST['token']) ? $_POST['token'] : '';
    $username = isset($_POST['username']) && is_string($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

    if (!hash_equals($_SESSION['token_akun_guru'], $token)) {
        $pesan = "Sesi tidak valid. Muat ulang halaman.";
        $jenis_pesan = 'error';
    } elseif (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $username)) {
        $pesan = "Username harus 3-50 karakter dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda hubung.";
        $jenis_pesan = 'error';
    } elseif (strlen($password) < 10) {
        $pesan = "Kata sandi guru minimal 10 karakter.";
        $jenis_pesan = 'error';
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = mysqli_prepare($koneksi, "INSERT INTO akun_pengguna (username, password_hash, role, id_siswa) VALUES (?, ?, 'guru', NULL)");
            mysqli_stmt_bind_param($statement, "ss", $username, $hash);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            unset($_SESSION['token_akun_guru']);
            header('Location: akun_guru.php?dibuat=1');
            exit;
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $pesan = $exception->getCode() === 1062
                ? "Username sudah digunakan."
                : "Akun guru gagal dibuat karena terjadi masalah pada database.";
            $jenis_pesan = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Akun Guru</h2>
            <p class="mb-0">Buat akun login untuk guru lain.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="guru.php" class="btn btn-outline-light">Menu Guru</a>
            <a href="logout.php" class="btn btn-success">Keluar</a>
        </div>
    </div>
    <?php if ($pesan !== ''): ?>
        <p class="<?php echo $jenis_pesan === 'success' ? 'alert-success' : 'alert-error'; ?>"><?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Buat Akun Guru</h5></div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token_akun_guru'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="col-12 col-md-5">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-control" id="username" name="username" minlength="3" maxlength="50" pattern="[A-Za-z0-9._-]+" autocomplete="off" required>
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="password">Kata sandi awal</label>
                    <input class="form-control" type="password" id="password" name="password" minlength="10" autocomplete="new-password" required>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary" type="submit">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>