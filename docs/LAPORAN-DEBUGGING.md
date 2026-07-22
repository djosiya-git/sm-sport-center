# Laporan Debugging — Double Booking

Masalah: reservasi tetap tersimpan walaupun rentang waktu lapangan sudah digunakan.

Penyebab umum: validasi hanya membandingkan `jam_mulai` yang sama, sehingga kasus 10.00–12.00 bertabrakan dengan 11.00–13.00 tidak terdeteksi.

Perbaikan menggunakan rumus overlap:
- jam mulai baru < jam selesai lama
- jam selesai baru > jam mulai lama

Query ditempatkan di dalam transaksi database dan menggunakan `lockForUpdate()` untuk mengurangi race condition. Saat edit, ID reservasi yang sedang diedit dikecualikan. Reservasi berstatus dibatalkan tidak mengunci jadwal.
