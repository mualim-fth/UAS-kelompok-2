<?php
require_once __DIR__ . '/../config/koneksi.php';

class CarModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // =================================================================
    // FUNGSI TAMPIL DATA (Tetap Ringkas)
    // =================================================================
    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM mobil ORDER BY created_at DESC")
                        ->fetchAll();
    }

    public function getAvailable(): array
    {
        return $this->db->query(
            "SELECT * FROM mobil WHERE status = 'Tersedia' ORDER BY merk ASC"
        )->fetchAll();
    }

    public function getById(int $id): array|false
    {
        return $this->db->query(
            "SELECT * FROM mobil WHERE id_mobil = ?", [$id]
        )->fetch();
    }

    // =================================================================
    // FUNGSI DARI FORM (Eksplisit menggunakan Prepare & Execute)
    // =================================================================
    public function create(array $data): bool
    {
        $sql = "INSERT INTO mobil (merk, tipe, transmisi, kapasitas, harga_per_hari, foto, deskripsi, status)
                VALUES (:merk, :tipe, :transmisi, :kapasitas, :harga_per_hari, :foto, :deskripsi, :status)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            ':merk'           => $data['merk'],
            ':tipe'           => $data['tipe'],
            ':transmisi'      => $data['transmisi'],
            ':kapasitas'      => $data['kapasitas'],
            ':harga_per_hari' => $data['harga_per_hari'],
            ':foto'           => $data['foto'] ?? null,
            ':deskripsi'      => $data['deskripsi'] ?? null,
            ':status'         => $data['status'] ?? 'Tersedia'
        ]);
        
        return true;
    }

    public function update(int $id, array $data): bool
    {

        $sql = "UPDATE mobil
                SET merk = :merk, tipe = :tipe, transmisi = :transmisi, kapasitas = :kapasitas,
                    harga_per_hari = :harga_per_hari, deskripsi = :deskripsi, status = :status
                WHERE id_mobil = :id_mobil";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':merk'           => $data['merk'],
            ':tipe'           => $data['tipe'],
            ':transmisi'      => $data['transmisi'],
            ':kapasitas'      => $data['kapasitas'],
            ':harga_per_hari' => $data['harga_per_hari'],
            ':deskripsi'      => $data['deskripsi'] ?? null,
            ':status'         => $data['status'],
            ':id_mobil'       => $id
        ]);
        
        return true;
    }

    /// =================================================================
    // FUNGSI UPDATE STATUS/FOTO & DELETE
    // =================================================================
    public function updateFoto(int $id, string $path): bool
    {
        $sql = "UPDATE mobil SET foto = :foto WHERE id_mobil = :id_mobil";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':foto'     => $path,
            ':id_mobil' => $id
        ]);
        
        return true;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE mobil SET status = :status WHERE id_mobil = :id_mobil";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':status'   => $status,
            ':id_mobil' => $id
        ]);
        
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM mobil WHERE id_mobil = :id_mobil";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_mobil' => $id
        ]);
        
        return true;
    }
}