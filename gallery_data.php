<?php
include "koneksi.php";
$hlm = isset($_POST['hlm']) ? $_POST['hlm'] : 1;
$limit = 3;
$start = ($hlm - 1) * $limit;
$no = $start + 1;

$sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $start, $limit";
$hasil = $conn->query($sql);
?>

<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Gambar</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $hasil->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['judul'] ?></td>
            <td><img src="img/<?= $row['gambar'] ?>" width="100"></td>
            <td><?= $row['tanggal'] ?></td>
            <td>
                <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>"><i class="bi bi-pencil"></i></a>
                <a href="#" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>"><i class="bi bi-trash"></i></a>
            </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit<?= $row['id'] ?>" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Gallery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="judul" value="<?= $row['judul'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Ganti Gambar</label>
                                <input type="file" class="form-control" name="gambar">
                            </div>
                            <div class="mb-3">
                                <label>Gambar Saat Ini</label><br>
                                <img src="img/<?= $row['gambar'] ?>" width="100">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <input type="submit" name="simpan_gallery" value="Simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div class="modal fade" id="modalHapus<?= $row['id'] ?>" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Gallery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="gambar" value="<?= $row['gambar'] ?>">
                        <div class="modal-body">
                            Yakin hapus "<?= $row['judul'] ?>"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <input type="submit" name="hapus_gallery" value="Hapus" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$sql_total = "SELECT COUNT(*) as total FROM gallery";
$hasil_total = $conn->query($sql_total);
$total = $hasil_total->fetch_assoc()['total'];
$pages = ceil($total / $limit);
?>

<nav>
    <ul class="pagination justify-content-end">
        <?php for($i=1; $i<=$pages; $i++): ?>
        <li class="page-item halaman <?= ($hlm==$i)?'active':'' ?>" id="<?= $i ?>">
            <a class="page-link" href="#"><?= $i ?></a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>