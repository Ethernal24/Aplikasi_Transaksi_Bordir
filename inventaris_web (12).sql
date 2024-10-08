-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2024 at 07:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `barang_id` int NOT NULL,
  `kode_barang` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `angka` float NOT NULL,
  `unit_id` int NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `tipe` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  `warna` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `supplier_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`barang_id`, `kode_barang`, `nama_barang`, `angka`, `unit_id`, `harga`, `tipe`, `warna`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 'A003', 'Benang Oren', 5, 1, 15000, 'Consumable', 'Oren', 1, NULL, '2024-09-17 15:45:51'),
(3, 'B001', 'Kain Hijau', 6, 1, 100000, 'Consumable', 'Hijau', 2, '2024-09-02 16:27:12', '2024-09-17 16:23:19'),
(4, 'A001', 'Benang Merah', 3000, 7, 12000, 'Consumable', 'Merah', 3, '2024-08-26 21:37:26', '2024-09-17 15:46:50'),
(5, 'B002', 'Kain Kuning', 3, 1, 12000, 'Consumable', 'Kuning', 2, '2024-09-02 15:59:24', '2024-09-17 16:23:29'),
(7, 'ZZZZ', 'Manik-manik', 2, 1, 15000, 'Consumable', 'Merah', 3, '2024-09-05 17:28:41', '2024-09-17 15:47:36'),
(9, 'A004', 'Benang Polyester', 1000, 8, 50000, 'Consumable', 'Putih', 1, '2024-09-17 16:20:33', '2024-09-17 16:20:33'),
(10, 'A005', 'Benang Polyester', 500, 8, 50000, 'Consumable', 'Putih', 3, '2024-09-17 16:21:33', '2024-09-17 16:21:33'),
(11, 'A002', 'Benang Rayon', 500, 8, 100000, 'Consumable', 'Merah', 2, '2024-09-17 16:22:51', '2024-09-17 16:22:51'),
(12, 'M001', 'Mesin Bordir', 1, 9, 50000000, 'Non Consumable', 'Silver', 1, '2024-09-17 16:25:12', '2024-09-17 16:25:12'),
(13, 'M002', 'Rangka Bordir', 5, 9, 2000000, 'Non Consumable', 'Hitam', 3, '2024-09-17 16:25:55', '2024-09-17 16:25:55'),
(14, 'A006', 'Benang Merah', 250, 8, 190000, 'Consumable', 'Merah', 1, '2024-09-17 16:34:07', '2024-09-17 16:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `barangproduksi`
--

CREATE TABLE `barangproduksi` (
  `barang_id` int NOT NULL,
  `nama` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_jenis` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `ukuran` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangproduksi`
--

INSERT INTO `barangproduksi` (`barang_id`, `nama`, `nama_jenis`, `ukuran`, `deskripsi`) VALUES
(4, 'Baju Merah', 'Baju Lengan Panjan', '0', '134');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int NOT NULL,
  `tanggal` date NOT NULL,
  `barang_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity_awal` float NOT NULL,
  `quantity_masuk` float NOT NULL,
  `quantity_keluar` float NOT NULL,
  `quantity_akhir` float NOT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `tanggal`, `barang_id`, `user_id`, `quantity_awal`, `quantity_masuk`, `quantity_keluar`, `quantity_akhir`, `catatan`, `created_at`, `update_at`) VALUES
(1, '2024-09-02', 1, 1, 0, 5, 1, 4, 'test', NULL, '2024-09-13 19:39:44'),
(2, '2024-09-02', 1, 1, 4, 15, 5, 14, 'test', '2024-09-13 19:44:28', '2024-09-13 19:44:28'),
(3, '2024-09-01', 3, 1, 0, 15, 5, 10, 'test', '2024-09-13 19:58:00', '2024-09-13 19:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` int NOT NULL,
  `nama_jenis` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `nama_jenis`, `deskripsi`) VALUES
(1, 'Baju', 'Tshirt biasa'),
(2, 'Baju Lengan Panjan', 'Baju dengan Lengan Panjang'),
(3, 'Celana Pendek', 'Celana Dengan panjang 20cm');

-- --------------------------------------------------------

--
-- Table structure for table `laporanproduksi`
--

