<?php

// Tidak ada lagi "extends Controller"
class BookingController
{
    // =================================================================
    // MIDDLEWARE KEAMANAN
    // =================================================================
    public function __construct()
    {
        // Pastikan tamu/pengunjung biasa tidak bisa mengakses fitur booking
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // =================================================================
    // MENAMPILKAN FORM BOOKING (Mencegat user jika profil kosong)
    // =================================================================
    public function create($id_mobil = null)
    {
        if ($id_mobil === null) {
            header('Location: /car');
            exit;
        }

        // 1. CEK KELENGKAPAN PROFIL (Panggil UserModel secara manual)
        require_once __DIR__ . '/../models/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->getById($_SESSION['user_id']);
        
        if (empty($user['nomor_hp']) || empty($user['alamat']) || empty($user['foto_ktp']) || empty($user['foto_sim'])) {
            echo "<script>alert('Akses Tertahan! Anda wajib melengkapi data alamat, KTP, dan SIM sebelum bisa menyewa armada.'); window.location.href='/profile';</script>";
            exit;
        }

        // 2. CEK KETERSEDIAAN MOBIL (Panggil CarModel secara manual)
        require_once __DIR__ . '/../models/CarModel.php';
        $carModel = new CarModel();
        $mobil = $carModel->getById($id_mobil);

        if (!$mobil || $mobil['status'] !== 'Tersedia') {
            echo "<script>alert('Mohon maaf, armada ini sedang tidak tersedia atau dalam perawatan.'); window.location.href='/car';</script>";
            exit;
        }

        $data['judul'] = 'Form Pemesanan - ' . APP_NAME;
        $data['mobil'] = $mobil;
        $data['user']  = $user;

        // Render form kalender sewa langsung dengan include
        include __DIR__ . '/../views/customer/form_booking.php';
    }

    // =================================================================
    // MEMPROSES TRANSAKSI (Rumus & Insert)
    // =================================================================
    public function proses()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_mobil = $_POST['id_mobil'];
            
            // Panggil CarModel untuk mendapatkan harga valid dari DB
            require_once __DIR__ . '/../models/CarModel.php';
            $carModel = new CarModel();
            $mobil = $carModel->getById($id_mobil);
            
            $dataBooking = [
                'id_user'          => $_SESSION['user_id'],
                'id_mobil'         => $id_mobil,
                'tanggal_ambil'    => $_POST['tanggal_ambil'],
                'tanggal_kembali'  => $_POST['tanggal_kembali'],
                'opsi_pengambilan' => $_POST['opsi_pengambilan'],
                'catatan'          => $_POST['catatan'] ?? null,
                'harga_per_hari'   => $mobil['harga_per_hari'] 
            ];

            // Validasi Logika Kalender
            $waktuAmbil   = strtotime($dataBooking['tanggal_ambil']);
            $waktuKembali = strtotime($dataBooking['tanggal_kembali']);
            
            if ($waktuAmbil < strtotime(date('Y-m-d')) || $waktuKembali <= $waktuAmbil) {
                echo "<script>alert('Error: Rentang tanggal sewa tidak valid!'); window.history.back();</script>";
                exit;
            }

            // Eksekusi insert ke database dengan BookingModel
            require_once __DIR__ . '/../models/BookingModel.php';
            $bookingModel = new BookingModel();
            $id_booking = $bookingModel->create($dataBooking);

            if ($id_booking) {
                // Ubah status mobil menjadi 'Disewa'
                $carModel->updateStatus($id_mobil, 'Disewa');
                
                echo "<script>alert('Transaksi berhasil dikirim! Silakan pantau status pesanan Anda.'); window.location.href='/riwayat';</script>";
            } else {
                echo "<script>alert('Sistem gagal memproses pesanan Anda.'); window.history.back();</script>";
            }
            exit;
        }
    }

    // =================================================================
    // HALAMAN RIWAYAT PESANAN CUSTOMER
    // =================================================================
    public function riwayat()
    {
        $data['judul'] = 'Riwayat Pesanan Saya - ' . APP_NAME;
        
        require_once __DIR__ . '/../models/BookingModel.php';
        $bookingModel = new BookingModel();
        $data['bookings'] = $bookingModel->getByUser($_SESSION['user_id']);
        
        include __DIR__ . '/../views/customer/riwayat_booking.php';
    }

    // =================================================================
    // AREA ADMIN: MANAJEMEN PESANAN (Fungsi Tambahan Baru)
    // =================================================================
    public function kelola()
    {
        // Proteksi khusus Admin
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $data['judul'] = 'Kelola Pesanan - Admin';
        
        require_once __DIR__ . '/../models/BookingModel.php';
        $bookingModel = new BookingModel();
        $data['bookings'] = $bookingModel->getAll();

        include __DIR__ . '/../views/admin/kelola_pesanan.php';
    }

    public function updateStatus($id, $status_baru)
    {
        // Proteksi khusus Admin
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        require_once __DIR__ . '/../models/BookingModel.php';
        $bookingModel = new BookingModel();
        
        if ($bookingModel->updateStatus($id, $status_baru)) {
            
            // Jika pesanan ditandai "Selesai" atau "Dibatalkan", mobil harus kembali "Tersedia"
            if ($status_baru == 'Selesai' || $status_baru == 'Dibatalkan') {
                $booking = $bookingModel->getById($id);
                if ($booking) {
                    require_once __DIR__ . '/../models/CarModel.php';
                    $carModel = new CarModel();
                    $carModel->updateStatus($booking['id_mobil'], 'Tersedia');
                }
            }

            echo "<script>alert('Status pesanan berhasil diperbarui menjadi {$status_baru}!'); window.location.href='/kelola_pesanan';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui status pesanan.'); window.location.href='/kelola_pesanan';</script>";
        }
        exit;
    }

    public function cancel($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        require_once __DIR__ . '/../models/BookingModel.php';
        $bookingModel = new BookingModel();
        
        // Ambil data booking dulu untuk update status mobil
        $booking = $bookingModel->getById((int)$id);
        
        if ($booking && $booking['id_user'] == $_SESSION['user_id'] && $booking['status'] == 'Pending') {
            $bookingModel->cancel((int)$id, $_SESSION['user_id']);
            
            // Kembalikan status mobil jadi Tersedia
            require_once __DIR__ . '/../models/CarModel.php';
            $carModel = new CarModel();
            $carModel->updateStatus($booking['id_mobil'], 'Tersedia');

            echo "<script>alert('Pesanan berhasil dibatalkan.'); window.location.href='/riwayat';</script>";
        } else {
            echo "<script>alert('Pesanan tidak dapat dibatalkan.'); window.location.href='/riwayat';</script>";
        }
        exit;
    }
}