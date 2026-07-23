# LAPORAN TUGAS

# PERANCANGAN SISTEM RESERVASI LAPANGAN OLAHRAGA PADA SM SPORT CENTER BERBASIS WEB

## Identitas Proyek

Nama aplikasi: SM Sport Center  
Jenis aplikasi: Sistem reservasi lapangan olahraga berbasis web  
Framework: Laravel 12  
Database: MySQL/MariaDB  
Repository: https://github.com/djosiya-git/sm-sport-center.git  
URL production: https://smsport.d-webindigital.web.id  

## Kata Pengantar

Laporan ini disusun sebagai bukti penyelesaian tugas perancangan dan implementasi sistem reservasi lapangan olahraga pada SM Sport Center berbasis web. Sistem ini dibuat untuk membantu proses reservasi lapangan futsal dan badminton agar lebih tertata, mengurangi risiko jadwal bentrok, memudahkan pencatatan transaksi, serta menyediakan laporan penggunaan lapangan.

Penyusunan laporan ini meliputi analisis kebutuhan, perancangan basis data, implementasi kode program, debugging, profiling, pengujian, serta hasil demonstrasi sistem. Dengan adanya sistem ini, pelanggan dapat melakukan reservasi secara mandiri dan admin dapat mengelola reservasi dengan lebih efektif.

## BAB I PENDAHULUAN

### 1.1 Latar Belakang

SM Sport Center memiliki 2 lapangan futsal dan 3 lapangan badminton. Sebelumnya proses reservasi dilakukan melalui telepon dan WhatsApp. Cara tersebut memiliki beberapa kendala, yaitu jadwal bentrok, kesalahan pencatatan transaksi, kesulitan membuat laporan penggunaan lapangan, dan sulit mengetahui lapangan yang masih tersedia.

Oleh karena itu diperlukan sistem reservasi berbasis web yang dapat digunakan oleh pelanggan dan admin. Sistem ini diharapkan dapat mengelola data lapangan, data pelanggan, reservasi, pembayaran DP, status reservasi, laporan, dan struk reservasi.

### 1.2 Rumusan Masalah

1. Bagaimana merancang sistem reservasi lapangan berbasis web untuk SM Sport Center?
2. Bagaimana mencegah terjadinya jadwal bentrok pada proses reservasi?
3. Bagaimana admin dapat memantau reservasi baru, status pembayaran, dan laporan penggunaan lapangan?
4. Bagaimana pelanggan dapat melihat jadwal lapangan dan melakukan reservasi secara mandiri?

### 1.3 Tujuan

1. Membuat aplikasi reservasi lapangan olahraga berbasis web.
2. Menyediakan fitur login dan registrasi pelanggan.
3. Menyediakan dashboard ketersediaan lapangan selama 24 jam.
4. Menyediakan fitur tambah, lihat, edit, hapus, dan pencarian reservasi.
5. Menyediakan validasi jadwal bentrok.
6. Menyediakan pencatatan DP wajib minimal Rp50.000 dan status pembayaran.
7. Menyediakan laporan reservasi dan struk reservasi.

## BAB II ANALISIS KEBUTUHAN

### 2.1 Aktor Sistem

1. Admin
   Admin bertugas mengelola data lapangan, data pelanggan, data reservasi, status reservasi, status pembayaran, laporan, dan struk.

2. Pelanggan
   Pelanggan dapat registrasi, login, melihat jadwal lapangan, membuat reservasi, melihat data reservasinya, dan mencetak struk reservasi.

### 2.2 Kebutuhan Fungsional

1. Sistem menyediakan fitur login untuk admin dan pelanggan.
2. Sistem menyediakan fitur registrasi pelanggan baru.
3. Admin dapat mengelola data lapangan.
4. Admin dapat mengelola data pelanggan.
5. Admin dan pelanggan dapat membuat reservasi.
6. Sistem menolak reservasi jika jadwal bentrok.
7. Dashboard menampilkan jadwal lapangan selama 24 jam berdasarkan tanggal.
8. Admin mendapat notifikasi jika ada reservasi baru berstatus menunggu.
9. Admin dapat mengubah status reservasi menjadi menunggu, dikonfirmasi, selesai, atau dibatalkan.
10. Admin dapat mengubah status pembayaran menjadi DP/sebagian atau lunas.
11. Sistem menyediakan input DP wajib minimal Rp50.000.
12. Sistem menyediakan laporan periode.
13. Sistem menyediakan struk reservasi yang dapat dicetak.

### 2.3 Kebutuhan Non Fungsional

