CREATE DATABASE IF NOT EXISTS sm_sport_center CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sm_sport_center;

CREATE TABLE users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(255) NOT NULL,
 email VARCHAR(255) NOT NULL UNIQUE,
 email_verified_at TIMESTAMP NULL,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
 remember_token VARCHAR(100) NULL,
 created_at TIMESTAMP NULL,
 updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE lapangans (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 kode_lapangan VARCHAR(20) NOT NULL UNIQUE,
 nama_lapangan VARCHAR(100) NOT NULL,
 jenis ENUM('futsal','badminton') NOT NULL,
 harga_per_jam DECIMAL(12,2) NOT NULL,
 status ENUM('tersedia','perawatan','nonaktif') NOT NULL DEFAULT 'tersedia',
 keterangan TEXT NULL,
 created_at TIMESTAMP NULL,
 updated_at TIMESTAMP NULL,
 INDEX idx_jenis_status (jenis,status)
) ENGINE=InnoDB;

CREATE TABLE pelanggans (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NULL UNIQUE,
 kode_pelanggan VARCHAR(20) NOT NULL UNIQUE,
 nama VARCHAR(100) NOT NULL,
 no_telepon VARCHAR(20) NOT NULL,
 alamat TEXT NULL,
 created_at TIMESTAMP NULL,
 updated_at TIMESTAMP NULL,
 CONSTRAINT fk_pelanggan_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL,
 INDEX idx_pelanggan_nama (nama)
) ENGINE=InnoDB;

CREATE TABLE reservasis (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 kode_reservasi VARCHAR(30) NOT NULL UNIQUE,
 pelanggan_id BIGINT UNSIGNED NOT NULL,
 lapangan_id BIGINT UNSIGNED NOT NULL,
 tanggal DATE NOT NULL,
 jam_mulai TIME NOT NULL,
 jam_selesai TIME NOT NULL,
 durasi INT UNSIGNED NOT NULL,
 harga_per_jam DECIMAL(12,2) NOT NULL,
 total_harga DECIMAL(12,2) NOT NULL,
 status_reservasi ENUM('menunggu','dikonfirmasi','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu',
 status_pembayaran ENUM('belum_bayar','sebagian','lunas') NOT NULL DEFAULT 'belum_bayar',
 catatan TEXT NULL,
 created_at TIMESTAMP NULL,
 updated_at TIMESTAMP NULL,
 CONSTRAINT fk_reservasi_pelanggan FOREIGN KEY(pelanggan_id) REFERENCES pelanggans(id) ON DELETE RESTRICT,
 CONSTRAINT fk_reservasi_lapangan FOREIGN KEY(lapangan_id) REFERENCES lapangans(id) ON DELETE RESTRICT,
 INDEX reservasi_jadwal_index (lapangan_id,tanggal,jam_mulai,jam_selesai),
 INDEX idx_tanggal_status (tanggal,status_reservasi)
) ENGINE=InnoDB;

INSERT INTO lapangans(kode_lapangan,nama_lapangan,jenis,harga_per_jam,status,created_at,updated_at) VALUES
('FUT-01','Lapangan Futsal 1','futsal',150000,'tersedia',NOW(),NOW()),
('FUT-02','Lapangan Futsal 2','futsal',150000,'tersedia',NOW(),NOW()),
('BDM-01','Lapangan Badminton 1','badminton',50000,'tersedia',NOW(),NOW()),
('BDM-02','Lapangan Badminton 2','badminton',50000,'tersedia',NOW(),NOW()),
('BDM-03','Lapangan Badminton 3','badminton',50000,'tersedia',NOW(),NOW());
