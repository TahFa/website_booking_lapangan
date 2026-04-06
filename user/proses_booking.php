<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['id'];

$lapangan_id = $_POST['lapangan_id'];
$tanggal = $_POST['tanggal'];
$jam_mulai = $_POST['jam_mulai'];
$durasi = $_POST['durasi'];
$total_harga = $_POST['total_harga'];

// HITUNG WAKTU 

// gabungkan tanggal + jam
$start_datetime = strtotime("$tanggal $jam_mulai");
$end_datetime   = strtotime("+$durasi hour", $start_datetime);

// jam operasional
$buka  = strtotime("$tanggal 08:00:00");
$tutup = strtotime("$tanggal 23:00:00");

// ambil jam selesai untuk disimpan
$jam_selesai = date("H:i:s", $end_datetime);

// VALIDASI

// validasi jam mulai
if ($start_datetime < $buka) {
    header("Location: index.php?menu=form_booking&lapangan_id=$lapangan_id&error=Lapangan buka jam 08:00!");
    exit;
}

// validasi jam selesai
if ($end_datetime > $tutup) {
    header("Location: index.php?menu=form_booking&lapangan_id=$lapangan_id&error=Booking melebihi jam operasional (maks 23:00)!");
    exit;
}

// VALIDASI BENTROK
$cek = mysqli_query($conn, "
    SELECT * FROM booking
    WHERE lapangan_id = '$lapangan_id'
    AND tanggal = '$tanggal'
    AND status != 'rejected'
    AND (
        ('$jam_mulai' < jam_selesai) AND
        ('$jam_selesai' > jam_mulai)
    )
");

if (mysqli_num_rows($cek) > 0) {
    header("Location: index.php?menu=form_booking&lapangan_id=$lapangan_id&error=Jadwal sudah dibooking!");
    exit;
}

// INSERT DATA
mysqli_query($conn, "
    INSERT INTO booking (user_id, lapangan_id, tanggal, jam_mulai, jam_selesai, durasi, total_harga, status)
    VALUES ('$user_id','$lapangan_id','$tanggal','$jam_mulai','$jam_selesai','$durasi','$total_harga','pending')
");

echo "<script>alert('Booking berhasil! Menunggu konfirmasi admin');window.location='index.php';</script>";
?>