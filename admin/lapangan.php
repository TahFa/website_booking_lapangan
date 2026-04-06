<?php
include 'koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM lapangan ORDER BY id DESC");
?>

<div class="content fade-in">

    <div class="topbar mb-4">
        <h5>🏟️ Data Lapangan</h5>
        <a href="index.php?menu=tambah_lapangan" class="btn btn-success">+ Tambah</a>
    </div>

    <div class="table-wrapper">
        <table id="tableAdmin" class="table align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $row['nama_lapangan'] ?></td>
                        <td>Rp <?= number_format($row['harga_per_jam']) ?></td>
                        <td><?= $row['deskripsi'] ?></td>
                        <td>
                            <img src="../img/lapangan/<?= $row['gambar'] ?>" width="80">
                        </td>
                        <td>
                            <a href="?menu=edit_lapangan&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_lapangan.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus lapangan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    </div>

</div>