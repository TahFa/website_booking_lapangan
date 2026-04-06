<?php
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// 🔢 jumlah lapangan terpakai (approved)
$today = date('Y-m-d');
$lapangan = mysqli_query($conn, "
    SELECT COUNT(DISTINCT lapangan_id) as total 
    FROM booking 
    WHERE tanggal='$today' AND status='approved'
");
$jml_lapangan = mysqli_fetch_assoc($lapangan)['total'];

// 📅 booking hari ini
$today = date('Y-m-d');
$booking_today = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM booking 
    WHERE tanggal='$today' AND status != 'rejected'
");
$jml_booking = mysqli_fetch_assoc($booking_today)['total'];

// 📋 riwayat booking
$riwayat = mysqli_query($conn, "
    SELECT booking.*, lapangan.nama_lapangan 
    FROM booking
    JOIN lapangan ON booking.lapangan_id = lapangan.id
    WHERE booking.user_id='$user_id' AND status!='cancelled'
    ORDER BY booking.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <style>
        body {
            background: #f1f5f9;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(90deg, #f97316, #ea580c);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        /* LINK */
        .navbar a {
            color: white !important;
            margin-right: 18px;
            font-weight: 500;
            position: relative;
            transition: 0.3s;
            text-decoration: none;
        }

        /* HOVER GLOW */
        .navbar a:hover {
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.9);
        }

        /* UNDERLINE ANIMASI */
        .navbar a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0%;
            height: 2px;
            background: white;
            transition: 0.3s;
        }

        .navbar a:hover::after {
            width: 100%;
        }

        /* CARD */
        .card-dashboard {
            border-radius: 18px;
            padding: 20px;
            color: white;
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
        }

        .btn-detail {
            background: #2563eb;
            color: white;
        }

        /* TABLE */
        .table-wrapper {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 18px;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px;
            padding: 4px 8px;
        }

        /* BADGE */
        .badge-approved {
            background: #22c55e;
        }

        .badge-pending {
            background: #facc15;
            color: #000;
        }

        .badge-rejected {
            background: #ef4444;
        }

        .footer-sport {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #cbd5e1;
        }

        .footer-sport h6 {
            color: #ffffff;
        }

        .footer-sport p {
            font-size: 14px;
        }

        .social-link {
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.3s;
        }

        .social-link:hover {
            color: #22c55e;
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white">User Page</a>

            <div class="ms-auto">
                <a href="index.php">Dashboard</a>
                <a href="?menu=lihat_jadwal">Lihat jadwal</a>
                <a href="?menu=booking_lapangan">Booking</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <?php include 'menu.php'; ?>

    <footer class="footer-sport mt-5">

        <div class="container py-4">
            <div class="row">

                <!-- ALAMAT -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">📍 Lokasi</h6>
                    <p class="mb-0">
                        Jl. Raya Olahraga No. 10<br>
                        Cirebon, Jawa Barat
                    </p>
                </div>

                <!-- KONTAK -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">📞 Kontak</h6>
                    <p class="mb-1">WhatsApp: 0812-3456-7890</p>
                    <p class="mb-0">Email: booking@sport.com</p>
                </div>

                <!-- SOSIAL MEDIA -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">📱 Sosial Media</h6>

                    <a href="#" class="social-link">Instagram</a><br>
                    <a href="#" class="social-link">Facebook</a><br>
                    <a href="#" class="social-link">TikTok</a>
                </div>

            </div>

            <hr>

            <div class="text-center small">
                © <?= date('Y'); ?> Sport Booking System — All Rights Reserved
            </div>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableRiwayat').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "order": [
                    [3, 'desc']
                ],
                "searching": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data",
                    "paginate": {
                        "next": "Next",
                        "previous": "Prev"
                    }
                }
            });
        });
    </script>
</body>

</html>