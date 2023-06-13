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

// Mempersiapkan pernyataan SQL yang akan dijalankan
$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE alat SET jarak = ?, hujan = ? WHERE id_alat = ?"
);
if (!$stmt) {
    http_response_code(500);
    die("Failed to prepare SQL statement: " . mysqli_error($koneksi));
}

// Menyisipkan data ke dalam pernyataan SQL
mysqli_stmt_bind_param($stmt, "iii", $jarak, $hujan, $id_alat);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    die("Failed to update data in database: " . mysqli_error($koneksi));
}

// Menampilkan pesan sukses
echo "Data berhasil disimpan!";