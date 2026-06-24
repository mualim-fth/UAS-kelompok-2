<?php

class ProfileController extends Controller
{
    // =================================================================
    // MIDDLEWARE / PROTEKSI CONSTRUCTOR
    // =================================================================
    public function __construct()
    {
        // Pastikan hanya user yang sudah login yang bisa mengakses controller ini
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // =================================================================
    // MENAMPILKAN HALAMAN PROFIL
    // =================================================================
    public function index()
    {
        $data['judul'] = 'Profil Saya - ' . APP_NAME;
        
        // Ambil data user yang sedang login dari database
        $data['user'] = $this->model('UserModel')->getById($_SESSION['user_id']);

        // Arahkan ke view form lengkapi profil
        $this->view('customer/lengkapi_profil', $data);
    }

    // =================================================================
    // PROSES UPLOAD KTP & SIM (INTI MANAJEMEN FILE)
    // =================================================================
    public function uploadDokumen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $userId = $_SESSION['user_id'];
            $pesanSukses = [];
            $pesanError = [];

            // 1. BLOK PEMROSESAN FOTO KTP
            if (isset($_FILES['foto_ktp']) && $_FILES['foto_ktp']['error'] === UPLOAD_ERR_OK) {
                
                $tipeMimeKtp = $_FILES['foto_ktp']['type'];
                $ukuranKtp   = $_FILES['foto_ktp']['size'];
                $tmpKtp      = $_FILES['foto_ktp']['tmp_name'];

                // Validasi Tipe & Ukuran (Memanfaatkan konstanta dari config.php)
                if (in_array($tipeMimeKtp, UPLOAD_ALLOWED_TYPES) && $ukuranKtp <= UPLOAD_MAX_SIZE) {
                    
                    $ekstensiKtp = pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION);
                    $namaFileKtp = uniqid('ktp_') . '.' . $ekstensiKtp; // Generate nama aman

                    // Pindahkan file dan update database
                    if (move_uploaded_file($tmpKtp, UPLOAD_KTP_SIM . $namaFileKtp)) {
                        $this->model('UserModel')->updateFotoKtp($userId, $namaFileKtp);
                        $pesanSukses[] = "Foto KTP berhasil diunggah.";
                    } else {
                        $pesanError[] = "Gagal memindahkan file KTP ke server.";
                    }
                } else {
                    $pesanError[] = "Format KTP tidak valid atau ukuran lebih dari 2MB.";
                }
            }

            // 2. BLOK PEMROSESAN FOTO SIM
            if (isset($_FILES['foto_sim']) && $_FILES['foto_sim']['error'] === UPLOAD_ERR_OK) {
                
                $tipeMimeSim = $_FILES['foto_sim']['type'];
                $ukuranSim   = $_FILES['foto_sim']['size'];
                $tmpSim      = $_FILES['foto_sim']['tmp_name'];

                if (in_array($tipeMimeSim, UPLOAD_ALLOWED_TYPES) && $ukuranSim <= UPLOAD_MAX_SIZE) {
                    
                    $ekstensiSim = pathinfo($_FILES['foto_sim']['name'], PATHINFO_EXTENSION);
                    $namaFileSim = uniqid('sim_') . '.' . $ekstensiSim;

                    if (move_uploaded_file($tmpSim, UPLOAD_KTP_SIM . $namaFileSim)) {
                        $this->model('UserModel')->updateFotoSim($userId, $namaFileSim);
                        $pesanSukses[] = "Foto SIM berhasil diunggah.";
                    } else {
                        $pesanError[] = "Gagal memindahkan file SIM ke server.";
                    }
                } else {
                    $pesanError[] = "Format SIM tidak valid atau ukuran lebih dari 2MB.";
                }
            }

            // 3. LOGIKA NOTIFIKASI PENGGUNA
            // Menggabungkan pesan array menjadi satu string agar mudah ditampilkan di alert JavaScript
            $alertMsg = "";
            if (!empty($pesanSukses)) {
                $alertMsg .= implode("\\n", $pesanSukses) . "\\n";
            }
            if (!empty($pesanError)) {
                $alertMsg .= implode("\\n", $pesanError);
            }

            // Jika tidak ada pesan sama sekali (user menekan tombol submit tapi tidak memilih file)
            if (empty($alertMsg)) {
                $alertMsg = "Tidak ada file dokumen yang dipilih.";
            }

            // Pantulkan kembali ke halaman profil dengan membawa pesan alert
            echo "<script>alert('$alertMsg'); window.location.href='".BASEURL."/profile';</script>";
            exit;
        }
    }
}