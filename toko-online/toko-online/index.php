<?php
require_once "services/config.php";

// Query 1: produk + kategori (JOIN, relasi 1-to-many)
$q_produk = mysqli_query($conn,
    "SELECT p.id_produk, p.nama_produk, k.nama_kategori, p.harga, p.stok
     FROM produk p
     JOIN kategori k ON p.id_kategori = k.id_kategori
     ORDER BY p.id_produk");

// Query 2: pelanggan
$q_pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id_pelanggan");

// Query 3: penjualan + pelanggan + produk (JOIN 3 tabel)
$q_jual = mysqli_query($conn,
    "SELECT s.id_penjualan, c.nama_pelanggan, p.nama_produk, s.jumlah,
            (s.jumlah * p.harga) AS total, s.tanggal_transaksi
     FROM penjualan s
     JOIN pelanggan c ON s.id_pelanggan = c.id_pelanggan
     JOIN produk p    ON s.id_produk = p.id_produk
     ORDER BY s.id_penjualan");

// Query 4: ringkasan kategori (1 kategori : banyak produk)
$q_kategori = mysqli_query($conn,
    "SELECT k.nama_kategori, COUNT(p.id_produk) AS jumlah_produk
     FROM kategori k
     LEFT JOIN produk p ON k.id_kategori = p.id_kategori
     GROUP BY k.id_kategori, k.nama_kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online - Data Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="brand">🛒 Toko Online</div>
    <div class="nav-links">
        <a href="#kategori">Kategori</a>
        <a href="#produk">Produk</a>
        <a href="#pelanggan">Pelanggan</a>
        <a href="#penjualan">Penjualan</a>
    </div>
</nav>

<header class="hero">
    <h1>Data Toko Online</h1>
    <p>Web sederhana yang menampilkan data dari database MySQL</p>
</header>

<main class="container">

    <section id="kategori">
        <h2>Ringkasan Kategori</h2>
        <div class="grid">
            <?php while ($row = mysqli_fetch_assoc($q_kategori)) { ?>
                <div class="card stat">
                    <h3><?= htmlspecialchars($row['nama_kategori']) ?></h3>
                    <p><?= $row['jumlah_produk'] ?> produk</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <section id="produk">
        <h2>Tabel Produk</h2>
        <div class="card table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th></tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($q_produk)) { ?>
                    <tr>
                        <td><?= $row['id_produk'] ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['stok'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="pelanggan">
        <h2>Tabel Pelanggan</h2>
        <div class="card table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama</th><th>Email</th><th>No. HP</th><th>Kota</th></tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($q_pelanggan)) { ?>
                    <tr>
                        <td><?= $row['id_pelanggan'] ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['no_hp']) ?></td>
                        <td><?= htmlspecialchars($row['kota']) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="penjualan">
        <h2>Tabel Penjualan</h2>
        <div class="card table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Pelanggan</th><th>Produk</th><th>Jumlah</th><th>Total</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($q_jual)) { ?>
                    <tr>
                        <td><?= $row['id_penjualan'] ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td><?= $row['tanggal_transaksi'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

<footer class="footer">
    <p>&copy; 2026 Toko Online - Tugas ISCOM Day 3</p>
</footer>

</body>
</html>
