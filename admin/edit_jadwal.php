<?php
include 'koneksi.php';

$id = $_GET['id'];

// ambil data
$data = mysqli_query($conn, "SELECT * FROM booking WHERE id='$id'");
$d = mysqli_fetch_assoc($data);

// hitung durasi
$durasi = (strtotime($d['jam_selesai']) - strtotime($d['jam_mulai'])) / 3600;

// ambil harga
$lap = mysqli_query($conn, "SELECT * FROM lapangan WHERE id='{$d['lapangan_id']}'");
$l = mysqli_fetch_assoc($lap);
$harga = $l['harga_per_jam'];
?>

<div class="content fade-in">

    <div class="topbar mb-4">
        <h5>Edit Jadwal</h5>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= $_GET['error']; ?></div>
    <?php endif; ?>

    <div class="table-wrapper">

        <form method="POST" action="update_jadwal.php">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?= $d['tanggal']; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" value="<?= $d['jam_mulai']; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Durasi (jam)</label>
                <input type="number" name="durasi" id="durasi" value="<?= $durasi; ?>" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label>Total Harga</label>
                <input type="text" id="total_view" class="form-control" readonly>
                <input type="hidden" name="total_harga" id="total" value="<?= $d['total_harga']; ?>">
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="?menu=manajemen_jadwal" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</div>

<script>
const durasi = document.getElementById('durasi');
const total = document.getElementById('total');
const total_view = document.getElementById('total_view');

let harga = <?= $harga ?>;

// tampil awal
total_view.value = "Rp " + Number(total.value).toLocaleString();

function hitungTotal() {
    let d = durasi.value;

    if (d) {
        let hasil = harga * d;
        total.value = hasil;
        total_view.value = "Rp " + hasil.toLocaleString();
    }
}

durasi.addEventListener('input', hitungTotal);
</script>