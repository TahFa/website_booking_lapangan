<?php
session_start();
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $user_id     = $_SESSION['id'];
    $lapangan_id = $_POST['lapangan_id'];
    $tanggal     = $_POST['tanggal'];
    $jam_mulai   = $_POST['jam_mulai'];
    $durasi      = (int)$_POST['durasi'];
    $total_harga = $_POST['total_harga'];

    // waktu mulai & selesai
    $start = strtotime("$tanggal $jam_mulai");
    $end   = strtotime("+$durasi hour", $start);

    $jam_selesai = date("H:i:s", $end);

    // jam operasional (08:00 - 23:00)
    $buka  = strtotime("$tanggal 08:00:00");
    $tutup = strtotime("$tanggal 23:00:00");

    // ✅ VALIDASI 1: jam mulai harus dalam jam operasional
    if ($start < $buka || $start >= $tutup) {
        header("Location: index.php?menu=tambah_jadwal&error=Jam mulai harus antara 08:00 - 22:59");
        exit;
    }

    // ✅ VALIDASI 2: jam selesai tidak boleh lewat 23:00
    if ($end > $tutup) {
        header("Location: index.php?menu=tambah_jadwal&error=Jam selesai melewati batas operasional (23:00)");
        exit;
    }

    // ✅ VALIDASI 3: bentrok jadwal
    $cek = mysqli_query($conn, "
        SELECT * FROM booking
        WHERE lapangan_id = '$lapangan_id'
        AND tanggal = '$tanggal'
        AND status = 'approved'
        AND (
            ('$jam_mulai' < jam_selesai) AND
            ('$jam_selesai' > jam_mulai)
        )
    ");

    if (mysqli_num_rows($cek) > 0) {
        header("Location: index.php?menu=tambah_jadwal&error=Jadwal bentrok dengan booking lain!");
        exit;
    }

    // simpan
    mysqli_query($conn, "
        INSERT INTO booking 
        (lapangan_id, tanggal, jam_mulai, jam_selesai, status, user_id, total_harga)
        VALUES 
        ('$lapangan_id','$tanggal','$jam_mulai','$jam_selesai','approved','$user_id','$total_harga')
    ");

    header("Location: index.php?menu=manajemen_jadwal&success=Jadwal berhasil ditambahkan");
    exit;
}