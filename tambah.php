<?php
include "koneksi.php";
if (isset($_POST['submit'])){
    $nama_alat = $_POST['nama_alat'];
    $merk = $_POST['merk'];
    $total_stok = $_POST['total_stok'];
    $kondisi = $_POST['kondisi'];
    $query = "INSERT INTO data_alat (nama_alat, merk, total_stok, kondisi) VALUES ('$nama_alat', '$merk', '$total_stok', '$kondisi')";
    $hasil = mysqli_query($koneksi, $query);
    if ($hasil) {
         echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    header("Location: tampil.php"); exit;
}
?>

    <html lang="en">
    <head>                                                                          
    </head>
    <body>
     <form action="" method="POST">
        <label for="nama_alat">Nama Alat:</label>
        <input type="text" name="nama_alat" id="nama_alat" required placeholder="Masukkan nama alat"><br><br>
        <label for="merk">Merk:</label>
        <input type="text" name="merk" id="merk" required placeholder="Masukkan merk"><br><br>
        <label for="total_stok">Total Stok:</label>
        <input type="number" name="total_stok" id="total_stok" required placeholder="Masukkan total stok"><br><br>
        <label for="kondisi">Kondisi:</label>
        <input type="text" name="kondisi" id="kondisi" required placeholder="Masukkan kondisi"><br><br>
        <input type="submit" name="submit" value="Submit">
     </form>
    </body>
    </html>
