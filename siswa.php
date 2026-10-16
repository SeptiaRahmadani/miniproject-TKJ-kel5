<?php
// Koneksi database
include "koneksi.php";

// Ambil data siswa
$query_siswa = "SELECT * FROM data_siswa ORDER BY id ASC";
$hasil_siswa = mysqli_query($koneksi, $query_siswa);
$data_siswa = mysqli_fetch_all($hasil_siswa, MYSQLI_ASSOC);
$total_siswa = count($data_siswa);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa TKJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">👨‍🎓 Data Siswa TKJ</h2>
            <p class="text-muted mb-0">Daftar siswa yang terdata di sistem</p>
        </div>
        <div class="d-flex gap-2">
            <a href="index.html" class="btn btn-outline-light me-2">🏠 Halaman Utama</a>
            <a href="index.php" class="btn btn-outline-primary">Data Alat</a>
            <a href="tambah_siswa.php" class="btn btn-success">+ Tambah Siswa</a>
        </div>
    </div>

    <!-- Kotak Statistik Total Siswa (Full Lebar) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="text-muted">Total Siswa Terdaftar</div>
            <div class="fs-2 fw-bold text-success"><?php echo $total_siswa; ?></div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Daftar Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>No. HP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data_siswa)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($data_siswa as $row): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_siswa'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['kelas'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['JK'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['No_hp'] ?? $row['No_Hp'] ?? ''); ?></td>
                            <td class="text-center text-nowrap">
                                <a href="update_siswa.php?id=<?php echo urlencode($row['id'] ?? ''); ?>" class="btn btn-warning btn-sm">Update</a>
                                <form class="d-inline" action="delete_siswa.php" method="post" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?');">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) ($row['id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>