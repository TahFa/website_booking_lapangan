<?php
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
} else {
    $menu = "";
}
if ($menu == "lihat_jadwal") {
    include "lihat_jadwal.php";
} else if ($menu == "booking_lapangan") {
    include "booking_lapangan.php";
} else if ($menu == "form_booking") {
    include "form_booking.php";
} else if ($menu == "proses_booking
") {
    include "proses_booking
    .php";
} else {
    include "home.php";
}
