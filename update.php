<?php
include "koneksi.php";
$id = isset($_GET['id']) ? $_GET['id'] : 0;
if (isset($_POST['submit'])) {
    $nama_alat = $_POST['nama_alat'];
    $merk = $_POST['merk'];
    $total_stok = $_POST['total_stok'];
    $kondisi = $_POST['kondisi'];
    $query = "UPDATE peminjaman SET nama_alat='$nama_alat', merk='$merk', total_stok='$total_stok', kondisi='$kondisi' WHERE id='$id'";
    mysqli_query($koneksi, $query);
    header("Location: tampil.php");
    exit;
    }  
    $query_lama = "SELECT * FROM peminjaman WHERE id='$id'";
    $hasil_lama = mysqli_query($koneksi, $query_lama);
    $data = mysqli_fetch_assoc($hasil_lama);
    ?>  
<form action="" method="POST">
    <input type="text" name="nama_alat" value="<?php echo $data['nama_alat']; ?>" required><br>
    <input type="text" name="merk" value="<?php echo $data['merk']; ?>" required><br>
    <input type="text" name="total_stok" value="<?php echo $data['total_stok']; ?>" required><br>
    <input type="text" name="kondisi" value="<?php echo $data['kondisi']; ?>" required><br>
    <button type="submit" name="submit">Update</button>
</form> 