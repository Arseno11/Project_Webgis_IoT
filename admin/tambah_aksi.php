<?php
// koneksi database
include 'koneksi.php';

// menangkap data yang di kirim dari form
$nama = $_POST['nama_alat'];
$alamat = $_POST['alamat'];
$deskripsi = $_POST['deskripsi'];
$gambar = $_FILES['gambar'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];



// menginput data ke database
mysqli_query($koneksi, "INSERT INTO alat (nama_alat, alamat, deskripsi, latitude, longitude) VALUES ('$nama', '$alamat', '$deskripsi', '$latitude', '$longitude')");

header("Location: tampil_data.php");
