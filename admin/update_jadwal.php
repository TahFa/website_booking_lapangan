<?php
session_start();
include 'koneksi.php';

if (isset($_POST['update'])) {

    $id           = $_POST['id'];
    $tanggal      = $_POST['tanggal'];
    $jam_mulai    = $_POST['jam_mulai'];
    $durasi_input = (int)$_POST['durasi'];
    $total_harga  = $_POST['total_harga'];

    $start = strtotime("$tanggal $jam_mulai");
    $end   = strtotime("+$durasi_input hour", $start);

    $jam_selesai = date("H:i:s", $end);

    $buka  = strtotime("$tanggal 08:00:00");
    $tutup = strtotime("$tanggal 23:00:00");

    // VALIDASI JAM
    if ($start < $buka || $start >= $tutup) {
        header("Location: index.php?menu=edit_jadwal&id=$id&error=Jam mulai harus antara 08:00 - 22:59");
        exit;
    }

    if ($end > $tutup) {
        header("Location: index.php?menu=edit_jadwal&id=$id&error=Jam selesai melebihi 23:00");
        exit;
    }

    // ambil data lama
    $d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM booking WHERE id='$id'"));

    // VALIDASI BENTROK
    $cek = mysqli_query($conn, "
        SELECT * FROM booking
        WHERE lapangan_id = '{$d['lapangan_id']}'
        AND tanggal = '$tanggal'
        AND status = 'approved'
        AND id != '$id'
        AND (
            ('$jam_mulai' < jam_selesai) AND
            ('$jam_selesai' > jam_mulai)
        )
    ");

    if (mysqli_num_rows($cek) > 0) {
        header("Location: index.php?menu=edit_jadwal&id=$id&error=Jadwal bentrok!");
        exit;
    }

    // UPDATE
    mysqli_query($conn, "
        UPDATE booking SET
        tanggal='$tanggal',
        jam_mulai='$jam_mulai',
        jam_selesai='$jam_selesai',
        total_harga='$total_harga'
        WHERE id='$id'
    ");

    header("Location: index.php?menu=manajemen_jadwal&success=Berhasil update");
    exit;
}