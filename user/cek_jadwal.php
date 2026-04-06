<?php
include 'koneksi.php';

$tanggal = $_GET['tanggal'];
$lapangan_id = $_GET['lapangan_id'];
$jam_mulai = $_GET['jam_mulai'];
$durasi = $_GET['durasi'];

$start = strtotime("$tanggal $jam_mulai");
$end   = strtotime("+$durasi hour", $start);

$data = mysqli_query($conn, "
    SELECT jam_mulai, jam_selesai 
    FROM booking
    WHERE tanggal = '$tanggal'
    AND lapangan_id = '$lapangan_id'
    AND status != 'rejected'
");

$list = [];
$bentrok = false;

while ($row = mysqli_fetch_assoc($data)) {
    $db_start = strtotime("$tanggal ".$row['jam_mulai']);
    $db_end   = strtotime("$tanggal ".$row['jam_selesai']);

    $list[] = $row['jam_mulai'] . " - " . $row['jam_selesai'];

    if ($start < $db_end && $end > $db_start) {
        $bentrok = true;
    }
}

echo json_encode([
    "jadwal" => $list,
    "bentrok" => $bentrok
]);