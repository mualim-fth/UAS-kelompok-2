<?php

class App
{
    // 1. Menetapkan Rute Default
    // Jika pengunjung hanya mengetik 'localhost/rental-mobil-mvc/', 
    // sistem otomatis memanggil HomeController dan fungsi index().
    protected $controller = 'HomeController'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // 2. SETUP CONTROLLER
        // Cek apakah file controller yang diketik di URL (indeks ke-0) benar-benar ada
        if (isset($url[0])) {
            // Ubah format: 'booking' menjadi 'BookingController'
            $controllerName = ucfirst($url[0]) . 'Controller';
            
            // Periksa di folder app/controllers/
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]); // Hapus nama controller dari array URL
            }
        }

        // Panggil file controllernya dan buat objek (instansiasi)
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 3. SETUP METHOD (Fungsi di dalam Controller)
        // Cek apakah ada nama fungsi yang diketik di URL (indeks ke-1)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]); // Hapus nama method dari array URL
            }
        }

        // 4. SETUP PARAMETER
        // Jika masih ada sisa array di URL (misal ID mobil atau ID booking), masukkan sebagai parameter
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 5. EKSEKUSI FINAL
        // Jalankan controller & method, serta kirimkan parameter jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi pemecah URL
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            // Hapus tanda slash (/) di akhir URL agar bersih
            $url = rtrim($_GET['url'], '/');
            
            // Filter URL dari karakter berbahaya (Keamanan dasar)
            $url = filter_var($url, FILTER_SANITIZE_URL);
            
            // Pecah URL berdasarkan slash (/) menjadi array
            $url = explode('/', $url);
            
            return $url;
        }
        return []; // Kembalikan array kosong jika tidak ada rute tambahan di URL
    }
}