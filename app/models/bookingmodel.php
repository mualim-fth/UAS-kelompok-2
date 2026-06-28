<?php
require_once __DIR__ . '/../config/koneksi.php';

class BookingModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // =================================================================
    // READ (Tanpa Parameter → Query Biasa)
    // =================================================================

    // getAll: tidak ada parameter, pakai query() biasa
    public function getAll(): array
    {
        return $this->db->query(
            "SELECT b.*, u.nama_lengkap, u.email, u.nomor_hp,
                    m.merk, m.tipe, m.harga_per_hari,
                    p.metode_pembayaran, p.status_pembayaran, p.bukti_transfer
             FROM bookings b
             JOIN users u ON b.id_user  = u.id_user
             JOIN mobil m ON b.id_mobil = m.id_mobil
             LEFT JOIN payments p ON b.id_booking = p.id_booking
             ORDER BY b.created_at DESC"
        )->fetchAll();
    }

    // =================================================================
    // READ (Ada Parameter → Tetap Prepared untuk Keamanan)
    // =================================================================

    public function getByUser(int $userId): array
    {
        $sql = "SELECT b.*, m.merk, m.tipe, m.foto, m.harga_per_hari,
                       p.metode_pembayaran, p.status_pembayaran, p.bukti_transfer
                FROM bookings b
                JOIN mobil m ON b.id_mobil = m.id_mobil
                LEFT JOIN payments p ON b.id_booking = p.id_booking
                WHERE b.id_user = ?
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT b.*, u.nama_lengkap, u.email, u.nomor_hp, u.alamat,
                       u.foto_ktp, u.foto_sim,
                       m.merk, m.tipe, m.harga_per_hari, m.foto AS foto_mobil,
                       p.metode_pembayaran, p.status_pembayaran, p.bukti_transfer
                FROM bookings b
                JOIN users u ON b.id_user  = u.id_user
                JOIN mobil m ON b.id_mobil = m.id_mobil
                LEFT JOIN payments p ON b.id_booking = p.id_booking
                WHERE b.id_booking = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getWithPayment(int $id): array|false
    {
        $sql = "SELECT b.*, m.merk, m.tipe, m.foto AS foto_mobil,
                       p.id_payment, p.metode_pembayaran, p.bukti_transfer,
                       p.status_pembayaran, p.konfirmasi
                FROM bookings b
                JOIN mobil m ON b.id_mobil = m.id_mobil
                LEFT JOIN payments p ON b.id_booking = p.id_booking
                WHERE b.id_booking = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // =================================================================
    // CREATE / UPDATE / DELETE (Dari Form → Wajib Prepared)
    // =================================================================

    public function create(array $data): int
    {
        $ambil   = new DateTime($data['tanggal_ambil']);
        $kembali = new DateTime($data['tanggal_kembali']);
        $hari    = $ambil->diff($kembali)->days;
        $total   = $hari * $data['harga_per_hari'];

        $sql = "INSERT INTO bookings
                (id_user, id_mobil, tanggal_ambil, tanggal_kembali,
                 opsi_pengambilan, catatan, total_hari, total_harga, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['id_user'],
            $data['id_mobil'],
            $data['tanggal_ambil'],
            $data['tanggal_kembali'],
            $data['opsi_pengambilan'] ?? 'Ambil di Garasi',
            $data['catatan'] ?? null,
            $hari,
            $total
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function savePayment(int $id_booking, string $metode, ?string $bukti = null): bool
    {
        $sql = "INSERT INTO payments
                (id_booking, metode_pembayaran, bukti_transfer, status_pembayaran)
                VALUES (?, ?, ?, 'Menunggu Konfirmasi')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_booking, $metode, $bukti]);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE bookings SET status = ? WHERE id_booking = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    public function updatePaymentStatus(int $id_payment, string $status): bool
    {
        $sql = "UPDATE payments SET status_pembayaran = ? WHERE id_payment = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $id_payment]);
    }

    public function cancel(int $id, int $userId): bool
    {
        $sql = "UPDATE bookings SET status = 'Dibatalkan'
                WHERE id_booking = ? AND id_user = ? AND status = 'Pending'";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id, $userId]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM bookings WHERE id_booking = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}