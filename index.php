<?php 
include "koneksi.php";
$query = "SELECT * FROM data_alat";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daftar Alat Praktik TKJ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- Custom Theme TKJ CSS -->
        <link rel="stylesheet" href="style.css">

    </head>
    <body>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="header-tkj d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">🔌 Lab TKJ - Inventaris</h2>
                    <small class="text-muted">Sistem Manajemen & Peminjaman Alat Jaringan</small>
                </div>
               
            </div>

            <div class="tkj-card">
                <div class="table-responsive">
        <table  class="table table-tkj align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nama Alat</th>
                <th>Merk</th>
                <th>Total Stok</th>
                <th>Kondisi</th>
            </tr>
            </thead>
            <tbody>
           <?php foreach ($data as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nama_alat']; ?></td>
        <td><?php echo $row['merk']; ?></td>
        <td><?php echo $row['total_stok']; ?></td>
        <td><?php echo $row['kondisi']; ?></td>
        <td>
            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            <a href="tambah.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Tambah Data</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

           </body>
           </html>
    </head>
    <body>
        <h1 class="text-center mt-3">Daftar Alat Praktik TKJ</h1>
        <div class="container mt-3">
            <a href="tambah.php" class="btn btn-success mb-3">Tambah Data</a>
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Nama Alat</th>
                    <th>Merk</th>
                    <th>Total Stok</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama_alat']; ?></td>
                    <td><?php echo $row['merk']; ?></td>
                    <td><?php echo $row['total_stok']; ?></td>
                    <td><?php echo $row['kondisi']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html> 

