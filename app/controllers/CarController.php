<?php

class CarController extends Controller
{
    // =================================================================
    // AREA PUBLIK (Katalog Pengunjung)
    // =================================================================

    public function index()
    {
        $data['judul'] = 'Katalog Mobil - ' . APP_NAME;
        
        // Memanggil fungsi getAvailable() dari CarModel (hanya yang berstatus 'Tersedia')
        $data['mobil'] = $this->model('CarModel')->getAvailable();

        // Mengirim data ke halaman view public/katalog buatan Anggota 2
        $this->view('public/katalog', $data);
    }

    // =================================================================
    // AREA ADMIN (Manajemen Inventaris)
    // =================================================================

    public function kelola()
    {
        // Proteksi Middleware: Mencegah tamu atau customer mengakses halaman ini
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $data['judul'] = 'Kelola Mobil - Admin';
        
        // Memanggil fungsi getAll() karena admin perlu melihat SEMUA mobil (termasuk yang sedang disewa)
        $data['mobil'] = $this->model('CarModel')->getAll();

        // Mengirim data ke halaman view admin/kelola_mobil
        $this->view('admin/kelola_mobil', $data);
    }

    public function tambah()
    {
        // Proteksi ganda di tahap pemrosesan data
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        // Pastikan hanya merespons jika ada pengiriman form (POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Tangkap data teks dari form
            $dataMobil = [
                'merk'           => $_POST['merk'],
                'tipe'           => $_POST['tipe'],
                'transmisi'      => $_POST['transmisi'],
                'kapasitas'      => $_POST['kapasitas'],
                'harga_per_hari' => $_POST['harga_per_hari'],
                'deskripsi'      => $_POST['deskripsi'] ?? null,
                'status'         => $_POST['status'] ?? 'Tersedia',
                'foto'           => null // Nilai default jika admin tidak mengunggah foto
            ];

            // 2. Logika Pemrosesan File Gambar
            // Mengecek apakah ada file yang diunggah dan tidak ada error saat proses HTTP upload
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                
                $namaAsli   = $_FILES['foto']['name'];
                $ukuranFile = $_FILES['foto']['size'];
                $tipeMime   = $_FILES['foto']['type'];
                $tmpName    = $_FILES['foto']['tmp_name']; // Lokasi file di memori sementara server

                // Validasi 1: Cek apakah tipe file dan ukurannya sesuai dengan aturan di config.php
                if (in_array($tipeMime, UPLOAD_ALLOWED_TYPES) && $ukuranFile <= UPLOAD_MAX_SIZE) {
                    
                    // Ambil ekstensi asli (misal: .jpg atau .png)
                    $ekstensi = pathinfo($namaAsli, PATHINFO_EXTENSION);
                    
                    // Generate nama file unik (Contoh hasil: car_64abc123.jpg)
                    // Ini mencegah gambar dengan nama yang sama saling menimpa
                    $namaFileBaru = uniqid('car_') . '.' . $ekstensi;

                    // Validasi 2: Eksekusi pemindahan file secara fisik
                    if (move_uploaded_file($tmpName, UPLOAD_MOBIL . $namaFileBaru)) {
                        $dataMobil['foto'] = $namaFileBaru; // Masukkan nama file baru ke dalam array untuk disimpan di DB
                    } else {
                        echo "<script>alert('Sistem gagal memindahkan file gambar!'); window.location.href='".BASEURL."/car/kelola';</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Gagal! Format harus JPG/PNG dan maksimal ukuran 2MB.'); window.location.href='".BASEURL."/car/kelola';</script>";
                    exit;
                }
            }

            // 3. Simpan seluruh data (teks + nama file) ke database Supabase
            if ($this->model('CarModel')->create($dataMobil)) {
                echo "<script>alert('Sukses! Data armada mobil berhasil ditambahkan.'); window.location.href='".BASEURL."/car/kelola';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan database saat menyimpan data.'); window.location.href='".BASEURL."/car/kelola';</script>";
            }
            exit;
        }
    }

    // Fungsi singkat untuk menghapus mobil
    public function hapus($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            // Opsional: Kamu bisa menambahkan fungsi untuk menghapus file fisik gambar di folder uploads di sini menggunakan unlink()
            
            $this->model('CarModel')->delete($id);
            echo "<script>alert('Data mobil dihapus!'); window.location.href='".BASEURL."/car/kelola';</script>";
        }
    }
}