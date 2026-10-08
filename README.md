# Toko Online (Tugas ISCOM Day 3)

Web sederhana PHP + MySQL yang menampilkan data dari 4 tabel berelasi.

## Cara Menjalankan
1. Install & jalankan **XAMPP** (aktifkan Apache dan MySQL).
2. Salin folder project ke `C:\xampp\htdocs\toko-online`.
3. Buka `http://localhost/phpmyadmin` -> tab **Import** -> pilih `database/schema.sql` -> **Go**.
4. Buka `http://localhost/toko-online/` di browser.

## Struktur Project
```
toko-online/
├── services/config.php   (koneksi database)
├── database/schema.sql   (DDL + DML + query sample)
├── index.php             (menampilkan data)
├── style.css             (styling)
└── README.md
```

## Entitas & Atribut
| Entitas | Atribut |
|---|---|
| kategori | **id_kategori (PK)**, nama_kategori, deskripsi |
| pelanggan (master) | **id_pelanggan (PK)**, nama_pelanggan, email, no_hp, kota |
| produk (master) | **id_produk (PK)**, id_kategori (FK), nama_produk, harga, stok |
| penjualan (transaksi) | **id_penjualan (PK)**, id_pelanggan (FK), id_produk (FK), jumlah, tanggal_transaksi |

## Relasi & Kardinalitas
- **kategori : produk = 1 : N** (satu kategori punya banyak produk)
- **pelanggan : penjualan = 1 : N** (satu pelanggan bisa melakukan banyak transaksi)
- **produk : penjualan = 1 : N** (satu produk bisa muncul di banyak transaksi)
- Secara tidak langsung pelanggan dan produk berelasi **N : M** lewat tabel penjualan.

## Query Sample
```sql
-- SELECT
SELECT * FROM produk;

-- JOIN
SELECT p.nama_produk, k.nama_kategori, p.harga
FROM produk p JOIN kategori k ON p.id_kategori = k.id_kategori;

SELECT s.id_penjualan, c.nama_pelanggan, p.nama_produk, s.jumlah,
       (s.jumlah * p.harga) AS total
FROM penjualan s
JOIN pelanggan c ON s.id_pelanggan = c.id_pelanggan
JOIN produk p    ON s.id_produk = p.id_produk;

-- UPDATE
UPDATE produk SET harga = 160000 WHERE id_produk = 1;

-- DELETE
DELETE FROM penjualan WHERE id_penjualan = 6;
```
