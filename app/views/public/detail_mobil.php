<?php $css_halaman = 'detail'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container detail-wrapper">
    <a href="/car" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Katalog
    </a>

    <div class="detail-grid">
        <div class="detail-image-box">
            <?php if (!empty($data['mobil']['foto'])) : ?>
                <img src="/public/uploads/mobil/<?= $data['mobil']['foto']; ?>" alt="<?= htmlspecialchars($data['mobil']['merk'] . ' ' . $data['mobil']['tipe']); ?>">
            <?php else : ?>
                <div class="detail-image-placeholder">
                    <i class="fas fa-image"></i>
                    <p>Gambar Belum Diunggah</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="detail-content">
            <h1 class="detail-title">
                <?= htmlspecialchars($data['mobil']['merk']); ?> <?= htmlspecialchars($data['mobil']['tipe']); ?>
            </h1>
            
            <div class="detail-price">
                Rp <?= number_format($data['mobil']['harga_per_hari'], 0, ',', '.'); ?> <span>/ hari</span>
            </div>

            <h3 class="section-title"><i class="fas fa-list-alt"></i> Spesifikasi Kendaraan</h3>
            <ul class="spec-list">
                <li>
                    <span><i class="fas fa-cogs" style="width: 20px;"></i> Transmisi</span>
                    <span><?= htmlspecialchars($data['mobil']['transmisi']); ?></span>
                </li>
                <li>
                    <span><i class="fas fa-users" style="width: 20px;"></i> Kapasitas</span>
                    <span><?= htmlspecialchars($data['mobil']['kapasitas']); ?> Orang</span>
                </li>
                <li>
                    <span><i class="fas fa-info-circle" style="width: 20px;"></i> Status</span>
                    <?php if ($data['mobil']['status'] == 'Tersedia'): ?>
                        <span class="badge badge-success">Tersedia</span>
                    <?php else: ?>
                        <span class="badge badge-danger"><?= htmlspecialchars($data['mobil']['status']); ?></span>
                    <?php endif; ?>
                </li>
            </ul>

            <h3 class="section-title"><i class="fas fa-file-alt"></i> Deskripsi & Syarat</h3>
            <div class="detail-desc">
                <?= !empty($data['mobil']['deskripsi']) ? nl2br(htmlspecialchars($data['mobil']['deskripsi'])) : 'Tidak ada catatan tambahan atau spesifikasi khusus untuk armada ini.'; ?>
            </div>

            <?php if ($data['mobil']['status'] == 'Tersedia'): ?>
                <a href="/booking/<?= $data['mobil']['id_mobil']; ?>" class="btn btn-primary btn-block">
                    <i class="fas fa-calendar-check" style="margin-right: 8px;"></i> Pesan Kendaraan Ini
                </a>
            <?php else: ?>
                <button class="btn btn-disabled btn-block" disabled>
                    <i class="fas fa-ban" style="margin-right: 8px;"></i> Sedang Tidak Tersedia
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>