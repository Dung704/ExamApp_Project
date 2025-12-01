-- Xóa database nếu đã tồn tại
DROP DATABASE IF EXISTS quanlydethitracnghiem;
CREATE DATABASE quanlydethitracnghiem CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE quanlydethitracnghiem;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Xóa bảng theo đúng thứ tự tránh lỗi khóa ngoại
DROP TABLE IF EXISTS lich_su_lam_bai;
DROP TABLE IF EXISTS ket_qua_thi;
DROP TABLE IF EXISTS lua_chon;
DROP TABLE IF EXISTS cau_hoi;
DROP TABLE IF EXISTS tap_tin_bai_hoc;
DROP TABLE IF EXISTS de_thi;
DROP TABLE IF EXISTS bai_hoc;
DROP TABLE IF EXISTS nguoi_dung;
DROP TABLE IF EXISTS phan_quyen;

-- --------------------------------------------------------
-- Table structure for table `phan_quyen`
-- --------------------------------------------------------
CREATE TABLE `phan_quyen` (
  `id` varchar(10) NOT NULL,
  `ten_quyen` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `phan_quyen` (`id`, `ten_quyen`) VALUES
('Q1', 'admin'),
('Q2', 'nguoi_dung');

-- --------------------------------------------------------
-- Table structure for table `nguoi_dung`
-- --------------------------------------------------------
CREATE TABLE `nguoi_dung` (
  `id` varchar(10) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `anh_dai_dien` varchar(255) DEFAULT NULL,
  `id_quyen` varchar(10) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_nguoidung_quyen` (`id_quyen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `id_quyen`) VALUES
('ND1', 'Nguyen Van A', 'a@gmail.com', '123456', '0123456789', 'Q2'),
('ND2', 'Tran Thi B', 'b@gmail.com', '123456', '0987654321', 'Q2'),
('ND3', 'Admin', 'admin@gmail.com', 'admin', '0123000000', 'Q1');

-- --------------------------------------------------------
-- Table structure for table `bai_hoc`
-- --------------------------------------------------------
CREATE TABLE `bai_hoc` (
  `id` varchar(10) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` text DEFAULT NULL,
  `anh_bai_hoc` varchar(255) DEFAULT NULL,
  `link_bai_hoc` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bai_hoc` (`id`, `tieu_de`, `noi_dung`, `anh_bai_hoc`, `link_bai_hoc`) VALUES
('BH1', 'Bài học 1', 'Nội dung bài học 1', 'bai1.jpg', 'link1.html'),
('BH2', 'Bài học 2', 'Nội dung bài học 2', 'bai2.jpg', 'link2.html');

-- --------------------------------------------------------
-- Table structure for table `de_thi`
-- --------------------------------------------------------
CREATE TABLE `de_thi` (
  `id` varchar(10) NOT NULL,
  `ten_de_thi` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `thoi_gian` int(11) DEFAULT NULL,
  `id_bai_hoc` varchar(10) DEFAULT NULL,
  `thang_diem` int(11) DEFAULT 10,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_dethi_baihoc` (`id_bai_hoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `de_thi` (`id`, `ten_de_thi`, `mo_ta`, `thoi_gian`, `id_bai_hoc`, `thang_diem`) VALUES
('DT1', 'Đề thi 1', 'Mô tả đề thi 1', 30, 'BH1', 10),
('DT2', 'Đề thi 2', 'Mô tả đề thi 2', 45, 'BH2', 10);

-- --------------------------------------------------------
-- Table structure for table `cau_hoi`
-- --------------------------------------------------------
CREATE TABLE `cau_hoi` (
  `id` varchar(10) NOT NULL,
  `id_de_thi` varchar(10) NOT NULL,
  `noi_dung` text NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `muc_do` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cauhoi_dethi` (`id_de_thi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cau_hoi` (`id`, `id_de_thi`, `noi_dung`, `hinh_anh`, `muc_do`) VALUES
('CH1', 'DT1', 'Câu hỏi 1 của đề 1', NULL, 'dễ'),
('CH2', 'DT1', 'Câu hỏi 2 của đề 1', NULL, 'trung bình'),
('CH3', 'DT2', 'Câu hỏi 1 của đề 2', NULL, 'khó');

-- --------------------------------------------------------
-- Table structure for table `lua_chon`
-- --------------------------------------------------------
CREATE TABLE `lua_chon` (
  `id` varchar(10) NOT NULL,
  `id_cau_hoi` varchar(10) NOT NULL,
  `noi_dung` text NOT NULL,
  `dung_sai` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_luachon_cauhoi` (`id_cau_hoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `lua_chon` (`id`, `id_cau_hoi`, `noi_dung`, `dung_sai`) VALUES
('LC1', 'CH1', 'Đáp án A', 0),
('LC2', 'CH1', 'Đáp án B', 1),
('LC3', 'CH2', 'Đáp án C', 1),
('LC4', 'CH2', 'Đáp án D', 0),
('LC5', 'CH3', 'Đáp án E', 1),
('LC6', 'CH3', 'Đáp án F', 0);

-- --------------------------------------------------------
-- Table structure for table `ket_qua_thi`
-- --------------------------------------------------------
CREATE TABLE `ket_qua_thi` (
  `id` varchar(10) NOT NULL,
  `id_nguoi_dung` varchar(10) NOT NULL,
  `id_de_thi` varchar(10) NOT NULL,
  `diem_so` float DEFAULT NULL,
  `thoi_gian_nop` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_ketqua_nguoidung` (`id_nguoi_dung`),
  KEY `fk_ketqua_dethi` (`id_de_thi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ket_qua_thi` (`id`, `id_nguoi_dung`, `id_de_thi`, `diem_so`) VALUES
('KQ1', 'ND1', 'DT1', 8),
('KQ2', 'ND2', 'DT1', 7),
('KQ3', 'ND1', 'DT2', 9);

-- --------------------------------------------------------
-- Table structure for table `lich_su_lam_bai`
-- --------------------------------------------------------
CREATE TABLE `lich_su_lam_bai` (
  `id` varchar(10) NOT NULL,
  `id_ket_qua` varchar(10) NOT NULL,
  `id_cau_hoi` varchar(10) NOT NULL,
  `id_lua_chon` varchar(10) NOT NULL,
  `dung_sai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lichsu_ketqua` (`id_ket_qua`),
  KEY `fk_lichsu_cauhoi` (`id_cau_hoi`),
  KEY `fk_lichsu_luachon` (`id_lua_chon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `lich_su_lam_bai` (`id`, `id_ket_qua`, `id_cau_hoi`, `id_lua_chon`, `dung_sai`) VALUES
('LS1', 'KQ1', 'CH1', 'LC1', 1),
('LS2', 'KQ1', 'CH2', 'LC3', 0),
('LS3', 'KQ2', 'CH1', 'LC2', 0),
('LS4', 'KQ3', 'CH3', 'LC6', 1);

-- --------------------------------------------------------
-- Table structure for table `tap_tin_bai_hoc`
-- --------------------------------------------------------
CREATE TABLE `tap_tin_bai_hoc` (
  `id` varchar(10) NOT NULL,
  `id_bai_hoc` varchar(10) NOT NULL,
  `duong_dan` varchar(255) NOT NULL,
  `loai_tap_tin` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_taptin_baihoc` (`id_bai_hoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tap_tin_bai_hoc` (`id`, `id_bai_hoc`, `duong_dan`, `loai_tap_tin`) VALUES
('TT1', 'BH1', 'file1.pdf', 'pdf'),
('TT2', 'BH2', 'file2.pdf', 'pdf');

-- --------------------------------------------------------
-- FOREIGN KEYS
-- --------------------------------------------------------
ALTER TABLE `cau_hoi`
  ADD CONSTRAINT `fk_cauhoi_dethi` FOREIGN KEY (`id_de_thi`) REFERENCES `de_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `de_thi`
  ADD CONSTRAINT `fk_dethi_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ket_qua_thi`
  ADD CONSTRAINT `fk_ketqua_dethi` FOREIGN KEY (`id_de_thi`) REFERENCES `de_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ketqua_nguoidung` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lich_su_lam_bai`
  ADD CONSTRAINT `fk_lichsu_cauhoi` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lichsu_ketqua` FOREIGN KEY (`id_ket_qua`) REFERENCES `ket_qua_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lichsu_luachon` FOREIGN KEY (`id_lua_chon`) REFERENCES `lua_chon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lua_chon`
  ADD CONSTRAINT `fk_luachon_cauhoi` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `fk_nguoidung_quyen` FOREIGN KEY (`id_quyen`) REFERENCES `phan_quyen` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tap_tin_bai_hoc`
  ADD CONSTRAINT `fk_taptin_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
