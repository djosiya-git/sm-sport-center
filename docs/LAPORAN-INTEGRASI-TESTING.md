# Laporan Integrasi Testing

## Tujuan
Memastikan alur utama sistem berjalan dari login, pembuatan reservasi, penyimpanan data, hingga laporan admin.

## Lingkungan Uji
```text
Aplikasi: SM Sport Center Laravel
Database: MySQL/MariaDB
Server production: https://smsport.d-webindigital.web.id
Role uji: admin dan pelanggan
```

## Data Uji
```text
Admin: admin@smsport.test / admin12345
Pelanggan: pelanggan@smsport.test / pelanggan123
Lapangan: Lapangan Futsal 1
Tanggal: tanggal hari ini atau tanggal setelah hari ini
Jam: slot kosong pada dashboard
DP: 50000
```

## Skenario Integrasi
| No | Alur | Hasil Diharapkan | Status |
|---|---|---|---|
| 1 | Login admin | Masuk dashboard admin | Lulus |
| 2 | Buka dashboard dan pilih tanggal | Jadwal 24 jam per lapangan tampil | Lulus |
| 3 | Klik slot kosong | Form tambah reservasi terbuka dan terisi lapangan/tanggal/jam | Lulus |
| 4 | Isi pelanggan, DP, dan simpan | Reservasi tersimpan dengan status menunggu dan DP/sebagian | Lulus |
| 5 | Buka Data Reservasi | Data baru tampil dan mendapat highlight menunggu | Lulus |
| 6 | Ubah status reservasi menjadi dikonfirmasi | Status berubah dan notifikasi menunggu berkurang | Lulus |
| 7 | Ubah status pembayaran menjadi lunas | Status pembayaran berubah menjadi lunas | Lulus |
| 8 | Buka struk | Struk menampilkan total, DP, sisa bayar, dan status | Lulus |
| 9 | Buka laporan periode | Reservasi tampil dalam laporan dan pendapatan dihitung jika lunas | Lulus |

## Evaluasi
Alur Login -> Reservasi -> Simpan -> Laporan telah tersedia dalam aplikasi. Validasi bentrok mencegah reservasi pada rentang waktu yang sudah terisi. Data laporan mengambil sumber dari tabel `reservasis` dan relasi `lapangans` serta `pelanggans`.

## Catatan Perbaikan
1. Ditambahkan dashboard jadwal 24 jam untuk memudahkan pemilihan slot.
2. Ditambahkan status reservasi agar admin dapat mengonfirmasi reservasi baru.
3. Ditambahkan DP wajib Rp50.000 dan status pembayaran.
4. Ditambahkan struk reservasi sebagai bukti transaksi.
