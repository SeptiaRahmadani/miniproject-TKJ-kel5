<?php
include "koneksi.php";
if (isset($_POST['submit'])){
    $nama_alat = $_POST['$nama_alat'];
    $merk = $_POST['merk'];
    $total_stok = $_POST['total_stok'];
    $kondisi = $_POST['kondisi'];
    $query = "INSERT INTO data_alat (nama_alat, merk, total_stok, kondisi) VALUES ('$nama_alat', '$merk', '$total_stok', '$kondisi')";
    $hasil = mysqli_query($koneksi, $query);
    if ($hasil) {
        header("Location: tampil.php");
    }
}
?>

    <html lang="en">
    <head>                                                                          
    </head>
    <body>
     <from action="" method="POST">
        <label for="nama_alat">Nama Alat:</label>
        <input type="text" name="nama_alat" id="nama_alat" required><br><br>
        <label for="merk">Merk:</label>
        <input type="text" name="merk" id="merk" required><br><br>
        <label for="total_stok">Total Stok:</label>
        <input type="number" name="total_stok" id="total_stok" required><br><br>
        <label for="kondisi">Kondisi:</label>
        <input type="text" name="kondisi" id="kondisi" required><br><br>
        <input type="submit" name="submit" value="Submit">
     </from>
    </body>
    </html>
