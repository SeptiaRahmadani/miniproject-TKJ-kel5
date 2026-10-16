<?php
// Koneksi database
include "koneksi.php";
require_once "auth.php";
auth_wajib_peran('guru');

// Ambil data alat
$query_alat = "SELECT * FROM data_alat ORDER BY id ASC";
$hasil_alat = mysqli_query($koneksi, $query_alat);
$data_alat = mysqli_fetch_all($hasil_alat, MYSQLI_ASSOC);

// Hitung jumlah jenis alat
$total_jenis_alat = count($data_alat);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat Praktik TKJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">🔌 Lab TKJ - Inventaris Alat</h2>
            <p class="text-muted mb-0">Sistem pengelolaan alat praktik jaringan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="beranda.html" class="btn btn-outline-light me-2">🏠 Halaman Utama</a>
            <a href="siswa.php" class="btn btn-outline-primary">Data Siswa</a>
            <a href="peminjaman.php" class="btn btn-outline-primary">Data Peminjaman</a>
            <a href="tambah.php" class="btn btn-success">+ Tambah Alat</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="text-muted">Total jenis alat</div>
            <div class="fs-2 fw-bold"><?php echo $total_jenis_alat; ?></div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Data Alat Praktik TKJ</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th> <!-- Diubah jadi No agar sesuai dengan nomor urut -->
                            <th>Nama Alat</th>
                            <th>Merk</th>
                            <th>Total Stok</th>
                            <th>Kondisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data_alat)): ?>
                        <?php $no = 1; // Inisialisasi nomor urut di sini ?>
                        <?php foreach ($data_alat as $row): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_alat']); ?></td>
                            <td><?php echo htmlspecialchars($row['merk']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_stok']); ?></td>
                            <td><?php echo htmlspecialchars($row['kondisi']); ?></td>
                            <td class="text-center text-nowrap">
                                <!-- Tombol update & delete tetap pakai ID asli dari database -->
                                <a href="update.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-warning btn-sm">Update</a>
                                <form class="d-inline" action="delete.php" method="post" onsubmit="return confirm('Yakin ingin menghapus data alat ini?');">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data alat.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>