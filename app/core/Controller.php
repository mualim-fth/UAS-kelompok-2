<?php

class Controller
{
    /**
     * Fungsi untuk memanggil dan merender antarmuka (View)
     * Mengambil file dari folder app/views/
     * * @param string $view Nama file view (contoh: 'admin/dashboard')
     * @param array $data Data dinamis yang akan dikirim ke view
     */
    public function view($view, $data = [])
    {
        // Mengecek apakah file view fisik benar-benar ada
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // Hentikan eksekusi dan beri pesan error jika desain belum dibuat Anggota 2
            die("Error System: File View '" . $view . ".php' tidak ditemukan di folder app/views/");
        }
    }

    /**
     * Fungsi untuk memanggil dan menginstansiasi Model
     * Mengambil file dari folder app/models/
     * * @param string $model Nama file model (contoh: 'UserModel')
     * @return object Instansiasi dari class Model
     */
    public function model($model)
    {
        // Mengecek apakah file model fisik benar-benar ada
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            // Mengembalikan objek baru dari class model yang dipanggil
            return new $model;
        } else {
            // Hentikan eksekusi jika Anggota 1 belum membuat file Model-nya
            die("Error System: File Model '" . $model . ".php' tidak ditemukan di folder app/models/");
        }
    }
}