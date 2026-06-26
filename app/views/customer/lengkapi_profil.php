<?php $css_halaman = 'profile'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container profile-section">
    <div class="profile-wrapper">
        <div class="profile-header">
            <h2><i class="fas fa-id-card"></i> Lengkapi Profil Anda</h2>
            <p>Sistem membutuhkan kelengkapan identitas Anda sebelum dapat memproses reservasi armada.</p>
        </div>

        <div class="profile-body">
            <form action="/upload_dokumen" method="POST" enctype="multipart/form-data">

                <h3 class="profile-section-title"><i class="fas fa-user-edit"></i> Data Kontak & Alamat</h3>

                <div class="profile-form-row">
                    <div class="form-group mb-0">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" class="form-control input-readonly" value="<?= htmlspecialchars($data['user']['nama_lengkap']); ?>" readonly>
                    </div>

                    <div class="form-group mb-0">
                        <label for="nomor_hp">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" placeholder="Contoh: 081234567890" value="<?= htmlspecialchars($data['user']['nomor_hp'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="alamat">Alamat Lengkap Domisili <span class="text-danger">*</span></label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap sesuai tempat tinggal saat ini" required><?= htmlspecialchars($data['user']['alamat'] ?? ''); ?></textarea>
                </div>

                <h3 class="profile-section-title mt-5"><i class="fas fa-file-upload"></i> Unggah Dokumen Identitas</h3>
                <p class="profile-hint">Format file yang diizinkan: <strong>JPG/PNG</strong>. Ukuran maksimal <strong>2MB</strong> per file.</p>

                <div class="upload-group">
                    <label>Foto KTP <span class="text-danger">*</span></label>
                    <div class="file-upload-wrapper <?= !empty($data['user']['foto_ktp']) ? 'uploaded-success' : ''; ?>">
                        <i class="fas fa-address-card upload-icon"></i>
                        <span class="upload-instruction">Pilih file KTP Anda</span>
                        <input type="file" name="foto_ktp" accept="image/jpeg, image/png" <?= empty($data['user']['foto_ktp']) ? 'required' : ''; ?>>
                    </div>
                    
                    <?php if (!empty($data['user']['foto_ktp'])): ?>
                        <div class="upload-status"><i class="fas fa-check-circle"></i> KTP sudah terunggah</div>
                        <div class="image-preview-box">
                            <img src="/public/uploads/ktp_sim/<?= htmlspecialchars($data['user']['foto_ktp']); ?>" alt="Preview KTP" class="img-preview">
                        </div>
                        <small style="color: var(--slate-400); display: block; margin-top: 8px;">* Unggah file baru jika ingin mengganti foto KTP.</small>
                    <?php endif; ?>
                </div>

                <div class="upload-group">
                    <label>Foto SIM A <span class="text-danger">*</span></label>
                    <div class="file-upload-wrapper <?= !empty($data['user']['foto_sim']) ? 'uploaded-success' : ''; ?>">
                        <i class="fas fa-car upload-icon"></i>
                        <span class="upload-instruction">Pilih file SIM Anda</span>
                        <input type="file" name="foto_sim" accept="image/jpeg, image/png" <?= empty($data['user']['foto_sim']) ? 'required' : ''; ?>>
                    </div>
                    
                    <?php if (!empty($data['user']['foto_sim'])): ?>
                        <div class="upload-status"><i class="fas fa-check-circle"></i> SIM sudah terunggah</div>
                        <div class="image-preview-box">
                            <img src="/public/uploads/ktp_sim/<?= htmlspecialchars($data['user']['foto_sim']); ?>" alt="Preview SIM" class="img-preview">
                        </div>
                        <small style="color: var(--slate-400); display: block; margin-top: 8px;">* Unggah file baru jika ingin mengganti foto SIM.</small>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-submit-profile">
                    <i class="fas fa-save"></i> Simpan & Perbarui Profil
                </button>
            </form>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>