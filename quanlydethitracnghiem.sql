-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2025 at 10:09 AM
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
('BH2', 'Bài học 2', 'Nội dung bài học 2', 'bai2.jpg', 'link2.html', '2025-12-01 04:37:38', 1),
('BH3', 'Bài học Test', 'Luyện Tập Test', '1766549984_42d5806e0d8bb423c977cd87b44e3202.jpg', 'https://www.youtube.com/\r\nhttps://www.youtube.com/watch?v=iB-FkHr_2tk&list=PLu1JbR18PKPGrRX7to0ZSFUHzh51Zq6OG', '2025-12-24 11:19:44', 1),
('BH4', 'Các Cách Dùng Của Chữ 得  Trong Tiếng Trung', 'Lời bài hát Chất Gây Hại\r\n[Verse 1: Quang Hùng MasterD]\r\n\r\nMặc quần ống loe (Loe)\r\n\r\nÁo anh oversize\r\n\r\nChỉnh trang lại tóc tai (Tai)\r\n\r\nDưới chân Nike\r\n\r\nChạy xe qua đón em (Đón em)\r\n\r\nTrái tim còn e ngại (Oh-oh)\r\n\r\nGiữ chặt tay lái\r\n\r\nMuốn được bên em sớm mai\r\n\r\n \r\n\r\n[Pre-Chorus: Quang Hùng MasterD]\r\n\r\nAnh không nói điêu đâu (Nói điêu đâu)\r\n\r\nAnh không thích làm màu (Ah-ah)\r\n\r\nAnh chỉ muốn thêm giàu để được lo cho em đến bạc đầu\r\n\r\nNhững nụ hôn tới sát lại\r\n\r\nMang nhiều thêm chất gây hại\r\n\r\nAnh như cảm giác là kẻ may mắn\r\n\r\nKhi em trao chiếc cúp anh là người thắng\r\n\r\n \r\n\r\n[Chorus: Quang Hùng MasterD]\r\n\r\nOh baby girl, em là vàng bạc châu báu\r\n\r\nChỉ muốn giữ em thật lâu để cuộc đời này lắm sắc màu\r\n\r\nEm khiến anh như chết điêu\r\n\r\nYêu em là điều chẳng thể thiếu\r\n\r\nCưa em là phải dùng hết chiêu\r\n\r\nTrao em cuộc tình này mãi real\r\n\r\nOh baby girl, em ngọt hơn socola\r\n\r\nĐôi mi khép chạm bờ môi\r\n\r\nChỉ vậy thôi anh muốn điên rồi\r\n\r\nAnh chẳng phải là người xấu xa\r\n\r\nĐưa em về quê thưa ba má\r\n\r\nTrên tay anh cầm một đóa hoa\r\n\r\nMong em gật đầu đồng ý nha\r\n\r\nSee upcoming pop shows\r\n\r\nGet tickets for your favorite artists\r\n\r\n \r\n\r\nYou might also like\r\n\r\nĐừng Để Tiền Rơi\r\n\r\nLow G (VNM)\r\n\r\nLần Cuối Anh Suy\r\n\r\nQuang Hùng MasterD & Hino (VNM)\r\n\r\nSau Tan Ca\r\n\r\nQuang Hùng MasterD', '1766551419_35bd5ef10c134bd9c76b0c723d94763f.jpg', 'https://www.youtube.com/watch?v=iB-FkHr_2tk&list=PLu1JbR18PKPGrRX7to0ZSFUHzh51Zq6OG\r\nhttps://www.youtube.com/watch?v=eX5b0T6VKXk', '2025-12-24 11:43:39', 1);

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
('CH4', 'DT3', 'Lớp 1A có 30 học sinh lớp 1B có 20 học sinh hỏi có tất cả bao nhiêu học sinh ở 2 lướp', '1766550414_42d5806e0d8bb423c977cd87b44e3202.jpg', 'dễ'),
('CH5', 'DT3', 'Con bò nặng 60kg con heo nặng 50kg hỏi hiệu số cân nặng của hai con là bao nhiêu ?', '', 'dễ'),
('CH6', 'DT3', 'Những câu trả lời đúng về a Jack', '', 'dễ');

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
('CHND_20251211_e3201d6b8f', 'Làm sao để nhớ được từ vựng nhanh vậy mọi người \nMong được giải đáp ạ.', NULL, 'ND8', '2025-12-11 11:54:33'),
('CHND_20251225_3905ab5b07', 'Chắc không anh Dũng', 'CHND_20251225_3905ab5b07.jpg', 'ND11', '2025-12-25 16:05:29'),
('CHND_20251225_eb82ac63ec', 'Anh Dũng báo vãi lolll', 'CHND_20251225_eb82ac63ec.png', 'ND11', '2025-12-25 16:08:08');

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
('05a350d28267658c8427', 'CHND_20251211_23a9652133', 'ND6', 'Có nha bạn', '1765439929_736462.png', '2025-12-11 14:58:49'),
('60c1354714ceee1511d3', 'CHND_20251211_23a9652133', 'ND11', 'Có nha cậu liên hệ số điện thoại này để lấy nha : 4267346w12321', '', '2025-12-25 16:08:56');

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
  `id_bai_hoc` varchar(10) DEFAULT NULL,
  `thang_diem` int(11) DEFAULT 10,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `trang_thai` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `de_thi`
