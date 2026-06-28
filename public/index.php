<?php
// Mulai sesi aplikasi
session_start();

// =================================================================
// 1. PINDAHKAN KONSTANTA APLIKASI DI SINI (Pengganti config.php)
// =================================================================
define('APP_NAME', 'Rental Mobil');
define('UPLOAD_MOBIL', __DIR__ . '/uploads/mobil/');
define('UPLOAD_KTP_SIM', __DIR__ . '/uploads/ktp_sim/');
define('UPLOAD_ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/jpg']);
define('UPLOAD_BUKTI', __DIR__ . '/uploads/bukti/');
define('UPLOAD_MAX_SIZE', 2097152); // 2 MB

// =================================================================
// 2. PANGGIL CORE YANG TERSISA (Hanya Database)
// =================================================================
require_once '../app/config/koneksi.php';

// =================================================================
// 3. TANGKAP URL DARI .HTACCESS
// =================================================================

// 1. Ambil rute dari URL (jika kosong, otomatis ke 'home')
$url = explode('/', trim($_GET['url'] ?? 'home', '/'));

// 2. Pecah menjadi komponen rute datar
$halaman = $url[0];
$id      = $url[1] ?? null;

// =================================================================
// 4. SWITCH CASE ROUTER (Explicit Flat Route)
// =================================================================
switch ($halaman) {
    case 'home':
        require_once '../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    // --- FITUR AUTENTIKASI ---
    case 'login':
        require_once '../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'register':
        require_once '../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    // --- FITUR KATALOG & DETAIL (PUBLIK) ---
    case 'car':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        $controller->index();
        break;

    case 'detail':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        $controller->detail($id);
        break;

    // --- FITUR PROFIL CUSTOMER ---
    case 'profile':
        require_once '../app/controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;

    case 'upload_dokumen':
        require_once '../app/controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->uploadDokumen();
        break;

    // --- FITUR TRANSAKSI BOOKING CUSTOMER ---
    case 'booking':
        require_once '../app/controllers/BookingController.php';
        $controller = new BookingController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $controller->proses();
        } else {
            $controller->create($id);
        }
        break;

    case 'riwayat':
        require_once '../app/controllers/BookingController.php';
        $controller = new BookingController();
        $controller->riwayat();
        break;

    // --- PANEL MANAGEMENT ADMIN ---
    case 'dashboard':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        $controller->dashboard(); 
        break;

    case 'kelola_mobil':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        $controller->kelola();
        break;

    case 'tambah_mobil':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        $controller->tambah();
        break;

    case 'hapus_mobil':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        $controller->hapus($id);
        break;

    case 'kelola_pesanan':
        require_once '../app/controllers/BookingController.php';
        $controller = new BookingController();
        $controller->kelola(); 
        break;

    case 'update_status_booking':
        require_once '../app/controllers/BookingController.php';
        $controller = new BookingController();
        $status_baru = isset($url[2]) ? $url[2] : '';
        $controller->updateStatus($id, $status_baru); 
        break;

    case 'batalkan':
        require_once '../app/controllers/BookingController.php';
        $controller = new BookingController();
        $controller->cancel($id);
        break;

    case 'edit_mobil':
        require_once '../app/controllers/CarController.php';
        $controller = new CarController();
        // ID didapat dari komponen URL kedua (/edit_mobil/5)
        $controller->edit($id);
        break;

    // --- DEFAULT KEMBALI KE BERANDA ---
    default:
        require_once '../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}