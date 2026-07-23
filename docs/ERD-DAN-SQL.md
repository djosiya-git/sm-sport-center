# ERD dan SQL Script

## Entitas dan Relasi
Sistem menggunakan lima tabel utama:

1. `user`
   Menyimpan akun login dan role pengguna.

2. `lapangan`
   Menyimpan master lapangan futsal dan badminton.

3. `pelanggan`
   Menyimpan profil pelanggan. Satu pelanggan dapat terhubung ke satu `user`.

4. `reservasi`
   Menyimpan transaksi reservasi. Setiap reservasi terhubung ke satu pelanggan dan satu lapangan.

5. `sessions`, `cache`, `cache_locks`
   Tabel pendukung Laravel untuk session dan cache berbasis database.

## Relasi
```text
user 1 -- 0..1 pelanggan
pelanggan 1 -- * reservasi
lapangan 1 -- * reservasi
```

## Struktur Kunci
```text
user.id                      PK
pelanggan.id                 PK
pelanggan.user_id            FK -> user.id
lapangan.id                  PK
reservasi.id                 PK
reservasi.pelanggan_id       FK -> pelanggan.id
reservasi.lapangan_id        FK -> lapangan.id
reservasi.kode_reservasi     UNIQUE
```

## Indeks Penting
```text
lapangan(jenis, status)
pelanggan(nama)
reservasi(lapangan_id, tanggal, jam_mulai, jam_selesai)
reservasi(tanggal, status_reservasi)
```

Indeks `reservasi(lapangan_id, tanggal, jam_mulai, jam_selesai)` digunakan untuk mempercepat validasi jadwal bentrok.

## SQL Script
SQL script tersedia pada:

```text
database/sm_sport_center.sql
```

Script tersebut memuat:
1. Pembuatan database `sm_sport_center`.
2. Tabel `user`, `lapangan`, `pelanggan`, dan `reservasi`.
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
