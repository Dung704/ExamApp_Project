-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 10:06 AM
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
('BH1', 'Bài học 1', 'Nội dung bài học 1', 'bai1.jpg', 'link1.html', '2025-12-01 04:37:38', 3),
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
('CH1', 'DT1', 'Câu hỏi 1 của đề 1', NULL, 'dễ'),
('CH2', 'DT1', 'Câu hỏi 2 của đề 1', NULL, 'trung bình'),
('CH3', 'DT2', 'Câu hỏi 1 của đề 2', NULL, 'khó');

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
(3, 'TOEIC', 'Đề thi tiếng Anh TOEIC');

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
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `de_thi`
--

INSERT INTO `de_thi` (`id`, `id_danh_muc`, `ten_de_thi`, `mo_ta`, `thoi_gian`, `id_bai_hoc`, `thang_diem`, `ngay_tao`) VALUES
('DT1', 1, 'Đề thi 1', 'Mô tả đề thi 1', 30, 'BH1', 10, '2025-12-01 04:37:38'),
('DT2', 2, 'Đề thi 2', 'Mô tả đề thi 2', 45, 'BH2', 10, '2025-12-01 04:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `ket_qua_thi`
--

CREATE TABLE `ket_qua_thi` (
  `id` varchar(10) NOT NULL,
  `id_nguoi_dung` varchar(10) NOT NULL,
  `id_de_thi` varchar(10) NOT NULL,
  `diem_so` float DEFAULT NULL,
  `thoi_gian_nop` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ket_qua_thi`
--

INSERT INTO `ket_qua_thi` (`id`, `id_nguoi_dung`, `id_de_thi`, `diem_so`, `thoi_gian_nop`) VALUES
('KQ1', 'ND1', 'DT1', 8, '2025-12-01 04:37:38'),
('KQ2', 'ND2', 'DT1', 7, '2025-12-01 04:37:38'),
('KQ3', 'ND1', 'DT2', 9, '2025-12-01 04:37:38');

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

--
-- Dumping data for table `lich_su_lam_bai`
--

INSERT INTO `lich_su_lam_bai` (`id`, `id_ket_qua`, `id_cau_hoi`, `id_lua_chon`, `dung_sai`) VALUES
('LS1', 'KQ1', 'CH1', 'LC1', 1),
('LS2', 'KQ1', 'CH2', 'LC3', 0),
('LS3', 'KQ2', 'CH1', 'LC2', 0),
('LS4', 'KQ3', 'CH3', 'LC6', 1);

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
('LC1', 'CH1', 'Đáp án A', 0),
('LC2', 'CH1', 'Đáp án B', 1),
('LC3', 'CH2', 'Đáp án C', 1),
('LC4', 'CH2', 'Đáp án D', 0),
('LC5', 'CH3', 'Đáp án E', 1),
('LC6', 'CH3', 'Đáp án F', 0);

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
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `anh_dai_dien`, `id_quyen`, `ngay_tao`) VALUES
('ND1', 'Hv', 'hv@gmail.com', '$2y$10$IKwGeijwumwxkIJRQdIvuOiEXqHAv4iYbNhy3XWjjyDtKErCpxYIy', '0123456789', '1764572609_DeGK_04.png', 'Q3', '2025-12-01 04:37:38'),
('ND2', 'Gv', 'gv@gmail.com', '$2y$10$dvLvwVID0SirYZ2/F.DBge.jKlkcY.wmPKAM0a6iRUnz67pI6BOqG', '0987654321', '1764572609_DeGK_04.png', 'Q2', '2025-12-01 04:37:38'),
('ND3', 'Admin', 'admin@gmail.com', '$2y$10$dvLvwVID0SirYZ2/F.DBge.jKlkcY.wmPKAM0a6iRUnz67pI6BOqG', '0123000000', '1764572609_DeGK_04.png', 'Q1', '2025-12-01 04:37:38'),
('ND6', 'Trúc Mai', 'trucmai124@gmail.com', '$2y$10$/eKlII/ePr30VH0Cnj/zxO07ejKnivbp33XNTLCz3uWBWk.cGJyIO', '35341962145', '1764572136_329153497_1527737297736766_819603327207651751_n.jpg', 'Q2', '2025-12-01 07:01:15');
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
('Q2', 'giang_vien'),
('Q3', 'hoc_vien');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Constraints for table `de_thi`
--
ALTER TABLE `de_thi`
  ADD CONSTRAINT `fk_de_thi_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_de_thi` (`id`),
  ADD CONSTRAINT `fk_dethi_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
