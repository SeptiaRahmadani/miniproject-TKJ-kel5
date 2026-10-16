<?php
include "koneksi.php";
include "peminjaman_helper.php";
require_once "auth.php";
$pengguna = auth_wajib_masuk();

$query = "SELECT p.id, p.id_siswa, s.nama_siswa, s.kelas, p.hari, p.tanggal_pinjam, p.status, p.batas_waktu
          FROM peminjaman p
          LEFT JOIN data_siswa s ON s.id = p.id_siswa
          " . ($pengguna['role'] === 'siswa' ? "WHERE p.id_siswa = " . (int) $pengguna['id_siswa'] . " " : "")
          . "ORDER BY p.id DESC";
$hasil = mysqli_query($koneksi, $query);
$data_peminjaman = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
$total_peminjaman = count($data_peminjaman);
$total_dipinjam = 0;

foreach ($data_peminjaman as $row) {
    if (strtolower(trim((string) $row['status'])) === 'dipinjam') {
        $total_dipinjam++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">📋 Data Peminjaman</h2>
            <p class="text-muted mb-0">Daftar dan pengelolaan data peminjaman</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="beranda.html" class="btn btn-outline-light">🏠 Halaman Utama</a>
            <?php if ($pengguna['role'] === 'guru'): ?>
                <a href="guru.php" class="btn btn-outline-primary">Menu Guru</a>
                <a href="index.php" class="btn btn-outline-primary">Data Alat</a>
                <a href="siswa.php" class="btn btn-outline-primary">Data Siswa</a>
                <a href="tambah_peminjaman.php" class="btn btn-success">+ Tambah Peminjaman</a>
            <?php else: ?>
                <span class="text-white">Halo, <?php echo htmlspecialchars((string) $pengguna['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                <a href="logout.php" class="btn btn-success">Keluar</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <?php if ($pengguna['role'] === 'guru'): ?>
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted">Total Catatan Peminjaman</div>
                    <div class="fs-2 fw-bold"><?php echo $total_peminjaman; ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted">Status Dipinjam</div>
                    <div class="fs-2 fw-bold text-warning"><?php echo $total_dipinjam; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Riwayat Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Siswa Peminjam</th>
                            <th>Hari</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Batas Waktu</th>
                            <?php if ($pengguna['role'] === 'guru'): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data_peminjaman)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($data_peminjaman as $row): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $no++; ?></td>
                            <td>
                                <?php if ($row['nama_siswa'] !== null): ?>
                                    <?php echo htmlspecialchars((string) $row['nama_siswa'] . ' - ' . (string) $row['kelas'], ENT_QUOTES, 'UTF-8'); ?>
                                <?php else: ?>
                                    <span class="text-muted">Belum dipilih</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars((string) $row['hari'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) $row['tanggal_pinjam'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) $row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) $row['batas_waktu'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <?php if ($pengguna['role'] === 'guru'): ?>
                                <td class="text-center text-nowrap">
                                    <a href="update_peminjaman.php?id=<?php echo urlencode((string) $row['id']); ?>" class="btn btn-warning btn-sm">Update</a>
                                    <form class="d-inline" action="delete_peminjaman.php" method="post" onsubmit="return confirm('Yakin ingin menghapus catatan peminjaman ini?');">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="<?php echo $pengguna['role'] === 'guru' ? '7' : '6'; ?>" class="text-center text-muted py-4"><?php echo $pengguna['role'] === 'siswa' ? 'Belum ada peminjaman atas nama akun ini.' : 'Belum ada data peminjaman.'; ?></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
