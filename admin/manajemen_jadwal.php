<?php
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

$data = mysqli_query($conn, "
    SELECT booking.*, lapangan.nama_lapangan 
    FROM booking
    JOIN lapangan ON booking.lapangan_id = lapangan.id
    WHERE booking.user_id = $user_id
    ORDER BY booking.tanggal DESC
");
?>

<div class="content fade-in">

    <div class="topbar mb-4">
        <h5>📅 Manajemen Jadwal</h5>
        <a href="?menu=tambah_jadwal" class="btn btn-success">+ Tambah Jadwal</a>
    </div>

    <div class="table-wrapper">

        <table id="tableAdmin" class="table align-middle">
            <thead>
                <tr>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $row['nama_lapangan']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['jam_mulai']; ?> - <?= $row['jam_selesai']; ?></td>
                        <td>
                            <a href="?menu=edit_jadwal&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_jadwal.php?id=<?= $row['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus jadwal ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>

</div>