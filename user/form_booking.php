<?php
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$lapangan_id = $_GET['lapangan_id'];

// ambil data lapangan
$data = mysqli_query($conn, "SELECT * FROM lapangan WHERE id='$lapangan_id'");
$lapangan = mysqli_fetch_assoc($data);
?>

<div class="d-flex justify-content-center py-5">

    <div class="booking-wrapper">

        <h4 class="fw-bold mb-4 text-center">Booking Lapangan</h4>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show auto-hide">
                <?= $_GET['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show auto-hide">
                <?= $_GET['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card-booking p-4">

            <h5 class="fw-bold text-center"><?= $lapangan['nama_lapangan']; ?></h5>
            <p class="text-center text-muted mb-4">
                Rp <?= number_format($lapangan['harga_per_jam']); ?> / jam
            </p>

            <form action="proses_booking.php" method="POST">

                <input type="hidden" name="lapangan_id" value="<?= $lapangan['id']; ?>">

                <!-- TANGGAL -->
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                </div>

                <!-- JAM MULAI (FLEXIBLE) -->
                <div class="mb-3">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required>
                </div>

                <!-- DURASI -->
                <div class="mb-3">
                    <label>Durasi</label>
                    <select name="durasi" id="durasi" class="form-control" required>
                        <option value="">-- Pilih Durasi --</option>
                        <option value="1">1 Jam</option>
                        <option value="2">2 Jam</option>
                        <option value="3">3 Jam</option>
                        <option value="4">4 Jam</option>
                    </select>
                </div>

                <!-- INFO JADWAL -->
                <div class="mb-3">
                    <label>Jadwal Terisi</label>
                    <div id="jadwal-list" class="small text-muted"></div>
                </div>

                <!-- WARNING -->
                <div id="warning-bentrok" class="alert alert-danger d-none">
                    Jadwal bentrok dengan booking lain!
                </div>

                <!-- TOTAL -->
                <div class="mb-3">
                    <label>Total Harga</label>
                    <input type="text" id="total" class="form-control" disabled readonly>
                    <input type="hidden" name="total_harga" id="total_hidden">
                </div>

                <button class="btn btn-success w-100" id="btnBooking">Booking Sekarang</button>

            </form>

        </div>

    </div>

</div>

<style>
    .card-booking {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.4s ease-in-out;
    }

    .booking-wrapper {
        width: 100%;
        max-width: 420px;
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

<script>
    const harga = <?= $lapangan['harga_per_jam']; ?>;

    // HITUNG TOTAL
    document.getElementById('durasi').addEventListener('change', function() {
        let durasi = this.value;
        let total = harga * durasi;

        document.getElementById('total').value = "Rp " + total.toLocaleString();
        document.getElementById('total_hidden').value = total;

        cekJadwal();
    });

    // AUTO HIDE ALERT
    setTimeout(() => {
        let alerts = document.querySelectorAll('.auto-hide');
        alerts.forEach(alert => {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // CEK JADWAL REALTIME 🔥
    function cekJadwal() {
        let tanggal = document.querySelector("[name='tanggal']").value;
        let jam = document.querySelector("[name='jam_mulai']").value;
        let durasi = document.getElementById("durasi").value;
        let lapangan = <?= $lapangan['id']; ?>;

        if (!tanggal || !jam || !durasi) return;

        fetch(`cek_jadwal.php?tanggal=${tanggal}&lapangan_id=${lapangan}&jam_mulai=${jam}&durasi=${durasi}`)
            .then(res => res.json())
            .then(data => {

                let list = document.getElementById("jadwal-list");
                list.innerHTML = "";

                if (data.jadwal.length === 0) {
                    list.innerHTML = "<span class='text-success'>Belum ada booking</span>";
                } else {
                    data.jadwal.forEach(j => {
                        list.innerHTML += `<div>• ${j}</div>`;
                    });
                }

                let warning = document.getElementById("warning-bentrok");
                let btn = document.getElementById("btnBooking");

                if (data.bentrok) {
                    warning.classList.remove("d-none");
                    btn.disabled = true;
                } else {
                    warning.classList.add("d-none");
                    btn.disabled = false;
                }
            });
    }

    // TRIGGER
    document.querySelector("[name='tanggal']").addEventListener("change", cekJadwal);
    document.querySelector("[name='jam_mulai']").addEventListener("input", cekJadwal);
</script>