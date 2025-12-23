-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 05:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

DROP DATABASE IF EXISTS quanlydethitracnghiem;
CREATE DATABASE quanlydethitracnghiem CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE quanlydethitracnghiem;

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
-- Table structure for table `bai_hoc`
--

CREATE TABLE `bai_hoc` (
  `id` varchar(10) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` text DEFAULT NULL,
  `anh_bai_hoc` varchar(255) DEFAULT NULL,
  `link_bai_hoc` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `id_danh_muc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bai_hoc`
--

INSERT INTO `bai_hoc` (`id`, `tieu_de`, `noi_dung`, `anh_bai_hoc`, `link_bai_hoc`, `ngay_tao`, `id_danh_muc`) VALUES
('BH1', 'Bài học 1', 'Nội dung bài học 1', 'bai1.jpg', 'https://www.youtube.com/watch?v=svZSkXxCnbs', '2025-12-01 04:37:38', 3),
('BH2', 'Bài học 2', 'Nội dung bài học 2', 'bai2.jpg', 'link2.html', '2025-12-01 04:37:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cau_hoi`
--

CREATE TABLE `cau_hoi` (
  `id` varchar(10) NOT NULL,
  `id_de_thi` varchar(10) NOT NULL,
  `noi_dung` text NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `muc_do` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cau_hoi`
--

INSERT INTO `cau_hoi` (`id`, `id_de_thi`, `noi_dung`, `hinh_anh`, `muc_do`) VALUES
('CH1', 'DT1', 'Chữ trong hình sau có nghĩa là gì ?', 'images.jpg', 'dễ'),
('CH2', 'DT1', '照片里有多少人？', 'hinh-anh-gia-dinh-hanh-phuc-cute-1.jpg', 'trung bình'),
('CH3', 'DT2', '1+1 = ?', NULL, 'khó'),
('CH_HSK1_01', 'DT_HSK1_01', '你好吗？', NULL, 'dễ'),
('CH_HSK1_02', 'DT_HSK1_01', '他是老师吗？', NULL, 'dễ'),
('CH_HSK1_03', 'DT_HSK1_01', '你叫什么名字？', NULL, 'dễ'),
('CH_HSK1_04', 'DT_HSK1_01', '你是哪国人？', NULL, 'trung bình'),
('CH_HSK1_05', 'DT_HSK1_01', '现在几点？', NULL, 'trung bình'),
('CH_HSK1_06', 'DT_HSK1_01', '你会说汉语吗？', NULL, 'trung bình'),
('CH_HSK1_07', 'DT_HSK1_01', '你家有几口人？', NULL, 'trung bình'),
('CH_HSK1_08', 'DT_HSK1_01', '你喜欢什么颜色？', NULL, 'trung bình'),
('CH_HSK1_09', 'DT_HSK1_01', '你住在哪儿？', NULL, 'khó'),
('CH_HSK1_10', 'DT_HSK1_01', '你今天做什么？', NULL, 'khó'),
('CH_MULTI_1', 'DT1', 'Các nội dung nào sau đây đúng về Jack?', 'jack.jpg', 'trung_binh');

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

-- --------------------------------------------------------

--
-- Table structure for table `cau_tra_loi_nguoi_dung`
--

CREATE TABLE `cau_tra_loi_nguoi_dung` (
  `id` varchar(50) NOT NULL,
  `id_cau_hoi` varchar(50) NOT NULL,
  `id_nguoi_tra_loi` varchar(10) NOT NULL,
  `noi_dung` text NOT NULL,
  `anh_dinh_kem` varchar(255) DEFAULT NULL,
  `thoi_gian_tao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cau_tra_loi_nguoi_dung`
--

INSERT INTO `cau_tra_loi_nguoi_dung` (`id`, `id_cau_hoi`, `id_nguoi_tra_loi`, `noi_dung`, `anh_dinh_kem`, `thoi_gian_tao`) VALUES
('051eae88ed3211f8498d', 'CHND_20251211_81c1a011ca', 'ND6', 'tuyệt vời\r\n', '1765961662_z6295691947218_3d5993a60e3de50544ebb6128d88ae56.jpg', '2025-12-17 15:54:22'),
('05a350d28267658c8427', 'CHND_20251211_23a9652133', 'ND6', 'Có nha bạn', '1765439929_736462.png', '2025-12-11 14:58:49'),
('2b4d9c240cd21f7c1879', 'CHND_20251211_81c1a011ca', 'ND6', 'Hello', '', '2025-12-17 15:52:03'),
('f499ab0ee98cc74dd2fe', 'CHND_20251211_81c1a011ca', 'ND6', 'Hehe mình biết rồi', '', '2025-12-17 15:49:15');

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_de_thi`
--

CREATE TABLE `danh_muc_de_thi` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danh_muc_de_thi`
--

INSERT INTO `danh_muc_de_thi` (`id`, `ten_danh_muc`, `mo_ta`) VALUES
(1, 'HSK', 'Đề thi tiếng Trung HSK'),
(2, 'TOPIK', 'Đề thi tiếng Hàn TOPIK'),
(3, 'TOEIC', 'Đề thi tiếng Anh TOEIC'),
(4, 'JPN', 'Chứng chỉ tiếng Nhật');

-- --------------------------------------------------------

--
-- Table structure for table `de_thi`
--

CREATE TABLE `de_thi` (
  `id` varchar(10) NOT NULL,
  `id_danh_muc` int(11) DEFAULT NULL,
  `ten_de_thi` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `thoi_gian` int(11) DEFAULT NULL,
  `thang_diem` int(11) DEFAULT 10,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `trang_thai` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `de_thi`
--

INSERT INTO `de_thi` (`id`, `id_danh_muc`, `ten_de_thi`, `mo_ta`, `thoi_gian`, `thang_diem`, `ngay_tao`, `trang_thai`) VALUES
('DT1', 1, 'Đề thi 1', 'Mô tả đề thi 1', 1, 10, '2025-12-01 04:37:38', 0),
('DT2', 2, 'Đề thi 2', 'Mô tả đề thi 2', 45, 10, '2025-12-01 04:37:38', 0),
('DT_HSK1_01', 1, 'HSK1 - Luyện tập tổng hợp', 'Luyện tập HSK1', 3, 100, '2025-12-17 16:23:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ket_qua_chi_tiet`
--

CREATE TABLE `ket_qua_chi_tiet` (
  `id` int(11) NOT NULL,
  `id_ket_qua` varchar(10) NOT NULL,
  `id_cau_hoi` varchar(10) NOT NULL,
  `id_lua_chon` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ket_qua_chi_tiet`
--

INSERT INTO `ket_qua_chi_tiet` (`id`, `id_ket_qua`, `id_cau_hoi`, `id_lua_chon`) VALUES
(47, 'KQ8', 'CH1', 'LC2'),
(48, 'KQ8', 'CH2', 'LC4'),
(49, 'KQ9', 'CH1', NULL),
(50, 'KQ9', 'CH2', 'LC3'),
(51, 'KQ10', 'CH3', 'LC5'),
(52, 'KQ11', 'CH1', NULL),
(53, 'KQ11', 'CH2', NULL),
(54, 'KQ12', 'CH1', NULL),
(55, 'KQ12', 'CH2', NULL),
(56, 'KQ12', 'CH_MULTI_1', NULL),
(57, 'KQ13', 'CH1', NULL),
(58, 'KQ13', 'CH2', NULL),
(59, 'KQ13', 'CH_MULTI_1', NULL),
(60, 'KQ14', 'CH1', NULL),
(61, 'KQ14', 'CH2', NULL),
(62, 'KQ14', 'CH_MULTI_1', NULL),
(63, 'KQ15', 'CH1', NULL),
(64, 'KQ15', 'CH2', NULL),
(65, 'KQ15', 'CH_MULTI_1', NULL),
(66, 'KQ16', 'CH1', NULL),
(67, 'KQ16', 'CH2', NULL),
(68, 'KQ16', 'CH_MULTI_1', NULL),
(73, 'KQ18', 'CH3', 'LC5'),
(82, 'KQ17', 'CH1', 'LC2'),
(83, 'KQ17', 'CH2', 'LC3'),
(84, 'KQ17', 'CH_MULTI_1', 'LC_M1'),
(85, 'KQ17', 'CH_MULTI_1', 'LC_M2'),
(86, 'KQ17', 'CH_MULTI_1', 'LC_M4'),
(87, 'KQ19', 'CH1', 'LC2'),
(88, 'KQ19', 'CH2', 'LC3'),
(89, 'KQ19', 'CH_MULTI_1', 'LC_M1'),
(90, 'KQ19', 'CH_MULTI_1', 'LC_M2'),
(91, 'KQ19', 'CH_MULTI_1', 'LC_M4'),
(92, 'KQ20', 'CH1', 'LC2'),
(93, 'KQ20', 'CH2', 'LC3'),
(94, 'KQ20', 'CH_MULTI_1', 'LC_M1'),
(95, 'KQ20', 'CH_MULTI_1', 'LC_M2'),
(96, 'KQ20', 'CH_MULTI_1', 'LC_M3'),
(100, 'KQ21', 'CH1', 'LC2'),
(101, 'KQ21', 'CH2', 'LC4'),
(102, 'KQ21', 'CH_MULTI_1', 'LC_M1'),
(103, 'KQ21', 'CH_MULTI_1', 'LC_M2'),
(104, 'KQ21', 'CH_MULTI_1', 'LC_M3'),
(105, 'KQ21', 'CH_MULTI_1', 'LC_M4'),
(106, 'KQ22', 'CH1', 'LC2'),
(107, 'KQ22', 'CH2', 'LC3'),
(108, 'KQ22', 'CH_MULTI_1', 'LC_M1'),
(109, 'KQ22', 'CH_MULTI_1', 'LC_M2'),
(110, 'KQ22', 'CH_MULTI_1', 'LC_M3'),
(111, 'KQ22', 'CH_MULTI_1', 'LC_M4'),
(112, 'KQ23', 'CH1', 'LC2'),
(113, 'KQ23', 'CH2', 'LC3'),
(114, 'KQ23', 'CH_MULTI_1', 'LC_M1'),
(115, 'KQ23', 'CH_MULTI_1', 'LC_M2'),
(116, 'KQ23', 'CH_MULTI_1', 'LC_M3'),
(117, 'KQ23', 'CH_MULTI_1', 'LC_M4'),
(118, 'KQ24', 'CH1', 'LC2'),
(119, 'KQ24', 'CH2', 'LC3'),
(120, 'KQ24', 'CH_MULTI_1', 'LC_M1'),
(121, 'KQ24', 'CH_MULTI_1', 'LC_M2'),
(122, 'KQ24', 'CH_MULTI_1', 'LC_M3'),
(123, 'KQ24', 'CH_MULTI_1', 'LC_M4'),
(124, 'KQ25', 'CH1', 'LC1'),
(125, 'KQ25', 'CH2', 'LC3'),
(126, 'KQ25', 'CH_MULTI_1', 'LC_M1'),
(127, 'KQ26', 'CH1', 'LC2'),
(128, 'KQ26', 'CH2', 'LC4'),
(129, 'KQ26', 'CH_MULTI_1', 'LC_M1'),
(130, 'KQ26', 'CH_MULTI_1', 'LC_M2'),
(131, 'KQ26', 'CH_MULTI_1', 'LC_M3'),
(132, 'KQ26', 'CH_MULTI_1', 'LC_M4'),
(133, 'KQ27', 'CH1', 'LC1'),
(134, 'KQ27', 'CH2', 'LC3'),
(135, 'KQ27', 'CH_MULTI_1', 'LC_M2'),
(136, 'KQ28', 'CH1', 'LC1'),
(137, 'KQ28', 'CH2', 'LC3'),
(138, 'KQ28', 'CH_MULTI_1', NULL),
(139, 'KQ29', 'CH1', 'LC1'),
(140, 'KQ29', 'CH2', 'LC3'),
(141, 'KQ29', 'CH_MULTI_1', 'LC_M1'),
(142, 'KQ29', 'CH_MULTI_1', 'LC_M2'),
(143, 'KQ29', 'CH_MULTI_1', 'LC_M4'),
(144, 'KQ31', 'CH_HSK1_01', NULL),
(145, 'KQ31', 'CH_HSK1_02', NULL),
(146, 'KQ31', 'CH_HSK1_03', NULL),
(147, 'KQ31', 'CH_HSK1_04', NULL),
(148, 'KQ31', 'CH_HSK1_05', NULL),
(149, 'KQ31', 'CH_HSK1_06', NULL),
(150, 'KQ31', 'CH_HSK1_07', NULL),
(151, 'KQ31', 'CH_HSK1_08', NULL),
(152, 'KQ31', 'CH_HSK1_09', NULL),
(153, 'KQ31', 'CH_HSK1_10', NULL),
(154, 'KQ32', 'CH_HSK1_01', 'LC101A'),
(155, 'KQ32', 'CH_HSK1_02', 'LC102A'),
(156, 'KQ32', 'CH_HSK1_03', 'LC103A'),
(157, 'KQ32', 'CH_HSK1_04', 'LC104A'),
(158, 'KQ32', 'CH_HSK1_05', 'LC105A'),
(159, 'KQ32', 'CH_HSK1_06', 'LC106A'),
(160, 'KQ32', 'CH_HSK1_07', 'LC107A'),
(161, 'KQ32', 'CH_HSK1_08', 'LC108A'),
(162, 'KQ32', 'CH_HSK1_09', 'LC109A'),
(163, 'KQ32', 'CH_HSK1_10', 'LC110A'),
(164, 'KQ33', 'CH_HSK1_01', NULL),
(165, 'KQ33', 'CH_HSK1_02', NULL),
(166, 'KQ33', 'CH_HSK1_03', NULL),
(167, 'KQ33', 'CH_HSK1_04', NULL),
(168, 'KQ33', 'CH_HSK1_05', NULL),
(169, 'KQ33', 'CH_HSK1_06', NULL),
(170, 'KQ33', 'CH_HSK1_07', NULL),
(171, 'KQ33', 'CH_HSK1_08', NULL),
(172, 'KQ33', 'CH_HSK1_09', NULL),
(173, 'KQ33', 'CH_HSK1_10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ket_qua_thi`
--

CREATE TABLE `ket_qua_thi` (
  `id` varchar(10) NOT NULL,
  `id_nguoi_dung` varchar(10) NOT NULL,
  `id_de_thi` varchar(10) NOT NULL,
  `diem_so` float DEFAULT NULL,
  `thoi_gian_nop` datetime DEFAULT current_timestamp(),
  `thoi_gian_bat_dau` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ket_qua_thi`
--

INSERT INTO `ket_qua_thi` (`id`, `id_nguoi_dung`, `id_de_thi`, `diem_so`, `thoi_gian_nop`, `thoi_gian_bat_dau`) VALUES
('KQ1', 'ND6', 'DT1', 5, '2025-12-10 15:19:09', '2025-12-10 15:19:02'),
('KQ10', 'ND8', 'DT2', 10, '2025-12-11 15:02:51', '2025-12-11 15:02:49'),
('KQ11', 'ND6', 'DT1', 0, '2025-12-17 09:38:31', '2025-12-17 09:37:29'),
('KQ12', 'ND6', 'DT1', 0, '2025-12-17 09:59:47', '2025-12-17 09:56:36'),
('KQ13', 'ND6', 'DT1', 0, '2025-12-17 10:05:11', '2025-12-17 10:00:07'),
('KQ14', 'ND6', 'DT1', 0, '2025-12-17 10:06:19', '2025-12-17 10:05:18'),
('KQ15', 'ND6', 'DT1', 0, '2025-12-17 10:10:31', '2025-12-17 10:10:11'),
('KQ16', 'ND6', 'DT1', 0, '2025-12-17 10:10:58', '2025-12-17 10:10:47'),
('KQ17', 'ND6', 'DT1', 10, '2025-12-17 10:43:04', '2025-12-17 10:17:36'),
('KQ18', 'ND6', 'DT2', 10, '2025-12-17 10:27:06', '2025-12-17 10:27:04'),
('KQ19', 'ND6', 'DT1', 10, '2025-12-17 10:59:20', '2025-12-17 10:59:09'),
('KQ2', 'ND6', 'DT2', 10, '2025-12-10 15:19:42', '2025-12-10 15:19:36'),
('KQ20', 'ND6', 'DT1', 6.67, '2025-12-17 10:59:39', '2025-12-17 10:59:30'),
('KQ21', 'ND6', 'DT1', 3.33, '2025-12-17 11:01:16', '2025-12-17 11:00:39'),
('KQ22', 'ND6', 'DT1', 6.67, '2025-12-17 11:10:33', '2025-12-17 11:10:24'),
('KQ23', 'ND6', 'DT1', 6.67, '2025-12-17 11:14:42', '2025-12-17 11:14:31'),
('KQ24', 'ND6', 'DT1', 6.67, '2025-12-17 11:18:22', '2025-12-17 11:18:08'),
('KQ25', 'ND6', 'DT1', 3.33, '2025-12-17 11:24:39', '2025-12-17 11:24:30'),
('KQ26', 'ND6', 'DT1', 3.33, '2025-12-17 11:25:08', '2025-12-17 11:24:58'),
('KQ27', 'ND6', 'DT1', 3.33, '2025-12-17 11:25:40', '2025-12-17 11:25:30'),
('KQ28', 'ND6', 'DT1', 3.33, '2025-12-17 11:25:52', '2025-12-17 11:25:48'),
('KQ29', 'ND6', 'DT1', 6.67, '2025-12-17 14:32:28', '2025-12-17 14:32:16'),
('KQ3', 'ND7', 'DT1', 10, '2025-12-10 15:52:45', '2025-12-10 15:52:36'),
('KQ30', 'ND6', 'DT1', NULL, '2025-12-17 14:47:48', '2025-12-17 14:47:48'),
('KQ31', 'ND6', 'DT_HSK1_01', 0, '2025-12-17 16:33:53', '2025-12-17 16:28:36'),
('KQ32', 'ND6', 'DT_HSK1_01', 60, '2025-12-17 16:36:35', '2025-12-17 16:35:19'),
('KQ33', 'ND6', 'DT_HSK1_01', 0, '2025-12-18 11:07:02', '2025-12-18 11:06:59'),
('KQ4', 'ND7', 'DT1', 5, '2025-12-10 16:01:38', '2025-12-10 16:01:21'),
('KQ5', 'ND7', 'DT1', 10, '2025-12-10 16:13:03', '2025-12-10 16:12:07'),
('KQ6', 'ND8', 'DT1', 10, '2025-12-11 10:38:27', '2025-12-11 10:38:19'),
('KQ7', 'ND8', 'DT1', 5, '2025-12-11 11:21:15', '2025-12-11 11:21:10'),
('KQ8', 'ND6', 'DT1', 5, '2025-12-11 14:58:11', '2025-12-11 14:58:07'),
('KQ9', 'ND8', 'DT1', 5, '2025-12-11 15:02:32', '2025-12-11 15:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `lich_su_lam_bai`
--

CREATE TABLE `lich_su_lam_bai` (
  `id` varchar(10) NOT NULL,
  `id_ket_qua` varchar(10) NOT NULL,
  `id_cau_hoi` varchar(10) NOT NULL,
  `id_lua_chon` varchar(10) NOT NULL,
  `dung_sai` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lua_chon`
--

CREATE TABLE `lua_chon` (
  `id` varchar(10) NOT NULL,
  `id_cau_hoi` varchar(10) NOT NULL,
  `noi_dung` text NOT NULL,
  `dung_sai` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lua_chon`
--

INSERT INTO `lua_chon` (`id`, `id_cau_hoi`, `noi_dung`, `dung_sai`) VALUES
('LC1', 'CH1', 'Bạn bè', 0),
('LC101A', 'CH_HSK1_01', '我很好', 0),
('LC101B', 'CH_HSK1_01', '他很好', 1),
('LC101C', 'CH_HSK1_01', '你是老师', 0),
('LC102A', 'CH_HSK1_02', '是的，他是老师', 0),
('LC102B', 'CH_HSK1_02', '不是，他是学生', 1),
('LC102C', 'CH_HSK1_02', '我不知道', 0),
('LC103A', 'CH_HSK1_03', '我叫李雷', 1),
('LC103B', 'CH_HSK1_03', '他叫王芳', 0),
('LC103C', 'CH_HSK1_03', '你是中国人', 0),
('LC104A', 'CH_HSK1_04', '我是中国人', 1),
('LC104B', 'CH_HSK1_04', '我住在北京', 0),
('LC104C', 'CH_HSK1_04', '我会说英语', 0),
('LC105A', 'CH_HSK1_05', '现在三点', 0),
('LC105B', 'CH_HSK1_05', '我三岁', 1),
('LC105C', 'CH_HSK1_05', '今天星期三', 0),
('LC106A', 'CH_HSK1_06', '我会说汉语', 0),
('LC106B', 'CH_HSK1_06', '我不会游泳', 1),
('LC106C', 'CH_HSK1_06', '我喜欢吃米饭', 0),
('LC107A', 'CH_HSK1_07', '我家有四口人', 1),
('LC107B', 'CH_HSK1_07', '我家很大', 0),
('LC107C', 'CH_HSK1_07', '我家在上海', 0),
('LC108A', 'CH_HSK1_08', '我喜欢蓝色', 1),
('LC108B', 'CH_HSK1_08', '我不喜欢吃鱼', 0),
('LC108C', 'CH_HSK1_08', '我会开车', 0),
('LC109A', 'CH_HSK1_09', '我住在广州', 1),
('LC109B', 'CH_HSK1_09', '我去学校', 0),
('LC109C', 'CH_HSK1_09', '我喜欢唱歌', 0),
('LC110A', 'CH_HSK1_10', '我今天学习汉语', 1),
('LC110B', 'CH_HSK1_10', '我昨天去商店', 0),
('LC110C', 'CH_HSK1_10', '我明天去旅游', 0),
('LC2', 'CH1', 'Chúng ta', 1),
('LC3', 'CH2', '六个人', 1),
('LC4', 'CH2', '四个人', 0),
('LC5', 'CH3', '2', 1),
('LC6', 'CH3', '3', 0),
('LC_M1', 'CH_MULTI_1', 'Anh ấy không bỏ con', 1),
('LC_M2', 'CH_MULTI_1', 'Anh ấy là ca sĩ giỏi nhất Việt Nam', 1),
('LC_M3', 'CH_MULTI_1', 'Anh ấy chu cấp 5 triệu', 0),
('LC_M4', 'CH_MULTI_1', 'Anh ấy là nam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` varchar(10) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `anh_dai_dien` varchar(255) DEFAULT NULL,
  `id_quyen` varchar(10) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` tinyint(1) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `anh_dai_dien`, `id_quyen`, `ngay_sinh`, `gioi_tinh`, `dia_chi`, `ngay_tao`) VALUES
('ND1', 'Hv', 'hv@gmail.com', '$2y$10$IKwGeijwumwxkIJRQdIvuOiEXqHAv4iYbNhy3XWjjyDtKErCpxYIy', '0123456789', NULL, 'Q2', NULL, NULL, NULL, '2025-12-01 04:37:38'),
('ND3', 'Admin', 'admin@gmail.com', '$2y$10$dvLvwVID0SirYZ2/F.DBge.jKlkcY.wmPKAM0a6iRUnz67pI6BOqG', '0123000000', NULL, 'Q1', NULL, NULL, NULL, '2025-12-01 04:37:38'),
('ND6', 'Nguyễn Hoàng Huy Phong', 'trucmai124@gmail.com', '$2y$10$/eKlII/ePr30VH0Cnj/zxO07ejKnivbp33XNTLCz3uWBWk.cGJyIO', '35341962145', '1765355921_42d5806e0d8bb423c977cd87b44e3202.jpg', 'Q2', '2004-10-23', 0, 'Ninh Thuận', '2025-12-01 07:01:15'),
('ND7', 'Nguyễn Vũ Huy Hoàng', 'hoang.nvh.66cnnt@ntu.edu.vn', '$2y$10$.XHNfTlebGyy5Wc9oWrUzu..gu1tuvqudvqAB4IuhsR.M8EI5fY22', '187641784', '1765356153_images.jpg', 'Q2', NULL, NULL, NULL, '2025-12-10 09:42:33'),
('ND8', 'Phạm Nhật Trường', 'truong.pn.64cntt@ntu.edu.vn', '$2y$10$Qgh0uan3FB8aw9UZrRZdR.HevB5cDj/rXPE3gB2c4XtIQz/0rd1/O', '0377875295', '1765964445_aa9423573c474ed08dbe0769fb0364f3.jpg', 'Q2', '2004-01-28', 0, 'Ninh Thuận', '2025-12-11 03:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `phan_quyen`
--

CREATE TABLE `phan_quyen` (
  `id` varchar(10) NOT NULL,
  `ten_quyen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phan_quyen`
--

INSERT INTO `phan_quyen` (`id`, `ten_quyen`) VALUES
('Q1', 'admin'),
('Q2', 'hoc_vien');

-- --------------------------------------------------------

--
-- Table structure for table `tap_tin_bai_hoc`
--

CREATE TABLE `tap_tin_bai_hoc` (
  `id` varchar(10) NOT NULL,
  `id_bai_hoc` varchar(10) NOT NULL,
  `duong_dan` varchar(255) NOT NULL,
  `loai_tap_tin` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tap_tin_bai_hoc`
--

INSERT INTO `tap_tin_bai_hoc` (`id`, `id_bai_hoc`, `duong_dan`, `loai_tap_tin`) VALUES
('TT1', 'BH1', 'file1.pdf', 'pdf'),
('TT2', 'BH2', 'file2.pdf', 'pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_baihoc_danhmuc` (`id_danh_muc`);

--
-- Indexes for table `cau_hoi`
--
ALTER TABLE `cau_hoi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cauhoi_dethi` (`id_de_thi`);

--
-- Indexes for table `cau_hoi_nguoi_dung`
--
ALTER TABLE `cau_hoi_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_hoi` (`id_nguoi_hoi`);

--
-- Indexes for table `cau_tra_loi_nguoi_dung`
--
ALTER TABLE `cau_tra_loi_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cau_hoi` (`id_cau_hoi`),
  ADD KEY `id_nguoi_tra_loi` (`id_nguoi_tra_loi`);

--
-- Indexes for table `danh_muc_de_thi`
--
ALTER TABLE `danh_muc_de_thi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_danh_muc` (`ten_danh_muc`);

--
-- Indexes for table `de_thi`
--
ALTER TABLE `de_thi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_de_thi_danh_muc` (`id_danh_muc`);

--
-- Indexes for table `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cau_hoi` (`id_cau_hoi`),
  ADD KEY `id_lua_chon` (`id_lua_chon`),
  ADD KEY `idx_ket_qua_cauhoi` (`id_ket_qua`,`id_cau_hoi`);

--
-- Indexes for table `ket_qua_thi`
--
ALTER TABLE `ket_qua_thi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ketqua_nguoidung` (`id_nguoi_dung`),
  ADD KEY `fk_ketqua_dethi` (`id_de_thi`);

--
-- Indexes for table `lich_su_lam_bai`
--
ALTER TABLE `lich_su_lam_bai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lichsu_ketqua` (`id_ket_qua`),
  ADD KEY `fk_lichsu_cauhoi` (`id_cau_hoi`),
  ADD KEY `fk_lichsu_luachon` (`id_lua_chon`);

--
-- Indexes for table `lua_chon`
--
ALTER TABLE `lua_chon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_luachon_cauhoi` (`id_cau_hoi`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_nguoidung_quyen` (`id_quyen`);

--
-- Indexes for table `phan_quyen`
--
ALTER TABLE `phan_quyen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tap_tin_bai_hoc`
--
ALTER TABLE `tap_tin_bai_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_taptin_baihoc` (`id_bai_hoc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danh_muc_de_thi`
--
ALTER TABLE `danh_muc_de_thi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD CONSTRAINT `fk_baihoc_danhmuc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_de_thi` (`id`);

--
-- Constraints for table `cau_hoi`
--
ALTER TABLE `cau_hoi`
  ADD CONSTRAINT `fk_cauhoi_dethi` FOREIGN KEY (`id_de_thi`) REFERENCES `de_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cau_hoi_nguoi_dung`
--
ALTER TABLE `cau_hoi_nguoi_dung`
  ADD CONSTRAINT `cau_hoi_nguoi_dung_ibfk_1` FOREIGN KEY (`id_nguoi_hoi`) REFERENCES `nguoi_dung` (`id`);

--
-- Constraints for table `cau_tra_loi_nguoi_dung`
--
ALTER TABLE `cau_tra_loi_nguoi_dung`
  ADD CONSTRAINT `cau_tra_loi_nguoi_dung_ibfk_1` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi_nguoi_dung` (`id`),
  ADD CONSTRAINT `cau_tra_loi_nguoi_dung_ibfk_2` FOREIGN KEY (`id_nguoi_tra_loi`) REFERENCES `nguoi_dung` (`id`);

--
-- Constraints for table `de_thi`
--
ALTER TABLE `de_thi`
  ADD CONSTRAINT `fk_de_thi_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_de_thi` (`id`);

--
-- Constraints for table `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  ADD CONSTRAINT `ket_qua_chi_tiet_ibfk_1` FOREIGN KEY (`id_ket_qua`) REFERENCES `ket_qua_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ket_qua_chi_tiet_ibfk_2` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ket_qua_chi_tiet_ibfk_3` FOREIGN KEY (`id_lua_chon`) REFERENCES `lua_chon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ket_qua_thi`
--
ALTER TABLE `ket_qua_thi`
  ADD CONSTRAINT `fk_ketqua_dethi` FOREIGN KEY (`id_de_thi`) REFERENCES `de_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ketqua_nguoidung` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lich_su_lam_bai`
--
ALTER TABLE `lich_su_lam_bai`
  ADD CONSTRAINT `fk_lichsu_cauhoi` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lichsu_ketqua` FOREIGN KEY (`id_ket_qua`) REFERENCES `ket_qua_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lichsu_luachon` FOREIGN KEY (`id_lua_chon`) REFERENCES `lua_chon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lua_chon`
--
ALTER TABLE `lua_chon`
  ADD CONSTRAINT `fk_luachon_cauhoi` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `fk_nguoidung_quyen` FOREIGN KEY (`id_quyen`) REFERENCES `phan_quyen` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tap_tin_bai_hoc`
--
ALTER TABLE `tap_tin_bai_hoc`
  ADD CONSTRAINT `fk_taptin_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
