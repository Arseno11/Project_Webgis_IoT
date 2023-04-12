<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php


// koneksi database
include 'koneksi.php';

// menangkap data id yang di kirim dari url
$id = $_GET['id_alat'];

// menghapus data dari database
$query = mysqli_query($koneksi, "DELETE FROM alat WHERE id_alat='$id'");

if ($query) {
    echo "<script>
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            );
            window.location = 'tampil_data.php';
          </script>";
} else {
    echo "<script>
            Swal.fire(
                'Failed to delete!',
                'Your file has not been deleted.',
                'error'
            );
            window.location = 'tampil_data.php';
          </script>";
}
