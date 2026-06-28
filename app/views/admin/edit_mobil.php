<?php $css_halaman = 'admin'; include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
            <h3 class="card-title m-0"><i class="fas fa-edit text-primary"></i> Edit Data Mobil</h3>
        </div>
        
        <div class="card-body p-4">
            <form action="/edit_mobil/<?= $data['mobil']['id_mobil']; ?>" method="POST" enctype="multipart/form-data" novalidate>
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Merk Mobil</label>
                        <input type="text" name="merk" class="form-control" value="<?= htmlspecialchars($data['mobil']['merk']); ?>" required>
                        <?php if (isset($data['errors']['merk'])): ?>
                            <small class="form-error-message"><i class="fas fa-exclamation-circle"></i> <?= $data['errors']['merk']; ?></small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label>Tipe / Model</label>
                        <input type="text" name="tipe" class="form-control" value="<?= htmlspecialchars($data['mobil']['tipe']); ?>" required>
                        <?php if (isset($data['errors']['tipe'])): ?>
                            <small class="form-error-message"><i class="fas fa-exclamation-circle"></i> <?= $data['errors']['tipe']; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <label>Transmisi</label>
                        <select name="transmisi" class="form-control" required>
                            <option value="AT" <?= ($data['mobil']['transmisi'] == 'AT') ? 'selected' : ''; ?>>Automatic (AT)</option>
                            <option value="MT" <?= ($data['mobil']['transmisi'] == 'MT') ? 'selected' : ''; ?>>Manual (MT)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label>Kapasitas Penumpang</label>
                        <input type="number" name="kapasitas" class="form-control" value="<?= htmlspecialchars($data['mobil']['kapasitas']); ?>" min="1" required>
                        <?php if (isset($data['errors']['kapasitas'])): ?>
                            <small class="form-error-message"><i class="fas fa-exclamation-circle"></i> <?= $data['errors']['kapasitas']; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <label>Harga Sewa per Hari (Rp)</label>
                        <input type="number" name="harga_per_hari" class="form-control" value="<?= htmlspecialchars($data['mobil']['harga_per_hari']); ?>" min="1" required>
                        <?php if (isset($data['errors']['harga_per_hari'])): ?>
                            <small class="form-error-message"><i class="fas fa-exclamation-circle"></i> <?= $data['errors']['harga_per_hari']; ?></small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Tersedia" <?= ($data['mobil']['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="Disewa" <?= ($data['mobil']['status'] == 'Disewa') ? 'selected' : ''; ?>>Disewa</option>
                            <option value="Tidak Tersedia" <?= ($data['mobil']['status'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Spesifikasi / Deskripsi Tambahan</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($data['mobil']['deskripsi'] ?? ''); ?></textarea>
                </div>

                <div class="form-group mt-4 p-3 mb-4" style="background-color: #f8f9fa; border-radius: 8px;">
                    <label>Perbarui Foto Mobil (Opsional)</label><br>
                    <?php if (!empty($data['mobil']['foto'])): ?>
                        <div class="mb-2">
                            <img src="/public/uploads/mobil/<?= $data['mobil']['foto']; ?>" alt="Foto Lama" class="img-thumbnail" style="max-height: 100px;">
                            <small class="text-muted d-block mt-1">Foto saat ini</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control-file mt-2">
                    <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah foto. (Maks 2MB, JPG/PNG)</small>
                    <?php if (isset($data['errors']['foto'])): ?>
                        <small class="form-error-message"><i class="fas fa-exclamation-circle"></i> <?= $data['errors']['foto']; ?></small>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end mt-5 pt-4 border-top">
                    <a href="/kelola_mobil" class="btn btn-secondary mr-2" style="margin-right: 10px;">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>