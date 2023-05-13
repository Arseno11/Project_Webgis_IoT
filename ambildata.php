<?php
include "koneksi.php";

try {
        $stmt = $koneksi->prepare("SELECT * FROM alat");
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = array();
        $errors = array();

        while ($row = mysqli_fetch_array($result)) {
                // Mendapatkan waktu terakhir update untuk setiap id
                $lastUpdateTime = strtotime($row['waktu']);
                // Mendapatkan waktu sekarang
                $currentTime = time();
                // Cek apakah waktu terakhir update melebihi 10 detik dari waktu sekarang
                if ($currentTime - $lastUpdateTime > 10) {
                        // Jika melebihi 10 detik, tambahkan pesan error ke data
                        $errorMsg = "Database tidak diupdate dalam 10 detik terakhir, waktu default: " . date('Y-m-d H:i:s', $lastUpdateTime);
                        $errors[$row['nama_alat']] = $errorMsg;
                }
                $posts[] = $row;
        }

        $data = json_encode(array('results' => $posts, 'errors' => $errors));
        echo $data;

        $koneksi->close();
} catch (mysqli_sql_exception $e) {
        // Tambahkan pernyataan untuk menangani error dan exception di sini
        echo "Error: " . $e->getMessage();
}
