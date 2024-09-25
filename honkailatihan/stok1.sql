-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Sep 2024 pada 09.52
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stok1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory`
--

CREATE TABLE `inventory` (
  `serial_number` int(20) NOT NULL,
  `nama_barang` varchar(60) NOT NULL,
  `jenis_barang` varchar(60) NOT NULL,
  `kuantitas_stok` int(60) NOT NULL,
  `harga_barang` int(60) NOT NULL,
  `lokasi_gudang` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inventory`
--

INSERT INTO `inventory` (`serial_number`, `nama_barang`, `jenis_barang`, `kuantitas_stok`, `harga_barang`, `lokasi_gudang`) VALUES
(34, 'Box Indomie: Goreng', 'makanan', 55, 56000, 'Jln Basuki Rahmat no23'),
(123, 'Action Figure Stelle:Honkai Star rail', 'Figure', 2, 230000, 'jl wonosobo no10'),
(453, 'Sunlight', 'sabun cuci', 245, 5000, 'Planet Bekasi dekat sungai nill no 45'),
(456, 'Masker Wajah', 'Pelindung wajah', 340, 20000, 'kedungdoro wetan no 79'),
(789, 'Milo ', 'Minuman', 450, 15000, 'kedungdoro wetan no 79');

-- --------------------------------------------------------

--
-- Struktur dari tabel `storage`
--

CREATE TABLE `storage` (
  `id_storage` int(20) NOT NULL,
  `nama_gudang` varchar(60) NOT NULL,
  `lokasi_gudang` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `storage`
--

INSERT INTO `storage` (`id_storage`, `nama_gudang`, `lokasi_gudang`) VALUES
(82113, 'sampoerna', 'jl wonosobo no10'),
(82114, 'Gudang garam', 'kedungdoro wetan no 79'),
(82115, 'Pt ABADI', 'Diponegoro no 32'),
(82116, 'Handada', 'Jln Basuki Rahmat no23'),
(82117, 'Kessen.Mitra', 'Bengawan Utara gg 6'),
(82118, 'Penacony.Land', 'Planet Bekasi dekat sungai nill no 45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `nomor_id` int(20) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nomor_id`, `nama`, `kontak`, `email`) VALUES
(9879, 'Yanqing', '0823416819', 'yanqingprime23@gmail.com'),
(10295, 'Jingyuang', '08123564782', 'kingyuan@gmail.com'),
(12342, 'Caelus', '0871627212', 'caecae@gmail.com'),
(43213, 'Stelle', '0856278181', 'stelle23@gmail.com'),
(78901, 'Jingliu', '0823671829', 'liuliusan@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vendor`
--

CREATE TABLE `vendor` (
  `id_vendor` int(20) NOT NULL,
  `nama_vendor` varchar(60) NOT NULL,
  `kontak_v` int(20) NOT NULL,
  `nama_barang` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `vendor`
--

INSERT INTO `vendor` (`id_vendor`, `nama_vendor`, `kontak_v`, `nama_barang`) VALUES
(21, 'aventurine', 86187672, 'Masker Wajah'),
(123, 'ferir', 9828771, 'Sunlight'),
(352, 'Caelus', 85678186, 'Action Figure Stelle:Honkai Star rail'),
(456, 'kimaskin', 819783798, 'Royco Rasa sapi'),
(856, 'Welt Yang', 867268763, 'Milo '),
(76193, 'Samsudin', 85278162, 'Box Indomie: Goreng');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`serial_number`),
  ADD KEY `lokasi_gudang` (`lokasi_gudang`),
  ADD KEY `inventory_ibfk_1` (`nama_barang`);

--
-- Indeks untuk tabel `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id_storage`),
  ADD KEY `lokasi_gudang` (`lokasi_gudang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nomor_id`);

--
-- Indeks untuk tabel `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id_vendor`),
  ADD KEY `nama_barang` (`nama_barang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `inventory`
--
ALTER TABLE `inventory`
  MODIFY `serial_number` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90818;

--
-- AUTO_INCREMENT untuk tabel `storage`
--
ALTER TABLE `storage`
  MODIFY `id_storage` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82119;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `nomor_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78902;

--
-- AUTO_INCREMENT untuk tabel `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id_vendor` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76194;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`nama_barang`) REFERENCES `vendor` (`nama_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`lokasi_gudang`) REFERENCES `storage` (`lokasi_gudang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
