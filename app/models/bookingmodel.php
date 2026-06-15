<?php
require_once __DIR__ . '/../core/Database.php';

class BookingModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->query(
            "SELECT b.*, u.nama_lengkap, u.email, u.nomor_hp,
                    m.merk, m.tipe, m.harga_per_hari
             FROM bookings b
             JOIN users u ON b.id_user  = u.id_user
             JOIN mobil m ON b.id_mobil = m.id_mobil
             ORDER BY b.created_at DESC"
        )->fetchAll();
    }

    public function getByUser(int $userId): array
    {
        return $this->db->query(
            "SELECT b.*, m.merk, m.tipe, m.foto, m.harga_per_hari
             FROM bookings b
             JOIN mobil m ON b.id_mobil = m.id_mobil
             WHERE b.id_user = ?
             ORDER BY b.created_at DESC",
            [$userId]
        )->fetchAll();
    }

    public function getById(int $id): array|false
    {
        return $this->db->query(
            "SELECT b.*, u.nama_lengkap, u.email, u.nomor_hp, u.alamat,
                    u.foto_ktp, u.foto_sim,
                    m.merk, m.tipe, m.harga_per_hari, m.foto AS foto_mobil
             FROM bookings b
             JOIN users u ON b.id_user  = u.id_user
             JOIN mobil m ON b.id_mobil = m.id_mobil
             WHERE b.id_booking = ?",
            [$id]
        )->fetch();
    }

    public function create(array $data): int
    {
        $ambil   = new DateTime($data['tanggal_ambil']);
        $kembali = new DateTime($data['tanggal_kembali']);
        $totalHari  = $ambil->diff($kembali)->days;
        $totalHarga = $totalHari * $data['harga_per_hari'];

        $this->db->query(
            "INSERT INTO bookings
                (id_user, id_mobil, tanggal_ambil, tanggal_kembali,
                 opsi_pengambilan, catatan, total_hari, total_harga, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')",
            [
                $data['id_user'],
                $data['id_mobil'],
                $data['tanggal_ambil'],
                $data['tanggal_kembali'],
                $data['opsi_pengambilan'] ?? 'Ambil di Garasi',
                $data['catatan']          ?? null,
                $totalHari,
                $totalHarga,
            ]
        );

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $this->db->query(
            "UPDATE bookings SET status = ? WHERE id_booking = ?",
            [$status, $id]
        );
        return true;
    }

    public function cancel(int $id, int $userId): bool
    {
        $this->db->query(
            "UPDATE bookings SET status = 'Dibatalkan'
             WHERE id_booking = ? AND id_user = ?",
            [$id, $userId]
        );
        return true;
    }

    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM bookings WHERE id_booking = ?", [$id]);
        return true;
    }

    public function getWithPayment(int $id): array|false
    {
        return $this->db->query(
            "SELECT b.*, m.merk, m.tipe, m.foto AS foto_mobil,
                    p.id_payment, p.metode_pembayaran, p.bukti_transfer,
                    p.status_pembayaran, p.konfirmasi
             FROM bookings b
             JOIN mobil m ON b.id_mobil = m.id_mobil
             LEFT JOIN payments p ON b.id_booking = p.id_booking
             WHERE b.id_booking = ?",
            [$id]
        )->fetch();
    }
}