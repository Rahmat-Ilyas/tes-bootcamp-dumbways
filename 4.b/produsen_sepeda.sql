-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jul 2020 pada 15.53
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `produsen_sepeda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `importir_tb`
--

CREATE TABLE `importir_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `importir_tb`
--

INSERT INTO `importir_tb` (`id`, `name`, `address`, `phone`) VALUES
(1, 'PT. Karya Jaya', 'Jl. Sultan Alauddin No. 25, Makassar ', '085299888452'),
(2, 'PT. Sepeda Murah', 'Jl. Tun Abdul Razak', '085234765789'),
(3, 'PT. Bike Colection', 'Jl. Jenral Sudirman', '085567356235'),
(4, 'PT. Bike Indonesia', 'Jl. Hertasning Raya', '085900345789');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_tb`
--

CREATE TABLE `produk_tb` (
  `id` int(11) NOT NULL,
  `importir_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk_tb`
--

INSERT INTO `produk_tb` (`id`, `importir_id`, `name`, `photo`, `qty`, `price`) VALUES
(2, 1, 'Fuji Bike', 'produk-070420152136.jpg', 6, 2300000),
(3, 2, 'GT Bike', 'sepeda3.jpg', 7, 2500000),
(4, 2, 'Giant', 'sepeda4.jpg', 3, 1800000),
(5, 2, 'Genio', 'sepeda5.jpg', 7, 2200000),
(6, 1, 'Sepeda BMX', 'produk-070420140351.jpg', 8, 2000000),
(7, 4, 'BMX Bike 2', 'produk-070420140559.jpg', 6, 3000000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `importir_tb`
--
ALTER TABLE `importir_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk_tb`
--
ALTER TABLE `produk_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `importir_tb`
--
ALTER TABLE `importir_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `produk_tb`
--
ALTER TABLE `produk_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
