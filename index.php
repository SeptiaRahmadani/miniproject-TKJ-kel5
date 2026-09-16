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
        <title>Daftar Peminjaman Alat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body>
        <h1 class="text-center mt-3">Daftar Peminjaman Alat</h1>
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
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html> 