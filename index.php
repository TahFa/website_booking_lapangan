<?php
include 'koneksi.php';

// ambil data lapangan
$lapangan = mysqli_query($conn, "SELECT * FROM lapangan");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sport Booking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* HERO */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)),
                url('img/lapangan/hero-lapangan-futsal.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
        }

        .btn-sport {
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            border: none;
            border-radius: 12px;
            color: white;
            padding: 10px 18px;
        }

        .section {
            padding: 80px 0;
        }

        .card-custom {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* GAMBAR FIX */
        .card-custom img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* ISI CARD */
        .card-body-custom {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        /* DESKRIPSI BIAR GA PANJANG BANGET */
        .card-desc {
            min-height: 50px;
        }

        /* BUTTON DI BAWAH */
        .card-footer-custom {
            margin-top: auto;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 40px 0;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold">🏟️ Sport Booking</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                ☰
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lapangan">Lapangan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                </ul>

                <a href="user/login.php" class="btn btn-outline-dark me-2">Login</a>
                <a href="user/register.php" class="btn btn-sport">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="home">
        <div class="container">
            <h1 class="fw-bold">Booking Lapangan Lebih Mudah</h1>
            <p>Tanpa ribet, cepat, dan bisa kapan saja</p>
            <a href="user/login.php" class="btn btn-sport mt-3">Booking Sekarang</a>
        </div>
    </section>

    <!-- LAPANGAN -->
    <section class="section" id="lapangan">
        <div class="container text-center">

            <h3 class="fw-bold mb-5">Lapangan Kami</h3>

            <div class="row d-flex justify-content-around">

                <?php while ($l = mysqli_fetch_assoc($lapangan)): ?>

                    <div class="col-md-4 mb-4 d-flex">
                        <div class="card-custom w-100">

                            <!-- GAMBAR -->
                            <img src="<?= $l['gambar'] ? 'img/lapangan/' . $l['gambar'] : 'https://via.placeholder.com/400x250'; ?>">

                            <!-- BODY -->
                            <div class="card-body-custom">

                                <h5 class="fw-bold"><?= $l['nama_lapangan']; ?></h5>

                                <p class="text-muted card-desc">
                                    <?= $l['deskripsi']; ?>
                                </p>

                                <h6 class="text-success fw-bold">
                                    Rp <?= number_format($l['harga_per_jam']); ?> / jam
                                </h6>

                                <div class="card-footer-custom">
                                    <a href="user/login.php" class="btn btn-sport w-100">
                                        Booking
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>

                <?php endwhile; ?>

            </div>

        </div>
    </section>

    <!-- FASILITAS -->
    <section class="section bg-light" id="fasilitas">
        <div class="container text-center">

            <h3 class="fw-bold mb-5">Fasilitas</h3>

            <div class="row">

                <div class="col-md-3">
                    <h5>📶 Wifi</h5>
                    <p>Internet cepat</p>
                </div>

                <div class="col-md-3">
                    <h5>🍜 Kantin</h5>
                    <p>Makanan & minuman</p>
                </div>

                <div class="col-md-3">
                    <h5>🚿 Kamar Mandi</h5>
                    <p>Bersih & nyaman</p>
                </div>

                <div class="col-md-3">
                    <h5>🅿️ Parkir</h5>
                    <p>Luas & aman</p>
                </div>

            </div>

        </div>
    </section>

    <!-- ABOUT -->
    <section class="section" id="about">
        <div class="container text-center">

            <h3 class="fw-bold mb-4">Tentang Kami</h3>

            <p class="text-muted">
                Sport Booking adalah platform yang memudahkan pengguna dalam melakukan pemesanan lapangan olahraga secara online.
                Kami menyediakan berbagai fasilitas terbaik dengan sistem booking yang cepat dan transparan.
            </p>

        </div>
    </section>

    <!-- CTA -->
    <section class="section bg-light text-center">
        <div class="container">
            <h3 class="fw-bold">Siap Booking?</h3>
            <a href="user/login.php" class="btn btn-sport mt-3">Login Sekarang</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <h5>🏟️ Sport Booking</h5>
            <p>Jl. Raya Olahraga No.123</p>
            <p>📞 0812-3456-7890</p>
            <p>Instagram | Facebook | WhatsApp</p>
            <p class="mt-3">© 2026</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>