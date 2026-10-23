<?php
include "koneksi.php";
require_once "auth.php";

$peran = isset($_GET['role']) && is_string($_GET['role']) ? $_GET['role'] : '';
$pesan = isset($_GET['dibuat'])
    ? "Akun guru berhasil dibuat. Silakan masuk."
    : (isset($_GET['daftar']) && $_GET['daftar'] === 'berhasil' ? "Akun siswa berhasil dibuat. Silakan masuk." : '');
$error = '';

if (auth_pengguna() !== null) {
    header('Location: ' . (auth_pengguna()['role'] === 'guru' ? 'guru.php' : 'peminjaman.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $peran = isset($_POST['role']) && is_string($_POST['role']) ? $_POST['role'] : '';
    $username = isset($_POST['username']) && is_string($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

    if (!in_array($peran, ['guru', 'siswa'], true) || $username === '' || $password === '') {
        $error = "Masukkan username dan kata sandi.";
    } else {
        $statement = mysqli_prepare($koneksi, "SELECT id, username, password_hash, role, id_siswa FROM akun_pengguna WHERE username = ?");
        mysqli_stmt_bind_param($statement, "s", $username);
        mysqli_stmt_execute($statement);
        $hasil = mysqli_stmt_get_result($statement);
        $akun = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($statement);

        if (!$akun || !password_verify($password, (string) $akun['password_hash']) || $akun['role'] !== $peran) {
            $error = "Username, kata sandi, atau jenis akun tidak sesuai.";
        } elseif ($akun['role'] === 'siswa' && $akun['id_siswa'] === null) {
            $error = "Akun siswa belum terhubung ke data siswa. Hubungi guru.";
        } else {
            session_regenerate_id(true);
            $_SESSION['pengguna'] = [
                'id' => (int) $akun['id'],
                'username' => (string) $akun['username'],
                'role' => (string) $akun['role'],
                'id_siswa' => $akun['id_siswa'] === null ? null : (int) $akun['id_siswa'],
            ];
            header('Location: ' . ($akun['role'] === 'guru' ? 'guru.php' : 'peminjaman.php'));
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk <?php echo $peran === 'guru' ? 'Guru' : ($peran === 'siswa' ? 'Siswa' : ''); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-card">
    <?php if (!in_array($peran, ['guru', 'siswa'], true)): ?>
        <h2>Masuk ke Portal</h2>
        <p class="text-muted">Pilih jenis akun untuk melanjutkan.</p>
        <div class="d-grid gap-3">
            <a class="btn btn-primary" href="login.php?role=siswa">Masuk sebagai Siswa</a>
            <a class="btn btn-success" href="login.php?role=guru">Masuk sebagai Guru</a>
            <a href="index.html">Kembali ke pilihan akses</a>
        </div>
    <?php else: ?>
        <h2>Masuk sebagai <?php echo $peran === 'guru' ? 'Guru' : 'Siswa'; ?></h2>
        <?php if ($pesan !== ''): ?>
            <p class="alert-success"><?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="role" value="<?php echo htmlspecialchars($peran, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Kata sandi</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Masuk</button>
                <a href="index.html">Ganti jenis akun</a>
            </div>
        </form>
        <?php if ($peran === 'guru'): ?>
            <p class="mt-4 mb-0 text-muted">Belum punya akun guru? <a href="setup_guru.php">Buat akun guru baru dari komputer server</a></p>
        <?php else: ?>
            <p class="mt-4 mb-0 text-muted">Belum punya akun? <a href="daftar_siswa.php">Buat akun siswa</a></p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
