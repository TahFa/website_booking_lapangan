<?php
include 'koneksi.php';

$id = $_GET['id'];

// update status jadi approved
mysqli_query($conn, "
    UPDATE booking 
    SET status = 'approved' 
    WHERE id = '$id'
");

header("Location: index.php?menu=booking");
exit;