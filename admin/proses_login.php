<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']);
$captcha  = $_POST['captcha'];

if ($captcha != $_SESSION['captcha']) {
    echo "<script>
    alert('Captcha salah!');
    window.location='login.php';
    </script>";
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);

    if ($data['role'] != 'admin') {

        echo "<script>
        alert('Akses ditolak! Halaman ini hanya untuk ADMIN');
        window.location='login.php';
        </script>";
        exit;
    }
    $_SESSION['login'] = true;
    $_SESSION['id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['role'] = $data['role'];

    echo "<script>
    alert('Login berhasil');
    window.location='index.php';
    </script>";
} else {

    echo "<script>
    alert('Username atau password salah');
    window.location='login.php';
    </script>";
}
