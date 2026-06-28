<?php $css_halaman = 'booking'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container booking-wrapper">
    <a href="/detail/<?= $data['mobil']['id_mobil']; ?>" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Detail
    </a>

    <div class="booking-grid">

        <!-- ===== KOLOM KIRI: FORM ===== -->
        <div class="booking-form-card">
            <h2 class="booking-form-title">
                <i class="fas fa-calendar-alt"></i> Form Reservasi
            </h2>
            <hr class="booking-divider">

            <form action="/booking" method="POST" enctype="multipart/form-data" id="formBooking">
                <input type="hidden" name="id_mobil" value="<?= $data['mobil']['id_mobil']; ?>">

                <!-- ── SEKSI 1: TANGGAL ── -->
                <div class="booking-section-label">
                    <span class="booking-step-number">1</span>
                    Pilih Tanggal Sewa
                </div>

                <div class="booking-date-grid">
                    <div class="form-group">
                        <label for="tanggal_ambil">Tanggal Pengambilan <span class="text-required">*</span></label>
                        <input type="date" id="tanggal_ambil" name="tanggal_ambil" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal Pengembalian <span class="text-required">*</span></label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <!-- ── SEKSI 2: OPSI PENGAMBILAN ── -->
                <div class="booking-section-label">
                    <span class="booking-step-number">2</span>
                    Opsi Pengambilan
                </div>

                <div class="form-group">
                    <select id="opsi_pengambilan" name="opsi_pengambilan" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Opsi Pengambilan --</option>
                        <option value="Ambil di Garasi">Ambil Sendiri di Garasi</option>
                        <option value="Antar ke Alamat">Antar ke Alamat Domisili Saya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan Tambahan (Opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-control" placeholder="Contoh: jam pengantaran, permintaan khusus..."></textarea>
                </div>

                <!-- ── SEKSI 3: METODE PEMBAYARAN ── -->
                <div class="booking-section-label">
                    <span class="booking-step-number">3</span>
                    Metode Pembayaran
                </div>

                <div class="payment-options">

                    <!-- Transfer Bank -->
                    <label class="payment-option-card" id="card-transfer">
                        <input type="radio" name="metode_pembayaran" value="Transfer Bank" required>
                        <div class="payment-option-inner">
                            <div class="payment-option-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="payment-option-info">
                                <strong>Transfer Bank</strong>
                                <span>BCA · BRI · Mandiri · BNI</span>
                            </div>
                            <div class="payment-option-check">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </label>

                    <!-- QRIS / E-Wallet -->
                    <label class="payment-option-card" id="card-qris">
                        <input type="radio" name="metode_pembayaran" value="QRIS">
                        <div class="payment-option-inner">
                            <div class="payment-option-icon payment-icon-qris">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class="payment-option-info">
                                <strong>QRIS / E-Wallet</strong>
                                <span>GoPay · OVO · Dana · ShopeePay</span>
                            </div>
                            <div class="payment-option-check">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </label>

                    <!-- COD -->
                    <label class="payment-option-card" id="card-cod">
                        <input type="radio" name="metode_pembayaran" value="COD">
                        <div class="payment-option-inner">
                            <div class="payment-option-icon payment-icon-cod">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div class="payment-option-info">
                                <strong>Bayar di Tempat (COD)</strong>
                                <span>Bayar tunai saat pengambilan mobil</span>
                            </div>
                            <div class="payment-option-check">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </label>

                </div>

                <!-- ── SEKSI 4: UPLOAD BUKTI (muncul kalau pilih Transfer/QRIS) ── -->
                <div class="bukti-upload-wrapper" id="buktiUploadArea" style="display:none;">
                    <div class="booking-section-label">
                        <span class="booking-step-number">4</span>
                        Upload Bukti Pembayaran
                    </div>

                    <div class="bukti-info-box">
                        <i class="fas fa-info-circle"></i>
                        <div id="buktiInfoText">Silakan transfer ke rekening berikut, lalu unggah bukti transfer Anda.</div>
                    </div>

                    <!-- Info Rekening (muncul kalau Transfer Bank) -->
                    <div id="rekeningInfo" class="rekening-box" style="display:none;">
                        <div class="rekening-item">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="bank-logo">
                            <div>
                                <strong>BCA</strong>
                                <span>1234567890 a.n. Rental Mobil</span>
                            </div>
                        </div>
                        <div class="rekening-item">
                            <img src="https://upload.wikimedia.org/wikipedia/id/a/a9/BRI_2020.svg" alt="BRI" class="bank-logo">
                            <div>
                                <strong>BRI</strong>
                                <span>0987654321 a.n. Rental Mobil</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info QRIS (muncul kalau QRIS) -->
                    <div id="qrisInfo" class="qris-box" style="display:none;">
                        <i class="fas fa-qrcode fa-4x" style="color: var(--sky-400);"></i>
                        <p>Scan QR Code di lokasi atau hubungi admin untuk mendapatkan kode pembayaran QRIS.</p>
                    </div>

                    <div class="form-group" style="margin-top: 16px;">
                        <label for="bukti_transfer">Unggah Bukti Pembayaran <span class="text-required">*</span></label>
                        <div class="file-upload-wrapper" id="buktiUploadWrapper">
                            <i class="fas fa-cloud-upload-alt fa-2x" style="color: var(--sky-400); margin-bottom: 10px;"></i>
                            <p style="color: var(--ink-soft); margin-bottom: 8px;">Klik atau seret file ke sini</p>
                            <small style="color: var(--slate-400);">Format: JPG/PNG · Maks. 2MB</small>
                            <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/jpeg, image/png">
                        </div>
                        <div id="buktiPreview" style="display:none; margin-top: 12px;">
                            <img id="buktiPreviewImg" src="" alt="Preview Bukti" style="max-width: 100%; border-radius: 10px; border: 1px solid var(--slate-200);">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block booking-submit-btn">
                    <i class="fas fa-check-circle"></i> Konfirmasi Pesanan
                </button>
            </form>
        </div>

        <!-- ===== KOLOM KANAN: RINGKASAN ===== -->
        <div class="booking-summary-card">
            <h3 class="booking-summary-title">Ringkasan Pesanan</h3>

            <?php if (!empty($data['mobil']['foto'])) : ?>
                <img src="/public/uploads/mobil/<?= $data['mobil']['foto']; ?>" alt="Mobil" class="booking-summary-img">
            <?php else : ?>
                <div class="booking-summary-no-img">
                    <i class="fas fa-car fa-3x"></i>
                </div>
            <?php endif; ?>

            <div class="summary-car-name">
                <?= htmlspecialchars($data['mobil']['merk']); ?> <?= htmlspecialchars($data['mobil']['tipe']); ?>
            </div>

            <div class="summary-price">
                Rp <?= number_format($data['mobil']['harga_per_hari'], 0, ',', '.'); ?>
                <span>/ hari</span>
            </div>

            <div class="summary-specs">
                <div class="summary-spec-item">
                    <i class="fas fa-cogs"></i>
                    <span><?= htmlspecialchars($data['mobil']['transmisi']); ?></span>
                </div>
                <div class="summary-spec-item">
                    <i class="fas fa-users"></i>
                    <span><?= htmlspecialchars($data['mobil']['kapasitas']); ?> Kursi</span>
                </div>
            </div>

            <div class="summary-note">
                <i class="fas fa-info-circle"></i>
                <p>Total harga dihitung otomatis berdasarkan tanggal yang dipilih. Pembayaran dikonfirmasi setelah admin menyetujui pesanan.</p>
            </div>

            <div class="summary-user-info">
                <div class="summary-user-title"><i class="fas fa-user"></i> Data Penyewa</div>
                <div class="summary-user-row">
                    <span>Nama</span>
                    <strong><?= htmlspecialchars($data['user']['nama_lengkap']); ?></strong>
                </div>
                <div class="summary-user-row">
                    <span>No. HP</span>
                    <strong><?= htmlspecialchars($data['user']['nomor_hp'] ?? '-'); ?></strong>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
// Logika tampil/sembunyikan area upload bukti
const radios = document.querySelectorAll('input[name="metode_pembayaran"]');
const buktiArea = document.getElementById('buktiUploadArea');
const rekeningInfo = document.getElementById('rekeningInfo');
const qrisInfo = document.getElementById('qrisInfo');
const buktiInfoText = document.getElementById('buktiInfoText');
const buktiInput = document.getElementById('bukti_transfer');
const cards = document.querySelectorAll('.payment-option-card');

radios.forEach(radio => {
    radio.addEventListener('change', function() {
        // Highlight card yang dipilih
        cards.forEach(c => c.classList.remove('selected'));
        this.closest('.payment-option-card').classList.add('selected');

        if (this.value === 'Transfer Bank') {
            buktiArea.style.display = 'block';
            rekeningInfo.style.display = 'block';
            qrisInfo.style.display = 'none';
            buktiInfoText.textContent = 'Silakan transfer ke rekening berikut, lalu unggah bukti transfer Anda.';
            buktiInput.required = true;
        } else if (this.value === 'QRIS') {
            buktiArea.style.display = 'block';
            rekeningInfo.style.display = 'none';
            qrisInfo.style.display = 'block';
            buktiInfoText.textContent = 'Setelah scan dan bayar, unggah screenshot bukti pembayaran QRIS Anda.';
            buktiInput.required = true;
        } else if (this.value === 'COD') {
            buktiArea.style.display = 'none';
            buktiInput.required = false;
        }
    });
});

// Preview gambar bukti sebelum upload
buktiInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('buktiPreviewImg').src = e.target.result;
            document.getElementById('buktiPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php include __DIR__ . '/../templates/footer.php'; ?>