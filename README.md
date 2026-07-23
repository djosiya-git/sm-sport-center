# SM Sport Center — Laravel 12

Sistem reservasi web untuk 2 lapangan futsal dan 3 lapangan badminton. Fitur utama: login admin/pelanggan, dashboard, CRUD lapangan, CRUD pelanggan, CRUD reservasi, pencarian, pagination, validasi jadwal bentrok, laporan periode, transaksi database, role middleware, seeder, dan feature test login.

## Persyaratan
- PHP 8.2+
- Composer 2
- MySQL/MariaDB
- Ekstensi PHP: pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo

## Instalasi lokal
```bash
composer install
cp .env.example .env
php artisan key:generate
```
Buat database `sm_sport_center`, atur `.env`, kemudian:
```bash
php artisan migrate --seed
php artisan serve
```

## Akun demo
- Admin: `admin@smsport.test` / `admin12345`
- Pelanggan: `pelanggan@smsport.test` / `pelanggan123`

## Upload GitHub
Folder `vendor`, `.env`, cache, dan log sudah masuk `.gitignore`.
```bash
git init
git add .
git commit -m "Initial SM Sport Center reservation system"
git branch -M main
git remote add origin URL_REPOSITORY_GITHUB
git push -u origin main
```

## Hosting pada subdomain cPanel
1. Buat subdomain, misalnya `sport.domainanda.com`.
2. Ideal: document root diarahkan ke folder `sm-sport-center/public`.
3. Upload source code di luar `public_html`, misalnya `/home/username/sm-sport-center`.
4. Jalankan `composer install --no-dev --optimize-autoloader` lewat Terminal/SSH cPanel.
5. Buat `.env` production dan database MySQL dari cPanel.
6. Jalankan `php artisan key:generate`, `php artisan migrate --seed --force`.
7. Jalankan `php artisan storage:link`.
8. Set permission `storage` dan `bootstrap/cache` menjadi writable.
9. Jalankan optimasi:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
10. Set `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL=https://sport.domainanda.com`.

Jika hosting tidak mengizinkan document root ke `/public`, baca `docs/PANDUAN-HOSTING-CPANEL.md`.

## Pengujian
```bash
php artisan test
```

## Bukti skenario sertifikasi
Dokumen bukti tersedia pada folder `docs/`.

- `docs/INDEX-BUKTI-SKENARIO.md`
- `docs/LAPORAN-TUGAS-SM-SPORT-CENTER-v2.pdf`
- `docs/LAPORAN-TUGAS-SM-SPORT-CENTER.md`
- `docs/ANALISIS-KEBUTUHAN.md`
- `docs/ANALISIS-SKALABILITAS.md`
- `docs/ERD-DAN-SQL.md`
- `docs/DOKUMENTASI-KODE-PROGRAM.md`
- `docs/LAPORAN-DEBUGGING.md`
- `docs/HASIL-PROFILING.md`
- `docs/DOKUMEN-TESTING.md`
- `docs/LAPORAN-INTEGRASI-TESTING.md`
- `docs/PERANCANGAN-DAN-DEMO.md`

## Catatan keamanan
Segera ubah password akun demo setelah deployment. Jangan pernah commit file `.env` ke GitHub.
