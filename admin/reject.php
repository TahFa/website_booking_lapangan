<?php
include 'koneksi.php';

$id = $_POST['id'];
$alasan = $_POST['alasan'];

mysqli_query($conn, "
    UPDATE booking 
    SET status='rejected', keterangan='$alasan'
    WHERE id='$id'
");

header("Location: index.php?menu=booking");