<?php
include "koneksi.php";
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