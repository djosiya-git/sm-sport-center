# ERD dan SQL Script

## Entitas dan Relasi
Sistem menggunakan lima tabel utama:

1. `users`
   Menyimpan akun login dan role pengguna.

2. `lapangans`
   Menyimpan master lapangan futsal dan badminton.

3. `pelanggans`
   Menyimpan profil pelanggan. Satu pelanggan dapat terhubung ke satu `users`.

4. `reservasis`
   Menyimpan transaksi reservasi. Setiap reservasi terhubung ke satu pelanggan dan satu lapangan.

5. `sessions`, `cache`, `cache_locks`
   Tabel pendukung Laravel untuk session dan cache berbasis database.

## Relasi
```text
users 1 -- 0..1 pelanggans
pelanggans 1 -- * reservasis
lapangans 1 -- * reservasis
```

## Struktur Kunci
```text
users.id                      PK
pelanggans.id                 PK
pelanggans.user_id            FK -> users.id
lapangans.id                  PK
reservasis.id                 PK
reservasis.pelanggan_id       FK -> pelanggans.id
reservasis.lapangan_id        FK -> lapangans.id
reservasis.kode_reservasi     UNIQUE
```

## Indeks Penting
```text
lapangans(jenis, status)
pelanggans(nama)
reservasis(lapangan_id, tanggal, jam_mulai, jam_selesai)
reservasis(tanggal, status_reservasi)
```

Indeks `reservasis(lapangan_id, tanggal, jam_mulai, jam_selesai)` digunakan untuk mempercepat validasi jadwal bentrok.

## SQL Script
SQL script tersedia pada:

```text
database/sm_sport_center.sql
```

Script tersebut memuat:
1. Pembuatan database `sm_sport_center`.
2. Tabel `users`, `lapangans`, `pelanggans`, dan `reservasis`.
3. Foreign key antar tabel.
4. Indeks untuk pencarian dan validasi jadwal.
5. Data awal 2 lapangan futsal, 3 lapangan badminton, admin, dan beberapa pelanggan.

## Implementasi Laravel Migration
Selain SQL script manual, struktur database juga tersedia dalam migration Laravel:

```text
database/migrations/
```

Migration digunakan untuk deployment production melalui perintah:

```bash
php artisan migrate --seed --force
```
