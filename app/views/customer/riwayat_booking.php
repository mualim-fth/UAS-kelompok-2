// Halaman riwayat booking 
<?php $css_halaman = 'riwayat'; include __DIR__ . '/../templates/header.php'; ?>

<section class="container">
    <div class="history-header">
        <h2><i class="fas fa-history text-primary"></i> Riwayat Pesanan Saya</h2>
        <p>Pantau status transaksi dan jadwal penyewaan armada Anda di sini.</p>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Armada Mobil</th>
                    <th>Tanggal Sewa</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['bookings'])) : ?>
                    <?php foreach ($data['bookings'] as $booking) : ?>
                        <tr>
                            <td><strong>#<?= $booking['id_booking']; ?></strong></td>
                            
                            <td>
                                <div class="car-info">
                                    <?php if (!empty($booking['foto'])) : ?>
                                        <img src="<?= BASEURL; ?>/uploads/mobil/<?= $booking['foto']; ?>" alt="Mobil">
                                    <?php else : ?>
                                        <div style="width: 60px; height: 40px; background: #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                            <i class="fas fa-car"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= htmlspecialchars($booking['merk']); ?> <?= htmlspecialchars($booking['tipe']); ?></strong>
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                <div style="font-size: 0.9rem;">
                                    <div style="color: var(--ink);"><i class="fas fa-calendar-check text-primary" style="width: 15px;"></i> <?= date('d M Y', strtotime($booking['tanggal_ambil'])); ?></div>
                                    <div style="color: var(--ink-soft);"><i class="fas fa-calendar-times" style="width: 15px;"></i> <?= date('d M Y', strtotime($booking['tanggal_kembali'])); ?></div>
                                </div>
                            </td>
                            
                            <td>
                                <strong style="color: #10b981;">Rp <?= number_format($booking['total_harga'], 0, ',', '.'); ?></strong>
                            </td>
                            
                            <td>
                                <?php 
                                    $badgeClass = '';
                                    switch ($booking['status']) {
                                        case 'Pending': $badgeClass = 'status-pending'; break;
                                        case 'Berjalan': $badgeClass = 'status-berjalan'; break;
                                        case 'Selesai': $badgeClass = 'status-selesai'; break;
                                        case 'Dibatalkan': $badgeClass = 'status-batal'; break;
                                        default: $badgeClass = 'status-pending';
                                    }
                                ?>
                                <span class="status-badge <?= $badgeClass; ?>">
                                    <?= htmlspecialchars($booking['status']); ?>
                                </span>
                            </td>
                            
                            <td style="text-align: center;">
                                <?php if ($booking['status'] == 'Pending') : ?>
                                    <a href="#" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85rem;" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                        Batalkan
                                    </a>
                                <?php else : ?>
                                    <span style="color: var(--ink-soft); font-size: 0.85rem;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state" style="padding: 40px 20px;">
                                <i class="fas fa-receipt"></i>
                                <h3>Belum Ada Transaksi</h3>
                                <p>Anda belum pernah melakukan pemesanan armada. Yuk, mulai perjalanan pertama Anda!</p>
                                <a href="<?= BASEURL; ?>/car" class="btn btn-primary" style="margin-top: 15px;">Lihat Katalog</a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
