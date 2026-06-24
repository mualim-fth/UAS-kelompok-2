<?php $css_halaman = 'admin'; include __DIR__ . '/../templates/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group shadow-sm">
                <a href="<?= BASEURL; ?>/admin/dashboard" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="<?= BASEURL; ?>/admin/kelola_mobil" class="list-group-item list-group-item-action">Kelola Mobil</a>
                <a href="<?= BASEURL; ?>/admin/kelola_pesanan" class="list-group-item list-group-item-action">Kelola Pesanan</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Admin</h1>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-primary shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Total Mobil</h5>
                            <p class="card-text display-4 font-weight-bold"><?= isset($data['total_mobil']) ? $data['total_mobil'] : 0; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Pesanan Baru (Pending)</h5>
                            <p class="card-text display-4 font-weight-bold"><?= isset($data['total_pending']) ? $data['total_pending'] : 0; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-warning shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Total Pelanggan</h5>
                            <p class="card-text display-4 font-weight-bold"><?= isset($data['total_users']) ? $data['total_users'] : 0; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <h4>Selamat Datang Kembali, Administrator!</h4>
                    <p class="text-muted mb-0">Melalui panel ini, Anda dapat mengelola armada kendaraan rental, meninjau unggahan dokumen identitas pengguna, serta mengubah status transaksi sewa pelanggan secara langsung.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
