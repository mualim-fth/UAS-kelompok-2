<?php $css_halaman = 'home'; include __DIR__ . '/../templates/header.php'; ?>

<section class="hero">
    <div class="hero-badge">🚗 Rental Mobil Terpercaya</div>
    <h1>Jelajahi Kota<br><span class="hero-highlight">Tanpa Batas</span></h1>
    <p>Sewa armada mobil berkualitas dengan proses verifikasi yang cepat, aman, dan transparan. Temukan kendaraan yang pas untuk perjalanan bisnis maupun liburan keluarga.</p>
    <div class="hero-actions">
        <a href="<?= BASEURL; ?>/car" class="btn btn-primary">
            <i class="fas fa-car-side"></i> Lihat Katalog Mobil
        </a>
        <a href="#tentang-kami" class="btn btn-hero-outline">
            <i class="fas fa-info-circle"></i> Tentang Kami
        </a>
    </div>
    <div class="hero-stats">
        <div class="hero-stat">
            <span class="hero-stat-number">50+</span>
            <span class="hero-stat-label">Armada Mobil</span>
        </div>
        <div class="hero-stat-divider"></div>
        <div class="hero-stat">
            <span class="hero-stat-number">500+</span>
            <span class="hero-stat-label">Pelanggan Puas</span>
        </div>
        <div class="hero-stat-divider"></div>
        <div class="hero-stat">
            <span class="hero-stat-number">3+</span>
            <span class="hero-stat-label">Tahun Pengalaman</span>
        </div>
    </div>
</section>

<section id="tentang-kami" class="about-section">
    <div class="container">
        <div class="about-grid">

            <div class="about-content">
                <div class="section-label">Tentang Kami</div>
                <h2 class="about-title">
                    Layanan Rental Mobil <span class="text-sky">Terpercaya</span> untuk Semua Kebutuhan
                </h2>
                <p class="about-desc">
                    Kami adalah platform reservasi rental mobil yang hadir untuk memudahkan perjalanan Anda. Dengan armada terawat, proses pemesanan yang simpel, dan verifikasi identitas yang aman, kami memastikan setiap perjalanan Anda nyaman dan terjamin.
                </p>
                <p class="about-desc">
                    Didukung oleh tim yang berpengalaman dan sistem berbasis teknologi, kami melayani kebutuhan transportasi harian, perjalanan bisnis, hingga liburan keluarga dengan standar layanan terbaik.
                </p>

                <div class="about-points">
                    <div class="about-point">
                        <div class="about-point-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <strong>Identitas Terverifikasi</strong>
                            <p>Setiap penyewa wajib mengunggah KTP & SIM sebelum menyewa, sehingga armada kami terlindungi dengan baik.</p>
                        </div>
                    </div>
                    <div class="about-point">
                        <div class="about-point-icon"><i class="fas fa-car"></i></div>
                        <div>
                            <strong>Armada Terawat</strong>
                            <p>Seluruh kendaraan kami menjalani pengecekan rutin untuk memastikan performa dan keamanan berkendara.</p>
                        </div>
                    </div>
                    <div class="about-point">
                        <div class="about-point-icon"><i class="fas fa-headset"></i></div>
                        <div>
                            <strong>Layanan Responsif</strong>
                            <p>Admin kami siap memproses pesanan dan konfirmasi pembayaran Anda dengan cepat dan profesional.</p>
                        </div>
                    </div>
                </div>

                <a href="<?= BASEURL; ?>/car" class="btn btn-primary" style="margin-top: 10px;">
                    <i class="fas fa-car-side"></i> Mulai Sewa Sekarang
                </a>
            </div>

            <div class="about-visual">
                <div class="about-card-main">
                    <div class="about-card-icon-big">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Rental Mobil</h3>
                    <p>Proses reservasi online mudah & cepat</p>
                    <div class="about-mini-cards">
                        <div class="about-mini-card">
                            <i class="fas fa-calendar-check"></i>
                            <span>Booking Online</span>
                        </div>
                        <div class="about-mini-card">
                            <i class="fas fa-id-card"></i>
                            <span>Verifikasi KTP/SIM</span>
                        </div>
                        <div class="about-mini-card">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Harga Transparan</span>
                        </div>
                        <div class="about-mini-card">
                            <i class="fas fa-tools"></i>
                            <span>Armada Terawat</span>
                        </div>
                    </div>
                </div>
                <div class="about-badge-float about-badge-1">
                    <i class="fas fa-star"></i> Terpercaya
                </div>
                <div class="about-badge-float about-badge-2">
                    <i class="fas fa-check-circle"></i> Terverifikasi
                </div>
            </div>

        </div>
    </div>
