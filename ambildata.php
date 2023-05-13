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
                // Cek apakah waktu terakhir update melebihi 1 jam dari waktu sekarang
                if ($currentTime - $lastUpdateTime > 3600) {
                        // Jika melebihi 1 jam, reset kolom 'jarak' dan 'cuaca' untuk id_alat yang tidak update
                        $id_alat = $row['id_alat'];
                        $reset_stmt = $koneksi->prepare("UPDATE alat SET jarak = 0, hujan = 0 WHERE id_alat = ?");
                        $reset_stmt->bind_param("i", $id_alat);
                        $reset_stmt->execute();
                        $reset_stmt->close();

                        // Tambahkan pesan error ke data
                        $errorMsg = "Kolom 'jarak' dan 'cuaca' untuk id_alat " . $id_alat . " telah direset karena tidak diupdate dalam 1 jam terakhir.";
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
