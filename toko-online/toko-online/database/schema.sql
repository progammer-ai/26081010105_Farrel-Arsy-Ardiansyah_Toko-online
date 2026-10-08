-- ============================================
-- Database: Toko Online
-- ============================================
CREATE DATABASE IF NOT EXISTS toko_online;
USE toko_online;

DROP TABLE IF EXISTS penjualan;
DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS kategori;

-- ---------- DDL ----------
CREATE TABLE kategori (
    id_kategori   INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL,
    deskripsi     VARCHAR(100)
);

-- Tabel 1 (Master)
CREATE TABLE pelanggan (
    id_pelanggan   INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(50)  NOT NULL,
    email          VARCHAR(60)  NOT NULL,
    no_hp          VARCHAR(15),
    kota           VARCHAR(40)
);

-- Tabel 2 (Master) - 1 kategori : banyak produk
CREATE TABLE produk (
    id_produk   INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_produk VARCHAR(60) NOT NULL,
    harga       INT NOT NULL,
    stok        INT NOT NULL,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

-- Tabel 3 (Transaksi) - FK ke pelanggan & produk
CREATE TABLE penjualan (
    id_penjualan      INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan      INT NOT NULL,
    id_produk         INT NOT NULL,
    jumlah            INT NOT NULL,
    tanggal_transaksi DATE NOT NULL,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan),
    FOREIGN KEY (id_produk)    REFERENCES produk(id_produk)
);

-- ---------- DML (data contoh) ----------
INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Elektronik', 'Perangkat elektronik harian'),
('Fashion',    'Pakaian dan aksesoris'),
('Makanan',    'Makanan dan minuman kemasan'),
('Buku',       'Buku dan alat tulis'),
('Olahraga',   'Perlengkapan olahraga');

INSERT INTO pelanggan (nama_pelanggan, email, no_hp, kota) VALUES
('Budi Santoso',  'budi@mail.com',  '081234567801', 'Malang'),
('Siti Aminah',   'siti@mail.com',  '081234567802', 'Surabaya'),
('Andi Wijaya',   'andi@mail.com',  '081234567803', 'Sidoarjo'),
('Dewi Lestari',  'dewi@mail.com',  '081234567804', 'Malang'),
('Rina Kartika',  'rina@mail.com',  '081234567805', 'Gresik');

INSERT INTO produk (id_kategori, nama_produk, harga, stok) VALUES
(1, 'Earphone Bluetooth', 150000, 40),
(1, 'Powerbank 10000mAh', 200000, 25),
(2, 'Kaos Polos',          65000, 100),
(3, 'Kopi Susu Botol',     18000, 200),
(4, 'Buku Tulis Premium',  15000, 150),
(5, 'Bola Futsal',        120000, 30);

INSERT INTO penjualan (id_pelanggan, id_produk, jumlah, tanggal_transaksi) VALUES
(1, 1, 1, '2026-10-01'),
(2, 3, 2, '2026-10-01'),
(3, 4, 5, '2026-10-02'),
(4, 2, 1, '2026-10-03'),
(5, 6, 1, '2026-10-04'),
(1, 5, 3, '2026-10-05');

-- ---------- QUERY SAMPLE ----------
-- SELECT
-- SELECT * FROM produk;
-- JOIN (produk + kategori)
-- SELECT p.nama_produk, k.nama_kategori, p.harga
--   FROM produk p JOIN kategori k ON p.id_kategori = k.id_kategori;
-- JOIN (3 tabel transaksi)
-- SELECT s.id_penjualan, c.nama_pelanggan, p.nama_produk, s.jumlah,
--        (s.jumlah * p.harga) AS total
--   FROM penjualan s
--   JOIN pelanggan c ON s.id_pelanggan = c.id_pelanggan
--   JOIN produk p    ON s.id_produk = p.id_produk;
-- UPDATE
-- UPDATE produk SET harga = 160000 WHERE id_produk = 1;
-- DELETE
-- DELETE FROM penjualan WHERE id_penjualan = 6;
