<?php $css_halaman = 'admin'; include __DIR__ . '/../templates/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group shadow-sm">
                <a href="<?= BASEURL; ?>/admin/dashboard" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="<?= BASEURL; ?>/admin/kelola_mobil" class="list-group-item list-group-item-action">Kelola Mobil</a>
                <a href="<?= BASEURL; ?>/admin/kelola_pesanan" class="list-group-item list-group-item-action active">Kelola Pesanan</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3 border-bottom">
                <h1 class="h2">Antrean Validasi Pesanan Pelanggan</h1>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Armada Mobil</th>
                                    <th>Periode Sewa</th>
                                    <th>Total Biaya</th>
                                    <th>Status Pesanan</th>
                                    <th class="text-center">Aksi / Kontrol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['bookings'])): ?>
                                    <?php foreach ($data['bookings'] as $booking): ?>
                                        <tr>
                                            <td>#<?= $booking['id_booking']; ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($booking['nama_lengkap']); ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars($booking['nomor_hp']); ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($booking['merk']); ?> <?= htmlspecialchars($booking['tipe']); ?></td>
                                            <td>
                                                <small>
                                                    Ambil: <?= date('d M Y', strtotime($booking['tanggal_ambil'])); ?><br>
                                                    Kembali: <?= date('d M Y', strtotime($booking['tanggal_kembali'])); ?>
                                                </small>
                                            </td>
                                            <td><strong>Rp <?= number_format($booking['total_harga'], 0, ',', '.'); ?></strong></td>
                                            <td>
                                                <?php 
                                                    $badgeClass = 'secondary';
                                                    if ($booking['status'] == 'Pending') $badgeClass = 'warning';
                                                    elseif ($booking['status'] == 'Berjalan') $badgeClass = 'primary';
                                                    elseif ($booking['status'] == 'Selesai') $badgeClass = 'success';
                                                    elseif ($booking['status'] == 'Dibatalkan') $badgeClass = 'danger';
                                                ?>
                                                <span class="badge badge-<?= $badgeClass; ?> p-2">
                                                    <?= htmlspecialchars($booking['status']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown" tabindex="0">
                                                    <button class="btn btn-sm btn-secondary" type="button" onclick="this.parentElement.classList.toggle('show')">
                                                        Ubah Status
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-menu-item p-2 d-block text-primary" href="<?= BASEURL; ?>/admin/update_status_booking/<?= $booking['id_booking']; ?>/Berjalan">Setujui & Jalankan</a>
                                                        <a class="dropdown-menu-item p-2 d-block text-success" href="<?= BASEURL; ?>/admin/update_status_booking/<?= $booking['id_booking']; ?>/Selesai">Tandai Selesai</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-menu-item p-2 d-block text-danger" href="<?= BASEURL; ?>/admin/update_status_booking/<?= $booking['id_booking']; ?>/Dibatalkan" onclick="return confirm('Batalkan pesanan ini?');">Tolak / Batalkan</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted p-4">Belum ada transaksi sewa masuk dari pengguna.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
