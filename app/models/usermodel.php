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
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id_user FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row !== false;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (nama_lengkap, email, password, nomor_hp, alamat, role)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        $stmt->execute([
            $data['nama_lengkap'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['nomor_hp']  ?? null,
            $data['alamat']    ?? null,
            $data['role']      ?? 'customer'
        ]);
        
        return true;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE users
             SET nama_lengkap = ?, nomor_hp = ?, alamat = ?
             WHERE id_user = ?"
        );
        
        $stmt->execute([
            $data['nama_lengkap'],
            $data['nomor_hp'] ?? null,
            $data['alamat']   ?? null,
            $id
        ]);
        
        return true;
    }

    public function updateFotoKtp(int $id, string $path): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET foto_ktp = ? WHERE id_user = ?");
        $stmt->execute([$path, $id]);
        return true;
    }

    public function updateFotoSim(int $id, string $path): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET foto_sim = ? WHERE id_user = ?");
        $stmt->execute([$path, $id]);
        return true;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        return true;
    }

    public function verifyPassword(string $inputPassword, string $hashedPassword): bool
    {
        return password_verify($inputPassword, $hashedPassword);
    }
}