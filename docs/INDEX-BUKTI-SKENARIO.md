# Index Bukti Skenario Sertifikasi

Dokumen ini memetakan permintaan pada bagian "Skenario Terlampir" ke artefak di project SM Sport Center.

Laporan gabungan tersedia pada:

```text
docs/LAPORAN-TUGAS-SM-SPORT-CENTER.pdf
docs/LAPORAN-TUGAS-SM-SPORT-CENTER.md
```

| No | Bukti yang Dikumpulkan | File / Lokasi |
|---|---|---|
| 1 | Dokumen Analisis Skalabilitas Perangkat Lunak | `docs/ANALISIS-SKALABILITAS.md` |
| 2 | Analisis kebutuhan dan identifikasi aktor | `docs/ANALISIS-KEBUTUHAN.md` |
| 3 | ERD dan SQL Script | `docs/ERD-DAN-SQL.md`, `database/sm_sport_center.sql`, `database/migrations/` |
| 4 | User Interface dan Source Code | `resources/views/`, `app/Http/Controllers/`, `app/Models/`, `routes/web.php` |
| 5 | Dokumentasi Kode Program | `docs/DOKUMENTASI-KODE-PROGRAM.md` |
| 6 | Laporan Debugging | `docs/LAPORAN-DEBUGGING.md` |
| 7 | Hasil Profiling | `docs/HASIL-PROFILING.md` |
| 8 | Hasil Unit Testing | `docs/DOKUMEN-TESTING.md`, `tests/Feature/AuthTest.php` |
| 9 | Hasil Integration Testing | `docs/LAPORAN-INTEGRASI-TESTING.md` |
| 10 | Hasil Perancangan dan Demonstrasi Sistem | `docs/PERANCANGAN-DAN-DEMO.md` |

## Ringkasan Kesesuaian Skenario
1. Login benar: tersedia pada `AuthController` dan diuji pada `AuthTest`.
2. Login salah: tersedia pada `AuthController` dan diuji pada `AuthTest`.
3. Reservasi valid: tersedia pada `ReservasiController::store`.
4. Validasi jadwal bentrok: tersedia pada `ReservasiController::save`.
5. Laporan penggunaan lapangan: tersedia pada `LaporanController`.
6. Ketersediaan lapangan: tersedia pada dashboard jadwal 24 jam.
7. Struk reservasi: tersedia pada `resources/views/reservasi/receipt.blade.php`.
