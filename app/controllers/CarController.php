<?php

class CarController
{
    // =================================================================
    // AREA PUBLIK (Katalog Pengunjung)
    // =================================================================

    public function index()
    {
        $data['judul'] = 'Katalog Mobil - ' . APP_NAME;
        
        require_once __DIR__ . '/../models/CarModel.php';
        $carModel = new CarModel();
        
        $data['mobil'] = $carModel->getAvailable();

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

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        require_once __DIR__ . '/../models/CarModel.php';
        require_once __DIR__ . '/../models/BookingModel.php';
        require_once __DIR__ . '/../models/UserModel.php';

        $carModel = new CarModel();
        $bookingModel = new BookingModel();
        $userModel = new UserModel();

        $semuaMobil = $carModel->getAll();
        $total_mobil = count($semuaMobil);

        $semuaBooking = $bookingModel->getAll();
        $total_pending = 0;
        foreach ($semuaBooking as $booking) {
            if ($booking['status'] === 'Pending') {
                $total_pending++;
            }
        }

        $semuaUser = $userModel->getAll();
        $total_users = 0;
        foreach ($semuaUser as $user) {
            if ($user['role'] === 'customer') {
                $total_users++;
            }
        }

        $data['judul']         = 'Dashboard Admin - ' . APP_NAME;
        $data['total_mobil']   = $total_mobil;
        $data['total_pending'] = $total_pending;
        $data['total_users']   = $total_users;

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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $errors = [];

            $merk           = trim($_POST['merk'] ?? '');
            $tipe           = trim($_POST['tipe'] ?? '');
            $transmisi      = $_POST['transmisi'] ?? '';
            $kapasitas      = $_POST['kapasitas'] ?? '';
            $harga_per_hari = $_POST['harga_per_hari'] ?? '';
            $status         = $_POST['status'] ?? '';
            $deskripsi      = trim($_POST['deskripsi'] ?? '');

            if ($merk === '') {
                $errors['merk'] = 'Form Merk Mobil tidak boleh kosong!';
            }
            if ($tipe === '') {
                $errors['tipe'] = 'Form Tipe / Model tidak boleh kosong!';
            }

            if ($kapasitas === '') {
                $errors['kapasitas'] = 'Form Kapasitas Penumpang tidak boleh kosong!';
            } elseif (!is_numeric($kapasitas)) {
                $errors['kapasitas'] = 'Form Kapasitas harus diisi dengan angka!';
            } elseif ((int)$kapasitas < 1) {
                $errors['kapasitas'] = 'Angka tidak boleh minus atau nol!';
            }

            if ($harga_per_hari === '') {
                $errors['harga_per_hari'] = 'Form Harga Sewa per Hari tidak boleh kosong!';
            } elseif (!is_numeric($harga_per_hari)) {
                $errors['harga_per_hari'] = 'Form Harga Sewa harus diisi dengan angka!';
            } elseif ((float)$harga_per_hari < 1) {
                $errors['harga_per_hari'] = 'Angka tidak boleh minus atau nol!';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: /edit_mobil/" . $id);
                exit;
            }

            $mobilLama = $carModel->getById($id);
            $fotoFinal = $mobilLama['foto']; 

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $namaAsli   = $_FILES['foto']['name'];
                $ukuranFile = $_FILES['foto']['size'];
                $tipeMime   = $_FILES['foto']['type'];
                $tmpName    = $_FILES['foto']['tmp_name'];

                if (in_array($tipeMime, UPLOAD_ALLOWED_TYPES) && $ukuranFile <= UPLOAD_MAX_SIZE) {
                    $ekstensi = pathinfo($namaAsli, PATHINFO_EXTENSION);
                    $namaFileBaru = uniqid('car_') . '.' . $ekstensi;

                    if (move_uploaded_file($tmpName, UPLOAD_MOBIL . $namaFileBaru)) {
                        $fotoFinal = $namaFileBaru; 
                    } else {
                        $_SESSION['errors']['foto'] = 'Sistem gagal memindahkan file gambar ke server!';
                        header("Location: /edit_mobil/" . $id);
                        exit;
                    }
                } else {
                    $_SESSION['errors']['foto'] = 'Format harus JPG/PNG dan ukuran maksimal 2MB!';
                    header("Location: /edit_mobil/" . $id);
                    exit;
                }
            }

            $dataMobil = [
                'merk'           => $merk,
                'tipe'           => $tipe,
                'transmisi'      => $transmisi,
                'kapasitas'      => (int)$kapasitas,
                'harga_per_hari' => (float)$harga_per_hari,
                'deskripsi'      => $deskripsi ?: null,
                'status'         => $status,
                'foto'           => $fotoFinal 
            ];

            if ($carModel->update($id, $dataMobil)) {
                echo "<script>alert('Data mobil berhasil diperbarui!'); window.location.href='/kelola_mobil';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data.'); window.history.back();</script>";
            }
            exit;
        }

        $mobil = $carModel->getById($id);
        if (!$mobil) {
            echo "<script>alert('Data mobil tidak ditemukan!'); window.location.href='/kelola_mobil';</script>";
            exit;
        }

        $data['errors'] = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        $data['judul'] = 'Edit Mobil - Admin';
        $data['mobil'] = $mobil;
        include __DIR__ . '/../views/admin/edit_mobil.php';
    }

}