<?php

// koneksi database
include 'koneksi.php';

// menangkap data id yang di kirim dari url
$id = $_GET['id_alat'];

// menghapus data dari database
$query = mysqli_query($koneksi, "DELETE FROM alat WHERE id_alat='$id'");

echo '<script>window.location = "tampil_data.php?delete=' . ($query ? 'success' : 'failed') . '";</script>';
