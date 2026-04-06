<?php
include 'koneksi.php';

// ambil data lapangan
$lap = mysqli_query($conn, "SELECT * FROM lapangan");
?>

<div class="content fade-in">

    <div class="topbar mb-4">
        <h5>Tambah Jadwal</h5>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= $_GET['error']; ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= $_GET['success']; ?></div>
    <?php endif; ?>

    <div class="table-wrapper">

        <form method="POST" action="simpan_jadwal.php">

            <div class="mb-3">
                <label>Lapangan</label>
                <select name="lapangan_id" id="lapangan" class="form-control" required>
                    <option value="">Pilih Lapangan</option>
                    <?php while ($l = mysqli_fetch_assoc($lap)): ?>
                        <option value="<?= $l['id']; ?>" data-harga="<?= $l['harga_per_jam']; ?>">
                            <?= $l['nama_lapangan']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Durasi (jam)</label>
                <input type="number" name="durasi" id="durasi" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label>Total Harga</label>
                <input type="text" id="total_view" class="form-control" readonly>
                <input type="hidden" name="total_harga" id="total">
            </div>

            <button name="simpan" class="btn btn-success">Simpan</button>
            <a href="?menu=manajemen_jadwal" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</div>

<script>
const lapangan = document.getElementById('lapangan');
const durasi = document.getElementById('durasi');
const total = document.getElementById('total');
const total_view = document.getElementById('total_view');

function hitungTotal() {
    let selected = lapangan.options[lapangan.selectedIndex];
    let harga = selected.getAttribute('data-harga');
    let d = durasi.value;

    if (harga && d) {
        let hasil = harga * d;
        total.value = hasil;
        total_view.value = "Rp " + hasil.toLocaleString();
    }
}

lapangan.addEventListener('change', hitungTotal);
durasi.addEventListener('input', hitungTotal);
</script>