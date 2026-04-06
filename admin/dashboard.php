<?php
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            padding: 20px;
        }

        .sidebar h4 {
            color: #fff;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            padding: 20px;
        }

        /* TOPBAR */
        .topbar {
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* CARD (LEBIH SOFT) */
        .card-sport {
            border-radius: 18px;
            padding: 20px;
            color: white;
            background: linear-gradient(135deg, #ff3b3b, #ff7a00);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-sport:hover {
            transform: translateY(-5px);
        }

        /* TABLE */
        .table-wrapper {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px;
            padding: 3px 8px;
        }

        /* HEADER TABLE (ABU-ABU LEBIH GELAP) */
        .table thead {
            background: #d1d5db;
        }

        .table thead th {
            background: #d1d5db;
        }

        .table th {
            color: #374151;
            padding: 14px;
            border: none;
        }

        /* BODY */
        .table td {
            padding: 14px;
            border: none;
        }

        /* ZEBRA */
        .table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        /* HOVER */
        .table tbody tr:hover {
            background: #e5e7eb;
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

        .badge-cancelled {
            background: #6b7280;
        }

        /* ANIMASI */
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4> Sport Admin</h4>

        <a href="index.php">Dashboard</a>
        <a href="?menu=booking">Booking</a>
        <a href="?menu=lapangan">Lapangan</a>
        <a href="?menu=manajemen_jadwal">Manajemen Jadwal</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <?php include "menu.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableAdmin').DataTable({
                pageLength: 5,
                order: [[4, 'desc']], // sort berdasarkan tanggal
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "Next",
                        previous: "Prev"
                    }
                }
            });
        });
    </script>
</body>

</html>