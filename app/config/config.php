<?php
define('BASEURL', 'http://localhost/UAS-kelompok-2/public');

// --- Konfigurasi Database Lokal (XAMPP MySQL) ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'rental_mobil');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', '3306'); 
// ------------------------------------------------

define('UPLOAD_PATH',     $_SERVER['DOCUMENT_ROOT'] . '/rental-mobil-mvc/public/uploads/');
define('UPLOAD_KTP_SIM',  UPLOAD_PATH . 'ktp_sim/');
define('UPLOAD_MOBIL',    UPLOAD_PATH . 'mobil/');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2 MB
define('UPLOAD_ALLOWED_TYPES', ['image/jpeg', 'image/jpg', 'image/png']);

define('APP_NAME', 'Rental Mobil');
define('APP_VERSION', '1.0.0');