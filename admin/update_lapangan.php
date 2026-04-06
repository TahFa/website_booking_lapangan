<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    // 🔥 ambil data lama
    $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lapangan WHERE id='$id'"));
    $gambar_lama = $old['gambar'];

    $gambar = $_FILES['gambar']['name'];

    if ($gambar != "") {

        $tmp = $_FILES['gambar']['tmp_name'];

        // 🔥 validasi ekstensi
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'jfif', 'webp'];

        if (!in_array($ext, $allowed)) {
            header("Location: index.php?menu=edit_lapangan&id=$id&error=Format gambar harus JPG/PNG");
            exit;
        }

        // 🔥 rename baru
        $gambar_baru = time() . "_" . rand(100, 999) . "." . $ext;

        move_uploaded_file($tmp, "../img/lapangan/" . $gambar_baru);

        // 🔥 hapus gambar lama
        if (file_exists("../img/lapangan/" . $gambar_lama)) {
            unlink("../img/lapangan/" . $gambar_lama);
        }

        mysqli_query($conn, "
            UPDATE lapangan 
            SET nama_lapangan='$nama',
                harga_per_jam='$harga',
                deskripsi='$deskripsi',
                gambar='$gambar_baru'
            WHERE id='$id'
        ");
    } else {

        mysqli_query($conn, "
            UPDATE lapangan 
            SET nama_lapangan='$nama',
                harga_per_jam='$harga',
                deskripsi='$deskripsi'
            WHERE id='$id'
        ");
    }

    header("Location: index.php?menu=lapangan&success=Update berhasil");
    exit;
}
