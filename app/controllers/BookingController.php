<?php

class BookingController extends Controller
{
    // =================================================================
    // MIDDLEWARE KEAMANAN
    // =================================================================
    public function __construct()
    {
        // Pastikan tamu/pengunjung biasa tidak bisa mengakses fitur booking
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // =================================================================
    // MENAMPILKAN FORM BOOKING (Mencegat user jika profil kosong)
    // =================================================================
    public function create($id_mobil)
    {
        // 1. CEK KELENGKAPAN PROFIL (Pencegatan)
        $user = $this->model('UserModel')->getById($_SESSION['user_id']);
        
        if (empty($user['nomor_hp']) || empty($user['alamat']) || empty($user['foto_ktp']) || empty($user['foto_sim'])) {
            // Paksa pengguna melengkapi profil sebelum merender halaman booking
            echo "<script>alert('Akses Tertahan! Anda wajib melengkapi data alamat, KTP, dan SIM sebelum bisa menyewa armada.'); window.location.href='".BASEURL."/profile';</script>";
            exit;
        }

        // 2. CEK KETERSEDIAAN MOBIL
        $mobil = $this->model('CarModel')->getById($id_mobil);
        if (!$mobil || $mobil['status'] !== 'Tersedia') {
            echo "<script>alert('Mohon maaf, armada ini sedang tidak tersedia atau dalam perawatan.'); window.location.href='".BASEURL."/car';</script>";
            exit;
        }

        $data['judul'] = 'Form Pemesanan - ' . APP_NAME;
        $data['mobil'] = $mobil;
        $data['user']  = $user;

        // Render form kalender sewa
        $this->view('customer/form_booking', $data);
    }

    // =================================================================
    // MEMPROSES TRANSAKSI (Rumus & Insert)
    // =================================================================
    public function proses()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_mobil = $_POST['id_mobil'];
            
            // KEAMANAN TINGKAT TINGGI:
            // Ambil harga_per_hari langsung dari database, BUKAN dari form HTML.
            // Ini mencegah pelanggan nakal yang menggunakan "Inspect Element" untuk mengubah harga sewa menjadi Rp 0.
            $mobil = $this->model('CarModel')->getById($id_mobil);
            
            $dataBooking = [
                'id_user'          => $_SESSION['user_id'],
                'id_mobil'         => $id_mobil,
                'tanggal_ambil'    => $_POST['tanggal_ambil'],
                'tanggal_kembali'  => $_POST['tanggal_kembali'],
                'opsi_pengambilan' => $_POST['opsi_pengambilan'],
                'catatan'          => $_POST['catatan'] ?? null,
                'harga_per_hari'   => $mobil['harga_per_hari'] 
            ];

            // Validasi Logika Kalender (Tanggal tidak boleh mundur)
            $waktuAmbil   = strtotime($dataBooking['tanggal_ambil']);
            $waktuKembali = strtotime($dataBooking['tanggal_kembali']);
            
            if ($waktuAmbil < strtotime(date('Y-m-d')) || $waktuKembali <= $waktuAmbil) {
                echo "<script>alert('Error: Rentang tanggal sewa tidak valid!'); window.history.back();</script>";
                exit;
            }

            // Eksekusi insert ke database
            $id_booking = $this->model('BookingModel')->create($dataBooking);

            if ($id_booking) {
                // Ubah status mobil menjadi 'Disewa' agar otomatis hilang dari katalog pengunjung lain
                $this->model('CarModel')->updateStatus($id_mobil, 'Disewa');
                
                echo "<script>alert('Transaksi berhasil dikirim! Silakan pantau status pesanan Anda.'); window.location.href='".BASEURL."/booking/riwayat';</script>";
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
        
        // Ambil data pesanan khusus untuk user yang sedang login saja
        $data['bookings'] = $this->model('BookingModel')->getByUser($_SESSION['user_id']);
        
        $this->view('customer/riwayat_booking', $data);
    }
}