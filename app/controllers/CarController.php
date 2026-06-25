<?php

// Tidak ada lagi "extends Controller"
class CarController
{
    // =================================================================
    // AREA PUBLIK (Katalog Pengunjung)
    // =================================================================

    public function index()
    {
        $data['judul'] = 'Katalog Mobil - ' . APP_NAME;
        
        // Memanggil file Model secara manual
        require_once __DIR__ . '/../models/CarModel.php';
        $carModel = new CarModel();
        
        $data['mobil'] = $carModel->getAvailable();

        // Mengirim data ke halaman view menggunakan include
        include __DIR__ . '/../views/public/katalog.php';
    }

    public function detail($id = null)
    {
        if ($id === null) {
            header('Location: /car');
            exit;
        }

        require_once __DIR__ . '/../models/CarModel.php';
        $carModel = new CarModel();
        $mobil = $carModel->getById($id);

        if (!$mobil) {
            echo "<script>alert('Data mobil tidak ditemukan!'); window.location.href='/car';</script>";
            exit;
        }

        $data['judul'] = $mobil['merk'] . ' ' . $mobil['tipe'] . ' - ' . APP_NAME;
        $data['mobil'] = $mobil;

        include __DIR__ . '/../views/public/detail_mobil.php';
    }


    // =================================================================
    // AREA ADMIN (Manajemen Inventaris)
    // =================================================================

    // FUNGSI BARU: Ditambahkan agar rute /dashboard di index.php tidak error
    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $data['judul'] = 'Dashboard Admin - ' . APP_NAME;
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function kelola()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $data['judul'] = 'Kelola Mobil - Admin';
        
        require_once __DIR__ . '/../models/CarModel.php';
        $carModel = new CarModel();
        $data['mobil'] = $carModel->getAll();

        include __DIR__ . '/../views/admin/kelola_mobil.php';
    }

    public function tambah()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $dataMobil = [
                'merk'           => $_POST['merk'],
                'tipe'           => $_POST['tipe'],
                'transmisi'      => $_POST['transmisi'],
                'kapasitas'      => $_POST['kapasitas'],
                'harga_per_hari' => $_POST['harga_per_hari'],
                'deskripsi'      => $_POST['deskripsi'] ?? null,
                'status'         => $_POST['status'] ?? 'Tersedia',
                'foto'           => null 
            ];

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                
                $namaAsli   = $_FILES['foto']['name'];
                $ukuranFile = $_FILES['foto']['size'];
                $tipeMime   = $_FILES['foto']['type'];
                $tmpName    = $_FILES['foto']['tmp_name'];

                if (in_array($tipeMime, UPLOAD_ALLOWED_TYPES) && $ukuranFile <= UPLOAD_MAX_SIZE) {
                    
                    $ekstensi = pathinfo($namaAsli, PATHINFO_EXTENSION);
                    $namaFileBaru = uniqid('car_') . '.' . $ekstensi;

                    if (move_uploaded_file($tmpName, UPLOAD_MOBIL . $namaFileBaru)) {
                        $dataMobil['foto'] = $namaFileBaru; 
                    } else {
                        echo "<script>alert('Sistem gagal memindahkan file gambar!'); window.location.href='/kelola_mobil';</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Gagal! Format harus JPG/PNG dan maksimal ukuran 2MB.'); window.location.href='/kelola_mobil';</script>";
                    exit;
                }
            }

            require_once __DIR__ . '/../models/CarModel.php';
            $carModel = new CarModel();

            if ($carModel->create($dataMobil)) {
                echo "<script>alert('Sukses! Data armada mobil berhasil ditambahkan.'); window.location.href='/kelola_mobil';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan database saat menyimpan data.'); window.location.href='/kelola_mobil';</script>";
            }
            exit;
        }
    }

    public function hapus($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            require_once __DIR__ . '/../models/CarModel.php';
            $carModel = new CarModel();
            $carModel->delete($id);
            echo "<script>alert('Data mobil dihapus!'); window.location.href='/kelola_mobil';</script>";
        }
    }

public function edit($id = null)
    {
        // Proteksi Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        if ($id === null) {
            header('Location: /kelola_mobil');
            exit;
        }

        require_once __DIR__ . '/../models/CarModel.php';
        $carModel = new CarModel();

        // BLOK A: JIKA ADMIN MENYIMPAN PERUBAHAN (POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Ambil data mobil yang lama terlebih dahulu
            $mobilLama = $carModel->getById($id);
            $fotoFinal = $mobilLama['foto']; // Default: gunakan foto lama

            // 2. Cek apakah admin mengunggah foto BARU
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $namaAsli   = $_FILES['foto']['name'];
                $ukuranFile = $_FILES['foto']['size'];
                $tipeMime   = $_FILES['foto']['type'];
                $tmpName    = $_FILES['foto']['tmp_name'];

                if (in_array($tipeMime, UPLOAD_ALLOWED_TYPES) && $ukuranFile <= UPLOAD_MAX_SIZE) {
                    $ekstensi = pathinfo($namaAsli, PATHINFO_EXTENSION);
                    $namaFileBaru = uniqid('car_') . '.' . $ekstensi;

                    // Jika berhasil pindah file, ganti variabel fotoFinal dengan yang baru
                    if (move_uploaded_file($tmpName, UPLOAD_MOBIL . $namaFileBaru)) {
                        $fotoFinal = $namaFileBaru; 
                    } else {
                        echo "<script>alert('Gagal memindahkan file gambar!'); window.history.back();</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Gagal! Format harus JPG/PNG dan maksimal 2MB.'); window.history.back();</script>";
                    exit;
                }
            }

            // 3. Gabungkan seluruh data (termasuk fotoFinal yang sudah valid)
            $dataMobil = [
                'merk'           => $_POST['merk'],
                'tipe'           => $_POST['tipe'],
                'transmisi'      => $_POST['transmisi'],
                'kapasitas'      => $_POST['kapasitas'],
                'harga_per_hari' => $_POST['harga_per_hari'],
                'deskripsi'      => $_POST['deskripsi'] ?? null,
                'status'         => $_POST['status'] ?? 'Tersedia',
                'foto'           => $fotoFinal // Kunci 'foto' sekarang dipastikan selalu ada!
            ];

            // 4. Simpan perubahan ke database
            if ($carModel->update($id, $dataMobil)) {
                echo "<script>alert('Data mobil berhasil diperbarui!'); window.location.href='/kelola_mobil';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data.'); window.history.back();</script>";
            }
            exit;
        }

        // BLOK B: JIKA ADMIN HANYA MEMBUKA HALAMAN (GET)
        $mobil = $carModel->getById($id);
        if (!$mobil) {
            echo "<script>alert('Data mobil tidak ditemukan!'); window.location.href='/kelola_mobil';</script>";
            exit;
        }

        $data['judul'] = 'Edit Mobil - Admin';
        $data['mobil'] = $mobil;
        include __DIR__ . '/../views/admin/edit_mobil.php';
    }

}