<?php
include "koneksi.php";
require_once "auth.php";

if (auth_pengguna() !== null) {
    header('Location: ' . (auth_pengguna()['role'] === 'guru' ? 'guru.php' : 'peminjaman.php'));
    exit;
}

if (empty($_SESSION['token_daftar_siswa'])) {
    $_SESSION['token_daftar_siswa'] = bin2hex(random_bytes(32));
}

$error = '';
$username = '';
$id_siswa = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) && is_string($_POST['token']) ? $_POST['token'] : '';
    $id_siswa = filter_var($_POST['id_siswa'] ?? '', FILTER_VALIDATE_INT);
    $username = isset($_POST['username']) && is_string($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';
    $konfirmasi_password = isset($_POST['konfirmasi_password']) && is_string($_POST['konfirmasi_password']) ? $_POST['konfirmasi_password'] : '';

    if (!hash_equals($_SESSION['token_daftar_siswa'], $token)) {
        $error = "Form pendaftaran sudah kedaluwarsa. Muat ulang halaman, lalu coba lagi.";
    } elseif ($id_siswa === false || $id_siswa < 1) {
        $error = "Pilih data siswa yang sesuai.";
    } elseif (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $username)) {
        $error = "Username harus 3-50 karakter dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda hubung.";
    } elseif (strlen($password) < 8) {
        $error = "Kata sandi minimal 8 karakter.";
    } elseif ($password !== $konfirmasi_password) {
        $error = "Konfirmasi kata sandi tidak sama.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = mysqli_prepare(
                $koneksi,
                "INSERT INTO akun_pengguna (username, password_hash, role, id_siswa)
                 SELECT ?, ?, 'siswa', s.id
                 FROM data_siswa s
                 LEFT JOIN akun_pengguna a ON a.id_siswa = s.id
                 WHERE s.id = ? AND a.id IS NULL"
            );
            mysqli_stmt_bind_param($statement, "ssi", $username, $hash, $id_siswa);
            mysqli_stmt_execute($statement);
            $akun_dibuat = mysqli_stmt_affected_rows($statement) === 1;
            mysqli_stmt_close($statement);

            if (!$akun_dibuat) {
                $error = "Data siswa itu tidak tersedia atau sudah memiliki akun.";
            } else {
                unset($_SESSION['token_daftar_siswa']);
                header('Location: login.php?role=siswa&daftar=berhasil');
                exit;
            }
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $error = "Akun gagal dibuat. Username mungkin sudah digunakan atau data siswa sudah memiliki akun.";
        }
    }
}

$hasil_siswa = mysqli_query(
    $koneksi,
    "SELECT s.id, s.nama_siswa, s.kelas
     FROM data_siswa s
     LEFT JOIN akun_pengguna a ON a.id_siswa = s.id
     WHERE a.id IS NULL
     ORDER BY s.nama_siswa"
);
$data_siswa = mysqli_fetch_all($hasil_siswa, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Siswa | Portal TJKT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="form-card">
    <h2>Buat Akun Siswa</h2>
    <p class="text-muted">Pilih data siswa yang terdaftar, lalu buat username dan kata sandi untuk masuk ke portal peminjaman.</p>
    <p class="alert-error">Pilih hanya data milikmu. Pendaftaran ini tidak memverifikasi identitas, jadi jangan memilih nama siswa lain.</p>
    <?php if ($error !== ''): ?>
        <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (empty($data_siswa)): ?>
        <p class="text-muted">Semua data siswa sudah memiliki akun. Jika ini keliru, hubungi guru.</p>
    <?php else: ?>
        <form method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token_daftar_siswa'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="id_siswa">Nama dan kelas</label>
                <select id="id_siswa" name="id_siswa" required>
                    <option value="">Pilih data siswa</option>
                    <?php foreach ($data_siswa as $siswa): ?>
                        <option value="<?php echo (int) $siswa['id']; ?>" <?php echo (int) $id_siswa === (int) $siswa['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars((string) $siswa['nama_siswa'] . ' - ' . (string) $siswa['kelas'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" minlength="3" maxlength="50" pattern="[A-Za-z0-9._-]+" autocomplete="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Kata sandi (minimal 8 karakter)</label>
                <input type="password" id="password" name="password" minlength="8" autocomplete="new-password" required>
            </div>
            <div class="form-group">
                <label for="konfirmasi_password">Ulangi kata sandi</label>
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" minlength="8" autocomplete="new-password" required>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Buat Akun</button>
                <a href="index.html">Kembali</a>
            </div>
        </form>
    <?php endif; ?>
</main>
</body>
</html>
