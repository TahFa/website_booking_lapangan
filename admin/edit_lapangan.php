<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lapangan WHERE id='$id'"));
?>

<div class="content fade-in">

    <div class="topbar mb-4">
        <h5>✏️ Edit Lapangan</h5>
    </div>

    <div class="table-wrapper">
        <form method="POST" action="update_lapangan.php" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= $data['nama_lapangan'] ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Harga per Jam</label>
                <input type="number" name="harga" value="<?= $data['harga_per_jam'] ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control"><?= $data['deskripsi'] ?></textarea>
            </div>

            <div class="mb-3">
                <label>Gambar (kosongkan jika tidak diganti)</label><br>
                <img src="../img/lapangan/<?= $data['gambar'] ?>" width="100" class="mb-2"><br>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button type="submit" name="submit" class="btn btn-warning">Update</button>
            <a href="index.php?menu=lapangan" class="btn btn-secondary">Kembali</a>

        </form>
    </div>

</div>