<!--halaman register-->
<?php $css_halaman = 'auth'; include __DIR__ . '/../templates/header.php'; ?>

<section class="auth-wrapper">
    <div class="auth-card register-card">
        <div class="auth-header">
            <h2>Buat Akun Baru</h2>
            <p>Lengkapi data di bawah ini untuk bergabung dengan kami</p>
        </div>

        <form action="/register" method="POST">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="form-group">
                    <label for="konfirmasi_password">Ulangi Sandi</label>
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="form-control" placeholder="Ketik ulang sandi" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 10px;">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Daftar Akun
            </button>
        </form>

        <div class="auth-footer">
            Sudah memiliki akun? <a href="/login">Masuk di sini</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>