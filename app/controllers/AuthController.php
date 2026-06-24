<?php

// Tidak ada lagi "extends Controller" karena file core controller sudah dihapus
class AuthController 
{
    // =================================================================
    // 1. FUNGSI LOGIN (Menggabungkan View & Proses)
    // =================================================================
    public function login()
    {
        // SKENARIO A: Jika user menekan tombol "Masuk" (Mengirim Form POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Panggil file UserModel dan buat objeknya secara manual
            require_once __DIR__ . '/../models/UserModel.php';
            $userModel = new UserModel();
            
            $user = $userModel->getByEmail($email);

            if ($user) {
                if ($userModel->verifyPassword($password, $user['password'])) {
                    
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] == 'admin') {
                        header('Location: /dashboard');
                    } else {
                        header('Location: /home');
                    }
                    exit;
                } else {
                    echo "<script>alert('Password salah!'); window.location.href='/login';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Email tidak ditemukan!'); window.location.href='/login';</script>";
                exit;
            }
        }

        // SKENARIO B: Jika user hanya membuka halaman login via URL (Method GET)
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] == 'admin') {
                header('Location: /dashboard');
            } else {
                header('Location: /home');
            }
            exit;
        }

        // Jika belum login, siapkan data dan langsung include file HTML-nya
        $data['judul'] = 'Login - Rental Mobil';
        include __DIR__ . '/../views/auth/login.php';
    }

    // =================================================================
    // 2. FUNGSI REGISTER (Menggabungkan View & Proses)
    // =================================================================
    public function register()
    {
        // SKENARIO A: Jika user menekan tombol "Daftar" (Mengirim Form POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if ($_POST['password'] !== $_POST['konfirmasi_password']) {
                echo "<script>alert('Error: Password dan Konfirmasi Password tidak cocok!'); window.location.href='/register';</script>";
                exit;
            }

            // Panggil file UserModel dan buat objeknya secara manual
            require_once __DIR__ . '/../models/UserModel.php';
            $userModel = new UserModel();

            if ($userModel->emailExists($_POST['email'])) {
                echo "<script>alert('Error: Email sudah terdaftar. Silakan gunakan email lain!'); window.location.href='/register';</script>";
                exit;
            }

            if ($userModel->create($_POST)) {
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location.href='/login';</script>";
                exit;
            } else {
                echo "<script>alert('Gagal melakukan registrasi.'); window.location.href='/register';</script>";
                exit;
            }
        }

        // SKENARIO B: Jika user hanya membuka halaman register via URL (Method GET)
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] == 'admin') {
                header('Location: /dashboard');
            } else {
                header('Location: /home');
            }
            exit;
        }

        // Siapkan data judul dan langsung include kerangka HTML pendaftaran
        $data['judul'] = 'Registrasi - Rental Mobil';
        include __DIR__ . '/../views/auth/register.php';
    }

    // =================================================================
    // 3. FUNGSI LOGOUT
    // =================================================================
    public function logout()
    {
        $_SESSION = [];
        session_unset();
        session_destroy();

        header('Location: /login');
        exit;
    }
}