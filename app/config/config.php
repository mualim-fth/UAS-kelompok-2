<?php
define('BASEURL', 'http://localhost/rental-mobil-mvc/public');

define('DB_HOST', 'db.gomjmzudsrcdtycumeiu.supabase.co');
define('DB_NAME', 'postgres');
define('DB_USER', 'postgres');
define('DB_PASS', 'databaserental_123');
define('DB_PORT', '5432');

define('UPLOAD_PATH',     $_SERVER['DOCUMENT_ROOT'] . '/rental-mobil-mvc/public/uploads/');
define('UPLOAD_KTP_SIM',  UPLOAD_PATH . 'ktp_sim/');
define('UPLOAD_MOBIL',    UPLOAD_PATH . 'mobil/');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2 MB
define('UPLOAD_ALLOWED_TYPES', ['image/jpeg', 'image/jpg', 'image/png']);

define('APP_NAME', 'Rental Mobil');
define('APP_VERSION', '1.0.0');