<?php
include "koneksi.php";

// Memastikan bahwa parameter "jarak" dan "hujan" telah ditentukan
if (!isset($_GET["jarak"]) || !isset($_GET["hujan"]) || !isset($_GET["id_alat"])) {
    http_response_code(400);
    die("Missing required parameters");
}

// Mengambil nilai dari parameter "jarak" dan "hujan"
$jarak = $_GET["jarak"];
$hujan = $_GET["hujan"];
$id = $_GET["id_alat"];

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
mysqli_stmt_bind_param($stmt, "sii", $jarak, $hujan, $id);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    die("Failed to update data in database: " . mysqli_error($koneksi));
}

// Menampilkan pesan sukses
echo "Data berhasil disimpan!";