</section>

<section class="container features">
    <div class="features-header">
        <div class="section-label">Keunggulan Kami</div>
        <h2>Mengapa Memilih <span class="text-sky">Rental Mobil</span> Kami?</h2>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon icon-blue"><i class="fas fa-shield-alt"></i></div>
            <h3>Transaksi Aman</h3>
            <p>Data identitas KTP & SIM Anda dienkripsi dan disimpan aman di server kami. Pembayaran dijamin transparan tanpa biaya tersembunyi.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon icon-green"><i class="fas fa-tags"></i></div>
            <h3>Harga Terjangkau</h3>
            <p>Nikmati harga sewa harian yang bersaing. Cocok untuk semua kalangan dengan pelayanan prima untuk setiap pelanggan.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon icon-orange"><i class="fas fa-tools"></i></div>
            <h3>Armada Terawat</h3>
            <p>Setiap mobil melewati pengecekan mesin secara rutin untuk memastikan performa maksimal dan kenyamanan perjalanan Anda.</p>
        </div>
    </div>
</section>

<section class="how-section">
    <div class="container">
        <div class="section-label" style="display:block; text-align:center; width:fit-content; margin: 0 auto 12px;">Cara Kerja</div>
        <h2 style="text-align:center; margin-bottom: 50px;">Sewa Mobil dalam <span class="text-sky">4 Langkah Mudah</span></h2>
        <div class="how-grid">
            <div class="how-step">
                <div class="how-number">1</div>
                <div class="how-icon"><i class="fas fa-user-plus"></i></div>
                <h4>Daftar Akun</h4>
                <p>Buat akun gratis dan lengkapi profil dengan data diri, KTP, dan SIM.</p>
            </div>
            <div class="how-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="how-step">
                <div class="how-number">2</div>
                <div class="how-icon"><i class="fas fa-search"></i></div>
                <h4>Pilih Mobil</h4>
                <p>Jelajahi katalog armada kami dan pilih mobil yang sesuai kebutuhan.</p>
            </div>
            <div class="how-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="how-step">
                <div class="how-number">3</div>
                <div class="how-icon"><i class="fas fa-calendar-alt"></i></div>
                <h4>Pilih Tanggal</h4>
                <p>Tentukan tanggal ambil dan kembali, lalu konfirmasi pesanan Anda.</p>
            </div>
            <div class="how-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="how-step">
                <div class="how-number">4</div>
                <div class="how-icon"><i class="fas fa-car"></i></div>
                <h4>Nikmati Perjalanan</h4>
                <p>Setelah pembayaran dikonfirmasi admin, mobil siap Anda gunakan!</p>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="bottom-cta">
        <div class="bottom-cta-icon"><i class="fas fa-rocket"></i></div>
        <h2>Siap Memulai Perjalanan?</h2>
        <p>Daftar sekarang, lengkapi profil Anda, dan dapatkan akses penuh ke fitur pemesanan armada kami.</p>
        <?php if (!isset($_SESSION['user_id'])) : ?>
            <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap; position:relative; z-index:1;">
                <a href="<?= BASEURL; ?>/auth/register" class="btn" style="background:rgba(255,255,255,0.2); color:var(--white); border:2px solid rgba(255,255,255,0.5);">
                    <i class="fas fa-user-plus"></i> Daftar Akun Baru
                </a>
                <a href="<?= BASEURL; ?>/auth" class="btn" style="background:var(--white); color:var(--sky-600);">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </a>
            </div>
        <?php else : ?>
            <a href="<?= BASEURL; ?>/car" class="btn" style="background:var(--white); color:var(--sky-600); position:relative; z-index:1;">
                <i class="fas fa-car-side"></i> Sewa Sekarang
            </a>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>