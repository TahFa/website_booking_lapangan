<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];

// pakai MD5
$password_md5 = md5($password);

// cek username
$cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Username sudah digunakan!');window.location='register.php';</script>";
    exit;
}

// insert
mysqli_query($conn, "
    INSERT INTO users (nama, username, password)
    VALUES ('$nama', '$username', '$password_md5')
");

echo "<script>alert('Registrasi berhasil!');window.location='login.php';</script>";