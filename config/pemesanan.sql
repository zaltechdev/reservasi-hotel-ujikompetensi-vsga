-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 18 Jul 2024 pada 15.23
-- Versi server: 8.0.30
-- Versi PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservasihotel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int NOT NULL,
  `nama` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `jeniskelamin` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `nomorktp` varchar(16) COLLATE latin1_general_ci NOT NULL,
  `tipekamar` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `hargakamarperhari` int NOT NULL,
  `tglpesan` datetime NOT NULL,
  `durasi` int NOT NULL,
  `sarapan` int NOT NULL,
  `diskon` float NOT NULL,
  `final` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `nama`, `jeniskelamin`, `nomorktp`, `tipekamar`, `hargakamarperhari`, `tglpesan`, `durasi`, `sarapan`, `diskon`, `final`) VALUES
(15, 'zalfa', 'laki-laki', '2345676545671234', 'Standar', 200000, '2024-07-18 19:47:13', 7, 0, 0.1, 1260000),
(16, 'ghani', 'laki-laki', '0987654321234513', 'Family', 300000, '2024-07-18 22:20:32', 4, 80000, 0.1, 1160000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
