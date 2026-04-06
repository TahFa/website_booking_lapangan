<?php
include 'koneksi.php';

// 📅 tanggal hari ini
$today = date('Y-m-d');

$q1 = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM booking 
    WHERE created_at >= '$today 00:00:00'
    AND created_at <= '$today 23:59:59'
");
$total_booking = mysqli_fetch_assoc($q1)['total'];

// 👤 total user
$q2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_user = mysqli_fetch_assoc($q2)['total'];

// 🏟️ total lapangan
$q3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM lapangan");
$total_lapangan = mysqli_fetch_assoc($q3)['total'];

// 📋 laporan booking (hanya approved rejected, dan cancelled)
$laporan = mysqli_query($conn, "
    SELECT booking.*, users.username, lapangan.nama_lapangan
    FROM booking
    JOIN users ON booking.user_id = users.id
    JOIN lapangan ON booking.lapangan_id = lapangan.id
    WHERE booking.status IN ('approved','rejected', 'cancelled')
    ORDER BY booking.created_at DESC
");
?>
<!-- CONTENT -->
<div class="content fade-in">

    <!-- TOPBAR -->
    <div class="topbar mb-4">
        <h5>Dashboard</h5>
        <span>👋 Welcome Admin</span>
    </div>

    <!-- CARDS -->
    <div class="row mb-4 g-3">

        <div class="col-md-4">
            <div class="card-sport">
                <h6>Total Booking hari ini</h6>
                <h2><?= $total_booking; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-sport">
                <h6>Total User</h6>
                <h2><?= $total_user; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-sport">
                <h6>Total Lapangan</h6>
                <h2><?= $total_lapangan; ?></h2>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-wrapper p-3 mb-5 rounded shadow-sm bg-white">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">📅 Laporan Booking</h5>
        </div>

        <div class="table-responsive">
            <table id="tableAdmin" class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Lapangan</th>
                        <th>Jam</th>
                        <th>Tanggal Main</th>
                        <th>Tanggal Dibuat</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (mysqli_num_rows($laporan) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($laporan)): ?>
                            <tr>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['nama_lapangan']; ?></td>
                                <td><?= date('H:i', strtotime($row['jam_mulai'])) ?> - <?= date('H:i', strtotime($row['jam_selesai'])) ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                <td data-order="<?= $row['created_at']; ?>">
                                    <?= date('d M Y H:i', strtotime($row['created_at'])); ?>
                                </td>
                                <td><?= $row['total_harga']; ?></td>

                                <td>
                                    <?php if ($row['status'] == 'approved'): ?>
                                        <span class="badge bg-primary">Approved</span>

                                    <?php elseif ($row['status'] == 'cancelled'): ?>
                                        <span class="badge bg-secondary">Cancelled</span>
                                        <div class="small text-muted">
                                            <?= htmlspecialchars($row['keterangan']); ?>
                                        </div>

                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data booking
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>

</div>