--

INSERT INTO `de_thi` (`id`, `id_danh_muc`, `ten_de_thi`, `mo_ta`, `thoi_gian`, `id_bai_hoc`, `thang_diem`, `ngay_tao`, `trang_thai`) VALUES
('DT1', 1, 'Đề thi 1', 'Mô tả đề thi 1', 1, 'BH1', 10, '2025-12-01 04:37:38', 0),
('DT2', 2, 'Đề thi 2', 'Mô tả đề thi 2', 45, 'BH2', 10, '2025-12-01 04:37:38', 0),
('DT3', 4, 'Đề thi Toán lớp 1', 'Đề thi dành cho học sinh tiểu học', 1, NULL, 10, '2025-12-24 10:32:58', 1);

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
(58, 'KQ1', 'CH1', 'LC1'),
(59, 'KQ1', 'CH2', 'LC3'),
(61, 'KQ3', 'CH4', 'LC8'),
(62, 'KQ3', 'CH5', 'LC11'),
(63, 'KQ4', 'CH4', 'LC8'),
(64, 'KQ4', 'CH5', 'LC11'),
(65, 'KQ5', 'CH4', 'LC7'),
(66, 'KQ5', 'CH5', 'LC12'),
(67, 'KQ6', 'CH4', 'LC8'),
(68, 'KQ6', 'CH5', 'LC12'),
(69, 'KQ7', 'CH4', 'LC8'),
(70, 'KQ7', 'CH5', 'LC11'),
(71, 'KQ8', 'CH4', 'LC7'),
(72, 'KQ8', 'CH5', 'LC13'),
(73, 'KQ9', 'CH4', 'LC8'),
(74, 'KQ9', 'CH5', 'LC11'),
(75, 'KQ10', 'CH4', 'LC8'),
(76, 'KQ10', 'CH5', 'LC11'),
(77, 'KQ11', 'CH5', 'LC11'),
(78, 'KQ12', 'CH4', 'LC8'),
(79, 'KQ12', 'CH5', 'LC11'),
(80, 'KQ12', 'CH6', 'LC15'),
(82, 'KQ13', 'CH4', 'LC8'),
(83, 'KQ13', 'CH5', 'LC11'),
(84, 'KQ13', 'CH6', 'LC15'),
(85, 'KQ13', 'CH6', 'LC16'),
(86, 'KQ14', 'CH6', 'LC15'),
(87, 'KQ14', 'CH6', 'LC16'),
(88, 'KQ14', 'CH6', 'LC18'),
(89, 'KQ15', 'CH4', 'LC8'),
(90, 'KQ15', 'CH5', 'LC11'),
(91, 'KQ15', 'CH6', 'LC15'),
(92, 'KQ15', 'CH6', 'LC16'),
(93, 'KQ17', 'CH4', 'LC8'),
(94, 'KQ18', 'CH5', 'LC12'),
(95, 'KQ20', 'CH5', 'LC11'),
(96, 'KQ21', 'CH4', 'LC8'),
(97, 'KQ21', 'CH5', 'LC12'),
(98, 'KQ21', 'CH6', 'LC15'),
(99, 'KQ22', 'CH4', 'LC8'),
(100, 'KQ22', 'CH5', 'LC11'),
(101, 'KQ22', 'CH6', 'LC15'),
(102, 'KQ23', 'CH6', 'LC15');

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
('KQ1', 'ND6', 'DT1', 5, '2025-12-24 11:07:09', '2025-12-24 11:07:09'),
('KQ10', 'ND11', 'DT3', 10, '2025-12-25 14:59:22', '2025-12-25 08:57:40'),
('KQ11', 'ND11', 'DT3', 5, '2025-12-25 15:13:07', '2025-12-25 09:13:00'),
('KQ12', 'ND3', 'DT3', 0, '2025-12-25 15:14:57', '2025-12-25 09:14:44'),
('KQ13', 'ND3', 'DT3', 10, '2025-12-25 15:31:19', '2025-12-25 09:14:44'),
('KQ14', 'ND3', 'DT3', 0, '2025-12-25 15:40:26', '0000-00-00 00:00:00'),
('KQ15', 'ND3', 'DT3', 10, '2025-12-25 15:40:51', '0000-00-00 00:00:00'),
('KQ16', 'ND3', 'DT3', 0, '2025-12-25 15:45:03', '2025-12-25 15:45:03'),
('KQ17', 'ND11', 'DT3', 3.33, '2025-12-25 15:48:16', '2025-12-25 15:48:16'),
('KQ18', 'ND11', 'DT3', 0, '2025-12-25 15:48:51', '2025-12-25 15:48:51'),
('KQ19', 'ND11', 'DT3', 0, '2025-12-25 15:53:23', '2025-12-25 15:53:23'),
('KQ2', 'ND6', 'DT1', 0, '2025-12-24 11:26:44', '2025-12-24 11:26:44'),
('KQ20', 'ND11', 'DT3', 3.33, '2025-12-25 15:54:23', '2025-12-25 15:54:23'),
('KQ21', 'ND11', 'DT3', 3.33, '2025-12-25 16:00:14', '2025-12-25 10:00:02'),
('KQ22', 'ND11', 'DT3', 6.67, '2025-12-25 16:02:09', '2025-12-25 16:01:57'),
('KQ23', 'ND11', 'DT3', 0, '2025-12-25 16:02:53', '2025-12-25 16:02:21'),
('KQ24', 'ND11', 'DT3', 0, '2025-12-25 16:04:23', '2025-12-25 16:03:21'),
('KQ3', 'ND11', 'DT3', 10, '2025-12-25 14:10:34', '2025-12-25 14:10:34'),
('KQ4', 'ND11', 'DT3', 10, '2025-12-25 14:16:02', '2025-12-25 14:16:02'),
('KQ5', 'ND11', 'DT3', 0, '2025-12-25 14:27:27', '2025-12-25 08:27:08'),
('KQ6', 'ND11', 'DT3', 5, '2025-12-25 14:30:56', '2025-12-25 14:30:56'),
('KQ7', 'ND11', 'DT3', 10, '2025-12-25 14:35:22', '2025-12-25 14:35:22'),
('KQ8', 'ND11', 'DT3', 0, '2025-12-25 14:37:41', '2025-12-25 14:37:41'),
('KQ9', 'ND11', 'DT3', 10, '2025-12-25 14:47:47', '2025-12-25 08:47:14');

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
('LC10', 'CH4', '100', 0),
('LC11', 'CH5', '10kg', 1),
('LC12', 'CH5', '30kg', 0),
('LC13', 'CH5', '35kg', 0),
('LC14', 'CH5', '15kg', 0),
('LC15', 'CH6', 'Anh ấy đẹp trai', 1),
('LC16', 'CH6', 'Anh ấy dễ thương', 1),
('LC17', 'CH6', 'Anh ấy bỏ con', 0),
('LC18', 'CH6', 'Anh ấy chu cấp 5 triệu', 0),
('LC2', 'CH1', 'Chúng ta', 1),
('LC3', 'CH2', '六个人', 1),
('LC4', 'CH2', '四个人', 0),
('LC5', 'CH3', '2', 1),
('LC6', 'CH3', '3', 0),
('LC7', 'CH4', '40', 0),
('LC8', 'CH4', '50', 1),
('LC9', 'CH4', '60', 0);

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
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0,
  `verify_token` varchar(64) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `anh_dai_dien`, `id_quyen`, `ngay_sinh`, `gioi_tinh`, `dia_chi`, `ngay_tao`, `is_verified`, `verify_token`, `reset_token`, `reset_token_expiry`) VALUES
