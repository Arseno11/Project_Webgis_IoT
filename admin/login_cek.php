<?php
// Mulai session
session_start();

// Cek apakah status login sudah diset
if (!isset($_SESSION['status'])) {
    // Jika tidak, cek apakah cookie sudah diset
    if (isset($_COOKIE['status'])) {
        // Jika cookie sudah diset, cek apakah cookie masih valid
        include 'koneksi.php';
        $username = $_COOKIE['username'];
        $query = "SELECT * FROM admin WHERE username='$username'";
        $hasil = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($hasil) > 0) {
            // Jika cookie masih valid, set ulang sesi dan cookie
            $_SESSION['username'] = $username;
            $_SESSION['status'] = "login";
            setcookie("username", $username, time() + 86400);
            setcookie("status", "login", time() + 86400);
        } else {
            // Jika cookie tidak valid, hapus cookie dan dialihkan ke halaman login
            setcookie("username", "", time() - 3600);
            setcookie("status", "", time() - 3600);
            header("location:login.php?pesan=cookie_expired");
        }
    } else {
        // Jika tidak ada sesi maupun cookie, dialihkan ke halaman login
        header("location:login.php?pesan=belum_login");
    }
}

// Set waktu untuk logout otomatis (dalam detik)
$inactive = 86400;
// Cek apakah sudah melewati waktu logout otomatis
if (isset($_SESSION['timeout'])) {
    $sessionTTL = time() - $_SESSION['timeout'];
    if ($sessionTTL > $inactive) {
        session_destroy();
        // Hapus cookie jika ada
        if (isset($_COOKIE['username'])) {
            setcookie("username", "", time() - 3600);
            setcookie("status", "", time() - 3600);
        }
        header("location:login.php?pesan=logout");
    }
}
// Update waktu terakhir aktivitas
$_SESSION['timeout'] = time();

// Validasi password memiliki minimal 8 karakter dan kombinasi angka, huruf, dan karakter khusus
if (strlen($password) < 8 || !preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#$%^&*()_+{}:"<>?,.\/\';\[\]\\|=-]).{8,}$/', $password)) {
    echo "Password harus memiliki minimal 8 karakter dan terdiri dari kombinasi angka, huruf, dan karakter khusus.";
} else {
    // Proses login jika password valid
    // ...
}

// Dialihkan ke halaman index
header("location:index.php");
