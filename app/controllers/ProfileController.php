<?php

// Tidak ada lagi "extends Controller"
class ProfileController 
{
    // =================================================================
    // MIDDLEWARE / PROTEKSI CONSTRUCTOR
    // =================================================================
    public function __construct()
    {
        // Pastikan hanya user yang sudah login yang bisa mengakses controller ini
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // =================================================================
    // MENAMPILKAN HALAMAN PROFIL
    // =================================================================
    public function index()
    {
        $data['judul'] = 'Profil Saya - ' . APP_NAME;
        
        // Ambil data user yang sedang login dari database menggunakan pemanggilan manual
        require_once __DIR__ . '/../models/UserModel.php';
        $userModel = new UserModel();
        $data['user'] = $userModel->getById($_SESSION['user_id']);

        // Arahkan ke view form lengkapi profil menggunakan include
        include __DIR__ . '/../views/customer/lengkapi_profil.php';
    }

    // =================================================================
    // PROSES UPLOAD KTP & SIM (INTI MANAJEMEN FILE)
    // =================================================================
    // =================================================================
    // PROSES UPLOAD KTP & SIM (INTI MANAJEMEN FILE)
    // =================================================================
    public function uploadDokumen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $userId = $_SESSION['user_id'];
            $pesanSukses = [];
            $pesanError = [];

            // Panggil UserModel untuk persiapan update data
            require_once __DIR__ . '/../models/UserModel.php';
            $userModel = new UserModel();

            // =========================================================
            // 1. BLOK BARU: SIMPAN DATA TEKS (NO HP & ALAMAT)
            // =========================================================
            // Karena 'nama_lengkap' tidak dikirim oleh form HTML, 
            // kita suntikkan datanya dari Session agar UserModel tidak error.
            $_POST['nama_lengkap'] = $_SESSION['nama_lengkap'];
            
            if ($userModel->update($userId, $_POST)) {
                $pesanSukses[] = "Data alamat dan nomor HP tersimpan.";
            } else {
                $pesanError[] = "Gagal menyimpan data teks.";
            }

            // =========================================================
            // 2. BLOK PEMROSESAN FOTO KTP
            // =========================================================
            if (isset($_FILES['foto_ktp']) && $_FILES['foto_ktp']['error'] === UPLOAD_ERR_OK) {
                
                $tipeMimeKtp = $_FILES['foto_ktp']['type'];
                $ukuranKtp   = $_FILES['foto_ktp']['size'];
                $tmpKtp      = $_FILES['foto_ktp']['tmp_name'];

                if (in_array($tipeMimeKtp, UPLOAD_ALLOWED_TYPES) && $ukuranKtp <= UPLOAD_MAX_SIZE) {
                    
                    $ekstensiKtp = pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION);
                    $namaFileKtp = uniqid('ktp_') . '.' . $ekstensiKtp;

                    if (move_uploaded_file($tmpKtp, UPLOAD_KTP_SIM . $namaFileKtp)) {
                        $userModel->updateFotoKtp($userId, $namaFileKtp);
                        $pesanSukses[] = "Foto KTP berhasil diunggah.";
                    } else {
                        $pesanError[] = "Gagal memindahkan file KTP ke server.";
                    }
                } else {
                    $pesanError[] = "Format KTP tidak valid atau ukuran lebih dari 2MB.";
                }
            }

            // =========================================================
            // 3. BLOK PEMROSESAN FOTO SIM
            // =========================================================
            if (isset($_FILES['foto_sim']) && $_FILES['foto_sim']['error'] === UPLOAD_ERR_OK) {
                
                $tipeMimeSim = $_FILES['foto_sim']['type'];
                $ukuranSim   = $_FILES['foto_sim']['size'];
                $tmpSim      = $_FILES['foto_sim']['tmp_name'];

                if (in_array($tipeMimeSim, UPLOAD_ALLOWED_TYPES) && $ukuranSim <= UPLOAD_MAX_SIZE) {
                    
                    $ekstensiSim = pathinfo($_FILES['foto_sim']['name'], PATHINFO_EXTENSION);
                    $namaFileSim = uniqid('sim_') . '.' . $ekstensiSim;

                    if (move_uploaded_file($tmpSim, UPLOAD_KTP_SIM . $namaFileSim)) {
                        $userModel->updateFotoSim($userId, $namaFileSim);
                        $pesanSukses[] = "Foto SIM berhasil diunggah.";
                    } else {
                        $pesanError[] = "Gagal memindahkan file SIM ke server.";
                    }
                } else {
                    $pesanError[] = "Format SIM tidak valid atau ukuran lebih dari 2MB.";
                }
            }

            // =========================================================
            // 4. LOGIKA NOTIFIKASI PENGGUNA
            // =========================================================
            $alertMsg = "";
            if (!empty($pesanSukses)) {
                $alertMsg .= implode("\\n", $pesanSukses) . "\\n";
            }
            if (!empty($pesanError)) {
                $alertMsg .= implode("\\n", $pesanError);
            }

            // Pantulkan kembali ke halaman profil
            echo "<script>alert('$alertMsg'); window.location.href='/profile';</script>";
            exit;
        }
    }
}