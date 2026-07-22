# Dokumen Testing

| No | Skenario | Hasil yang diharapkan |
|---|---|---|
| 1 | Login benar | Masuk dashboard |
| 2 | Login salah | Pesan error |
| 3 | Reservasi valid | Data tersimpan |
| 4 | Reservasi bentrok | Ditolak dan pesan bentrok |
| 5 | Jam selesai sebelum jam mulai | Validasi gagal |
| 6 | Tanggal lampau | Validasi gagal |
| 7 | Pencarian reservasi | Data sesuai kata kunci |
| 8 | Pelanggan membuka data pelanggan lain | HTTP 403 |
| 9 | Alur Login → Reservasi → Simpan → Laporan | Data tampil di laporan admin |

Jalankan pengujian otomatis dengan `php artisan test`, kemudian dokumentasikan pengujian integrasi menggunakan screenshot setiap tahapan.
