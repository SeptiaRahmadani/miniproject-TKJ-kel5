<?php
// Koneksi database
include "koneksi.php";
require_once "auth.php";
auth_wajib_peran('guru');

// Ambil data siswa
$query_siswa = "SELECT * FROM data_siswa ORDER BY id ASC";
$hasil_siswa = mysqli_query($koneksi, $query_siswa);
$data_siswa = mysqli_fetch_all($hasil_siswa, MYSQLI_ASSOC);
$total_siswa = count($data_siswa);

$cari = isset($_GET['cari']) && is_string($_GET['cari']) ? trim($_GET['cari']) : '';
$filter_kelas = isset($_GET['kelas']) && is_string($_GET['kelas']) ? trim($_GET['kelas']) : '';
$filter_jk = isset($_GET['jk']) && is_string($_GET['jk']) ? trim($_GET['jk']) : '';
$opsi_kelas = [];
$opsi_jk = [];
$statistik_kelas = [];
$statistik_jk = [];
$siswa_terfilter = [];

foreach ($data_siswa as $row) {
    $kelas = trim((string) ($row['kelas'] ?? ''));
    $jk = trim((string) ($row['JK'] ?? ''));
    $nama = (string) ($row['nama_siswa'] ?? '');

    if ($kelas !== '') {
        $opsi_kelas[$kelas] = $kelas;
        $statistik_kelas[$kelas] = ($statistik_kelas[$kelas] ?? 0) + 1;
    }
    if ($jk !== '') {
        $opsi_jk[$jk] = $jk;
        $statistik_jk[$jk] = ($statistik_jk[$jk] ?? 0) + 1;
    }

    if (($cari === '' || stripos($nama, $cari) !== false)
        && ($filter_kelas === '' || $kelas === $filter_kelas)
        && ($filter_jk === '' || $jk === $filter_jk)) {
        $siswa_terfilter[] = $row;
    }
}

natcasesort($opsi_kelas);
natcasesort($opsi_jk);
ksort($statistik_kelas, SORT_NATURAL | SORT_FLAG_CASE);
ksort($statistik_jk, SORT_NATURAL | SORT_FLAG_CASE);
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
            <a href="beranda.html" class="btn btn-outline-light me-2">🏠 Halaman Utama</a>
            <a href="index.php" class="btn btn-outline-primary">Data Alat</a>
            <a href="peminjaman.php" class="btn btn-outline-primary">Data Peminjaman</a>
            <a href="tambah_siswa.php" class="btn btn-success">+ Tambah Siswa</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted">Total Siswa Terdaftar</div>
                    <div class="fs-2 fw-bold text-success"><?php echo $total_siswa; ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Siswa per Kelas</div>
                    <?php if (!empty($statistik_kelas)): ?>
                        <?php foreach ($statistik_kelas as $kelas => $jumlah): ?>
                            <div class="d-flex justify-content-between gap-3">
                                <span><?php echo htmlspecialchars((string) $kelas, ENT_QUOTES, 'UTF-8'); ?></span>
                                <strong><?php echo $jumlah; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-muted">Belum ada data.</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Siswa per Jenis Kelamin</div>
                    <?php if (!empty($statistik_jk)): ?>
                        <?php foreach ($statistik_jk as $jk => $jumlah): ?>
                            <div class="d-flex justify-content-between gap-3">
                                <span><?php echo htmlspecialchars((string) $jk, ENT_QUOTES, 'UTF-8'); ?></span>
                                <strong><?php echo $jumlah; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-muted">Belum ada data.</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Daftar Siswa (<?php echo count($siswa_terfilter); ?> dari <?php echo $total_siswa; ?>)</h5>
        </div>
        <div class="card-body">
            <form method="get" action="siswa.php" class="row g-2 mb-4">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="cari">Cari nama siswa</label>
                    <input class="form-control" type="search" id="cari" name="cari" value="<?php echo htmlspecialchars($cari, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ketik nama siswa">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="kelas">Filter kelas</label>
                    <select class="form-select" id="kelas" name="kelas">
                        <option value="">Semua kelas</option>
                        <?php foreach ($opsi_kelas as $kelas): ?>
                            <option value="<?php echo htmlspecialchars($kelas, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $filter_kelas === $kelas ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($kelas, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="jk">Filter jenis kelamin</label>
                    <select class="form-select" id="jk" name="jk">
                        <option value="">Semua jenis kelamin</option>
                        <?php foreach ($opsi_jk as $jk): ?>
                            <option value="<?php echo htmlspecialchars($jk, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $filter_jk === $jk ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($jk, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="siswa.php" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
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
                    <?php if (!empty($siswa_terfilter)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($siswa_terfilter as $row): ?>
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
                        <tr><td colspan="6" class="text-center text-muted py-4"><?php echo $total_siswa === 0 ? 'Belum ada data siswa.' : 'Tidak ada siswa yang cocok dengan pencarian atau filter.'; ?></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>