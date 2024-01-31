-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 18, 2024 at 04:32 AM
-- Server version: 10.10.2-MariaDB
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_pajak`
--
CREATE DATABASE IF NOT EXISTS `system_pajak` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `system_pajak`;

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi`
--

DROP TABLE IF EXISTS `data_transaksi`;
CREATE TABLE IF NOT EXISTS `data_transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(100) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `ppn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  UNIQUE KEY `no_faktur` (`no_faktur`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_transaksi`
--

INSERT INTO `data_transaksi` (`id_transaksi`, `no_faktur`, `tanggal_pembelian`, `supplier`, `nama_barang`, `harga`, `ppn`) VALUES
(1, 'TP-001', '2024-01-18', 'Toko mebel', 'meja rapat', '2000000', '200000'),
(2, 'TP-002', '2024-01-18', 'Toko elektronik', 'komputer', '4000000', '400000'),
(9, 'TP-003', '2023-08-26', 'toko mebel', 'kursi', '2250000', '225000'),
(11, 'TP-004', '2023-08-26', 'Toko eko', 'Atk', '2250000', '225000'),
(12, 'TP-005', '2023-07-27', 'toko mebel', 'meja rapat', '3250000', '325000'),
(17, 'PT-0123', '2023-12-31', 'toko kursi', 'kursi', '20213123', '2021312.3'),
(19, 'PT-0124', '2023-12-31', 'asdaw', 'kursi', '22242', '2224.2'),
(20, '1312ekl2l1', '2024-01-18', 'adww', 'adwa', '10000000000', '1000000000');

-- --------------------------------------------------------

--
-- Table structure for table `seting_pajak`
--

DROP TABLE IF EXISTS `seting_pajak`;
CREATE TABLE IF NOT EXISTS `seting_pajak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `angka` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seting_pajak`
--

INSERT INTO `seting_pajak` (`id`, `angka`) VALUES
(1, 0.11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'admin', 'admin@coding.dev', 'BROADCAST_2324_20230613_220956.jpg', '$2y$10$CXNhC/Q9ZAgDwOTTKHAPGOezMdc3FCwV4ezdOdaJz7iZbIY7KIdV6', 1, 1, 1667232119),
(13, 'user', 'user@coding.dev', 'logo1.png', '$2y$10$OdIHfQbb2LteAIfNr0oMbuAo1Vntp/p4QR6KaYCv8Nb/posQEVfa.', 2, 1, 1693141618),
(19, 'Deva', 'ezarr699@gmail.com', 'default.jpg', '$2y$10$S3L7FnNCOWuoxbYquZ/O6OoTetCmZaY/mthSveR5SmNIMXb9VxkRi', 2, 1, 1693214949);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

DROP TABLE IF EXISTS `user_access_menu`;
CREATE TABLE IF NOT EXISTS `user_access_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(15, 1, 5),
(18, 2, 5),
(20, 1, 3),
(22, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

DROP TABLE IF EXISTS `user_menu`;
CREATE TABLE IF NOT EXISTS `user_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(5, 'PPN');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

DROP TABLE IF EXISTS `user_sub_menu`;
CREATE TABLE IF NOT EXISTS `user_sub_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'Dashboard', 'user', 'fas fa-fw fa-tachometer-alt	', 1),
(3, 2, 'My Profile', 'user/profile', 'fas fa-fw fa-user', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(10, 5, 'Data PPN', 'PPN', 'fas fa-fw fa-print', 1),
(11, 5, 'Data Pajak', 'PPN/datalis', 'fas fa-fw fa-print', 1),
(12, 1, 'User Managen', 'admin/user', 'fas fa-fw fa-user', 1),
(13, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(15, 1, 'Edit Profile', 'admin/edit', 'fas fa-fw fa-user-edit', 1),
(16, 1, 'Change Password', 'admin/changepassword', 'fas fa-fw fa-key', 1),
(19, 5, 'PPN Settings ', 'PPN/settings', 'fas fa-fw fa-cogs', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(10, 'user@coding.dev', '1L+Q/BDTkRkz12V2CUxDwrKIAOPMtD9Jd/u4MqMEWtY=', 1693141618);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
