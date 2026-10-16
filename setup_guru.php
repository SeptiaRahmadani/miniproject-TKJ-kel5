<?php
include "koneksi.php";
require_once "auth.php";

$alamat = $_SERVER['REMOTE_ADDR'] ?? '';
if (!in_array($alamat, ['127.0.0.1', '::1'], true)) {
    http_response_code(403);
    exit('Penyiapan akun guru hanya dapat dilakukan dari komputer server.');
}

$jumlah_guru = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM akun_pengguna WHERE role = 'guru'");
$sudah_ada_guru = (int) mysqli_fetch_assoc($jumlah_guru)['total'] > 0;
if ($sudah_ada_guru) {
    header('Location: login.php?role=guru');
    exit;
}

if (empty($_SESSION['token_setup_guru'])) {
    $_SESSION['token_setup_guru'] = bin2hex(random_bytes(32));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) && is_string($_POST['token']) ? $_POST['token'] : '';
    $username = isset($_POST['username']) && is_string($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

    if (!hash_equals($_SESSION['token_setup_guru'], $token)) {
        $error = "Sesi penyiapan tidak valid. Muat ulang halaman.";
    } elseif (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $username)) {
        $error = "Username harus 3-50 karakter dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda hubung.";
    } elseif (strlen($password) < 10) {
        $error = "Kata sandi guru minimal 10 karakter.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = mysqli_prepare($koneksi, "INSERT INTO akun_pengguna (username, password_hash, role, id_siswa) VALUES (?, ?, 'guru', NULL)");
            mysqli_stmt_bind_param($statement, "ss", $username, $hash);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            unset($_SESSION['token_setup_guru']);
            header('Location: login.php?role=guru&dibuat=1');
            exit;
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $error = "Akun guru gagal dibuat. Username mungkin sudah dipakai.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyiapan Akun Guru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-card">
    <h2>Penyiapan Akun Guru</h2>
    <p class="text-muted">Buat akun guru pertama. Halaman ini hanya tersedia dari komputer server dan akan dikunci setelah akun guru dibuat.</p>
    <?php if ($error !== ''): ?>
        <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token_setup_guru'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="form-group">
            <label for="username">Username guru</label>
            <input id="username" name="username" minlength="3" maxlength="50" pattern="[A-Za-z0-9._-]+" autocomplete="username" required>
        </div>
        <div class="form-group">
            <label for="password">Kata sandi (minimal 10 karakter)</label>
            <input type="password" id="password" name="password" minlength="10" autocomplete="new-password" required>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Buat Akun Guru</button>
            <a href="index.html">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
