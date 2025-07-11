-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 06:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fahriel`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_mahasiswa`
--

CREATE TABLE `data_mahasiswa` (
  `id_user` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim_nidn` varchar(30) NOT NULL,
  `role` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_mahasiswa`
--

INSERT INTO `data_mahasiswa` (`id_user`, `nama`, `nim_nidn`, `role`) VALUES
('user01', 'fahriel', '2417052805007', 'admin'),
('user02', 'andin', '2417052805013', 'user'),
('user03', 'anreal', '2417052805123', 'super user');

-- --------------------------------------------------------

--
-- Table structure for table `data_ruangan`
--

CREATE TABLE `data_ruangan` (
  `id_ruangan` varchar(30) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `nomor_ruangan` varchar(30) NOT NULL,
  `status` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_ruangan`
--

INSERT INTO `data_ruangan` (`id_ruangan`, `nama_ruangan`, `nomor_ruangan`, `status`) VALUES
('Laboratorium1', 'lab Multimedia', '1', 'not available'),
('ruang01', 'Ruang Teori 1', '1', 'available'),
('ruang02', 'Ruang Teori 2', '2', 'available'),
('ruang03', 'Ruang Teori 3', '3', 'available'),
('ruang04', 'Ruang Teori 4', '4', 'available'),
('ruang05', 'Ruang Teori 5', '5', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `kamis_fahriel`
--

CREATE TABLE `kamis_fahriel` (
  `id_menu` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nama` varchar(30) NOT NULL,
  `link` varchar(11) NOT NULL,
  `class` varchar(15) NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `aktif` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamis_fahriel`
--

INSERT INTO `kamis_fahriel` (`id_menu`, `nama`, `link`, `class`, `posisi`, `aktif`) VALUES
('12', 'nmnm', 'rey.usti', 'si', '4', 'Y'),
('id_1', 'Nurva Fitri Andini', 'andin.com', 'tif', '2', 'Y'),
('id_2', 'Fahriel abdul rasyid', 'fahriel.com', 'tif', '1', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `lap_barang`
--

CREATE TABLE `lap_barang` (
  `id_kode` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jumlah` varchar(11) NOT NULL,
  `harga` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lap_barang`
--

INSERT INTO `lap_barang` (`id_kode`, `nama`, `jumlah`, `harga`) VALUES
('kode_1', 'laptop', '29', '29000000'),
('kode_2', 'Hp', '100', '4000000');

-- --------------------------------------------------------

--
-- Table structure for table `status_booking`
--

CREATE TABLE `status_booking` (
  `nama_ruang` varchar(30) NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `jam` varchar(13) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `keperluan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_booking`
--

INSERT INTO `status_booking` (`nama_ruang`, `tanggal`, `jam`, `nama_user`, `keperluan`) VALUES
('lab Multimedia', '2025-07-08', '13.00-15.00', 'fahriel', 'Belajar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_mahasiswa`
--
ALTER TABLE `data_mahasiswa`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `data_ruangan`
--
ALTER TABLE `data_ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `kamis_fahriel`
--
ALTER TABLE `kamis_fahriel`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `lap_barang`
--
ALTER TABLE `lap_barang`
  ADD PRIMARY KEY (`id_kode`);

--
-- Indexes for table `status_booking`
--
ALTER TABLE `status_booking`
  ADD PRIMARY KEY (`nama_ruang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
