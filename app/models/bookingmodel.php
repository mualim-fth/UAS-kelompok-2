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
    // FUNGSI READ/TAMPIL DATA (Menggunakan Query Bawaan PDO)
    // =================================================================
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

    // =================================================================
    // FUNGSI MANIPULASI DATA (Eksplisit Prepare Statement & Execute)
    // =================================================================
    public function create(array $data): int
    {
        // Kalkulasi Waktu
        $ambil      = new DateTime($data['tanggal_ambil']);
        $kembali    = new DateTime($data['tanggal_kembali']);
        $totalHari  = $ambil->diff($kembali)->days;
        $totalHarga = $totalHari * $data['harga_per_hari'];

        // 1. Susun Query dengan Named Parameters
        $sql = "INSERT INTO bookings
                    (id_user, id_mobil, tanggal_ambil, tanggal_kembali,
                     opsi_pengambilan, catatan, total_hari, total_harga, status)
                VALUES (:id_user, :id_mobil, :tanggal_ambil, :tanggal_kembali,
                     :opsi_pengambilan, :catatan, :total_hari, :total_harga, 'Pending')";
        
        // 2. Prepare Statement
        $stmt = $this->db->prepare($sql);

        // 3. Execute dengan binding array data
        $stmt->execute([
            ':id_user'          => $data['id_user'],
            ':id_mobil'         => $data['id_mobil'],
            ':tanggal_ambil'    => $data['tanggal_ambil'],
            ':tanggal_kembali'  => $data['tanggal_kembali'],
            ':opsi_pengambilan' => $data['opsi_pengambilan'] ?? 'Ambil di Garasi',
            ':catatan'          => $data['catatan']          ?? null,
            ':total_hari'       => $totalHari,
            ':total_harga'      => $totalHarga
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE bookings SET status = :status WHERE id_booking = :id_booking";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':status'     => $status,
            ':id_booking' => $id
        ]);
        return true;
    }

    public function cancel(int $id, int $userId): bool
    {
        $sql = "UPDATE bookings SET status = 'Dibatalkan'
                WHERE id_booking = :id_booking AND id_user = :id_user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_booking' => $id,
            ':id_user'    => $userId
        ]);
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM bookings WHERE id_booking = :id_booking";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_booking' => $id
        ]);
        return true;
    }
}