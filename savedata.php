<?php
include 'koneksi.php';

// Memastikan bahwa parameter "jarak", "hujan", dan "id_alat" telah ditentukan
if (!isset($_GET["jarak"]) || !isset($_GET["hujan"]) || !isset($_GET["id_alat"])) {
    http_response_code(400);
    die("Missing required parameters");
}

// Mengambil nilai dari parameter "jarak", "hujan", dan "id_alat"
$jarak = $_GET["jarak"];
$hujan = $_GET["hujan"];
$id_alat = $_GET["id_alat"];

// Memeriksa apakah id sudah ada di database
$id_exists_stmt = mysqli_prepare(
    $koneksi,
    "SELECT id_alat FROM alat WHERE id_alat = ?"
);
if (!$id_exists_stmt) {
    http_response_code(500);
    die("Failed to prepare SQL statement: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($id_exists_stmt, "i", $id_alat);
if (!mysqli_stmt_execute($id_exists_stmt)) {
    http_response_code(500);
    die("Failed to check id in database: " . mysqli_error($koneksi));
}

mysqli_stmt_store_result($id_exists_stmt);
if (mysqli_stmt_num_rows($id_exists_stmt) == 0) {
    http_response_code(404);
    die("Id not found in database");
}

// Mempersiapkan pernyataan SQL yang akan dijalankan
$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE alat SET jarak = ?, hujan = ? WHERE id_alat = ?"
);
if (!$stmt) {
    http_response_code(500);
    die("Failed to prepare SQL statement: " . mysqli_error($koneksi));
}

// Menyisipkan data ke dalam database
mysqli_stmt_bind_param($stmt, "iii", $jarak, $hujan, $id_alat);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    die("Failed to update data in database: " . mysqli_error($koneksi));
}

// Menampilkan pesan sukses
echo "Data berhasil disimpan!";