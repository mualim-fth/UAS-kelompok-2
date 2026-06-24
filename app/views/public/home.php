<?php $css_halaman = 'home'; include __DIR__ . '/../templates/header.php'; ?>

<section class="hero">
    <h1>Jelajahi Kota Tanpa Batas</h1>
    <p>Sewa armada mobil berkualitas dengan proses verifikasi yang cepat, aman, dan transparan. Temukan kendaraan yang pas untuk perjalanan bisnismu maupun liburan keluarga.</p>
    <a href="/car" class="btn btn-primary" style="font-size: 1.1rem; padding: 12px 30px;">
        <i class="fas fa-car-side" style="margin-right: 8px;"></i> Lihat Katalog Mobil
    </a>
</section>

<section class="container features">
    <div class="feature-card">
        <div class="feature-icon icon-blue">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h3>Transaksi Aman</h3>
        <p>Data identitas KTP & SIM Anda dienkripsi dan disimpan aman di server kami. Pembayaran dijamin transparan tanpa biaya tersembunyi.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon icon-green">
            <i class="fas fa-tags"></i>
        </div>
        <h3>Harga Terjangkau</h3>
        <p>Nikmati harga sewa harian yang bersaing. Cocok untuk semua kalangan dengan pelayanan bintang lima untuk setiap pelanggan.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon icon-orange">
            <i class="fas fa-tools"></i>
        </div>
        <h3>Armada Terawat</h3>
        <p>Setiap mobil melewati proses pengecekan mesin secara rutin untuk memastikan performa maksimal dan kenyamanan perjalanan Anda.</p>
    </div>
</section>

<section class="container">
    <div class="bottom-cta">
        <h2>Siap Memulai Perjalanan?</h2>
        <p>Daftar sekarang untuk melengkapi profil Anda dan dapatkan akses penuh ke fitur pemesanan kami.</p>
        <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="/register" class="btn" style="background-color: var(--dark); color: var(--white); border: 1px solid var(--dark);">
                Daftar Akun Baru
            </a>
        <?php else : ?>
            <a href="/car" class="btn btn-primary">
                Sewa Sekarang
            </a>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>