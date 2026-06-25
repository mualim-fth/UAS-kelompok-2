<?php

class HomeController
{
    public function index()
    {
        // 1. Siapkan data judul (akan dibaca otomatis oleh header.php)
        $data['judul'] = 'Beranda - Rental Mobil';

        // 2. Panggil file desain halamannya secara langsung
        include __DIR__ . '/../views/public/home.php';
    }
}