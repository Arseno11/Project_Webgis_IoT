<?php
$host = "sql310.epizy.com";
$user = "epiz_33256224";
$pass = "rWs9bhMIL6SP";
$name = "epiz_33256224_tugas_akhir";

$koneksi = mysqli_connect($host, $user, $pass, $name);
if (mysqli_connect_errno()) {
    echo "Koneksi database mysqli gagal!!! : " . mysqli_connect_error();
}
//mysqli_select_db($name, $koneksi) or die("Tidak ada database yang dipilih!");