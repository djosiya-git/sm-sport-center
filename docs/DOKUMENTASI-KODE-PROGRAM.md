# Dokumentasi Kode Program

## Arsitektur
Aplikasi menggunakan framework Laravel dengan pola MVC:

1. Model: representasi tabel database dan relasi.
2. View: tampilan Blade untuk login, dashboard, reservasi, laporan, pelanggan, dan lapangan.
3. Controller: penghubung request, validasi, proses bisnis, dan response.
4. Middleware: pembatasan akses berdasarkan role.

## Modul Autentikasi
File utama:

```text
app/Http/Controllers/AuthController.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
```

Fungsi:
1. Menampilkan login dan register.
2. Memvalidasi credential.
3. Membuat akun pelanggan baru.
4. Membuat profil pelanggan otomatis saat registrasi.
5. Logout dan invalidasi session.

## Modul Dashboard
File utama:

```text
app/Http/Controllers/DashboardController.php
resources/views/dashboard.blade.php
```

Fungsi:
1. Menampilkan statistik jumlah lapangan, pelanggan, reservasi hari ini, dan pendapatan bulan ini.
2. Menampilkan jadwal 24 jam per lapangan berdasarkan tanggal.
3. Memberi link slot kosong ke form tambah reservasi.

## Modul Reservasi
File utama:

```text
app/Http/Controllers/ReservasiController.php
app/Models/Reservasi.php
resources/views/reservasi/
```

Fungsi:
1. Menampilkan daftar reservasi dengan pencarian, filter tanggal, dan filter status.
2. Menambah, mengedit, dan menghapus reservasi.
3. Memvalidasi tanggal, jam, lapangan, DP minimal Rp50.000, dan status pembayaran.
4. Mencegah jadwal bentrok menggunakan rumus overlap:

```text
jam_mulai_baru < jam_selesai_lama
jam_selesai_baru > jam_mulai_lama
```

5. Menggunakan transaksi database dan `lockForUpdate()` untuk mengurangi risiko race condition.
6. Mengubah status reservasi dan status pembayaran oleh admin.
7. Membuat halaman struk reservasi yang dapat dicetak.

## Modul Master Data
File utama:

```text
app/Http/Controllers/LapanganController.php
app/Http/Controllers/PelangganController.php
resources/views/lapangan/
resources/views/pelanggan/
```

Fungsi:
1. CRUD data lapangan.
2. CRUD data pelanggan.
3. Membuat akun login pelanggan saat admin menambah pelanggan.

## Modul Laporan
File utama:

```text
app/Http/Controllers/LaporanController.php
resources/views/laporan/index.blade.php
```

Fungsi:
1. Menampilkan laporan periode.
2. Menghitung total reservasi.
3. Menghitung total pendapatan dari reservasi lunas.
4. Mengelompokkan reservasi per lapangan.

## Middleware Role
File utama:

```text
app/Http/Middleware/RoleMiddleware.php
bootstrap/app.php
```

Fungsi:
1. Membatasi menu dan route admin.
2. Mengembalikan HTTP 403 jika role pengguna tidak sesuai.

## Struktur Database
Struktur lengkap tersedia di:

```text
database/migrations/
database/sm_sport_center.sql
docs/ERD-DAN-SQL.md
```