1. Keamanan
   Sistem memisahkan akses admin dan pelanggan menggunakan role middleware.

2. Keandalan
   Proses penyimpanan reservasi menggunakan transaksi database dan row locking.

3. Performa
   Daftar reservasi dan laporan menggunakan pagination. Relasi data dimuat menggunakan eager loading.

4. Skalabilitas
   Tabel reservasi memiliki indeks gabungan untuk mempercepat pengecekan jadwal.

5. Kemudahan Penggunaan
   Dashboard menampilkan slot kosong dan terisi secara visual. Pelanggan dapat memilih slot kosong langsung dari dashboard.

## BAB III PERANCANGAN SISTEM

### 3.1 Arsitektur Aplikasi

Aplikasi menggunakan framework Laravel dengan pola Model View Controller. Model digunakan untuk mengelola data dan relasi database. View digunakan untuk menampilkan antarmuka pengguna. Controller digunakan untuk mengatur validasi, proses bisnis, dan response aplikasi.

### 3.2 Entitas Database

Entitas utama sistem terdiri dari:

1. user
   Menyimpan akun login, email, password, dan role.

2. lapangan
   Menyimpan data lapangan futsal dan badminton.

3. pelanggan
   Menyimpan profil pelanggan.

4. reservasi
   Menyimpan transaksi reservasi, jadwal, total harga, DP, status reservasi, dan status pembayaran.

### 3.3 Relasi Database

Relasi database:

1. Satu user dapat memiliki satu data pelanggan.
2. Satu pelanggan dapat memiliki banyak reservasi.
3. Satu lapangan dapat memiliki banyak reservasi.

### 3.4 SQL Script

SQL script tersedia pada file:

database/sm_sport_center.sql

Script tersebut memuat pembuatan database, tabel utama, foreign key, indeks, data lapangan, admin, dan beberapa pelanggan.

## BAB IV IMPLEMENTASI SISTEM

### 4.1 Modul Autentikasi

Modul autentikasi menangani login, logout, dan registrasi pelanggan. Pelanggan baru yang melakukan registrasi otomatis dibuatkan akun dengan role pelanggan dan data profil pelanggan.

File utama:

app/Http/Controllers/AuthController.php  
resources/views/auth/login.blade.php  
resources/views/auth/register.blade.php  

### 4.2 Modul Dashboard

Dashboard menampilkan jumlah lapangan, jumlah pelanggan, reservasi hari ini, pendapatan bulan ini, dan jadwal 24 jam per lapangan. Slot kosong dapat diklik untuk membuka form tambah reservasi dengan data lapangan, tanggal, dan jam yang telah terisi.

File utama:

app/Http/Controllers/DashboardController.php  
resources/views/dashboard.blade.php  

### 4.3 Modul Reservasi

Modul reservasi menangani daftar reservasi, tambah, edit, hapus, struk, status reservasi, status pembayaran, dan validasi jadwal bentrok.

Validasi bentrok menggunakan rumus:

jam_mulai_baru < jam_selesai_lama  
jam_selesai_baru > jam_mulai_lama  

Reservasi berstatus dibatalkan tidak mengunci jadwal.

File utama:

app/Http/Controllers/ReservasiController.php  
resources/views/reservasi/index.blade.php  
resources/views/reservasi/form.blade.php  
resources/views/reservasi/receipt.blade.php  

### 4.4 Modul Laporan

Modul laporan menampilkan data reservasi berdasarkan periode, total reservasi, total pendapatan dari pembayaran lunas, dan rekap per lapangan.

File utama:

app/Http/Controllers/LaporanController.php  
resources/views/laporan/index.blade.php  

### 4.5 Modul Notifikasi Admin

Admin akan melihat badge dan banner notifikasi apabila terdapat reservasi baru dengan status menunggu. Setelah admin mengubah status reservasi menjadi dikonfirmasi, selesai, atau dibatalkan, jumlah notifikasi akan berkurang.

## BAB V DEBUGGING

### 5.1 Masalah

Terjadi kasus reservasi tetap tersimpan walaupun jadwal sudah terisi. Hal ini menyebabkan double booking pada lapangan yang sama.

### 5.2 Penyebab

Validasi awal hanya membandingkan jam mulai yang sama, sehingga reservasi dengan waktu saling tumpang tindih tetap dapat tersimpan.

Contoh:

Reservasi lama: 10.00 sampai 12.00  
Reservasi baru: 11.00 sampai 13.00  

Jika hanya membandingkan jam mulai, sistem tidak mendeteksi bentrok.

