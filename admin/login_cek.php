<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE username='$username'";
$hasil = mysqli_query($koneksi, $query);

if (mysqli_num_rows($hasil) > 0) {
    // Ambil data admin dari database
    $data_admin = mysqli_fetch_assoc($hasil);

    // Periksa apakah password yang dimasukkan oleh user cocok dengan password hash di database
    if (password_verify($password, $data_admin['password'])) {
        // Jika password cocok, set sesi dan cookie
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        setcookie("username", $username, time() + 86400);
        setcookie("status", "login", time() + 86400);
        header("location:index.php");
    } else {
        // Jika password tidak cocok, redirect ke halaman login
        header("location:login.php?pesan=gagal");
    }
} else {
    // Jika username tidak ditemukan, redirect ke halaman login
    header("location:login.php?pesan=gagal");
}
