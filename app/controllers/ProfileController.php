<?php

class ProfileController 
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Profil Saya - ' . APP_NAME;
        
        require_once __DIR__ . '/../models/UserModel.php';
        $userModel = new UserModel();
        $data['user'] = $userModel->getById($_SESSION['user_id']);

        // Menangkap array pesan error/sukses dari session
        $data['flash_error'] = $_SESSION['flash_error'] ?? [];
        $data['flash_sukses'] = $_SESSION['flash_sukses'] ?? [];
        
        // Hapus session setelah ditangkap
        unset($_SESSION['flash_error'], $_SESSION['flash_sukses']);

        include __DIR__ . '/../views/customer/lengkapi_profil.php';
    }

    public function uploadDokumen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $userId = $_SESSION['user_id'];
            $pesanError = []; // Keranjang untuk menyimpan semua error
            $pesanSukses = [];

            require_once __DIR__ . '/../models/UserModel.php';
            $userModel = new UserModel();
            $currentUser = $userModel->getById($userId);

            // ==========================================
            // TAHAP 1: KUMPULKAN SEMUA ERROR (VALIDASI)
            // ==========================================
            
            // Cek Nomor HP
            $nomorHp = trim($_POST['nomor_hp'] ?? '');
            if (empty($nomorHp)) {
                $pesanError[] = "Nomor HP wajib diisi.";
            } elseif (!is_numeric($nomorHp)) {
                $pesanError[] = "Nomor HP hanya boleh berisi angka.";
            } elseif (strlen($nomorHp) < 10 || strlen($nomorHp) > 15) {
                $pesanError[] = "Nomor HP harus antara 10 hingga 15 digit.";
            }

            // Cek Alamat
            $alamat = trim($_POST['alamat'] ?? '');
            if (empty($alamat)) {
                $pesanError[] = "Alamat domisili wajib diisi.";
            } elseif (strlen($alamat) < 10) {
                $pesanError[] = "Alamat terlalu singkat, mohon isi minimal 10 karakter.";
            }

            // Aturan File
            $maxSize = 2 * 1024 * 1024; // 2MB
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            // Cek Foto KTP
            $fileKtp = $_FILES['foto_ktp'] ?? null;
            $ktpSudahAda = !empty($currentUser['foto_ktp']);
            
            if ($fileKtp && $fileKtp['error'] === UPLOAD_ERR_OK) {
                if (!in_array($fileKtp['type'], $allowedTypes)) {
                    $pesanError[] = "Format file KTP harus berupa JPG atau PNG.";
                } elseif ($fileKtp['size'] > $maxSize) {
                    $pesanError[] = "Ukuran file KTP terlalu besar (Maksimal 2MB).";
                }
            } elseif (!$ktpSudahAda) {
                $pesanError[] = "Anda wajib melampirkan foto KTP.";
            }

            // Cek Foto SIM
            $fileSim = $_FILES['foto_sim'] ?? null;
            $simSudahAda = !empty($currentUser['foto_sim']);
            
            if ($fileSim && $fileSim['error'] === UPLOAD_ERR_OK) {
                if (!in_array($fileSim['type'], $allowedTypes)) {
                    $pesanError[] = "Format file SIM harus berupa JPG atau PNG.";
                } elseif ($fileSim['size'] > $maxSize) {
                    $pesanError[] = "Ukuran file SIM terlalu besar (Maksimal 2MB).";
                }
            } elseif (!$simSudahAda) {
                $pesanError[] = "Anda wajib melampirkan foto SIM A.";
            }

            // ==========================================
            // TAHAP 2: EKSEKUSI JIKA TIDAK ADA ERROR
            // ==========================================
            if (empty($pesanError)) {
                
                // 1. Simpan Teks (Alamat & HP)
                $dataUpdate = [
                    'nama_lengkap' => $_SESSION['nama_lengkap'],
                    'nomor_hp'     => $nomorHp,
                    'alamat'       => $alamat
                ];
                $userModel->update($userId, $dataUpdate);

                // 2. Simpan File KTP (Jika ada yang diunggah)
                if ($fileKtp && $fileKtp['error'] === UPLOAD_ERR_OK) {
                    $ekstensi = pathinfo($fileKtp['name'], PATHINFO_EXTENSION);
                    $namaFileKtp = uniqid('ktp_') . '.' . $ekstensi;
                    if (move_uploaded_file($fileKtp['tmp_name'], UPLOAD_KTP_SIM . $namaFileKtp)) {
                        $userModel->updateFotoKtp($userId, $namaFileKtp);
                    }
                }

                // 3. Simpan File SIM (Jika ada yang diunggah)
                if ($fileSim && $fileSim['error'] === UPLOAD_ERR_OK) {
                    $ekstensi = pathinfo($fileSim['name'], PATHINFO_EXTENSION);
                    $namaFileSim = uniqid('sim_') . '.' . $ekstensi;
                    if (move_uploaded_file($fileSim['tmp_name'], UPLOAD_KTP_SIM . $namaFileSim)) {
                        $userModel->updateFotoSim($userId, $namaFileSim);
                    }
                }

                $pesanSukses[] = "Profil dan dokumen Anda berhasil diperbarui.";
                $_SESSION['flash_sukses'] = $pesanSukses;
            } else {
                // Jika ada error, masukkan array $pesanError ke session
                $_SESSION['flash_error'] = $pesanError;
            }

            // Kembali ke halaman profil
            header('Location: /profile');
            exit;
        }
    }
}