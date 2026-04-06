<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM booking WHERE id='$id'");

header("Location: index.php?menu=manajemen_jadwal");