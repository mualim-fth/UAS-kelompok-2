# 🚗 Aplikasi Manajemen Rental Mobil (MVC Architecture)

Aplikasi berbasis web untuk manajemen penyewaan armada mobil dan validasi identitas pelanggan. Proyek ini dikembangkan dari awal (scratch) menggunakan arsitektur **MVC (Model-View-Controller)** murni dengan bahasa pemrograman PHP Native dan basis data PostgreSQL (Supabase).

Tugas ini disusun untuk memenuhi evaluasi proyek pengembangan perangkat lunak pada Program Studi Sistem Informasi Universitas Dian Nuswantoro.

---

## 🛠️ Teknologi yang Digunakan
* **Backend:** PHP 8.x (Native OOP & MVC Pattern)
* **Database:** PostgreSQL (Hosted on Supabase cloud)
* **Frontend:** HTML5, CSS3, Bootstrap 4, JavaScript
* **Keamanan:** PDO Prepared Statements (Anti SQL Injection), Password Hashing (Bcrypt), URL Routing Protection.

---

## ⚙️ Persyaratan Sistem (Prerequisites)
Sebelum menjalankan aplikasi ini di localhost, pastikan komputer/server dosen penguji telah memenuhi spesifikasi berikut:
1. **XAMPP / Laragon** dengan versi PHP minimal 7.4 (Direkomendasikan PHP 8.x).
2. **Ekstensi PostgreSQL aktif:** Buka file `php.ini` pada konfigurasi PHP Anda, lalu pastikan baris `extension=pdo_pgsql` dan `extension=pgsql` tidak dikomentari (hilangkan tanda `;` di depannya).
3. Koneksi internet aktif (karena aplikasi terhubung langsung ke *database cloud* Supabase).

---

## 🚀 Panduan Instalasi (Langkah Pengujian)

1. **Unduh Proyek:**
   Clone repositori ini atau ekstrak file `.zip` ke dalam direktori server lokal Anda (contoh: `C:\xampp\htdocs\rental-mobil-mvc`).

2. **Pengecekan Folder Manajemen File:**
   [cite_start]Pastikan folder berikut tersedia di dalam direktori `public/` untuk menampung unggahan gambar secara dinamis[cite: 138, 139, 140]:
   * `public/uploads/mobil/` 
   * `public/uploads/ktp_sim/`

3. **Konfigurasi Database:**
   [cite_start]Secara default, aplikasi sudah terhubung ke *cloud database* Supabase milik kelompok kami melalui file `app/config/config.php`[cite: 89, 150]. Dosen **tidak perlu** mengimpor file `.sql` secara manual ke phpMyAdmin/pgAdmin. 
   [cite_start]*(Namun, kami tetap melampirkan file `database_rental.sql` di root direktori sebagai cadangan struktur fisik tabel [cite: 143, 149]).*

4. **Jalankan Aplikasi:**
   Buka web browser dan akses URL berikut:
   `http://localhost/rental-mobil-mvc/`

---

## 🔐 Kredensial Login Default (Untuk Pengujian)

Untuk memudahkan pengujian fitur *dashboard*, manajemen armada, dan validasi pesanan, silakan gunakan akun Administrator berikut:

* **URL Login:** `http://localhost/rental-mobil-mvc/auth`
* **Email:** `admin@rentalmobil.com`
* **Password:** `admin123`

[cite_start]Untuk pengujian jalur pelanggan (*customer flow*), dosen dapat melakukan registrasi akun baru melalui halaman pendaftaran[cite: 59].

---

## 👥 Pembagian Tugas & Peran Tim
[cite_start]Proyek ini dibangun secara kolaboratif dengan pemisahan fokus (*Separation of Concerns*) sebagai berikut[cite: 145]:

* [cite_start]**Anggota 1 (Data Architect & Admin Interface):** Bertanggung jawab atas perancangan DDL Database, Class Wrapper PDO, pembuatan seluruh sistem Model, dan tata letak dasbor Administrator[cite: 146, 147, 148].
* [cite_start]**Anggota 2 (Frontend & Customer Experience):** Bertanggung jawab merancang antarmuka publik (Katalog), UI/UX formulir pendaftaran, kalender pemesanan, dan pengelolaan aset statis (CSS/JS)[cite: 158, 159, 160].
* [cite_start]**Anggota 3 (Core Logic, System Routing & Integrator):** Bertanggung jawab merakit sistem *Routing* utama (`App.php`), *Front Controller* (`.htaccess`), logika validasi *Controller* (termasuk upload file), dan integrasi keamanan antar modul[cite: 172, 173, 174].

---
*Dibuat dengan ☕ dan dedikasi penuh untuk evaluasi akhir semester.*