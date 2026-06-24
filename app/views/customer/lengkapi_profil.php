<?php $css_halaman = 'profile'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container">
    <div class="profile-wrapper">
        <div class="profile-header">
            <h2><i class="fas fa-id-card"></i> Lengkapi Profil Anda</h2>
            <p>Sistem membutuhkan kelengkapan identitas Anda sebelum dapat melakukan pemesanan armada.</p>
        </div>

        <div class="profile-body">
            <form action="<?= BASEURL; ?>/profile/uploadDokumen" method="POST" enctype="multipart/form-data">

                <h3 class="section-title"><i class="fas fa-user-edit"></i> Data Kontak & Alamat</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group mb-0">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['user']['nama_lengkap']); ?>" readonly style="background-color: #f3f4f6; cursor: not-allowed;">
                    </div>

                    <div class="form-group mb-0">
                        <label for="nomor_hp">Nomor HP / WhatsApp <span style="color: var(--red-600);">*</span></label>
                        <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" placeholder="Contoh: 081234567890" value="<?= htmlspecialchars($data['user']['nomor_hp'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap Domisili <span style="color: var(--red-600);">*</span></label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap sesuai tempat tinggal saat ini" required><?= htmlspecialchars($data['user']['alamat'] ?? ''); ?></textarea>
                </div>

                <h3 class="section-title" style="margin-top: 40px;"><i class="fas fa-file-upload"></i> Unggah Dokumen Identitas</h3>
                <p style="color: var(--ink-soft); margin-bottom: 20px; font-size: 0.95rem;">Format file yang diizinkan: JPG/PNG. Ukuran maksimal 2MB per file.</p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    
                    <div class="form-group">
                        <label>Foto KTP <span style="color: var(--red-600);">*</span></label>
                        <div class="file-upload-wrapper">
                            <i class="fas fa-address-card fa-3x" style="color: #9ca3af;"></i>
                            <input type="file" name="foto_ktp" accept="image/jpeg, image/png" <?= empty($data['user']['foto_ktp']) ? 'required' : ''; ?>>
                        </div>
                        <?php if (!empty($data['user']['foto_ktp'])): ?>
                            <small style="color: #10b981; font-weight: bold;"><i class="fas fa-check-circle"></i> KTP sudah terunggah</small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Foto SIM A <span style="color: var(--red-600);">*</span></label>
                        <div class="file-upload-wrapper">
                            <i class="fas fa-car fa-3x" style="color: #9ca3af;"></i>
                            <input type="file" name="foto_sim" accept="image/jpeg, image/png" <?= empty($data['user']['foto_sim']) ? 'required' : ''; ?>>
                        </div>
                        <?php if (!empty($data['user']['foto_sim'])): ?>
                            <small style="color: #10b981; font-weight: bold;"><i class="fas fa-check-circle"></i> SIM sudah terunggah</small>
                        <?php endif; ?>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 30px;">
                    <i class="fas fa-save" style="margin-right: 8px;"></i> Simpan & Perbarui Profil
                </button>
            </form>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
