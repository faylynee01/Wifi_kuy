-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2024 at 10:57 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wifikuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_metode_pembayaran`
--

CREATE TABLE `tbl_metode_pembayaran` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_atau_norek` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `atas_nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_metode_pembayaran`
--

INSERT INTO `tbl_metode_pembayaran` (`id`, `nama`, `tipe`, `nomor_atau_norek`, `atas_nama`) VALUES
(1, 'DANA', 'E-wallet', '084832122333', 'Pemilik Dana');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paket`
--

CREATE TABLE `tbl_paket` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_paket`
--

INSERT INTO `tbl_paket` (`id`, `judul`, `kategori`, `tipe`, `harga`) VALUES
(4, 'Paket Kencang Mingguan', '20 Mbps', 'Mingguan', '50000'),
(5, 'Paket Kencang Harian', '10 Mbps', 'Harian', '10000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id` int NOT NULL,
  `id_paket` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal_waktu` datetime NOT NULL,
  `bukti_pembayaran` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_metode_pembayaran` int NOT NULL,
  `status` enum('diterima','ditolak','pending') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `alasan` text COLLATE utf8mb4_general_ci,
  `kode_wifi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `invoice` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id`, `id_paket`, `id_user`, `tanggal_waktu`, `bukti_pembayaran`, `id_metode_pembayaran`, `status`, `alasan`, `kode_wifi`, `invoice`) VALUES
(22, 4, 1, '2024-11-09 05:57:01', '672e97250662f7.32978926.png', 1, 'diterima', '', '', 'INV-20241109-672E97250661F');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengaturan`
--

CREATE TABLE `tbl_pengaturan` (
  `id` int NOT NULL,
  `nama_web` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pengaturan`
--

INSERT INTO `tbl_pengaturan` (`id`, `nama_web`, `no_telp`, `email`) VALUES
(1, 'WifiKuy', '082284538351', 'Firmanalfarezy4@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `token_expires_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `role` enum('admin','member') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama`, `username`, `email`, `password`, `remember_token`, `token_expires_at`, `role`) VALUES
(1, 'Admin', '', 'admin@gmail.com', '$2y$10$.Bg7v1pwZI8L0rslWS9EeufDnNeJn2TU0U9gre1./cehhES5To0b2', 'e80655d0c6ddbf12560a3705c8d8e78e', '1731101136', 'admin'),
(4, 'member', '', 'member@gmail.com', '$2y$10$x2HJGfh8BYxZY41QTulbzeTPgkzRi15GeQZJK56KV8ser8jkSHNrS', NULL, NULL, 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_metode_pembayaran`
--
ALTER TABLE `tbl_metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_paket`
--
ALTER TABLE `tbl_paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paket` (`id_paket`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_metode_pembayaran` (`id_metode_pembayaran`);

--
-- Indexes for table `tbl_pengaturan`
--
ALTER TABLE `tbl_pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_metode_pembayaran`
--
ALTER TABLE `tbl_metode_pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_paket`
--
ALTER TABLE `tbl_paket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_pengaturan`
--
ALTER TABLE `tbl_pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD CONSTRAINT `tbl_pembayaran_ibfk_1` FOREIGN KEY (`id_paket`) REFERENCES `tbl_paket` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pembayaran_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pembayaran_ibfk_3` FOREIGN KEY (`id_metode_pembayaran`) REFERENCES `tbl_metode_pembayaran` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
