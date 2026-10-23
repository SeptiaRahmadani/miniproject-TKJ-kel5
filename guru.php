<?php
require_once "auth.php";
$pengguna = auth_wajib_peran('guru');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Menu Guru</h2>
            <p class="mb-0">Masuk sebagai <?php echo htmlspecialchars((string) $pengguna['username'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="beranda.html" class="btn btn-outline-light">Halaman Utama</a>
            <a href="logout.php" class="btn btn-success">Keluar</a>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <a class="card role-card h-100 text-decoration-none" href="peminjaman.php">
                <div class="card-body">
                    <div class="role-card-icon">📋</div>
                    <h3 class="h5">Data Peminjaman</h3>
                    <p class="text-muted mb-0">Lihat siapa yang meminjam dan kelola catatan peminjaman.</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="card role-card h-100 text-decoration-none" href="index.php">
                <div class="card-body">
                    <div class="role-card-icon">🔌</div>
                    <h3 class="h5">Data Alat</h3>
                    <p class="text-muted mb-0">Kelola inventaris alat praktik.</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="card role-card h-100 text-decoration-none" href="siswa.php">
                <div class="card-body">
                    <div class="role-card-icon">👨‍🎓</div>
                    <h3 class="h5">Data Siswa</h3>
                    <p class="text-muted mb-0">Kelola data siswa dan akun peminjaman mereka.</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="card role-card h-100 text-decoration-none" href="akun_siswa.php">
                <div class="card-body">
                    <div class="role-card-icon">🔐</div>
                    <h3 class="h5">Akun Siswa</h3>
                    <p class="text-muted mb-0">Buat akun agar siswa dapat melihat peminjaman miliknya.</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="card role-card h-100 text-decoration-none" href="akun_guru.php">
                <div class="card-body">
                    <div class="role-card-icon">👩‍🏫</div>
                    <h3 class="h5">Akun Guru</h3>
                    <p class="text-muted mb-0">Buat akun login untuk guru lain.</p>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
