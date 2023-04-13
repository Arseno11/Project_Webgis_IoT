<?php
$host = "localhost";
$user = "asiw6467_arsen";
$pass = "Arseno123#";
$name = "asiw6467_banjir";

$koneksi = mysqli_connect($host, $user, $pass, $name);
if (mysqli_connect_errno()) {
    echo "Koneksi database mysqli gagal!!! : " . mysqli_connect_error();
}
//mysqli_select_db($name, $koneksi) or die("Tidak ada database yang dipilih!");