('ND1', 'Hv', 'hv@gmail.com', '$2y$10$IKwGeijwumwxkIJRQdIvuOiEXqHAv4iYbNhy3XWjjyDtKErCpxYIy', '0123456789', NULL, 'Q2', NULL, NULL, NULL, '2025-12-01 04:37:38', 0, NULL, NULL, NULL),
('ND10', 'Trần Đại Dũng', 'dung.td.64cntt@ntu.edu.vn', '$2y$10$gHRP6CuRcnqAWGC6euAbJ.VZmJHtnyfO3kMxcun9Nwj1YuvQgPnUq', '0377875294', '1766629440_54k.png', 'Q2', '2004-07-23', 0, 'Nha Trang', '2025-12-25 03:24:00', 0, '2d6bdfd4d0e73ab1fea2ad30a4b4e5bd056140ad276cbc61cfd622ab5a124ebd', NULL, NULL),
('ND11', 'Phạm Nhật Trường', 'truongpham28124@gmail.com', '$2y$10$0OnhTQxtnEY94vMkQ1QlfeVNoYH429qVu6Peyb3JM4C6g9AcZ.yQu', '0377875296', '1766632954_ChatGPT Image 13_44_29 16 thg 4, 2025.png', 'Q2', '2004-01-28', 0, 'Ninh Thuận', '2025-12-25 04:22:34', 1, NULL, NULL, NULL),
('ND12', 'Trúc Mai', 'trucma1672@gmail.com', '$2y$10$2A79v/AN54rhGg1Zvsfvw.BfL2ktMBrcVocHO3ysi7626L3pXJZm6', '01897321231', '1766633605_329153497_1527737297736766_819603327207651751_n.jpg', 'Q2', '2004-08-23', 0, 'Nha Trang', '2025-12-25 04:33:25', 0, '71e820ac8400bab4d4addda8ad350f69f9106b548066a0026dfdfcc948238283', NULL, NULL),
('ND13', 'Trúc Mai', 'maitruc123@gmail.com', '$2y$10$sOqvWt7ZcnYE84JoJt2nEOKtG93uMhFj/MHOk4llGHpySPshW8ad.', '1576224142', '1766633856_736462.png', 'Q2', '2005-05-23', 0, 'Nha Trang', '2025-12-25 04:37:36', 0, 'd9531eb70b60b90363fe806de476f41831b2eaaca5485bbb7e43ed074b2a7831', NULL, NULL),
('ND14', 'Châu Huệ Mẫn', 'chauhueman123@gmail.com', '$2y$10$gCZewwu2sUJHTkkSIbL8ouvOXoSBeVJsKwghMYYw7Pz7g7pEnRY8u', '18627182', '1766633954_doraemon.jpg', 'Q2', '2002-07-01', 0, 'Nha Trang', '2025-12-25 04:39:14', 0, 'a0fc3f80590788e0818f13f08ba9ef226886a48f7790277bfc9b504359f2b555', NULL, NULL),
('ND3', 'Admin', 'admin@gmail.com', '$2y$10$dvLvwVID0SirYZ2/F.DBge.jKlkcY.wmPKAM0a6iRUnz67pI6BOqG', '0123000000', NULL, 'Q1', NULL, NULL, NULL, '2025-12-01 04:37:38', 1, NULL, NULL, NULL),
('ND6', 'Nguyễn Hoàng Huy Phong', 'trucmai124@gmail.com', '$2y$10$/eKlII/ePr30VH0Cnj/zxO07ejKnivbp33XNTLCz3uWBWk.cGJyIO', '0377875291', '1766549459_images.jpg', 'Q2', '0000-00-00', 0, '', '2025-12-01 07:01:15', 0, NULL, NULL, NULL),
('ND7', 'Nguyễn Vũ Huy Hoàng', 'hoang.nvh.66cnnt@ntu.edu.vn', '$2y$10$.XHNfTlebGyy5Wc9oWrUzu..gu1tuvqudvqAB4IuhsR.M8EI5fY22', '187641784', '1765356153_images.jpg', 'Q2', NULL, NULL, NULL, '2025-12-10 09:42:33', 0, NULL, NULL, NULL),
('ND8', 'Phạm Nhật Trường', 'truong.pn.64cntt@ntu.edu.vn', '$2y$10$G8qFHHdJ1Kzzd888G5K3medTVdUZ.9bcw93zai.8CMqT2lZYhkMq.', '0377875295', '1765421826_z6269562799673_7ef78d977acba491d670974db406e681.jpg', 'Q2', '2004-01-28', 0, 'Ninh Thuận', '2025-12-11 03:57:06', 1, NULL, NULL, NULL),
('ND9', 'hgcvhg', 'truong@gmail.com', '$2y$10$gPhTdnobU5GRq331UMIhfuT6tG4Of0ddY2vfVJi8bZMQ51DimA40y', '75576576576', '1766551608_images.jpg', 'Q2', '2007-04-02', 0, 'vftfc', '2025-12-24 05:46:48', 0, NULL, NULL, NULL);

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
('TT2', 'BH2', 'file2.pdf', 'pdf'),
('TT3', 'BH3', 'Đề N2 T7-2023 (230710)_250611_194144.pdf', 'pdf'),
('TT4', 'BH3', 'GetX_StateManagement.pdf', 'pdf'),
('TT5', 'BH4', 'file2.docx', 'docx');

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
  ADD KEY `fk_dethi_baihoc` (`id_bai_hoc`),
  ADD KEY `fk_de_thi_danh_muc` (`id_danh_muc`);

--
-- Indexes for table `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cau_hoi` (`id_cau_hoi`),
  ADD KEY `id_lua_chon` (`id_lua_chon`),
  ADD KEY `id_ket_qua_2` (`id_ket_qua`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

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
  ADD CONSTRAINT `fk_de_thi_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_de_thi` (`id`),
  ADD CONSTRAINT `fk_dethi_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
