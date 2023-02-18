<?php
include "koneksi.php";

// Query untuk mengambil waktu terbaru
$query = "SELECT waktu FROM alat ORDER BY waktu DESC";
$hasil = mysqli_query($koneksi, $query);

// Ambil data waktu dari hasil query
$data = mysqli_fetch_assoc($hasil);
$waktu = $data['waktu'];

// Kembalikan waktu dalam format teks atau JSON
echo $waktu;
// atau
// echo json_encode($waktu);