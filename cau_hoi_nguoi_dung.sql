-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 10:13 AM
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
-- Database: `quanlydethitracnghiem`
--

-- --------------------------------------------------------

--
-- Table structure for table `cau_hoi_nguoi_dung`
--

CREATE TABLE `cau_hoi_nguoi_dung` (
  `id` varchar(50) NOT NULL,
  `noi_dung` text NOT NULL,
  `anh_dinh_kem` varchar(255) DEFAULT NULL,
  `id_nguoi_hoi` varchar(10) NOT NULL,
  `thoi_gian_tao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cau_hoi_nguoi_dung`
--

INSERT INTO `cau_hoi_nguoi_dung` (`id`, `noi_dung`, `anh_dinh_kem`, `id_nguoi_hoi`, `thoi_gian_tao`) VALUES
('CHND_20251211_23a9652133', 'Có ai có tài liệu học HSK không ạ, \r\ngửi cho em qua mail này với ạ, admin không cho upload file lên đây ạ.', NULL, 'ND8', '2025-12-11 11:57:03'),
('CHND_20251211_3e3007cd52', 'Nên học trong bao lâu thì đi thi lấy chứng chỉ HSK được ạ', NULL, 'ND8', '2025-12-11 11:55:29'),
('CHND_20251211_7a206e4836', 'Mọi người ơi , có ai học tốt tiếng Nhật không ạ , em săp đi nhật rồi ạ.', NULL, 'ND6', '2025-12-11 12:01:28'),
('CHND_20251211_81c1a011ca', 'Chữ trong ảnh này đọc thế nào ạ', 'CHND_20251211_81c1a011ca.jpg', 'ND6', '2025-12-11 14:06:05'),
('CHND_20251211_e3201d6b8f', 'Làm sao để nhớ được từ vựng nhanh vậy mọi người \nMong được giải đáp ạ.', NULL, 'ND8', '2025-12-11 11:54:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cau_hoi_nguoi_dung`
--
ALTER TABLE `cau_hoi_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_hoi` (`id_nguoi_hoi`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cau_hoi_nguoi_dung`
--
ALTER TABLE `cau_hoi_nguoi_dung`
  ADD CONSTRAINT `cau_hoi_nguoi_dung_ibfk_1` FOREIGN KEY (`id_nguoi_hoi`) REFERENCES `nguoi_dung` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
