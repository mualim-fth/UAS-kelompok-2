<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group shadow-sm">
                <a href="<?= BASEURL; ?>/admin/dashboard" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="<?= BASEURL; ?>/admin/kelola_mobil" class="list-group-item list-group-item-action active">Kelola Mobil</a>
                <a href="<?= BASEURL; ?>/admin/kelola_pesanan" class="list-group-item list-group-item-action">Kelola Pesanan</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kelola Data Mobil</h1>
                <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambahMobil">
                    <i class="fas fa-plus"></i> Tambah Mobil Baru
                </button>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Merk / Tipe</th>
                                    <th>Transmisi</th>
                                    <th>Kapasitas</th>
                                    <th>Harga / Hari</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </table>
                            <tbody>
                                <?php if (!empty($data['mobil'])): ?>
                                    <?php $no = 1; foreach ($data['mobil'] as $mobil): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php if (!empty($mobil['foto'])): ?>
                                                    <img src="<?= BASEURL; ?>/uploads/mobil/<?= $mobil['foto']; ?>" alt="Mobil" class="img-thumbnail" style="width: 80px;">
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Tidak Ada Foto</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?= htmlspecialchars($mobil['merk']); ?></strong><br><small class="text-muted"><?= htmlspecialchars($mobil['tipe']); ?></small></td>
                                            <td><?= htmlspecialchars($mobil['transmisi']); ?></td>
                                            <td><?= htmlspecialchars($mobil['kapasitas']); ?> Kursi</td>
                                            <td>Rp <?= number_format($mobil['harga_per_hari'], 0, ',', '.'); ?></td>
                                            <td>
                                                <span class="badge badge-<?= ($mobil['status'] == 'Tersedia') ? 'success' : 'danger'; ?>">
                                                    <?= htmlspecialchars($mobil['status']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= BASEURL; ?>/admin/edit_mobil/<?= $mobil['id_mobil']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="<?= BASEURL; ?>/admin/hapus_mobil/<?= $mobil['id_mobil']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?');">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted p-4">Belum ada data armada mobil di database Supabase.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahMobil" tabindex="-1" role="dialog" aria-labelledby="modalTambahMobilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= BASEURL; ?>/admin/tambah_mobil" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahMobilLabel">Form Tambah Armada Mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Merk Mobil</label>
                            <input type="text" name="merk" class="form-control" placeholder="Contoh: Toyota" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tipe / Model</label>
                            <input type="text" name="tipe" class="form-control" placeholder="Contoh: Avanza" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Transmisi</label>
                            <select name="transmisi" class="form-control" required>
                                <option value="AT">Automatic (AT)</option>
                                <option value="MT">Manual (MT)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kapasitas Penumpang</label>
                            <input type="number" name="kapasitas" class="form-control" placeholder="Contoh: 7" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Harga Sewa per Hari (Rp)</label>
                            <input type="number" name="harga_per_hari" class="form-control" placeholder="350000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Disewa">Disewa</option>
                                <option value="Perawatan">Perawatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Foto Mobil</label>
                        <input type="file" name="foto" class="form-control-file">
                        <small class="text-muted">Maksimal file 2MB dengan ekstensi .jpg, .jpeg, .png</small>
                    </div>
                    <div class="mb-3">
                        <label>Spesifikasi / Deskripsi Tambahan</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tulis rincian mesin atau syarat lepas kunci disini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>