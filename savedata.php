<?php
include 'koneksi.php';

// Mendapatkan data dari permintaan POST
$data = json_decode(file_get_contents("php://input"));

// Memastikan bahwa data yang diperlukan ada
if (!isset($data->jarak) || !isset($data->hujan) || !isset($data->id_alat)) {
    http_response_code(400);
    die("Missing required parameters");
}

// Mengambil nilai dari data
$jarak = $data->jarak;
$hujan = $data->hujan;
$id_alat = $data->id_alat;

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