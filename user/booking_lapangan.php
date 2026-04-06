<?php
include 'koneksi.php';

// ambil data lapangan
$data = mysqli_query($conn, "SELECT * FROM lapangan");
?>

<style>
    /* CARD */
    .card-lapangan {
        background: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        cursor: pointer;
    }

    .card-lapangan:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* IMAGE */
    .img-box {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
    }

    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* FALLBACK */
    .no-img {
        width: 100%;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #22c55e;
        color: white;
        font-weight: bold;
    }

    /* TITLE */
    h5 {
        color: #0f172a;
    }

    /* TEXT */
    p {
        color: #475569;
        font-size: 14px;
    }
</style>

<div class="container mt-4 mb-5">

    <h3 class="mb-2 fw-bold">Pilih Lapangan</h3>
    <p class="mb-4">Pastikan sudah lihat jadwal sebelum booking</p>

    <div class="row">

        <?php while ($row = mysqli_fetch_assoc($data)): ?>

            <div class="col-md-6 mb-4">
                <a href="?menu=form_booking&lapangan_id=<?= $row['id']; ?>" style="text-decoration:none;">

                    <div class="card-lapangan">

                        <div class="row g-0">

                            <!-- GAMBAR -->
                            <div class="col-md-4">
                                <div class="img-box">
                                    <?php if ($row['gambar']): ?>
                                        <img src="../img/lapangan/<?= $row['gambar']; ?>" class="img-fluid">
                                    <?php else: ?>
                                        <div class="no-img">No Image</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- DETAIL -->
                            <div class="col-md-8">
                                <div class="p-3">

                                    <h5 class="fw-bold"><?= $row['nama_lapangan']; ?></h5>

                                    <p class="mb-2">
                                        <strong>Fasilitas:</strong><br>
                                        <?= $row['deskripsi']; ?>
                                    </p>

                                    <p class="mb-3">
                                        <strong>Harga:</strong><br>
                                        Rp <?= number_format($row['harga_per_jam']); ?> / jam
                                    </p>

                                    <small class="text-muted">
                                        <i>Klik dimana saja untuk booking →</i>
                                    </small>

                                </div>
                            </div>

                        </div>

                    </div>

                </a>
            </div>

        <?php endwhile; ?>

    </div>

</div>