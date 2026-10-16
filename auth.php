<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '' && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $secure,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function auth_pengguna(): ?array
{
    $pengguna = $_SESSION['pengguna'] ?? null;
    if (!is_array($pengguna)
        || !isset($pengguna['id'], $pengguna['username'], $pengguna['role'])
        || !in_array($pengguna['role'], ['guru', 'siswa'], true)) {
        return null;
    }

    return $pengguna;
}

function auth_wajib_masuk(): array
{
    $pengguna = auth_pengguna();
    if ($pengguna === null) {
        header('Location: index.html');
        exit;
    }

    return $pengguna;
}

function auth_wajib_peran(string $peran): array
{
    $pengguna = auth_wajib_masuk();
    if ($pengguna['role'] !== $peran) {
        http_response_code(403);
        $halaman = $pengguna['role'] === 'guru' ? 'guru.php' : 'peminjaman.php';
        echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Akses Ditolak</title><link rel="stylesheet" href="style.css"></head><body><div class="form-card"><h2>Akses tidak diizinkan</h2><p class="text-muted">Halaman ini tidak tersedia untuk peran akun Anda.</p><a class="btn btn-primary" href="' . htmlspecialchars($halaman, ENT_QUOTES, 'UTF-8') . '">Kembali</a></div></body></html>';
        exit;
    }

    return $pengguna;
}
