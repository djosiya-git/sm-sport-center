# Dokumen Analisis Skalabilitas

Dengan 5 lapangan, jam operasional 08.00–23.00, dan slot minimum 1 jam, kapasitas teoritis adalah 75 reservasi per hari. Pada utilisasi 60%, estimasinya 45 reservasi/hari, 16.425/tahun, 82.125/5 tahun, dan 164.250/10 tahun.

Potensi bottleneck: query jadwal tanpa indeks, N+1 query, daftar tanpa pagination, agregasi laporan, request bersamaan, penyimpanan log, dan export besar. Implementasi telah menggunakan indeks gabungan jadwal, eager loading, pagination, transaksi serta row locking. Peningkatan berikutnya: Redis cache, queue untuk export/notifikasi, monitoring slow query, backup otomatis, optimasi production, dan pemisahan server database saat trafik tinggi.
