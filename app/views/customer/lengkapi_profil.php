<?php $css_halaman = 'profile'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container profile-section">
    <div class="profile-wrapper">
        <div class="profile-header">
            <h2><i class="fas fa-id-card"></i> Lengkapi Profil Anda</h2>
            <p>Sistem membutuhkan kelengkapan identitas Anda sebelum dapat memproses reservasi armada.</p>
        </div>

        <div class="profile-body">
            
            <?php if (!empty($data['flash_error'])): ?>
                <div class="alert-box alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i> Mohon perbaiki data berikut:</strong>
                    <ul style="margin-top: 8px; margin-bottom: 0;">
                        <?php foreach ($data['flash_error'] as $error): ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($data['flash_sukses'])): ?>
                <div class="alert-box alert-success">
                    <strong><i class="fas fa-check-circle"></i> Berhasil!</strong>
                    <ul style="margin-top: 8px; margin-bottom: 0;">
                        <?php foreach ($data['flash_sukses'] as $sukses): ?>
                            <li><?= $sukses; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/upload_dokumen" method="POST" enctype="multipart/form-data">

                <h3 class="profile-section-title"><i class="fas fa-user-edit"></i> Data Kontak & Alamat</h3>

                <div class="profile-form-row">
                    <div class="form-group mb-0">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" class="form-control input-readonly" value="<?= htmlspecialchars($data['user']['nama_lengkap'] ?? ''); ?>" readonly>
                    </div>

                    <div class="form-group mb-0">
                        <label for="nomor_hp">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" placeholder="Contoh: 081234567890" value="<?= htmlspecialchars($data['user']['nomor_hp'] ?? ''); ?>">
                        <small style="color: var(--amber-600); font-size: 0.82rem; margin-top: 6px; display: block;">
                            <i class="fas fa-info-circle"></i> Wajib diisi angka (10 - 15 digit).
                        </small>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="alamat">Alamat Lengkap Domisili <span class="text-danger">*</span></label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap sesuai tempat tinggal saat ini"><?= htmlspecialchars($data['user']['alamat'] ?? ''); ?></textarea>
                    <small style="color: var(--amber-600); font-size: 0.82rem; margin-top: 6px; display: block;">
                        <i class="fas fa-info-circle"></i> Alamat wajib diisi minimal 10 karakter.
                    </small>
                </div>

                <h3 class="profile-section-title mt-5"><i class="fas fa-file-upload"></i> Unggah Dokumen Identitas</h3>
                <p class="profile-hint">Format file yang diizinkan: <strong>JPG/PNG</strong>. Ukuran maksimal <strong>2MB</strong> per file.</p>

                <div class="upload-group">
                    <label>Foto KTP <span class="text-danger">*</span></label>
                    <div class="file-upload-wrapper <?= !empty($data['user']['foto_ktp']) ? 'uploaded-success' : ''; ?>">
                        <input type="file" name="foto_ktp" accept="image/jpeg, image/png">
                    </div>
                    
                    <?php if (!empty($data['user']['foto_ktp'])): ?>
                        <div class="upload-status"><i class="fas fa-check-circle"></i> KTP sudah terunggah</div>
                        <div class="image-preview-box">
                            <img src="/public/uploads/ktp_sim/<?= htmlspecialchars($data['user']['foto_ktp']); ?>" alt="Preview KTP" class="img-preview">
                        </div>
                        <small style="color: var(--slate-400); display: block; margin-top: 8px;">* Unggah file baru jika ingin mengganti foto KTP.</small>
                    <?php else: ?>
                        <small style="color: var(--amber-600); font-size: 0.82rem; margin-top: 6px; display: block; grid-area: note;">
                            <i class="fas fa-exclamation-circle"></i> Wajib melampirkan foto KTP.
                        </small>
                    <?php endif; ?>
                </div>

                <div class="upload-group" style="margin-top: 24px;">
                    <label>Foto SIM A <span class="text-danger">*</span></label>
                    <div class="file-upload-wrapper <?= !empty($data['user']['foto_sim']) ? 'uploaded-success' : ''; ?>">
                        <input type="file" name="foto_sim" accept="image/jpeg, image/png">
                    </div>
                    
                    <?php if (!empty($data['user']['foto_sim'])): ?>
                        <div class="upload-status"><i class="fas fa-check-circle"></i> SIM sudah terunggah</div>
                        <div class="image-preview-box">
                            <img src="/public/uploads/ktp_sim/<?= htmlspecialchars($data['user']['foto_sim']); ?>" alt="Preview SIM" class="img-preview">
                        </div>
                        <small style="color: var(--slate-400); display: block; margin-top: 8px;">* Unggah file baru jika ingin mengganti foto SIM.</small>
                    <?php else: ?>
                        <small style="color: var(--amber-600); font-size: 0.82rem; margin-top: 6px; display: block; grid-area: note;">
                            <i class="fas fa-exclamation-circle"></i> Wajib melampirkan foto SIM A.
                        </small>
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