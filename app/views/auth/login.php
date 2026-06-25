<?php $css_halaman = 'auth'; include __DIR__ . '/../templates/header.php'; ?>

<section class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Selamat Datang</h2>
            <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <form action="/login" method="POST">
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 10px;">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Masuk
            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="/register">Daftar sekarang</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>