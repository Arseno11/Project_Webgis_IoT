<?php
include "koneksi.php";

try {
        $stmt = $koneksi->prepare("SELECT * FROM alat");
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = array();
        if (mysqli_num_rows($result)) {
                while ($post = mysqli_fetch_assoc($result)) {
                        // Mendapatkan waktu terakhir update untuk setiap id
                        $lastUpdateTime = strtotime($post['waktu']);
                        // Cek apakah waktu terakhir update melebihi 20 detik dari waktu sekarang
                        if (time() - $lastUpdateTime > 20) {
                                // Jika melebihi 20 detik, tambahkan pesan error ke data
                                $post['error'] = 'Data tidak diupdate';
                        }
                        $posts[] = $post;
                }
        }
        $data = json_encode(array('results' => $posts));
        echo $data;
} catch (Exception $e) {
        // Tambahkan pernyataan untuk menangani error dan exception di sini
        echo "Error: " . $e->getMessage();
}
