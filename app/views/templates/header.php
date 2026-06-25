<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['judul']) ? $data['judul'] : 'Sistem Rental Mobil'; ?></title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="/public/assets/css/base.css">
    
<?php if (isset($css_halaman)) : ?>
        <link rel="stylesheet" href="/public/assets/css/<?= $css_halaman; ?>.css?v=<?= time(); ?>">
    <?php endif; ?>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="/home" class="navbar-brand">
            <i class="fas fa-car"></i> Rental Mobil
        </a>
        
        <ul class="nav-menu">
            <li><a href="/home">Beranda</a></li>
            <li><a href="/car">Katalog Mobil</a></li>
            
            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <li><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <?php else : ?>
                    <li><a href="/riwayat"><i class="fas fa-history"></i> Riwayat</a></li>
                    <li><a href="/profile"><i class="fas fa-user-circle"></i> Profil</a></li>
                <?php endif; ?>
                
                <li>
                    <a href="/logout" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            <?php else : ?>
                <li><a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="/register" class="btn btn-primary">Daftar</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main>