### 5.3 Perbaikan

Perbaikan dilakukan dengan rumus overlap:

jam mulai baru < jam selesai lama  
jam selesai baru > jam mulai lama  

Query validasi diletakkan di dalam transaksi database dan menggunakan lockForUpdate untuk mengurangi risiko race condition.

## BAB VI PROFILING DAN SKALABILITAS

### 6.1 Hasil Profiling

Pengukuran ringan production:

1. Halaman login: status 200, waktu respons 0.674 detik.
2. Halaman register: status 200, waktu respons 0.191 detik.
3. Halaman reservasi tanpa login: status 302, waktu respons 0.175 detik.

### 6.2 Potensi Bottleneck

1. Query daftar reservasi dengan pencarian relasi.
2. Dashboard jadwal 24 jam.
3. Laporan periode dengan agregasi data.
4. Validasi jadwal bentrok saat reservasi bersamaan.

### 6.3 Estimasi Pertumbuhan Data

Dengan 5 lapangan dan jam operasional 08.00 sampai 23.00, kapasitas teoritis adalah 75 reservasi per hari. Pada utilisasi 60 persen, estimasi reservasi adalah 45 reservasi per hari, 16.425 reservasi per tahun, 82.125 reservasi dalam 5 tahun, dan 164.250 reservasi dalam 10 tahun.

### 6.4 Rekomendasi Performa

1. Gunakan indeks pada kolom yang sering difilter.
2. Gunakan cache untuk statistik dashboard.
3. Gunakan queue untuk notifikasi dan export laporan.
4. Batasi rentang tanggal laporan.
5. Pantau slow query MySQL.
6. Lakukan backup database dan rotasi log secara berkala.

## BAB VII PENGUJIAN

### 7.1 Pengujian Unit

Pengujian otomatis tersedia pada:

tests/Feature/AuthTest.php  
tests/Feature/ReservasiTest.php  

Skenario yang diuji:

1. Login benar berhasil masuk dashboard.
2. Login salah menampilkan error.
3. Reservasi valid berhasil tersimpan.
4. Reservasi bentrok ditolak.

### 7.2 Pengujian Integrasi

Alur integrasi yang diuji:

Login -> Dashboard -> Pilih Slot -> Reservasi -> Simpan -> Ubah Status -> Struk -> Laporan

Hasil yang diharapkan adalah data reservasi tersimpan, status dapat diubah admin, struk dapat dicetak, dan data tampil pada laporan.

## BAB VIII DEPLOYMENT

### 8.1 Repository

Source code disimpan pada GitHub:

https://github.com/djosiya-git/sm-sport-center.git

### 8.2 Hosting

Aplikasi telah dipasang pada cPanel dengan akses SSH.

URL production:

https://smsport.d-webindigital.web.id

### 8.3 Konfigurasi Production

1. PHP 8.3 pada hosting.
2. MySQL/MariaDB sebagai database.
3. Source Laravel diletakkan di luar document root.
4. Document root diarahkan ke entry point yang memuat folder Laravel.
5. Config, route, dan view cache diaktifkan.

## BAB IX KESIMPULAN

Sistem reservasi lapangan SM Sport Center berbasis web telah berhasil dirancang dan diimplementasikan. Sistem menyediakan fitur login, registrasi pelanggan, dashboard jadwal 24 jam, reservasi, validasi bentrok, DP wajib, status pembayaran, status reservasi, notifikasi admin, struk, laporan, serta dokumen pendukung untuk kebutuhan asesmen.

Dengan sistem ini, proses reservasi menjadi lebih rapi, risiko double booking berkurang, pencatatan transaksi lebih jelas, dan manajemen dapat melihat laporan penggunaan lapangan secara lebih mudah.

## Lampiran

1. Analisis kebutuhan: docs/ANALISIS-KEBUTUHAN.md
2. Analisis skalabilitas: docs/ANALISIS-SKALABILITAS.md
3. ERD dan SQL: docs/ERD-DAN-SQL.md
4. SQL script: database/sm_sport_center.sql
5. Dokumentasi kode program: docs/DOKUMENTASI-KODE-PROGRAM.md
6. Laporan debugging: docs/LAPORAN-DEBUGGING.md
7. Hasil profiling: docs/HASIL-PROFILING.md
8. Dokumen testing: docs/DOKUMEN-TESTING.md
9. Laporan integrasi testing: docs/LAPORAN-INTEGRASI-TESTING.md
10. Perancangan dan demo: docs/PERANCANGAN-DAN-DEMO.md
