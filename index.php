<?php 
include "koneksi.php";
$query = "SELECT * FROM data_alat";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat Praktik TKJ</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Theme TKJ CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <!-- Header section -->
            <div class="header-tkj d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="mb-0">🔌 Lab TKJ - Inventaris</h2>
                    <small class="text-muted">Sistem Manajemen & Peminjaman Alat Jaringan</small>
                </div>
                <div>
                    <a href="tambah.php" class="btn btn-success">➕ Tambah Data</a>
                </div>
            </div>

            <!-- Card & Table Section -->
            <div class="tkj-card card shadow-sm p-3">
                <div class="table-responsive">
                    <table class="table table-tkj table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Alat</th>
                                <th>Merk</th>
                                <th>Total Stok</th>
                                <th>Kondisi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_alat']); ?></td>
                                <td><?php echo htmlspecialchars($row['merk']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_stok']); ?></td>
                                <td><?php echo htmlspecialchars($row['kondisi']); ?></td>
                                <td class="text-center">
                                    <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm me-1">Update</a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</a>
                                </td>
                            </tr>  
                            <?php endforeach; ?> 
                        </tbody>
                    </table> 
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>