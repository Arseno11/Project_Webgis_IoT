<?php
include "koneksi.php";

try {
        $stmt = $koneksi->prepare("SELECT * FROM alat");
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = array();
        $errors = array();

        while ($post = mysqli_fetch_assoc($result)) {
                // Mendapatkan waktu terakhir update untuk setiap id
                $lastUpdateTime = strtotime($post['waktu']);
                // Cek apakah waktu terakhir update melebihi 20 detik dari waktu sekarang
                if (time() - $lastUpdateTime > 20) {
                        // Jika melebihi 20 detik, tambahkan ID alat ke array errors dan set updated ke 0
                        $post['updated'] = 0;
                        $errors[] = $post['id_alat'];
                } else {
                        // Jika belum melebihi 20 detik, set updated ke 1
                        $post['updated'] = 1;
                }
                $posts[] = $post;
        }

        $data = json_encode(array('results' => $posts, 'errors' => $errors));
        echo $data;
} catch (mysqli_sql_exception $e) {
        // Tambahkan pernyataan untuk menangani error dan exception di sini
        echo "Error: " . $e->getMessage();
}
