<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    // 🔥 ambil file
    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];

    // 🔥 ambil ekstensi
    $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    // 🔥 validasi ekstensi
    $allowed = ['jpg', 'jpeg', 'png', 'jfif', 'webp'];
    if (!in_array($ext, $allowed)) {
        header("Location: index.php?menu=tambah_lapangan&error=Format gambar harus JPG/PNG");
        exit;
    }

    // 🔥 rename otomatis
    $gambar_baru = time() . "_" . rand(100, 999) . "." . $ext;

    // 🔥 upload
    move_uploaded_file($tmp, "../img/lapangan/" . $gambar_baru);

    mysqli_query($conn, "
        INSERT INTO lapangan (nama_lapangan, harga_per_jam, deskripsi, gambar)
        VALUES ('$nama', '$harga', '$deskripsi', '$gambar_baru')
    ");

    header("Location: index.php?menu=lapangan&success=Tambah berhasil");
    exit;
}
