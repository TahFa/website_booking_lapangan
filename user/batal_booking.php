<?php
session_start();
include 'koneksi.php';

$id = $_POST['id'];
$alasan = $_POST['alasan'];
$user_id = $_SESSION['id'];

// ambil data
$data = mysqli_query($conn, "
    SELECT * FROM booking 
    WHERE id='$id' AND user_id='$user_id'
");
$booking = mysqli_fetch_assoc($data);

// validasi
if ($booking['status'] != 'pending') {
    header("Location: index.php?menu=dashboard&error=Booking tidak bisa dibatalkan!");
    exit;
}

// update jadi cancelled + simpan alasan
mysqli_query($conn, "
    UPDATE booking 
    SET status='cancelled', keterangan='$alasan'
    WHERE id='$id'
");

header("Location: index.php?menu=dashboard&success=Booking berhasil dibatalkan!");