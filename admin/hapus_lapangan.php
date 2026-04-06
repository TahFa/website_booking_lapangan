<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM lapangan WHERE id='$id'"));

unlink("../img/lapangan/".$data['gambar']);

mysqli_query($conn, "DELETE FROM lapangan WHERE id='$id'");

header("Location: index.php?menu=lapangan");