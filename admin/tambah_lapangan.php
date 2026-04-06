<?php include 'koneksi.php'; ?>

<div class="content fade-in">

    <div class="topbar mb-4">
        <h5>➕ Tambah Lapangan</h5>
    </div>

    <div class="table-wrapper">
        <form method="POST" action="simpan_lapangan.php" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Harga per Jam</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>

            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            <a href="index.php?menu=lapangan" class="btn btn-secondary">Kembali</a>

        </form>
    </div>

</div>