CREATE TABLE `laporanproduksi` (
  `laporan_id` int NOT NULL,
  `mesin_id` int NOT NULL,
  `shift_id` int NOT NULL,
  `tanggal_kerja` date NOT NULL,
  `nama_kerjaan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `vs` int NOT NULL,
  `stitch` int NOT NULL,
  `kuantitas` int NOT NULL,
  `bs` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporanproduksi`
--

INSERT INTO `laporanproduksi` (`laporan_id`, `mesin_id`, `shift_id`, `tanggal_kerja`, `nama_kerjaan`, `vs`, `stitch`, `kuantitas`, `bs`) VALUES
(8, 2, 21, '2024-09-02', 'babi', 1, 2, 3, 4),
(9, 2, 22, '2024-09-03', 'babi', 1, 2, 3, 4),
(10, 1, 21, '2024-09-04', 'babi12', 1, 2, 24, 2),
(11, 1, 22, '2024-09-04', 'babi12', 1, 1, 52, 1),
(12, 2, 22, '2024-09-04', 'babi12', 1, 2, 52, 1),
(13, 1, 22, '2024-09-05', 'babi12', 1, 2, 55, 2),
(21, 1, 21, '2021-09-08', 'P12', 2, 2, 1555, 1),
(22, 1, 21, '2021-09-08', 'P12', 1, 2, 155, 1),
(23, 1, 23, '2024-09-05', 'Jahit', 123, 123, 123, 123),
(24, 2, 22, '2019-07-01', 'Nukang', 1, 1, 1, 1),
(25, 2, 21, '2019-07-12', 'Nukang', 1, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keluar`
--

CREATE TABLE `laporan_keluar` (
  `id` int NOT NULL,
  `nama` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `barang` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int NOT NULL,
  `tanggal` date NOT NULL,
  `catatan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_keluar`
--

INSERT INTO `laporan_keluar` (`id`, `nama`, `barang`, `qty`, `tanggal`, `catatan`) VALUES
(1, 'babi12', 'Baju Merah', 2, '2024-10-01', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `mesin`
--

CREATE TABLE `mesin` (
  `mesin_id` int NOT NULL,
  `nama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mesin`
--

INSERT INTO `mesin` (`mesin_id`, `nama`, `deskripsi`) VALUES
(1, 'Mesin Bordir', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `nota_id` int NOT NULL,
  `nama_konsumen` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total_qty` int NOT NULL,
  `total_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`nota_id`, `nama_konsumen`, `tanggal`, `barang`, `harga`, `qty`, `total_qty`, `total_harga`) VALUES
(18, 'Test21', '2024-10-14', 'Baju Merah,Baju Merah', '155,1551', '155,151', 306, 258226);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `pembelian_id` int NOT NULL,
  `pemesanan_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `total_biaya` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`pembelian_id`, `pemesanan_id`, `user_id`, `total_biaya`) VALUES
(15, 80, NULL, 0),
(16, 81, NULL, 0),
(17, 81, NULL, 0),
(18, 82, NULL, 0),
(19, 83, NULL, 0),
(20, 83, NULL, 0),
(21, 84, NULL, 0),
(22, 85, NULL, 0),
(23, 86, NULL, 0),
(24, 87, NULL, 0),
(25, 88, NULL, 0),
(26, 92, NULL, 0),
(27, 93, NULL, 0),
(28, 94, NULL, 0),
(29, 95, NULL, 0),
(30, 96, NULL, 0),
(31, 97, NULL, 0),
(32, 98, NULL, 0),
(33, 99, NULL, 0),
(34, 100, NULL, 0),
(35, 101, NULL, 0),
(36, 102, NULL, 0),
(37, 103, NULL, 0),
(38, 104, NULL, 0),
(39, 105, NULL, 0),
(40, 106, NULL, 0),
(41, 107, NULL, 0),
(42, 108, NULL, 0),
(43, 109, NULL, 0),
(44, 110, NULL, 0),
(45, 111, NULL, 0),
(46, 112, NULL, 0),
(47, 113, NULL, 0),
(48, 114, NULL, 0),
(49, 115, NULL, 0),
(50, 116, NULL, 0),
(51, 117, NULL, 0),
(52, 118, NULL, 0),
(53, 119, NULL, 0),
(54, 120, NULL, 0),
(55, 121, NULL, 0),
(56, 122, NULL, 0),
(57, 123, NULL, 0),
(58, 124, NULL, 0),
(59, 125, NULL, 0),
(60, 126, NULL, 0),
(61, 127, NULL, 0),
(62, 128, NULL, 0),
(63, 129, NULL, 0),
(64, 130, NULL, 0),
(65, 131, NULL, 0),
(66, 132, NULL, 0),
(67, 133, NULL, 0),
(68, 134, NULL, 0),
(69, 135, NULL, 0),
(70, 136, NULL, 0),
(71, 137, NULL, 0),
(72, 138, NULL, 0),
(73, 139, NULL, 0),
(74, 140, NULL, 0),
(75, 141, NULL, 0),
(76, 142, NULL, 0),
(77, 143, NULL, 0),
(78, 144, NULL, 0),
(79, 145, NULL, 0),
(80, 146, NULL, 0),
(81, 147, NULL, 0),
(82, 148, NULL, 0),
(83, 149, NULL, 0),
(84, 150, NULL, 0),
(85, 151, NULL, 0),
(86, 152, NULL, 0),
(87, 153, NULL, 0),
(88, 154, NULL, 0),
(89, 155, NULL, 0),
(90, 156, NULL, 0),
(91, 157, NULL, 0),
(92, 158, NULL, 0),
(93, 159, NULL, 0),
(94, 160, NULL, 0),
(95, 161, NULL, 0),
(96, 162, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `belidetail_id` int NOT NULL,
  `pembelian_id` int NOT NULL,
  `pesandetail_id` int NOT NULL,
  `cek_barang` decimal(10,0) NOT NULL,
  `total_biaya` decimal(10,0) NOT NULL,
  `catatan` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `is_correct` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`belidetail_id`, `pembelian_id`, `pesandetail_id`, `cek_barang`, `total_biaya`, `catatan`, `is_correct`, `created_at`, `updated_at`) VALUES
(39, 19, 30, 0, 0, NULL, 0, '2024-09-23 11:53:06', NULL),
(40, 20, 31, 0, 0, NULL, 0, '2024-09-23 11:54:46', NULL),
(41, 21, 32, 0, 0, NULL, 0, '2024-09-23 12:05:01', NULL),
(42, 22, 33, 0, 0, NULL, 0, '2024-09-24 09:51:47', NULL),
(43, 32, 34, 0, 0, NULL, 0, '2024-09-24 12:31:35', NULL),
(44, 33, 35, 0, 0, NULL, 0, '2024-09-24 12:32:21', NULL),
(45, 34, 36, 0, 0, NULL, 0, '2024-09-24 12:46:10', NULL),
(46, 36, 37, 0, 0, NULL, 0, '2024-09-24 12:48:35', NULL),
(47, 37, 38, 0, 0, NULL, 0, '2024-09-24 12:53:41', NULL),
(48, 40, 39, 0, 0, NULL, 0, '2024-09-24 13:07:23', NULL),
(49, 47, 40, 0, 0, NULL, 0, '2024-09-29 09:59:23', NULL),
(50, 50, 41, 0, 0, NULL, 0, '2024-09-29 11:19:55', NULL),
(51, 51, 43, 0, 0, NULL, 0, '2024-09-29 11:27:12', NULL),
(52, 53, 45, 0, 0, NULL, 0, '2024-10-01 10:42:35', NULL),
(53, 54, 47, 0, 0, NULL, 0, '2024-10-01 11:09:12', NULL),
(54, 55, 50, 0, 0, NULL, 0, '2024-10-01 11:12:59', NULL),
(55, 56, 53, 0, 0, NULL, 0, '2024-10-01 11:26:13', NULL),
(56, 57, 56, 0, 0, NULL, 0, '2024-10-01 11:30:59', NULL),
(57, 58, 58, 0, 0, NULL, 0, '2024-10-01 11:35:28', NULL),
(58, 59, 61, 0, 0, NULL, 0, '2024-10-01 11:40:35', NULL),
(59, 60, 64, 0, 0, NULL, 0, '2024-10-01 11:43:34', NULL),
(60, 61, 65, 0, 0, NULL, 0, '2024-10-01 11:49:18', NULL),
(61, 62, 68, 0, 0, NULL, 0, '2024-10-01 11:49:43', NULL),
(62, 65, 69, 0, 0, NULL, 0, '2024-10-04 04:54:29', NULL),
(63, 67, 72, 0, 0, NULL, 0, '2024-10-04 05:24:05', NULL),
(64, 67, 75, 0, 0, NULL, 0, '2024-10-04 05:39:18', NULL),
(65, 67, 76, 0, 0, NULL, 0, '2024-10-04 05:39:43', NULL),
(66, 67, 77, 0, 0, NULL, 0, '2024-10-04 05:40:38', NULL),
(67, 67, 78, 0, 0, NULL, 0, '2024-10-04 05:40:43', NULL),
(68, 67, 79, 0, 0, NULL, 0, '2024-10-04 05:43:20', NULL),
(69, 68, 80, 0, 0, NULL, 0, '2024-10-04 05:53:32', NULL),
(70, 68, 82, 0, 0, NULL, 0, '2024-10-04 05:56:41', NULL),
(71, 74, 83, 0, 0, NULL, 0, '2024-10-05 07:57:26', NULL),
(72, 85, 86, 0, 0, NULL, 0, '2024-10-06 00:05:32', NULL),
(73, 87, 87, 0, 0, NULL, 0, '2024-10-06 00:08:30', NULL),
(74, 88, 93, 0, 0, NULL, 0, '2024-10-06 00:51:38', NULL),
(75, 89, 96, 0, 0, NULL, 0, '2024-10-06 06:12:35', NULL),
(76, 93, 99, 0, 0, NULL, 0, '2024-10-06 12:37:29', NULL),
(77, 94, 102, 0, 0, NULL, 0, '2024-10-06 12:45:50', NULL),
(78, 95, 104, 0, 0, NULL, 0, '2024-10-06 12:48:38', NULL),
(79, 96, 109, 0, 0, NULL, 0, '2024-10-07 23:46:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `pemesanan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `total_item` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`pemesanan_id`, `user_id`, `tanggal`, `total_item`, `created_at`, `updated_at`) VALUES
(71, 1, '2024-09-23', 1, '2024-09-23 17:17:10', '2024-09-23 17:32:52'),
(72, 1, '2024-09-23', 0, '2024-09-23 17:18:29', '2024-09-23 17:18:29'),
(73, 1, '2024-09-23', 0, '2024-09-23 17:21:58', '2024-09-23 17:21:58'),
(74, 1, '2024-09-23', 0, '2024-09-23 17:29:54', '2024-09-23 17:29:54'),
(75, 1, '2024-09-23', 0, '2024-09-23 17:31:57', '2024-09-23 17:31:57'),
(76, 1, '2024-09-23', 1, '2024-09-23 17:33:08', '2024-09-23 17:33:19'),
(77, 1, '2024-09-23', 1, '2024-09-23 17:35:08', '2024-09-23 17:36:01'),
(78, 1, '2024-09-23', 1, '2024-09-23 17:36:15', '2024-09-23 17:36:23'),
(79, 1, '2024-09-23', 1, '2024-09-23 17:47:07', '2024-09-23 17:47:19'),
(80, 1, '2024-09-23', 1, '2024-09-23 17:56:06', '2024-09-23 17:56:15'),
(81, 1, '2024-09-23', 2, '2024-09-23 18:05:25', '2024-09-23 18:06:40'),
(82, 1, '2024-09-23', 1, '2024-09-23 18:11:57', '2024-09-23 18:12:02'),
(83, 1, '2024-09-23', 2, '2024-09-23 18:52:43', '2024-10-06 13:10:53'),
(84, 1, '2024-09-23', 1, '2024-09-23 19:04:53', '2024-09-23 19:05:01'),
(85, 1, '2024-09-24', 1, '2024-09-24 16:51:19', '2024-09-24 16:51:47'),
(86, 1, '2024-09-24', 0, '2024-09-24 17:38:47', '2024-09-24 17:38:47'),
(87, 1, '2024-09-24', 0, '2024-09-24 17:52:08', '2024-09-24 17:52:08'),
(88, 1, '2024-09-24', 0, '2024-09-24 17:57:52', '2024-09-24 17:57:52'),
(89, 1, '2024-09-24', 0, '2024-09-24 18:04:16', '2024-09-24 18:04:16'),
(90, 1, '2024-09-24', 0, '2024-09-24 18:04:29', '2024-09-24 18:04:29'),
(91, 1, '2024-09-24', 0, '2024-09-24 18:06:15', '2024-09-24 18:06:15'),
(92, 1, '2024-09-24', 0, '2024-09-24 18:09:35', '2024-09-24 18:09:35'),
(93, 1, '2024-09-24', 0, '2024-09-24 18:44:45', '2024-09-24 18:44:45'),
(94, 1, '2024-09-24', 0, '2024-09-24 19:07:57', '2024-09-24 19:07:57'),
(95, 1, '2024-09-24', 0, '2024-09-24 19:10:10', '2024-09-24 19:10:10'),
(96, 1, '2024-09-24', 0, '2024-09-24 19:10:45', '2024-09-24 19:10:45'),
(97, 1, '2024-09-24', 0, '2024-09-24 19:11:25', '2024-09-24 19:11:25'),
(98, 1, '2024-09-24', 1, '2024-09-24 19:19:15', '2024-09-24 19:31:35'),
(99, 1, '2024-09-24', 1, '2024-09-24 19:31:51', '2024-09-24 19:32:21'),
(100, 1, '2024-09-24', 1, '2024-09-24 19:32:44', '2024-09-24 19:46:10'),
(101, 1, '2024-09-24', 0, '2024-09-24 19:46:37', '2024-09-24 19:46:37'),
(102, 1, '2024-09-24', 1, '2024-09-24 19:47:07', '2024-09-24 19:48:35'),
(103, 1, '2024-09-24', 1, '2024-09-24 19:48:50', '2024-09-24 19:53:41'),
(104, 1, '2024-09-24', 0, '2024-09-24 19:53:44', '2024-09-24 19:53:44'),
(105, 1, '2024-09-24', 0, '2024-09-24 20:01:56', '2024-09-24 20:01:56'),
(106, 1, '2024-09-24', 1, '2024-09-24 20:03:16', '2024-09-24 20:07:23'),
(107, 1, '2024-09-29', 0, '2024-09-29 14:02:58', '2024-09-29 14:02:58'),
(108, 1, '2024-09-29', 0, '2024-09-29 14:03:01', '2024-09-29 14:03:01'),
(109, 1, '2024-09-29', 0, '2024-09-29 14:04:47', '2024-09-29 14:04:47'),
(110, 1, '2024-09-29', 0, '2024-09-29 16:20:45', '2024-09-29 16:20:45'),
(111, 1, '2024-09-29', 0, '2024-09-29 16:20:51', '2024-09-29 16:20:51'),
(112, 1, '2024-09-29', 0, '2024-09-29 16:24:23', '2024-09-29 16:24:23'),
(113, 1, '2024-09-29', 1, '2024-09-29 16:24:39', '2024-09-29 16:59:23'),
(114, 1, '2024-09-29', 0, '2024-09-29 16:59:32', '2024-09-29 16:59:32'),
(115, 1, '2024-09-29', 0, '2024-09-29 17:56:54', '2024-09-29 17:56:54'),
(116, 1, '2024-09-29', 2, '2024-09-29 18:08:34', '2024-09-29 18:19:55'),
(117, 1, '2024-09-29', 2, '2024-09-29 18:22:39', '2024-09-29 18:27:12'),
(118, 1, '2024-09-29', 0, '2024-09-29 18:37:24', '2024-09-29 18:37:24'),
(119, 1, '2024-10-01', 2, '2024-10-01 17:31:42', '2024-10-01 17:42:35'),
(120, 1, '2024-10-01', 3, '2024-10-01 17:45:13', '2024-10-01 18:09:12'),
(121, 1, '2024-10-01', 3, '2024-10-01 18:10:38', '2024-10-01 18:12:59'),
(122, 1, '2024-10-01', 3, '2024-10-01 18:25:26', '2024-10-01 18:26:13'),
(123, 1, '2024-10-01', 2, '2024-10-01 18:30:28', '2024-10-01 18:30:59'),
(124, 1, '2024-10-01', 3, '2024-10-01 18:34:38', '2024-10-01 18:35:28'),
(125, 1, '2024-10-01', 3, '2024-10-01 18:40:07', '2024-10-01 18:40:35'),
(126, 1, '2024-10-01', 1, '2024-10-01 18:43:27', '2024-10-01 18:43:34'),
(127, 1, '2024-10-01', 3, '2024-10-01 18:48:28', '2024-10-01 18:49:18'),
(128, 1, '2024-10-01', 1, '2024-10-01 18:49:35', '2024-10-01 18:49:43'),
(129, 1, '2024-10-04', 0, '2024-10-04 10:56:06', '2024-10-04 10:56:06'),
(130, 1, '2024-10-04', 0, '2024-10-04 11:10:22', '2024-10-04 11:10:22'),
(131, 1, '2024-10-04', 3, '2024-10-04 11:16:59', '2024-10-04 11:54:29'),
(132, 1, '2024-10-04', 0, '2024-10-04 12:20:59', '2024-10-04 12:20:59'),
(133, 1, '2024-10-04', 8, '2024-10-04 12:22:52', '2024-10-04 12:43:20'),
(134, 1, '2024-10-04', 4, '2024-10-04 12:53:16', '2024-10-06 07:44:44'),
(135, 1, '2024-10-04', 0, '2024-10-04 14:31:28', '2024-10-04 14:31:28'),
(136, 1, '2024-10-04', 0, '2024-10-04 14:40:54', '2024-10-04 14:40:54'),
(137, 1, '2024-10-05', 0, '2024-10-05 12:32:09', '2024-10-05 12:32:09'),
(138, 1, '2024-10-05', 0, '2024-10-05 12:51:05', '2024-10-05 12:51:05'),
(139, 1, '2024-10-05', 0, '2024-10-05 14:02:33', '2024-10-05 14:02:33'),
(140, 1, '2024-10-05', 4, '2024-10-05 14:56:51', '2024-10-06 07:28:54'),
(141, 1, '2024-10-05', 0, '2024-10-05 14:57:55', '2024-10-05 14:57:55'),
(142, 1, '2024-10-05', 0, '2024-10-05 14:58:16', '2024-10-05 14:58:16'),
(143, 1, '2024-10-05', 0, '2024-10-05 15:12:14', '2024-10-05 15:12:14'),
(144, 1, '2024-10-06', 0, '2024-10-06 06:30:12', '2024-10-06 06:30:12'),
(145, 1, '2024-10-06', 0, '2024-10-06 06:38:48', '2024-10-06 06:38:48'),
(146, 1, '2024-10-06', 0, '2024-10-06 06:40:04', '2024-10-06 06:40:04'),
(147, 1, '2024-10-06', 0, '2024-10-06 06:43:07', '2024-10-06 06:43:07'),
(148, 1, '2024-10-06', 0, '2024-10-06 06:50:09', '2024-10-06 06:50:09'),
(149, 1, '2024-10-06', 0, '2024-10-06 06:58:14', '2024-10-06 06:58:14'),
(150, 1, '2024-10-06', 0, '2024-10-06 07:03:32', '2024-10-06 07:03:32'),
(151, 1, '2024-10-06', 2, '2024-10-06 07:05:19', '2024-10-06 07:22:37'),
(152, 1, '2024-10-06', 0, '2024-10-06 07:07:36', '2024-10-06 07:07:36'),
(153, 1, '2024-10-06', 3, '2024-10-06 07:08:20', '2024-10-06 07:28:24'),
(154, 1, '2024-10-06', 3, '2024-10-06 07:50:58', '2024-10-06 07:57:43'),
(155, 1, '2024-10-06', 3, '2024-10-06 13:11:58', '2024-10-06 13:14:11'),
(156, 1, '2024-10-06', 0, '2024-10-06 16:39:48', '2024-10-06 16:39:48'),
(157, 1, '2024-10-06', 0, '2024-10-06 18:40:40', '2024-10-06 18:40:40'),
(158, 1, '2024-10-06', 0, '2024-10-06 18:59:59', '2024-10-06 18:59:59'),
(159, 1, '2024-10-06', 3, '2024-10-06 19:09:57', '2024-10-06 19:37:29'),
(160, 1, '2024-10-06', 2, '2024-10-06 19:38:35', '2024-10-06 19:45:50'),
(161, 1, '2024-10-06', 5, '2024-10-06 19:46:57', '2024-10-06 19:48:38'),
(162, 1, '2024-10-08', 3, '2024-10-08 06:45:21', '2024-10-08 06:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `penggunaan_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `user_id` int NOT NULL,
  `jumlah_digunakan` int NOT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_digunakan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penggunaan`
--

INSERT INTO `penggunaan` (`penggunaan_id`, `barang_id`, `user_id`, `jumlah_digunakan`, `catatan`, `tanggal_digunakan`) VALUES
(5, 3, 3, 4, '4 digunakan', '2024-09-10'),
(6, 1, 6, 6, 'Digunakan untuk jahit', '2024-09-19'),
(7, 3, 5, 4, '4 item Digunakan dari stock', '2024-09-23'),
(8, 3, 1, 4, '4 digunakan', '2024-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `pesan_detail`
--

CREATE TABLE `pesan_detail` (
  `pesandetail_id` int NOT NULL,
  `pemesanan_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `qty` float NOT NULL,
  `qty_terima` float DEFAULT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `langsung_pakai` tinyint NOT NULL DEFAULT '0',
  `is_correct` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesan_detail`
--

INSERT INTO `pesan_detail` (`pesandetail_id`, `pemesanan_id`, `barang_id`, `qty`, `qty_terima`, `catatan`, `langsung_pakai`, `is_correct`, `created_at`, `update_at`) VALUES
(17, 71, 9, 5, 0, '', 1, 0, '2024-09-23 17:17:21', '2024-09-23 17:32:52'),
(18, 72, 9, 4, 0, '', 1, 0, '2024-09-23 17:18:39', '2024-09-23 17:18:39'),
(19, 73, 4, 5, 0, '', 1, 0, '2024-09-23 17:22:06', '2024-09-23 17:22:06'),
(20, 74, 9, 5, 0, '', 1, 0, '2024-09-23 17:30:02', '2024-09-23 17:30:02'),
(21, 75, 11, 5, 0, '', 1, 0, '2024-09-23 17:32:07', '2024-09-23 17:32:07'),
(22, 76, 10, 5, 0, '', 1, 0, '2024-09-23 17:33:19', '2024-09-23 17:33:19'),
(23, 77, 11, 5, 0, '', 1, 0, '2024-09-23 17:36:01', '2024-09-23 17:36:01'),
(24, 78, 9, 4, 0, '', 1, 0, '2024-09-23 17:36:23', '2024-09-23 17:36:23'),
(25, 79, 4, 5, 1, 'Pesan', 1, 0, '2024-09-23 17:47:19', '2024-09-23 17:47:19'),
(26, 80, 9, 5, 0, 'Pesan', 1, 0, '2024-09-23 17:56:15', '2024-09-23 17:56:15'),
(27, 81, 9, 5, 1, '', 1, 0, '2024-09-23 18:05:33', '2024-09-23 18:05:33'),
(28, 81, 9, 5, 1, '', 1, 0, '2024-09-23 18:06:40', '2024-09-23 18:06:40'),
(29, 82, 4, 5, 0, '', 1, 0, '2024-09-23 18:12:02', '2024-09-23 18:12:02'),
(30, 83, 4, 5, 5, 'Proses Pemesanan', 1, 1, '2024-09-23 18:53:06', '2024-10-06 13:10:53'),
(31, 83, 4, 5, 5, 'Proses Pemesanan', 1, 1, '2024-09-23 18:54:46', '2024-10-06 13:10:53'),
(32, 84, 9, 5, 0, 'Pesan', 0, 0, '2024-09-23 19:05:01', '2024-09-23 19:05:01'),
(33, 85, 1, 5, 0, '', 1, 0, '2024-09-24 16:51:47', '2024-09-24 16:51:47'),
(34, 98, 14, 5, 0, 'test', 1, 1, '2024-09-24 19:31:35', '2024-09-24 19:31:35'),
(35, 99, 14, 5, 0, 'test', 1, 1, '2024-09-24 19:32:21', '2024-09-24 19:32:21'),
(36, 100, 4, 15, 1, '', 1, 1, '2024-09-24 19:46:10', '2024-09-24 19:46:10'),
(37, 102, 9, 123, 1, '', 1, 0, '2024-09-24 19:48:35', '2024-09-24 19:48:35'),
(38, 103, 9, 123, 1, '123', 0, 0, '2024-09-24 19:53:41', '2024-09-24 19:53:41'),
(39, 106, 14, 5, 0, 'test', 0, 0, '2024-09-24 20:07:23', '2024-09-24 20:07:23'),
(40, 113, 1, 5, 0, 'test', 1, 1, '2024-09-29 16:59:23', '2024-09-29 16:59:23'),
(41, 116, 9, 5, 0, 'test', 1, 1, '2024-09-29 18:19:55', '2024-09-29 18:19:55'),
(42, 116, 3, 6, 1, 'agg', 1, 1, '2024-09-29 18:19:55', '2024-09-29 18:19:55'),
(43, 117, 9, 5, 0, 'test', 1, 1, '2024-09-29 18:27:12', '2024-09-29 18:27:12'),
(44, 117, 3, 5, 0, 'testtt', 1, 1, '2024-09-29 18:27:12', '2024-09-29 18:27:12'),
(45, 119, 14, 5, 0, 'test', 1, 0, '2024-10-01 17:42:35', '2024-10-01 17:42:35'),
(46, 119, 3, 15, 0, '', 0, 0, '2024-10-01 17:42:35', '2024-10-01 17:42:35'),
(47, 120, 4, 5, 0, 'test', 1, 0, '2024-10-01 18:09:12', '2024-10-01 18:09:12'),
(48, 120, 3, 5, 0, '', 0, 0, '2024-10-01 18:09:12', '2024-10-01 18:09:12'),
(49, 120, 10, 7, 0, '', 0, 0, '2024-10-01 18:09:12', '2024-10-01 18:09:12'),
(50, 121, 14, 5, 0, '', 0, 0, '2024-10-01 18:12:59', '2024-10-01 18:12:59'),
(51, 121, 3, 5, 0, '', 0, 0, '2024-10-01 18:12:59', '2024-10-01 18:12:59'),
(52, 121, 9, 7, 0, '', 0, 0, '2024-10-01 18:12:59', '2024-10-01 18:12:59'),
(53, 122, 9, 5, 0, '', 0, 0, '2024-10-01 18:26:13', '2024-10-01 18:26:13'),
(54, 122, 3, 7, 0, '', 1, 0, '2024-10-01 18:26:13', '2024-10-01 18:26:13'),
(55, 122, 10, 5, 0, '', 0, 1, '2024-10-01 18:26:13', '2024-10-01 18:26:13'),
(56, 123, 14, 5, 0, '', 1, 0, '2024-10-01 18:30:59', '2024-10-01 18:30:59'),
(57, 123, 3, 6, 0, '', 0, 0, '2024-10-01 18:30:59', '2024-10-01 18:30:59'),
(58, 124, 14, 5, 0, 'test', 0, 0, '2024-10-01 18:35:28', '2024-10-01 18:35:28'),
(59, 124, 3, 5, 0, 'testtt', 1, 0, '2024-10-01 18:35:28', '2024-10-01 18:35:28'),
(60, 124, 9, 5, 0, '', 0, 0, '2024-10-01 18:35:28', '2024-10-01 18:35:28'),
(61, 125, 9, 5, 0, 'test', 0, 0, '2024-10-01 18:40:35', '2024-10-01 18:40:35'),
(62, 125, 3, 7, 0, 'ok', 0, 0, '2024-10-01 18:40:35', '2024-10-01 18:40:35'),
(63, 125, 10, 7, 0, 'yahhh', 1, 0, '2024-10-01 18:40:35', '2024-10-01 18:40:35'),
(64, 126, 14, 5, 0, 'test', 0, 0, '2024-10-01 18:43:34', '2024-10-01 18:43:34'),
(65, 127, 4, 5, 0, '', 1, 0, '2024-10-01 18:49:18', '2024-10-01 18:49:18'),
(66, 127, 9, 8, 0, 'ok', 0, 0, '2024-10-01 18:49:18', '2024-10-01 18:49:18'),
(67, 127, 11, 9, 0, '', 1, 0, '2024-10-01 18:49:18', '2024-10-01 18:49:18'),
(68, 128, 9, 5, 0, 'test', 1, 0, '2024-10-01 18:49:43', '2024-10-01 18:49:43'),
(69, 131, 1, 5, 0, 'test', 1, 0, '2024-10-04 11:54:29', '2024-10-04 11:54:29'),
(70, 131, 3, 5, 0, 'ok', 0, 0, '2024-10-04 11:54:29', '2024-10-04 11:54:29'),
(71, 131, 9, 7, 0, 'yahhh', 1, 0, '2024-10-04 11:54:29', '2024-10-04 11:54:29'),
(72, 133, 14, 5, 0, 'test', 1, 0, '2024-10-04 12:24:05', '2024-10-04 12:24:05'),
(73, 133, 14, 6, 0, 'ok', 0, 0, '2024-10-04 12:24:05', '2024-10-04 12:24:05'),
(74, 133, 9, 12, 0, 'yahhh', 1, 0, '2024-10-04 12:24:05', '2024-10-04 12:24:05'),
(75, 133, 14, 5, 0, 'test', 1, 0, '2024-10-04 12:39:18', '2024-10-04 12:39:18'),
(76, 133, 14, 5, 0, 'test', 1, 0, '2024-10-04 12:39:43', '2024-10-04 12:39:43'),
(77, 133, 14, 5, 0, 'test', 1, 0, '2024-10-04 12:40:38', '2024-10-04 12:40:38'),
(78, 133, 14, 5, 0, 'test', 1, 0, '2024-10-04 12:40:43', '2024-10-04 12:40:43'),
(79, 133, 14, 5, 0, 'test', 0, 0, '2024-10-04 12:43:20', '2024-10-04 12:43:20'),
(80, 134, 14, 5, 5, 'test', 1, 1, '2024-10-04 12:53:32', '2024-10-06 07:44:44'),
(81, 134, 3, 10, 0, 'agg', 0, 0, '2024-10-04 12:53:32', '2024-10-04 12:53:32'),
(82, 134, 14, 5, 0, 'test', 1, 0, '2024-10-04 12:56:41', '2024-10-04 12:56:41'),
(83, 140, 9, 5, 0, 'test', 1, 0, '2024-10-05 14:57:26', '2024-10-05 14:57:26'),
(84, 140, 14, 6, 0, '', 0, 0, '2024-10-05 14:57:26', '2024-10-05 14:57:26'),
(85, 140, 10, 6, 0, 'yahhh', 1, 0, '2024-10-05 14:57:26', '2024-10-05 14:57:26'),
(86, 151, 9, 5, 0, '', 0, 0, '2024-10-06 07:05:32', '2024-10-06 07:05:32'),
(87, 153, 14, 5, 0, '', 1, 0, '2024-10-06 07:08:30', '2024-10-06 07:08:30'),
(88, 153, 14, 5, 5, 'Barang sudah dateng semua', 1, 1, '2024-10-06 07:21:37', '2024-10-06 07:21:37'),
(89, 151, 9, 5, 5, 'Barang sudah dateng semua', 0, 1, '2024-10-06 07:22:37', '2024-10-06 07:22:37'),
(90, 153, 14, 5, 5, 'Barang sudah dateng semua', 1, 1, '2024-10-06 07:28:24', '2024-10-06 07:28:24'),
(91, 140, 9, 5, 5, 'test', 1, 1, '2024-10-06 07:28:54', '2024-10-06 07:28:54'),
(92, 134, 3, 10, 10, 'agg', 0, 1, '2024-10-06 07:32:07', '2024-10-06 07:32:07'),
(93, 154, 14, 5, 0, 'test', 1, 0, '2024-10-06 07:51:38', '2024-10-06 07:51:38'),
(94, 154, 5, 15, 15, '', 0, 1, '2024-10-06 07:51:38', '2024-10-06 07:52:33'),
(95, 154, 13, 4, 4, '', 1, 1, '2024-10-06 07:51:38', '2024-10-06 07:57:43'),
(96, 155, 9, 5, 5, 'test', 0, 1, '2024-10-06 13:12:35', '2024-10-06 13:14:11'),
(97, 155, 11, 15, 0, 'testtt', 1, 0, '2024-10-06 13:12:35', '2024-10-06 13:14:11'),
(98, 155, 5, 17, 17, 'yahhh', 0, 1, '2024-10-06 13:12:35', '2024-10-06 13:14:11'),
(99, 159, 11, 5, 0, 'testtt', 0, 0, '2024-10-06 19:37:29', '2024-10-06 19:37:29'),
(100, 159, 5, 5, 0, '', 0, 0, '2024-10-06 19:37:29', '2024-10-06 19:37:29'),
(101, 159, 13, 5, 0, 'yahhh', 1, 0, '2024-10-06 19:37:29', '2024-10-06 19:37:29'),
(102, 160, 4, 5, 0, 'test', 0, 0, '2024-10-06 19:45:50', '2024-10-06 19:45:50'),
(103, 160, 5, 15, 0, 'coba aja', 1, 0, '2024-10-06 19:45:50', '2024-10-06 19:45:50'),
(104, 161, 1, 5, 0, 'test', 0, 0, '2024-10-06 19:48:38', '2024-10-06 19:48:38'),
(105, 161, 4, 12, 0, '', 1, 0, '2024-10-06 19:48:38', '2024-10-06 19:48:38'),
(106, 161, 11, 17, 0, '', 0, 0, '2024-10-06 19:48:38', '2024-10-06 19:48:38'),
(107, 161, 9, 26, 0, '', 0, 0, '2024-10-06 19:48:38', '2024-10-06 19:48:38'),
(108, 161, 10, 10, 0, '', 1, 0, '2024-10-06 19:48:38', '2024-10-06 19:48:38'),
(109, 162, 11, 5, 0, '', 1, 0, '2024-10-08 06:46:07', '2024-10-08 06:46:07'),
(110, 162, 9, 12, 0, 'testtt', 0, 0, '2024-10-08 06:46:07', '2024-10-08 06:46:07'),
(111, 162, 5, 14, 0, 'yahhh', 1, 0, '2024-10-08 06:46:07', '2024-10-08 06:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `nama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `shift_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` int NOT NULL,
  `shift` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `waktu_kerja` decimal(4,2) NOT NULL,
  `nama_operator` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mulai_istirahat` time NOT NULL,
  `selesai_istirahat` time NOT NULL,
  `kendala` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ganti_benang` int NOT NULL,
  `ganti_kain` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`shift_id`, `tanggal`, `user_id`, `shift`, `waktu_kerja`, `nama_operator`, `mulai_istirahat`, `selesai_istirahat`, `kendala`, `ganti_benang`, `ganti_kain`) VALUES
(21, '2024-06-12', 2, '2', 0.44, 'Joni', '12:00:00', '13:00:00', 'tidak ada', 1, 1),
(22, '2024-06-12', 2, '2', 0.33, 'Joni', '12:00:00', '13:00:00', 'test', 1, 1),
(23, '2024-09-05', 2, '2', 1.00, 'Koni', '12:00:00', '13:00:00', 'aewe', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int NOT NULL,
  `tambah_stock` date NOT NULL,
  `barang_id` int NOT NULL,
  `quantity_awal` float NOT NULL,
  `quantity_masuk` float NOT NULL,
  `quantity_keluar` float NOT NULL,
  `quantity_akhir` float NOT NULL,
  `user_id` int NOT NULL,
  `is_ready` tinyint(1) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `tambah_stock`, `barang_id`, `quantity_awal`, `quantity_masuk`, `quantity_keluar`, `quantity_akhir`, `user_id`, `is_ready`, `is_new`, `created_at`, `updated_at`) VALUES
(6, '2024-09-02', 1, 0, 3, 0, 3, 2, 0, 1, '2024-09-04 21:14:34', '2024-09-04 21:14:34'),
(10, '2024-09-02', 1, 3, 6, 0, 9, 2, 0, 1, '2024-09-04 21:42:35', '2024-09-04 21:42:35'),
(13, '2024-09-02', 3, 0, 3, 0, 3, 2, 0, 1, '2024-09-04 21:55:25', '2024-09-04 21:55:25'),
(14, '2024-09-02', 3, 3, 5, 0, 8, 2, 0, 1, '2024-09-04 21:55:48', '2024-09-04 21:55:48'),
(16, '2024-09-02', 3, 8, 0, 6, 8, 2, 1, 0, '2024-09-04 22:05:32', '2024-09-04 22:05:32'),
(18, '2024-09-02', 5, 0, 0, 12, 0, 2, 1, 0, '2024-09-04 22:07:57', '2024-09-04 22:07:57'),
(20, '2024-09-02', 5, 0, 6, 0, 6, 2, 0, 1, '2024-09-04 22:09:48', '2024-09-04 22:09:48'),
(23, '2024-09-10', 3, 8, 0, 4, 4, 3, 1, 0, '2024-09-05 11:31:32', '2024-09-05 11:31:32'),
(24, '2024-09-11', 1, 9, 6, 0, 15, 6, 0, 1, '2024-09-05 14:24:42', '2024-09-05 14:24:42'),
(25, '2024-09-11', 1, 15, 0, 12, 15, 6, 1, 0, '2024-09-05 14:25:18', '2024-09-05 14:25:18'),
(26, '2024-09-19', 1, 15, 0, 6, 9, 6, 1, 0, '2024-09-05 14:31:46', '2024-09-05 14:31:46'),
(27, '2024-09-03', 3, 4, 12, 0, 16, 3, 0, 1, '2024-09-05 17:27:18', '2024-09-05 17:27:18'),
(28, '2024-09-03', 7, 0, 12, 0, 12, 3, 0, 1, '2024-09-05 17:29:00', '2024-09-05 17:29:00'),
(29, '2024-09-10', 3, 16, 0, 4, 12, 3, 1, 0, '2024-09-07 11:58:18', '2024-09-07 11:58:18'),
(30, '2024-09-19', 1, 9, 0, 6, 3, 6, 1, 0, '2024-09-07 11:58:36', '2024-09-07 11:58:36'),
(31, '2024-09-23', 3, 12, 0, 4, 8, 5, 1, 0, '2024-09-10 16:22:13', '2024-09-10 16:22:13'),
(32, '2024-09-01', 3, 8, 0, 4, 4, 1, 1, 0, '2024-09-13 19:28:06', '2024-09-13 19:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int NOT NULL,
  `nama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `notelfon` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kota` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kodepos` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `nama`, `notelfon`, `alamat`, `kota`, `kodepos`) VALUES
(1, 'Toko Sumber Jaya', '081252807753', 'Jalan Jaya no 15', 'Surabaya', 22134),
(2, 'Toko Abadi', '082122224532', 'Jalan Mawar  1/11', 'Jakarta', 60113),
(3, 'Toko Bahagia Kasih', '098741365897', 'Jl. Krembangan 123', 'Surabaya', 94123);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int NOT NULL,
  `satuan` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `satuan`) VALUES
(1, 'Meter'),
(5, 'Kilo'),
(6, 'Centimeter'),
(7, 'Yard'),
(8, 'Gulung'),
(9, 'Unit');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `id_role` int NOT NULL,
  `nama_pengguna` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kata_sandi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `id_role`, `nama_pengguna`, `email`, `kata_sandi`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'user1', 'user1@gmail.com', '123', '2024-08-04 14:59:38', '2024-08-04 14:59:38'),
(2, 2, 'Jojo', 'jojo@gmail.com', '123', '2024-08-13 09:40:30', '2024-08-13 09:40:30'),
(3, 3, 'Berttt', 'bert@gmail.com', '123', '2024-08-13 09:40:58', '2024-08-13 12:47:34'),
(5, 1, 'Felix', 'felix@gmail.com', '123', '2024-08-27 03:00:27', '2024-08-27 03:03:10'),
(6, 1, 'Christina', 'christina@gmail.com', '123', '2024-09-05 21:23:17', '2024-09-05 21:23:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `barangproduksi`
--
ALTER TABLE `barangproduksi`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporanproduksi`
--
ALTER TABLE `laporanproduksi`
  ADD PRIMARY KEY (`laporan_id`);

--
-- Indexes for table `laporan_keluar`
--
ALTER TABLE `laporan_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`mesin_id`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`nota_id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pembelian_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `pemesanan_id` (`pemesanan_id`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`belidetail_id`),
  ADD KEY `pembelian_id` (`pembelian_id`) USING BTREE,
  ADD KEY `pesandetail_id` (`pesandetail_id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`pemesanan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`penggunaan_id`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pesan_detail`
--
ALTER TABLE `pesan_detail`
  ADD PRIMARY KEY (`pesandetail_id`),
  ADD KEY `pemesanan_id` (`pemesanan_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shift_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `barang_id` (`barang_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `barangproduksi`
--
ALTER TABLE `barangproduksi`
  MODIFY `barang_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `laporanproduksi`
--
ALTER TABLE `laporanproduksi`
  MODIFY `laporan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `laporan_keluar`
--
ALTER TABLE `laporan_keluar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mesin`
--
ALTER TABLE `mesin`
  MODIFY `mesin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `nota_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `pembelian_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `belidetail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `pemesanan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `penggunaan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pesan_detail`
--
ALTER TABLE `pesan_detail`
  MODIFY `pesandetail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `shift_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`);

--
-- Constraints for table `gudang`
--
ALTER TABLE `gudang`
  ADD CONSTRAINT `gudang_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`),
  ADD CONSTRAINT `gudang_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`);

--
-- Constraints for table `pesan_detail`
--
ALTER TABLE `pesan_detail`
  ADD CONSTRAINT `pesan_detail_ibfk_1` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan` (`pemesanan_id`),
  ADD CONSTRAINT `pesan_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `shift_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
