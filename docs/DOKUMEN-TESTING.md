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

## Pengujian Otomatis
File test otomatis:

```text
tests/Feature/AuthTest.php
tests/Feature/ReservasiTest.php
```

Pemetaan test:
1. `AuthTest::test_login_benar` menguji login benar.
2. `AuthTest::test_login_salah` menguji login salah.
3. `ReservasiTest::test_reservasi_valid_tersimpan` menguji reservasi valid tersimpan.
4. `ReservasiTest::test_reservasi_bentrok_ditolak` menguji jadwal bentrok ditolak.

Jalankan pengujian otomatis dengan:

```bash
php artisan test
```

Dokumentasikan pengujian integrasi menggunakan screenshot setiap tahapan, mengacu pada `docs/LAPORAN-INTEGRASI-TESTING.md`.
