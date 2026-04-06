<div class="container mt-4 mb-5">

    <h4 class="mb-4">Halo, <?= $_SESSION['nama']; ?> 👋</h4>

    <!-- CARD -->
    <div class="row mb-4 justify-content-around">
        <div class="col-md-4">
            <div class="card-dashboard">
                <h6>Lapangan Terpakai Hari ini</h6>
                <h3><?= $jml_lapangan ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dashboard">
                <h6>Total Booking Hari Ini</h6>
                <h3><?= $jml_booking ?></h3>
            </div>
        </div>
    </div>

    <!-- RIWAYAT -->
    <div class="table-wrapper">
        <h5>Riwayat Booking</h5>
        <div class="text-muted mb-3 ms-1">
            ⚠️ Booking yang sudah <b>disetujui (approved)</b> tidak dapat dibatalkan.
        </div>

        <table id="tableRiwayat" class="table align-middle">
            <thead>
                <tr>
                    <th>Lapangan</th>
                    <th>Jam</th>
                    <th>Tanggal Main</th>
                    <th>Tanggal Dibuat</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php if (mysqli_num_rows($riwayat) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($riwayat)): ?>
                        <tr>
                            <td><?= $row['nama_lapangan'] ?></td>
                            <td><?= date('H:i', strtotime($row['jam_mulai'])) ?> - <?= date('H:i', strtotime($row['jam_selesai'])) ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                            <td data-order="<?= $row['created_at']; ?>">
                                <?= date('d M Y H:i', strtotime($row['created_at'])); ?>
                            </td>
                            <td><?= $row['total_harga']; ?></td>

                            <td>
                                <?php if ($row['status'] == 'approved'): ?>
                                    <span class="badge badge-approved">Approved</span>

                                <?php elseif ($row['status'] == 'pending'): ?>
                                    <span class="badge badge-pending">Pending</span>

                                <?php else: ?>
                                    <span class="badge badge-rejected">Rejected</span>
                                    <br><small><?= $row['keterangan'] ?></small>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <button
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalBatal<?= $row['id']; ?>"
                                        style="width: 5rem;">
                                        Batal
                                    </button>

                                <?php elseif ($row['status'] == 'approved'): ?>
                                    <small class="text-muted d-block">
                                        Booking sudah disetujui admin
                                    </small>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- MODAL -->
                        <div class="modal fade" id="modalBatal<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="batal_booking.php" method="POST">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Batalkan Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">

                                            <label class="mb-2">Pilih Alasan:</label>
                                            <select name="alasan" class="form-control" required>
                                                <option value="">-- Pilih Alasan --</option>
                                                <option value="Tidak jadi booking">Tidak jadi booking</option>
                                                <option value="Mau ganti jadwal booking">Mau ganti jadwal booking</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-danger">Konfirmasi Batal</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada booking</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>