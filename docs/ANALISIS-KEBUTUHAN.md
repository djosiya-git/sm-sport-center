# Analisis Kebutuhan Sistem

## Ringkasan Masalah
SM Sport Center memiliki 2 lapangan futsal dan 3 lapangan badminton. Proses reservasi manual melalui telepon dan WhatsApp menimbulkan risiko jadwal bentrok, kesalahan pencatatan transaksi, kesulitan membuat laporan, dan pelanggan/admin sulit mengetahui ketersediaan lapangan.

## Aktor
1. Admin: mengelola data lapangan, pelanggan, reservasi, status reservasi, status pembayaran, laporan, dan struk.
2. Pelanggan: registrasi, login, melihat jadwal, membuat reservasi, melihat data reservasinya, dan mencetak struk.

## Kebutuhan Fungsional
1. Sistem menyediakan login dan registrasi pelanggan.
2. Admin dapat mengelola master lapangan dan pelanggan.
3. Pelanggan dan admin dapat membuat reservasi dengan memilih lapangan, tanggal, jam mulai, dan jam selesai.
4. Sistem menolak reservasi jika rentang jadwal bentrok dengan reservasi aktif.
5. Sistem menampilkan dashboard ketersediaan lapangan per tanggal selama 24 jam.
6. Admin dapat mengubah status reservasi: menunggu, dikonfirmasi, selesai, dibatalkan.
7. Sistem mencatat DP minimal Rp50.000 dan status pembayaran: DP/sebagian atau lunas.
8. Admin dapat membuat laporan reservasi berdasarkan periode.
9. Sistem menyediakan struk reservasi yang dapat dicetak.
10. Sistem menyediakan pencarian dan pagination daftar reservasi.

## Kebutuhan Non Fungsional
1. Keamanan: akses admin dan pelanggan dipisahkan menggunakan role middleware.
2. Keandalan: proses simpan reservasi menggunakan transaksi database dan locking.
3. Performa: daftar data memakai pagination dan eager loading untuk mengurangi N+1 query.
4. Skalabilitas: tabel reservasi memiliki indeks gabungan untuk pengecekan jadwal.
5. Usability: dashboard menampilkan status kosong/terisi secara visual dan dapat difilter tanggal.
6. Maintainability: source code menggunakan pola MVC Laravel.
7. Deployability: aplikasi dapat dipasang di shared hosting cPanel dengan PHP 8.2+ dan MySQL/MariaDB.

## Batasan Sistem
1. Pembayaran dicatat sebagai status manual oleh admin, belum terhubung payment gateway.
2. Notifikasi admin berupa badge dan banner dalam aplikasi, belum melalui email/WhatsApp.
3. Struk tersedia sebagai halaman print, belum berupa file PDF otomatis.
