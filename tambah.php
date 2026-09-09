<?php
include "koneksi.php";
if (isset($_POST['submit'])){
    $namasiswa = $_POST['$namasiswa'];
    $kelas = $_POST['kelas'];
    $Judulbuku = $_POST['Judulbuku'];
    $query = "INSERT INTO peminjaman
    (namasiswa, kelas, Judulbuku) VALUES
    ('FIKRI PUTRA", 'XIII 9', 'Sistem Listrik')";
    mysqli_query($koneksi, $query);
    header("Location: tampil.php");}
    }
    ?>

    <html lang="en">
    <head>                                                                          
    <head>
    <body>
     <from action="" method="POST">
        <label for="namasiswa">Nama Siswa:</label>
        <input type="text" name="namasiswa" id="namasiswa" required><br><br>
        <label for="kelas">Kelas:</label>
        <input type="text" name="kelas" id="kelas" required><br><br>
        <label for="Judulbuku">Judul Buku:</label>
        <input type="text" name="Judulbuku" id="Judulbuku" required><br><br>
        <input type="submit" name="submit" value="Submit">