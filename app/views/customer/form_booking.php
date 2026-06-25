<?php $css_halaman = 'booking'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container booking-wrapper">
    <a href="/detail/<?= $data['mobil']['id_mobil']; ?>" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Detail
    </a>

    <div class="booking-grid">
        <div class="booking-form-card">
            <h2 style="margin-bottom: 20px; color: var(--ink);"><i class="fas fa-calendar-alt text-primary"></i> Form Reservasi</h2>
            <hr style="border: 0; height: 1px; background: #f3f4f6; margin-bottom: 25px;">

            <form action="/booking" method="POST">
                <input type="hidden" name="id_mobil" value="<?= $data['mobil']['id_mobil']; ?>">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="tanggal_ambil">Tanggal Pengambilan <span style="color: var(--red-600);">*</span></label>
                        <input type="date" id="tanggal_ambil" name="tanggal_ambil" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal Pengembalian <span style="color: var(--red-600);">*</span></label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="opsi_pengambilan">Opsi Pengambilan <span style="color: var(--red-600);">*</span></label>
                    <select id="opsi_pengambilan" name="opsi_pengambilan" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Opsi Pengambilan --</option>
                        <option value="Ambil di Garasi">Ambil Sendiri di Garasi</option>
                        <option value="Antar ke Alamat">Antar ke Alamat Domisili Saya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan Tambahan (Opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-control" placeholder="Contoh: Tolong mobil dicuci bersih sebelum diambil, atau rincian jam pengantaran..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 30px;">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Konfirmasi Pesanan
                </button>
            </form>
        </div>

        <div class="booking-summary-card">
            <h3 style="font-size: 1.1rem; color: var(--ink-soft); margin-bottom: 15px;">Ringkasan Pesanan</h3>
            
            <?php if (!empty($data['mobil']['foto'])) : ?>
                <img src="/public/uploads/mobil/<?= $data['mobil']['foto']; ?>" alt="Mobil">
            <?php else : ?>
                <div style="background: #e5e7eb; height: 180px; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 15px;">
                    <i class="fas fa-car fa-3x" style="color: #9ca3af;"></i>
                </div>
            <?php endif; ?>

            <div class="summary-title">
                <?= htmlspecialchars($data['mobil']['merk']); ?> <?= htmlspecialchars($data['mobil']['tipe']); ?>
            </div>
            
            <div class="summary-price">
                Rp <?= number_format($data['mobil']['harga_per_hari'], 0, ',', '.'); ?> <span>/ hari</span>
            </div>

            <div class="summary-note">
                <i class="fas fa-info-circle"></i> 
                <strong>Pemberitahuan:</strong> Total harga sewa akan dihitung secara otomatis oleh sistem berdasarkan rentang tanggal yang Anda pilih. Pembayaran dilakukan setelah status pesanan disetujui.
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>