<?php $css_halaman = 'katalog'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container">
    <div class="catalog-header">
        <h2>Katalog Armada Kami</h2>
        <p>Pilih mobil yang paling sesuai dengan kebutuhan perjalanan Anda.</p>
        <hr>
    </div>

    <div class="catalog-grid">
        <?php if (!empty($data['mobil'])) : ?>
            <?php foreach ($data['mobil'] as $mobil) : ?>
                <div class="car-card">
                    <div class="car-image-wrapper">
                        <?php if (!empty($mobil['foto'])) : ?>
                            <img src="/public/uploads/mobil/<?= $mobil['foto']; ?>" class="car-image" alt="<?= htmlspecialchars($mobil['merk'] . ' ' . $mobil['tipe']); ?>">
                        <?php else : ?>
                            <div class="car-image-placeholder">
                                <i class="fas fa-car"></i>
                                <div>No Image</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="car-content">
                        <div class="car-title">
                            <?= htmlspecialchars($mobil['merk']); ?> <?= htmlspecialchars($mobil['tipe']); ?>
                        </div>
                        <div class="car-price">
                            Rp <?= number_format($mobil['harga_per_hari'], 0, ',', '.'); ?> <span>/ hari</span>
                        </div>
                        
                        <ul class="car-specs">
                            <li><i class="fas fa-cogs"></i> Transmisi: <strong><?= htmlspecialchars($mobil['transmisi']); ?></strong></li>
                            <li><i class="fas fa-users"></i> Kapasitas: <strong><?= htmlspecialchars($mobil['kapasitas']); ?> Kursi</strong></li>
                        </ul>
                        
                        <div class="car-actions">
                            <a href="/detail/<?= $mobil['id_mobil']; ?>" class="btn btn-outline">Detail</a>
                            <a href="/booking/<?= $mobil['id_mobil']; ?>" class="btn btn-primary">Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Katalog Kosong</h3>
                <p>Maaf, saat ini belum ada armada mobil yang tersedia untuk disewa.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>