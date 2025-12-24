-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 24, 2025 lúc 02:23 AM
-- Phiên bản máy phục vụ: 8.0.43
-- Phiên bản PHP: 8.2.29
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
-- Cơ sở dữ liệu: `quanlydethitracnghiem`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_hoc`
--

CREATE TABLE `bai_hoc` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_general_ci,
  `anh_bai_hoc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_bai_hoc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_danh_muc` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_hoc`
--

INSERT INTO `bai_hoc` (`id`, `tieu_de`, `noi_dung`, `anh_bai_hoc`, `link_bai_hoc`, `ngay_tao`, `id_danh_muc`) VALUES
('BH1', 'Bài học 1', 'Nội dung bài học 1', 'bai1.jpg', 'https://www.youtube.com/watch?v=svZSkXxCnbs', '2025-12-01 04:37:38', 3),
('BH2', 'Bài học 2', 'Nội dung bài học 2', 'bai2.jpg', 'link2.html', '2025-12-01 04:37:38', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cau_hoi`
--

CREATE TABLE `cau_hoi` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_de_thi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_general_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `muc_do` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cau_hoi`
--

INSERT INTO `cau_hoi` (`id`, `id_de_thi`, `noi_dung`, `hinh_anh`, `muc_do`) VALUES
('CH1', 'DT1', 'Chữ trong hình sau có nghĩa là gì ?', 'images.jpg', 'dễ'),
('CH2', 'DT1', '照片里有多少人？', 'hinh-anh-gia-dinh-hanh-phuc-cute-1.jpg', 'trung bình'),
('CH3', 'DT2', '1+1 = ?', NULL, 'khó');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cau_hoi_nguoi_dung`
--

CREATE TABLE `cau_hoi_nguoi_dung` (
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_general_ci NOT NULL,
  `anh_dinh_kem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_nguoi_hoi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `thoi_gian_tao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cau_hoi_nguoi_dung`
--

INSERT INTO `cau_hoi_nguoi_dung` (`id`, `noi_dung`, `anh_dinh_kem`, `id_nguoi_hoi`, `thoi_gian_tao`) VALUES
('CHND_20251211_23a9652133', 'Có ai có tài liệu học HSK không ạ, \r\ngửi cho em qua mail này với ạ, admin không cho upload file lên đây ạ.', NULL, 'ND8', '2025-12-11 11:57:03'),
('CHND_20251211_3e3007cd52', 'Nên học trong bao lâu thì đi thi lấy chứng chỉ HSK được ạ', NULL, 'ND8', '2025-12-11 11:55:29'),
('CHND_20251211_7a206e4836', 'Mọi người ơi , có ai học tốt tiếng Nhật không ạ , em săp đi nhật rồi ạ.', NULL, 'ND6', '2025-12-11 12:01:28'),
('CHND_20251211_81c1a011ca', 'Chữ trong ảnh này đọc thế nào ạ', 'CHND_20251211_81c1a011ca.jpg', 'ND6', '2025-12-11 14:06:05'),
('CHND_20251211_e3201d6b8f', 'Làm sao để nhớ được từ vựng nhanh vậy mọi người \nMong được giải đáp ạ.', NULL, 'ND8', '2025-12-11 11:54:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cau_tra_loi_nguoi_dung`
--

CREATE TABLE `cau_tra_loi_nguoi_dung` (
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cau_hoi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_nguoi_tra_loi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_general_ci NOT NULL,
  `anh_dinh_kem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thoi_gian_tao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cau_tra_loi_nguoi_dung`
--

INSERT INTO `cau_tra_loi_nguoi_dung` (`id`, `id_cau_hoi`, `id_nguoi_tra_loi`, `noi_dung`, `anh_dinh_kem`, `thoi_gian_tao`) VALUES
('05a350d28267658c8427', 'CHND_20251211_23a9652133', 'ND6', 'Có nha bạn', '1765439929_736462.png', '2025-12-11 14:58:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc_de_thi`
--

CREATE TABLE `danh_muc_de_thi` (
  `id` int NOT NULL,
  `ten_danh_muc` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc_de_thi`
--

INSERT INTO `danh_muc_de_thi` (`id`, `ten_danh_muc`, `mo_ta`) VALUES
(1, 'HSK', 'Đề thi tiếng Trung HSK'),
(2, 'TOPIK', 'Đề thi tiếng Hàn TOPIK'),
(3, 'TOEIC', 'Đề thi tiếng Anh TOEIC'),
(4, 'JPN', 'Chứng chỉ tiếng Nhật');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `de_thi`
--

CREATE TABLE `de_thi` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_danh_muc` int DEFAULT NULL,
  `ten_de_thi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_general_ci,
  `thoi_gian` int DEFAULT NULL,
  `id_bai_hoc` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thang_diem` int DEFAULT '10',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `de_thi`
--

INSERT INTO `de_thi` (`id`, `id_danh_muc`, `ten_de_thi`, `mo_ta`, `thoi_gian`, `id_bai_hoc`, `thang_diem`, `ngay_tao`, `trang_thai`) VALUES
('DT1', 1, 'Đề thi 1', 'Mô tả đề thi 1', 1, 'BH1', 10, '2025-12-01 04:37:38', 0),
('DT2', 2, 'Đề thi 2', 'Mô tả đề thi 2', 45, 'BH2', 10, '2025-12-01 04:37:38', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ket_qua_chi_tiet`
--

CREATE TABLE `ket_qua_chi_tiet` (
  `id` int NOT NULL,
  `id_ket_qua` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cau_hoi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_lua_chon` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ket_qua_chi_tiet`
--

INSERT INTO `ket_qua_chi_tiet` (`id`, `id_ket_qua`, `id_cau_hoi`, `id_lua_chon`) VALUES
(47, 'KQ8', 'CH1', 'LC2'),
(48, 'KQ8', 'CH2', 'LC4'),
(49, 'KQ9', 'CH1', NULL),
(50, 'KQ9', 'CH2', 'LC3'),
(51, 'KQ10', 'CH3', 'LC5');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ket_qua_thi`
--

CREATE TABLE `ket_qua_thi` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_nguoi_dung` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_de_thi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `diem_so` float DEFAULT NULL,
  `thoi_gian_nop` datetime DEFAULT CURRENT_TIMESTAMP,
  `thoi_gian_bat_dau` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ket_qua_thi`
--

INSERT INTO `ket_qua_thi` (`id`, `id_nguoi_dung`, `id_de_thi`, `diem_so`, `thoi_gian_nop`, `thoi_gian_bat_dau`) VALUES
('KQ1', 'ND6', 'DT1', 5, '2025-12-10 15:19:09', '2025-12-10 15:19:02'),
('KQ10', 'ND8', 'DT2', 10, '2025-12-11 15:02:51', '2025-12-11 15:02:49'),
('KQ2', 'ND6', 'DT2', 10, '2025-12-10 15:19:42', '2025-12-10 15:19:36'),
('KQ3', 'ND7', 'DT1', 10, '2025-12-10 15:52:45', '2025-12-10 15:52:36'),
('KQ4', 'ND7', 'DT1', 5, '2025-12-10 16:01:38', '2025-12-10 16:01:21'),
('KQ5', 'ND7', 'DT1', 10, '2025-12-10 16:13:03', '2025-12-10 16:12:07'),
('KQ6', 'ND8', 'DT1', 10, '2025-12-11 10:38:27', '2025-12-11 10:38:19'),
('KQ7', 'ND8', 'DT1', 5, '2025-12-11 11:21:15', '2025-12-11 11:21:10'),
('KQ8', 'ND6', 'DT1', 5, '2025-12-11 14:58:11', '2025-12-11 14:58:07'),
('KQ9', 'ND8', 'DT1', 5, '2025-12-11 15:02:32', '2025-12-11 15:02:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lich_su_lam_bai`
--

CREATE TABLE `lich_su_lam_bai` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_ket_qua` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cau_hoi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_lua_chon` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `dung_sai` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lua_chon`
--

CREATE TABLE `lua_chon` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cau_hoi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_general_ci NOT NULL,
  `dung_sai` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lua_chon`
--

INSERT INTO `lua_chon` (`id`, `id_cau_hoi`, `noi_dung`, `dung_sai`) VALUES
('LC1', 'CH1', 'Bạn bè', 0),
('LC2', 'CH1', 'Chúng ta', 1),
('LC3', 'CH2', '六个人', 1),
('LC4', 'CH2', '四个人', 0),
('LC5', 'CH3', '2', 1),
('LC6', 'CH3', '3', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anh_dai_dien` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_quyen` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` tinyint(1) DEFAULT NULL,
  `dia_chi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `anh_dai_dien`, `id_quyen`, `ngay_sinh`, `gioi_tinh`, `dia_chi`, `ngay_tao`) VALUES
('ND1', 'Hv', 'hv@gmail.com', '$2y$10$IKwGeijwumwxkIJRQdIvuOiEXqHAv4iYbNhy3XWjjyDtKErCpxYIy', '0123456789', NULL, 'Q2', NULL, NULL, NULL, '2025-12-01 04:37:38'),
('ND3', 'Admin', 'admin@gmail.com', '$2y$10$dvLvwVID0SirYZ2/F.DBge.jKlkcY.wmPKAM0a6iRUnz67pI6BOqG', '0123000000', NULL, 'Q1', NULL, NULL, NULL, '2025-12-01 04:37:38'),
('ND6', 'Nguyễn Hoàng Huy Phong', 'trucmai124@gmail.com', '$2y$10$/eKlII/ePr30VH0Cnj/zxO07ejKnivbp33XNTLCz3uWBWk.cGJyIO', '35341962145', '1765355921_42d5806e0d8bb423c977cd87b44e3202.jpg', 'Q2', NULL, NULL, NULL, '2025-12-01 07:01:15'),
('ND7', 'Nguyễn Vũ Huy Hoàng', 'hoang.nvh.66cnnt@ntu.edu.vn', '$2y$10$.XHNfTlebGyy5Wc9oWrUzu..gu1tuvqudvqAB4IuhsR.M8EI5fY22', '187641784', '1765356153_images.jpg', 'Q2', NULL, NULL, NULL, '2025-12-10 09:42:33'),
('ND8', 'Phạm Nhật Trường', 'truong.pn.64cntt@ntu.edu.vn', '$2y$10$Qgh0uan3FB8aw9UZrRZdR.HevB5cDj/rXPE3gB2c4XtIQz/0rd1/O', '0377875295', '1765421826_z6269562799673_7ef78d977acba491d670974db406e681.jpg', 'Q2', '2004-01-28', 0, 'Ninh Thuận', '2025-12-11 03:57:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phan_quyen`
--

CREATE TABLE `phan_quyen` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `ten_quyen` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phan_quyen`
--

INSERT INTO `phan_quyen` (`id`, `ten_quyen`) VALUES
('Q1', 'admin'),
('Q2', 'hoc_vien');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tap_tin_bai_hoc`
--

CREATE TABLE `tap_tin_bai_hoc` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_bai_hoc` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `duong_dan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `loai_tap_tin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tap_tin_bai_hoc`
--

INSERT INTO `tap_tin_bai_hoc` (`id`, `id_bai_hoc`, `duong_dan`, `loai_tap_tin`) VALUES
('TT1', 'BH1', 'file1.pdf', 'pdf'),
('TT2', 'BH2', 'file2.pdf', 'pdf');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_baihoc_danhmuc` (`id_danh_muc`);

--
-- Chỉ mục cho bảng `cau_hoi`
--
ALTER TABLE `cau_hoi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cauhoi_dethi` (`id_de_thi`);

--
-- Chỉ mục cho bảng `cau_hoi_nguoi_dung`
--
ALTER TABLE `cau_hoi_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_hoi` (`id_nguoi_hoi`);

--
-- Chỉ mục cho bảng `cau_tra_loi_nguoi_dung`
--
ALTER TABLE `cau_tra_loi_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cau_hoi` (`id_cau_hoi`),
  ADD KEY `id_nguoi_tra_loi` (`id_nguoi_tra_loi`);

--
-- Chỉ mục cho bảng `danh_muc_de_thi`
--
ALTER TABLE `danh_muc_de_thi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_danh_muc` (`ten_danh_muc`);

--
-- Chỉ mục cho bảng `de_thi`
--
ALTER TABLE `de_thi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dethi_baihoc` (`id_bai_hoc`),
  ADD KEY `fk_de_thi_danh_muc` (`id_danh_muc`);

--
-- Chỉ mục cho bảng `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_ket_qua` (`id_ket_qua`,`id_cau_hoi`),
  ADD KEY `id_cau_hoi` (`id_cau_hoi`),
  ADD KEY `id_lua_chon` (`id_lua_chon`);

--
-- Chỉ mục cho bảng `ket_qua_thi`
--
ALTER TABLE `ket_qua_thi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ketqua_nguoidung` (`id_nguoi_dung`),
  ADD KEY `fk_ketqua_dethi` (`id_de_thi`);

--
-- Chỉ mục cho bảng `lich_su_lam_bai`
--
ALTER TABLE `lich_su_lam_bai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lichsu_ketqua` (`id_ket_qua`),
  ADD KEY `fk_lichsu_cauhoi` (`id_cau_hoi`),
  ADD KEY `fk_lichsu_luachon` (`id_lua_chon`);

--
-- Chỉ mục cho bảng `lua_chon`
--
ALTER TABLE `lua_chon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_luachon_cauhoi` (`id_cau_hoi`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_nguoidung_quyen` (`id_quyen`);

--
-- Chỉ mục cho bảng `phan_quyen`
--
ALTER TABLE `phan_quyen`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tap_tin_bai_hoc`
--
ALTER TABLE `tap_tin_bai_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_taptin_baihoc` (`id_bai_hoc`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `danh_muc_de_thi`
--
ALTER TABLE `danh_muc_de_thi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD CONSTRAINT `fk_baihoc_danhmuc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_de_thi` (`id`);

--
-- Ràng buộc cho bảng `cau_hoi`
--
ALTER TABLE `cau_hoi`
  ADD CONSTRAINT `fk_cauhoi_dethi` FOREIGN KEY (`id_de_thi`) REFERENCES `de_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `cau_hoi_nguoi_dung`
--
ALTER TABLE `cau_hoi_nguoi_dung`
  ADD CONSTRAINT `cau_hoi_nguoi_dung_ibfk_1` FOREIGN KEY (`id_nguoi_hoi`) REFERENCES `nguoi_dung` (`id`);

--
-- Ràng buộc cho bảng `cau_tra_loi_nguoi_dung`
--
ALTER TABLE `cau_tra_loi_nguoi_dung`
  ADD CONSTRAINT `cau_tra_loi_nguoi_dung_ibfk_1` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi_nguoi_dung` (`id`),
  ADD CONSTRAINT `cau_tra_loi_nguoi_dung_ibfk_2` FOREIGN KEY (`id_nguoi_tra_loi`) REFERENCES `nguoi_dung` (`id`);

--
-- Ràng buộc cho bảng `de_thi`
--
ALTER TABLE `de_thi`
  ADD CONSTRAINT `fk_de_thi_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_de_thi` (`id`),
  ADD CONSTRAINT `fk_dethi_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `ket_qua_chi_tiet`
--
ALTER TABLE `ket_qua_chi_tiet`
  ADD CONSTRAINT `ket_qua_chi_tiet_ibfk_1` FOREIGN KEY (`id_ket_qua`) REFERENCES `ket_qua_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ket_qua_chi_tiet_ibfk_2` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ket_qua_chi_tiet_ibfk_3` FOREIGN KEY (`id_lua_chon`) REFERENCES `lua_chon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `ket_qua_thi`
--
ALTER TABLE `ket_qua_thi`
  ADD CONSTRAINT `fk_ketqua_dethi` FOREIGN KEY (`id_de_thi`) REFERENCES `de_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ketqua_nguoidung` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `lich_su_lam_bai`
--
ALTER TABLE `lich_su_lam_bai`
  ADD CONSTRAINT `fk_lichsu_cauhoi` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lichsu_ketqua` FOREIGN KEY (`id_ket_qua`) REFERENCES `ket_qua_thi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lichsu_luachon` FOREIGN KEY (`id_lua_chon`) REFERENCES `lua_chon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `lua_chon`
--
ALTER TABLE `lua_chon`
  ADD CONSTRAINT `fk_luachon_cauhoi` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `fk_nguoidung_quyen` FOREIGN KEY (`id_quyen`) REFERENCES `phan_quyen` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `tap_tin_bai_hoc`
--
ALTER TABLE `tap_tin_bai_hoc`
  ADD CONSTRAINT `fk_taptin_baihoc` FOREIGN KEY (`id_bai_hoc`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
