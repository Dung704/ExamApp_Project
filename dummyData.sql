-- Dummy data cho bai_hoc
INSERT INTO `bai_hoc` (`tieu_de`, `noi_dung`, `anh_bai_hoc`, `link_bai_hoc`) VALUES
('Bài học 1', 'Nội dung bài học 1', 'bai1.jpg', 'link1.html'),
('Bài học 2', 'Nội dung bài học 2', 'bai2.jpg', 'link2.html');

-- Dummy data cho de_thi
INSERT INTO `de_thi` (`ten_de_thi`, `mo_ta`, `thoi_gian`, `id_bai_hoc`, `thang_diem`) VALUES
('Đề thi 1', 'Mô tả đề thi 1', 30, 1, 10),
('Đề thi 2', 'Mô tả đề thi 2', 45, 2, 10);

-- Dummy data cho cau_hoi
INSERT INTO `cau_hoi` (`id_de_thi`, `noi_dung`, `hinh_anh`, `muc_do`) VALUES
(1, 'Câu hỏi 1 của đề 1', NULL, 'dễ'),
(1, 'Câu hỏi 2 của đề 1', NULL, 'trung bình'),
(2, 'Câu hỏi 1 của đề 2', NULL, 'khó');

-- Dummy data cho lua_chon
INSERT INTO `lua_chon` (`id_cau_hoi`, `noi_dung`, `dung_sai`) VALUES
(1, 'Đáp án A', 0),
(1, 'Đáp án B', 1),
(2, 'Đáp án C', 1),
(2, 'Đáp án D', 0),
(3, 'Đáp án E', 1),
(3, 'Đáp án F', 0);

-- Dummy data cho nguoi_dung
INSERT INTO `nguoi_dung` (`ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `id_quyen`) VALUES
('Nguyen Van A', 'a@gmail.com', '123456', '0123456789', 2),
('Tran Thi B', 'b@gmail.com', '123456', '0987654321', 2),
('Admin', 'admin@gmail.com', 'admin', '0123000000', 1);

-- Dummy data cho ket_qua_thi
INSERT INTO `ket_qua_thi` (`id_nguoi_dung`, `id_de_thi`, `diem_so`) VALUES
(1, 1, 8),
(2, 1, 7),
(1, 2, 9);

-- Dummy data cho lich_su_lam_bai
INSERT INTO `lich_su_lam_bai` (`id_ket_qua`, `id_cau_hoi`, `id_lua_chon`, `dung_sai`) VALUES
(1, 1, 1, 1),
(1, 2, 3, 0),
(2, 1, 2, 0),
(3, 3, 6, 1);

-- Dummy data cho tap_tin_bai_hoc
INSERT INTO `tap_tin_bai_hoc` (`id_bai_hoc`, `duong_dan`, `loai_tap_tin`) VALUES
(1, 'file1.pdf', 'pdf'),
(2, 'file2.pdf', 'pdf');
