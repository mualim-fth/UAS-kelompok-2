<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // 1. TULIS KREDENSIAL XAMPP LANGSUNG DI SINI
        $host = 'localhost';
        $user = 'root';
        $pass = '';             // Default XAMPP biasanya kosong
        $db   = 'rental_mobil'; // Sesuaikan jika nama database kamu berbeda

        // 2. Buat koneksi PDO yang simpel dan kuat
        $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }

    // Fungsi Singleton untuk dipanggil oleh Model (Jangan dihapus)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Fungsi eksekusi Query (Aman dari SQL Injection)
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Fungsi untuk mendapatkan ID terakhir yang disimpan
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}