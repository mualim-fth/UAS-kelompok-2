<?php $css_halaman = 'home'; include __DIR__ . '/../templates/header.php'; ?>

<section class="rh-hero">
    <div class="container rh-hero-container">
        <div class="rh-hero-text">
            <span class="badge badge-sky mb-3">#1 Pilihan Rental Mobil Terpercaya</span>
            <h1 class="rh-title">sewa mobil mudah</h1>
            <p class="rh-subtitle">Liburan keluarga, acara pernikahan, atau urusan bisnis? Kami menyediakan berbagai pilihan armada terawat dengan harga jujur dan proses pemesanan yang super cepat tanpa antre panjang.</p>
            <div class="rh-hero-actions">
                <a href="/car" class="btn btn-primary btn-lg"><i class="fas fa-car-side"></i> Pesan Sekarang</a>
                <a href="#keunggulan" class="btn btn-outline btn-lg">Kenapa Memilih Kami?</a>
            </div>
        </div>
    </div>
</section>

<section id="keunggulan" class="rh-features bg-light">
    <div class="container">
        <div class="rh-section-header">
            <h2>Layanan Bintang Lima untuk Anda</h2>
            <p>Kami memastikan pengalaman penyewaan mobil Anda aman, nyaman, dan sama sekali tidak merepotkan.</p>
        </div>
        <div class="rh-features-grid">
            <div class="rh-feature-card">
                <div class="rh-icon-wrapper"><i class="fas fa-tags"></i></div>
                <h3>Harga Transparan</h3>
                <p>Tidak ada biaya tersembunyi yang mengejutkan. Harga sewa harian yang Anda lihat di katalog adalah harga pas yang Anda bayarkan.</p>
            </div>
            <div class="rh-feature-card">
                <div class="rh-icon-wrapper"><i class="fas fa-tools"></i></div>
                <h3>Armada Prima & Bersih</h3>
                <p>Kenyamanan Anda adalah prioritas. Setiap mobil rutin masuk bengkel dan kabinnya disterilisasi sebelum kunci diserahkan ke tangan Anda.</p>
            </div>
            <div class="rh-feature-card">
                <div class="rh-icon-wrapper"><i class="fas fa-user-shield"></i></div>
                <h3>Privasi Terjamin</h3>
                <p>Proses unggah foto KTP dan SIM dilindungi dengan enkripsi tinggi. Data pribadi Anda aman di server kami dan hanya digunakan untuk verifikasi sewa.</p>
            </div>
        </div>
    </div>
</section>

<section class="rh-steps">
    <div class="container">
        <div class="rh-section-header">
            <h2>Cara Mudah Menyewa Mobil</h2>
            <p>Tinggalkan cara lama yang ribet. Pesan mobil idaman Anda hanya dalam tiga langkah mudah melalui smartphone.</p>
        </div>
        <div class="rh-steps-container">
            <div class="rh-step-item">
                <div class="rh-step-circle">1</div>
                <h4>Daftar & Lengkapi Profil</h4>
                <p>Buat akun gratis dan unggah dokumen persyaratan dasar (KTP & SIM) untuk proses verifikasi yang cepat.</p>
            </div>
            <div class="rh-step-item">
                <div class="rh-step-circle">2</div>
                <h4>Pilih Mobil Idaman</h4>
                <p>Jelajahi katalog kami, pilih mobil yang sesuai kebutuhan, dan tentukan tanggal peminjaman Anda.</p>
            </div>
            <div class="rh-step-item">
                <div class="rh-step-circle">3</div>
                <h4>Ambil Kunci & Jalan!</h4>
                <p>Setelah reservasi disetujui, datang ke lokasi kami dengan menunjukkan bukti pemesanan, dan Anda siap meluncur.</p>
            </div>
        </div>
    </div>
</section>

<section class="rh-cta">
    <div class="container">
        <div class="rh-cta-box">
            <div class="rh-cta-content">
                <h2>Sudah Punya Rencana Perjalanan?</h2>
                <p>Jangan sampai kehabisan mobil idamanmu di tanggal liburan. Cek ketersediaan armada kami hari ini juga!</p>
            </div>
            <div class="rh-cta-button">
                <?php if (!isset($_SESSION['user_id'])) : ?>
                    <a href="/register" class="btn btn-light btn-lg">Daftar & Sewa Sekarang</a>
                <?php else : ?>
                    <a href="/car" class="btn btn-light btn-lg">Lihat Katalog Mobil</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>