<?php

class AuthController extends Controller
{
    // Menampilkan halaman Login default
    public function index()
    {
        // Jika user sudah login, langsung arahkan ke dashboard masing-masing
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] == 'admin') {
                header('Location: ' . BASEURL . '/admin/dashboard');
            } else {
                header('Location: ' . BASEURL . '/customer/form_booking');
            }
            exit;
        }

        $data['judul'] = 'Login - ' . APP_NAME;
        $this->view('auth/login', $data);
    }

    // Menampilkan halaman Register
    public function register()
    {
        $data['judul'] = 'Registrasi - ' . APP_NAME;
        $this->view('auth/register', $data);
    }

    // Menangani form submit dari halaman Register
    public function prosesRegister()
    {
        // Pastikan request adalah POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Validasi konfirmasi password
            if ($_POST['password'] !== $_POST['konfirmasi_password']) {
                // Dalam aplikasi nyata, gunakan Flash Message (session) untuk mengirim pesan error ke View
                echo "<script>alert('Error: Password dan Konfirmasi Password tidak cocok!'); window.location.href='".BASEURL."/auth/register';</script>";
                exit;
            }

            // 2. Cek apakah email sudah terdaftar
            if ($this->model('UserModel')->emailExists($_POST['email'])) {
                echo "<script>alert('Error: Email sudah terdaftar. Silakan gunakan email lain!'); window.location.href='".BASEURL."/auth/register';</script>";
                exit;
            }

            // 3. Eksekusi penyimpanan ke database
            // Catatan Integrasi: Fungsi password_hash() sudah ditangani secara otomatis di dalam UserModel->create() 
            // milik Anggota 1, sehingga kita cukup melempar array $_POST mentah dari sini.
            if ($this->model('UserModel')->create($_POST)) {
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location.href='".BASEURL."/auth';</script>";
                exit;
            } else {
                echo "<script>alert('Gagal melakukan registrasi.'); window.location.href='".BASEURL."/auth/register';</script>";
                exit;
            }
        }
    }

    // Menangani form submit dari halaman Login
    public function prosesLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 1. Cari user berdasarkan email
            $user = $this->model('UserModel')->getByEmail($email);

            if ($user) {
                // 2. Verifikasi Hash Password menggunakan fungsi bantuan dari UserModel
                if ($this->model('UserModel')->verifyPassword($password, $user['password'])) {
                    
                    // 3. Password cocok! Ciptakan Sesi ($_SESSION)
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['role'] = $user['role'];

                    // 4. Pengatur Lalu Lintas (Router Berdasarkan Role)
                    if ($user['role'] == 'admin') {
                        header('Location: ' . BASEURL . '/admin/dashboard');
                    } else {
                        // Jika customer, arahkan ke halaman utama atau booking
                        header('Location: ' . BASEURL . '/public/home');
                    }
                    exit;
                } else {
                    echo "<script>alert('Password salah!'); window.location.href='".BASEURL."/auth';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Email tidak ditemukan!'); window.location.href='".BASEURL."/auth';</script>";
                exit;
            }
        }
    }

    // Fungsi untuk mengakhiri sesi
    public function logout()
    {
        // Hapus semua data sesi
        $_SESSION = [];
        session_unset();
        session_destroy();

        // Arahkan kembali ke halaman login
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}