<?php
function peminjaman_parse_tanggal(string $tanggal, string $format): ?DateTimeImmutable
{
    $nilai = DateTimeImmutable::createFromFormat('!' . $format, $tanggal);
    $kesalahan = DateTimeImmutable::getLastErrors();

    if ($nilai === false
        || ($kesalahan !== false && ($kesalahan['warning_count'] > 0 || $kesalahan['error_count'] > 0))
        || $nilai->format($format) !== $tanggal) {
        return null;
    }

    return $nilai;
}

function peminjaman_tanggal_input(?string $tanggal): string
{
    if ($tanggal === null || $tanggal === '') {
        return '';
    }

    $nilai = peminjaman_parse_tanggal($tanggal, 'd-m-Y');
    return $nilai ? $nilai->format('Y-m-d') : '';
}

function peminjaman_tanggal_database(string $tanggal): ?string
{
    $nilai = peminjaman_parse_tanggal($tanggal, 'Y-m-d');
    return $nilai ? $nilai->format('d-m-Y') : null;
}

function peminjaman_nama_hari(string $tanggal): string
{
    $hari = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    return $hari[(int) $tanggal] ?? '';
}

function peminjaman_ambil_siswa(mysqli $koneksi): array
{
    $hasil = mysqli_query($koneksi, "SELECT id, nama_siswa, kelas FROM data_siswa ORDER BY nama_siswa ASC");
    return mysqli_fetch_all($hasil, MYSQLI_ASSOC);
}

function peminjaman_siswa_ada(mysqli $koneksi, int $id_siswa): bool
{
    $statement = mysqli_prepare($koneksi, "SELECT id FROM data_siswa WHERE id = ?");
    mysqli_stmt_bind_param($statement, "i", $id_siswa);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    $ada = mysqli_stmt_num_rows($statement) === 1;
    mysqli_stmt_close($statement);

    return $ada;
}
