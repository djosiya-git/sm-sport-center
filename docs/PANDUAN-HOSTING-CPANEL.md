# Panduan Hosting cPanel dan Subdomain

## Struktur yang direkomendasikan
- Source Laravel: `/home/USERNAME/sm-sport-center`
- Document root subdomain: `/home/USERNAME/sm-sport-center/public`

Dengan struktur ini, `.env`, source controller, dan folder vendor tidak dapat diakses langsung dari browser.

## Jika document root subdomain tidak bisa diarahkan ke public
Salin isi folder `public` ke folder document root subdomain. Edit `index.php` di document root:
```php
require __DIR__.'/../../sm-sport-center/vendor/autoload.php';
$app = require_once __DIR__.'/../../sm-sport-center/bootstrap/app.php';
```
Jumlah `../` harus disesuaikan dengan posisi folder. Jangan memindahkan seluruh source Laravel ke folder publik.

## Cron opsional
Tambahkan cron setiap menit jika kelak menggunakan scheduler:
```bash
* * * * * cd /home/USERNAME/sm-sport-center && php artisan schedule:run >> /dev/null 2>&1
```
