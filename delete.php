<?php
include "koneksi.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];
$query = "DELETE FROM data_alat WHERE id = $id";
$hasil = mysqli_query($koneksi, $query);

if ($hasil) {
    header("Location: index.php");
    exit;
} else {
    die("Error: " . mysqli_error($koneksi));
}
?>