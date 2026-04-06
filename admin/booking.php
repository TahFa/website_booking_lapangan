<?php
include 'koneksi.php';

$query = mysqli_query($conn, "
    SELECT booking.*, users.nama, lapangan.nama_lapangan 
    FROM booking
    JOIN users ON booking.user_id = users.id
    JOIN lapangan ON booking.lapangan_id = lapangan.id
    ORDER BY booking.created_at DESC
");
?>

<div class="content fade-in">

    <!-- TOPBAR -->
    <div class="topbar mb-4">
        <h5>📅 Data Booking</h5>
        <span>📋 Kelola Booking</span>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table id="tableAdmin" class="table align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <?php if ($row['status'] == 'pending'): ?>
                        <tr>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nama_lapangan'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?></td>

                            <td>
                                <?php if ($row['status'] == 'approved'): ?>
                                    <span class="badge badge-approved">Approved</span>
                                <?php elseif ($row['status'] == 'pending'): ?>
                                    <span class="badge badge-pending">Pending</span>
                                <?php else: ?>
                                    <span class="badge badge-rejected">Rejected</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <!-- APPROVE -->
                                <button class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#approveModal<?= $row['id'] ?>">
                                    Approve
                                </button>

                                <!-- REJECT -->
                                <button class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal<?= $row['id'] ?>">
                                    Reject
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL APPROVE -->
                        <div class="modal fade" id="approveModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Approve</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Yakin ingin menyetujui booking ini?
                                    </div>

                                    <div class="modal-footer">
                                        <a href="approve.php?id=<?= $row['id'] ?>" class="btn btn-success">
                                            Ya, Approve
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- MODAL REJECT -->
                        <div class="modal fade" id="rejectModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="reject.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Tolak Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="mb-2">Pilih Alasan:</label>

                                            <select name="alasan" class="form-control" required>
                                                <option value="">-- Pilih Alasan --</option>
                                                <option value="Lapangan sedang maintenance">Lapangan sedang maintenance</option>
                                                <option value="Jadwal sudah di booking">Jadwal sudah di booking</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-danger">Tolak</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>