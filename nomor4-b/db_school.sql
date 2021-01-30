-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jan 2021 pada 13.24
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_school`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_school`
--

CREATE TABLE `tb_school` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `npsn` varchar(255) NOT NULL,
  `name_school` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `logo_school` varchar(255) NOT NULL,
  `school_level` varchar(255) NOT NULL,
  `status_school` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_school`
--

INSERT INTO `tb_school` (`id`, `user_id`, `npsn`, `name_school`, `address`, `logo_school`, `school_level`, `status_school`) VALUES
(1, 1, '40303655', 'SMP MUHAMMADIYAH WALATTASI', 'JL. SULTAN HASANUDDIN NO 47 TANALLE', 'logo1.jpg', 'SMP', 'SWASTA'),
(2, 1, '40303647', 'SMP NEGERI 1 MARIORIWAWO', 'JL. PAHLAWAN NO 11 TAKALAR', 'logo2.png', 'SMP', 'NEGERI'),
(3, 2, '40404060', 'SMA NEGERI 10 BOMBANA', 'JL. PELAJAR NO 5 KAB. TOBURI', 'logo3.jpg', 'SMA', 'NEGERI'),
(5, 3, '54140298', 'SMA NEGERI 2 BULUKUMBA', 'JL. KEMAKMURAN TANETE', 'logo-school-013021125121.jpg', 'SMA', 'NEGERI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Rahmat Ilyas', 'rahmat.ilyas142@gmail.com', '$2y$10$QgpXDnoMd9.HjTZs5xZEQeD/EIrKJzf9GX.0DRUwbVInmWcNPbuKe'),
(2, 'Muhammad Ilham', 'muhammad.ilham82@gmail.com', '$2y$10$QgpXDnoMd9.HjTZs5xZEQeD/EIrKJzf9GX.0DRUwbVInmWcNPbuKe'),
(3, 'Haerul Azwar', 'haerul@gmail.com', '$2y$10$aj8sUiATq3BEdvgQypZcWuwIk7drk1aLD549ndGKxB6qJUfIBhUWa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_school`
--
ALTER TABLE `tb_school`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_school`
--
ALTER TABLE `tb_school`
  ADD CONSTRAINT `tb_school_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
