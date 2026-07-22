# Hasil Profiling

Komponen yang perlu diukur di lingkungan nyata: waktu respons halaman, query SQL, jumlah query, penggunaan memori, dan ukuran response. Gunakan Laravel Debugbar hanya pada local development atau Laravel Telescope yang diamankan.

Bagian berisiko lambat: daftar reservasi, pencarian berdasarkan relasi, laporan periode, dan statistik dashboard. Implementasi menggunakan eager loading dan pagination. Indeks `reservasi_jadwal_index` mempercepat pengecekan lapangan/tanggal/waktu. Catat hasil aktual sebelum dan sesudah optimasi sebagai bukti profiling.
