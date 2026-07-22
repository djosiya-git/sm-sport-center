# Hasil Perancangan Perangkat Lunak dan Demonstrasi Sistem

## Perancangan Sistem
Sistem dirancang sebagai aplikasi web Laravel yang berjalan pada PHP 8.2+ dan MySQL/MariaDB. Aplikasi dibagi menjadi modul autentikasi, dashboard, master data, reservasi, laporan, dan struk.

## Alur Pengguna Pelanggan
1. Pelanggan membuka halaman login atau register.
2. Pelanggan membuat akun jika belum memiliki akun.
3. Pelanggan melihat dashboard ketersediaan lapangan.
4. Pelanggan memilih slot kosong.
5. Sistem membuka form reservasi dengan lapangan, tanggal, dan jam terisi otomatis.
6. Pelanggan menyimpan reservasi dengan DP minimal Rp50.000.
7. Pelanggan dapat melihat daftar reservasi dan struk.

## Alur Pengguna Admin
1. Admin login.
2. Admin melihat notifikasi reservasi baru berstatus menunggu.
3. Admin membuka Data Reservasi.
4. Admin mengubah status reservasi menjadi dikonfirmasi, selesai, atau dibatalkan.
5. Admin mengubah status pembayaran menjadi DP/sebagian atau lunas.
6. Admin mencetak struk.
7. Admin melihat laporan periode.

## Fitur Demonstrasi
1. Login benar dan login salah.
2. Registrasi pelanggan.
3. Dashboard jadwal 24 jam.
4. Klik slot kosong untuk membuat reservasi.
5. Validasi jadwal bentrok.
6. Status reservasi dan pembayaran.
7. Notifikasi reservasi baru untuk admin.
8. Struk reservasi.
9. Laporan periode.

## URL Production
```text
https://smsport.d-webindigital.web.id
```

## Akun Demo
```text
Admin: admin@smsport.test / admin12345
Pelanggan: pelanggan@smsport.test / pelanggan123
```

## Bukti Source Code
Source code tersimpan pada repository:

```text
https://github.com/djosiya-git/sm-sport-center.git
```
