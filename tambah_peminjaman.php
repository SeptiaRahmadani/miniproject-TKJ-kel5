<?php
include "koneksi.php";
include "peminjaman_helper.php";
require_once "auth.php";
auth_wajib_peran('guru');

$error = '';
$tanggal_pinjam = '';
$batas_waktu = '';
$status = 'dipinjam';
$id_siswa = 0;
$data_siswa = peminjaman_ambil_siswa($koneksi);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $tanggal_pinjam = isset($_POST['tanggal_pinjam']) && is_string($_POST['tanggal_pinjam']) ? trim($_POST['tanggal_pinjam']) : '';
    $batas_waktu = isset($_POST['batas_waktu']) && is_string($_POST['batas_waktu']) ? trim($_POST['batas_waktu']) : '';
    $status = isset($_POST['status']) && is_string($_POST['status']) ? trim($_POST['status']) : '';
    $id_siswa = filter_var($_POST['id_siswa'] ?? '', FILTER_VALIDATE_INT);

    $tanggal_database = peminjaman_tanggal_database($tanggal_pinjam);
    $batas_database = peminjaman_tanggal_database($batas_waktu);

    if ($id_siswa === false || $id_siswa < 1 || !peminjaman_siswa_ada($koneksi, $id_siswa)) {
        $error = "Pilih siswa yang terdaftar sebagai peminjam.";
    } elseif ($tanggal_database === null || $batas_database === null) {
        $error = "Masukkan tanggal pinjam dan batas waktu yang valid.";
    } elseif ($batas_waktu < $tanggal_pinjam) {
        $error = "Batas waktu tidak boleh lebih awal dari tanggal pinjam.";
    } elseif ($status === '' || strlen($status) > 15) {
        $error = "Status wajib diisi dan maksimal 15 karakter.";
    } else {
        $hari = peminjaman_nama_hari(date('N', strtotime($tanggal_pinjam)));
        try {
            $statement = mysqli_prepare($koneksi, "INSERT INTO peminjaman (id_siswa, hari, tanggal_pinjam, status, batas_waktu) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($statement, "issss", $id_siswa, $hari, $tanggal_database, $status, $batas_database);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            header("Location: peminjaman.php");
            exit;
        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $error = "Data peminjaman gagal disimpan. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-card">
    <h2>Tambah Data Peminjaman</h2>
    <?php if ($error !== ''): ?>
        <p class="alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (empty($data_siswa)): ?>
        <p class="alert-error">Belum ada data siswa. Tambahkan siswa terlebih dahulu sebelum membuat peminjaman.</p>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="id_siswa">Siswa Peminjam</label>
            <select class="form-select" id="id_siswa" name="id_siswa" required <?php echo empty($data_siswa) ? 'disabled' : ''; ?>>
                <option value="">Pilih siswa</option>
                <?php foreach ($data_siswa as $siswa): ?>
                    <option value="<?php echo (int) $siswa['id']; ?>" <?php echo (int) $id_siswa === (int) $siswa['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars((string) $siswa['nama_siswa'] . ' - ' . (string) $siswa['kelas'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo htmlspecialchars($tanggal_pinjam, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="batas_waktu">Batas Waktu</label>
            <input type="date" id="batas_waktu" name="batas_waktu" value="<?php echo htmlspecialchars($batas_waktu, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" id="status" name="status" maxlength="15" value="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Contoh: dipinjam" required>
        </div>
        <p class="text-muted">Hari peminjaman akan diisi otomatis dari tanggal pinjam.</p>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit" <?php echo empty($data_siswa) ? 'disabled' : ''; ?>>Simpan Data</button>
            <a href="peminjaman.php">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
