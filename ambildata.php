<?php
include "koneksi.php";

// Mendapatkan waktu terakhir update
$lastUpdateTime = 0;
$stmt = $koneksi->prepare("SELECT MAX(waktu) as last_update_time FROM alat");
$stmt->execute();
$result = $stmt->get_result();
if (mysqli_num_rows($result)) {
        $lastUpdateTime = strtotime(mysqli_fetch_assoc($result)['last_update_time']);
}

// Cek apakah waktu terakhir update melebihi 20 detik dari waktu sekarang
if (time() - $lastUpdateTime > 20) {
        echo json_encode(array('error' => 'Data tidak diupdate'));
} else {
        try {
                $stmt = $koneksi->prepare("SELECT * FROM alat");
                $stmt->execute();
                $result = $stmt->get_result();
                $posts = array();
                if (mysqli_num_rows($result)) {
                        while ($post = mysqli_fetch_assoc($result)) {
                                $posts[] = $post;
                        }
                }
                $data = json_encode(array('results' => $posts));
                echo $data;
        } catch (Exception $e) {
                // Tambahkan pernyataan untuk menangani error dan exception di sini
                echo "Error: " . $e->getMessage();
        }
}
