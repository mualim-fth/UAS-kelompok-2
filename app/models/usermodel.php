<?php
require_once __DIR__ . '/../config/koneksi.php';

class UserModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM users ORDER BY created_at DESC")
                        ->fetchAll();
    }

    public function getById(int $id): array|false
    {
        return $this->db->query(
            "SELECT * FROM users WHERE id_user = ?", [$id]
        )->fetch();
    }

    public function getByEmail(string $email): array|false
    {
        return $this->db->query(
            "SELECT * FROM users WHERE email = ?", [$email]
        )->fetch();
    }

    public function emailExists(string $email): bool
    {
        $row = $this->db->query(
            "SELECT id_user FROM users WHERE email = ?", [$email]
        )->fetch();
        return $row !== false;
    }

    public function create(array $data): bool
    {
        $this->db->query(
            "INSERT INTO users (nama_lengkap, email, password, nomor_hp, alamat, role)
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                $data['nama_lengkap'],
                $data['email'],
                password_hash($data['password'], PASSWORD_BCRYPT),
                $data['nomor_hp']  ?? null,
                $data['alamat']    ?? null,
                $data['role']      ?? 'customer',
            ]
        );
        return true;
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query(
            "UPDATE users
             SET nama_lengkap = ?, nomor_hp = ?, alamat = ?
             WHERE id_user = ?",
            [
                $data['nama_lengkap'],
                $data['nomor_hp'] ?? null,
                $data['alamat']   ?? null,
                $id,
            ]
        );
        return true;
    }

    public function updateFotoKtp(int $id, string $path): bool
    {
        $this->db->query(
            "UPDATE users SET foto_ktp = ? WHERE id_user = ?",
            [$path, $id]
        );
        return true;
    }

    public function updateFotoSim(int $id, string $path): bool
    {
        $this->db->query(
            "UPDATE users SET foto_sim = ? WHERE id_user = ?",
            [$path, $id]
        );
        return true;
    }

    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM users WHERE id_user = ?", [$id]);
        return true;
    }

    public function verifyPassword(string $inputPassword, string $hashedPassword): bool
    {
        return password_verify($inputPassword, $hashedPassword);
    }
}