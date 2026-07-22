# Hasil Profiling

## Tujuan
Profiling dilakukan untuk mengukur respons aplikasi, mengidentifikasi bagian yang berpotensi lambat, dan memberikan rekomendasi peningkatan performa.

## Lingkungan Pengukuran
```text
URL production: https://smsport.d-webindigital.web.id
Server: cPanel/LiteSpeed
PHP: 8.3
Database: MySQL/MariaDB
Tanggal pengukuran: 22 Juli 2026
Metode: curl time_total
```

## Hasil Pengukuran Respons
| Endpoint | Status HTTP | Waktu Respons |
|---|---:|---:|
| `/login` | 200 | 0.674 detik |
| `/register` | 200 | 0.191 detik |
| `/reservasi` tanpa login | 302 | 0.175 detik |

Halaman yang memerlukan login tidak diukur dengan browser automation pada sesi ini, tetapi alur production telah diuji melalui smoke test HTTP dan log Laravel.

## Bagian yang Berpotensi Lambat
1. Daftar reservasi: memuat relasi pelanggan dan lapangan, pencarian, filter tanggal, dan filter status.
2. Dashboard jadwal 24 jam: membuat matriks lapangan x jam dan membaca reservasi pada tanggal tertentu.
3. Laporan periode: agregasi jumlah reservasi, pendapatan, dan pengelompokan per lapangan.
4. Validasi jadwal bentrok: query overlap rentang waktu pada tabel reservasi.

## Optimasi yang Sudah Diterapkan
1. Eager loading relasi `pelanggan` dan `lapangan` untuk menghindari N+1 query.
2. Pagination pada daftar reservasi dan laporan.
3. Indeks `reservasi_jadwal_index` pada `lapangan_id`, `tanggal`, `jam_mulai`, `jam_selesai`.
4. Indeks `tanggal` dan `status_reservasi` untuk laporan/filter.
5. Cache production Laravel: `config:cache`, `route:cache`, dan `view:cache`.
6. Query validasi bentrok dibungkus transaksi dan `lockForUpdate()`.

## Rekomendasi Perbaikan
1. Tambahkan monitoring slow query MySQL untuk periode penggunaan nyata.
2. Gunakan Redis/file cache untuk statistik dashboard jika traffic meningkat.
3. Gunakan queue untuk export laporan atau notifikasi eksternal.
4. Batasi rentang tanggal laporan agar query agregasi tidak terlalu besar.
5. Tambahkan indexing tambahan jika query laporan menunjukkan bottleneck baru.
6. Gunakan backup database terjadwal dan rotasi log agar storage hosting tidak cepat penuh.
