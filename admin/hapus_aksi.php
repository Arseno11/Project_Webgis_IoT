<?php
// koneksi database
include 'koneksi.php';

// menangkap data id yang di kirim dari url
$id = $_GET['id_alat'];


// menghapus data dari database
$query = mysqli_query($koneksi, "delete from alat where id_alat='$id'");
if ($query) {
    echo `<script>fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    ) window.location = 'tampil_data.php'</script>`;
} else {
    echo "<script>Swal . fire(
    'Deleted!',
    'Your file not deleted.',
    'error'
) window.location = 'tampil_data.php'</script>";
}
