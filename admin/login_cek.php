<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$hasil = mysqli_query($koneksi, $query);

if (mysqli_num_rows($hasil) > 0) {
    // Jika username dan password benar, set sesi dan cookie
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    setcookie("username", $username, time() + 86400);
    setcookie("status", "login", time() + 86400);
    header("location:index.php");
} else {
    // Jika username dan password salah, redirect ke halaman login
    header("location:login.php?pesan=gagal");
}
