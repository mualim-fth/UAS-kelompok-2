<?php
require_once __DIR__ . '/../core/Database.php';

class CarModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

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

    public function create(array $data): bool
    {
        $this->db->query(
            "INSERT INTO mobil (merk, tipe, transmisi, kapasitas, harga_per_hari, foto, deskripsi, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['merk'],
                $data['tipe'],
                $data['transmisi'],
                $data['kapasitas'],
                $data['harga_per_hari'],
                $data['foto']      ?? null,
                $data['deskripsi'] ?? null,
                $data['status']    ?? 'Tersedia',
            ]
        );
        return true;
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query(
            "UPDATE mobil
             SET merk = ?, tipe = ?, transmisi = ?, kapasitas = ?,
                 harga_per_hari = ?, deskripsi = ?, status = ?
             WHERE id_mobil = ?",
            [
                $data['merk'],
                $data['tipe'],
                $data['transmisi'],
                $data['kapasitas'],
                $data['harga_per_hari'],
                $data['deskripsi'] ?? null,
                $data['status'],
                $id,
            ]
        );
        return true;
    }

    public function updateFoto(int $id, string $path): bool
    {
        $this->db->query(
            "UPDATE mobil SET foto = ? WHERE id_mobil = ?",
            [$path, $id]
        );
        return true;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $this->db->query(
            "UPDATE mobil SET status = ? WHERE id_mobil = ?",
            [$status, $id]
        );
        return true;
    }

    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM mobil WHERE id_mobil = ?", [$id]);
        return true;
    }
}