<?php
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
} else {
    $menu = "";
}
if ($menu == "booking") {
    include "booking.php";
} else if ($menu == "lapangan") {
    include "lapangan.php";
} else if ($menu == "tambah_lapangan") {
    include "tambah_lapangan.php";
} else if ($menu == "edit_lapangan") {
    include "edit_lapangan.php";
} else if ($menu == "manajemen_jadwal") {
    include "manajemen_jadwal.php";
} else if ($menu == "tambah_jadwal") {
    include "tambah_jadwal.php";
} else if ($menu == "edit_jadwal") {
    include "edit_jadwal.php";
} else {
    include "home.php";
}
