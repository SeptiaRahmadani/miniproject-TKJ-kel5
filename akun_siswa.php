<?php
include "koneksi.php";
include "peminjaman_helper.php";
require_once "auth.php";
$pengguna = auth_wajib_peran('guru');

$pesan = '';
$jenis_pesan = 'error';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buat_akun'])) {
    $id_siswa = filter_var($_POST['id_siswa'] ?? '', FILTER_VALIDATE_INT);
    $username = isset($_POST['username']) && is_string($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

    if ($id_siswa === false || $id_siswa < 1 || !peminjaman_siswa_ada($koneksi, $id_siswa)) {
        $pesan = "Pilih siswa yang terdaftar.";
    } elseif (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $username)) {
        $pesan = "Username harus 3-50 karakter dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda hubung.";
    } elseif (strlen($password) < 8) {
        $pesan = "Kata sandi minimal 8 karakter.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = mysqli_prepare($koneksi, "INSERT INTO akun_pengguna (username, password_hash, role, id_siswa) VALUES (?, ?, 'siswa', ?)");
            mysqli_stmt_bind_param($statement, "ssi", $username, $hash, $id_siswa);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            $pesan = "Akun siswa berhasil dibuat.";
            $jenis_pesan = 'success';
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $pesan = $exception->getCode() === 1062
                ? "Username sudah digunakan atau siswa sudah memiliki akun."
                : "Akun gagal dibuat karena terjadi masalah pada database. Hubungi administrator.";
        }
    }
}

$hasil_siswa = mysqli_query(
    $koneksi,
    "SELECT s.id, s.nama_siswa, s.kelas
     FROM data_siswa s
     WHERE NOT EXISTS (
         SELECT 1 FROM akun_pengguna a WHERE a.id_siswa = s.id
     )
     ORDER BY s.nama_siswa"
);
$data_siswa = mysqli_fetch_all($hasil_siswa, MYSQLI_ASSOC);
$hasil_jumlah_siswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_siswa");
$belum_ada_data_siswa = (int) mysqli_fetch_assoc($hasil_jumlah_siswa)['total'] === 0;
$hasil_akun = mysqli_query($koneksi, "SELECT s.id, s.nama_siswa, s.kelas, a.username FROM data_siswa s LEFT JOIN akun_pengguna a ON a.id_siswa = s.id ORDER BY s.nama_siswa");
$akun_siswa = mysqli_fetch_all($hasil_akun, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Akun Siswa</h2>
            <p class="mb-0">Buat kredensial login yang terhubung ke data siswa.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="guru.php" class="btn btn-outline-light">Menu Guru</a>
            <a href="logout.php" class="btn btn-success">Keluar</a>
        </div>
    </div>
    <?php if ($pesan !== ''): ?>
        <p class="<?php echo $jenis_pesan === 'success' ? 'alert-success' : 'alert-error'; ?>"><?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Buat Akun Siswa</h5></div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="id_siswa">Siswa</label>
                    <select class="form-select" id="id_siswa" name="id_siswa" required>
                        <?php if (empty($data_siswa)): ?>
                            <option value=""><?php echo $belum_ada_data_siswa ? 'Belum ada data siswa' : 'Semua siswa sudah memiliki akun'; ?></option>
                        <?php else: ?>
                            <option value="">Pilih siswa</option>
                        <?php endif; ?>
                        <?php foreach ($data_siswa as $siswa): ?>
                            <option value="<?php echo (int) $siswa['id']; ?>"><?php echo htmlspecialchars((string) $siswa['nama_siswa'] . ' - ' . (string) $siswa['kelas'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-control" id="username" name="username" minlength="3" maxlength="50" pattern="[A-Za-z0-9._-]+" autocomplete="off" required>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="password">Kata sandi awal</label>
                    <input class="form-control" type="password" id="password" name="password" minlength="8" autocomplete="new-password" required>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary" type="submit" name="buat_akun" <?php echo empty($data_siswa) ? 'disabled' : ''; ?>>Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Status Akun</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Nama</th><th>Kelas</th><th>Username</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach ($akun_siswa as $siswa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars((string) $siswa['nama_siswa'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) $siswa['kelas'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) ($siswa['username'] ?? '-'), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $siswa['username'] === null ? 'Belum ada akun' : 'Aktif'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
