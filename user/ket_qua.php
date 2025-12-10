<?php
include("./header.php");

if (!isset($_GET['id'])) {
    die("Lỗi: Không có ID kết quả.");
}

$id_kq = $_GET['id'];

// Lấy thông tin kết quả + đề thi
$sql = "
    SELECT kq.*, dt.ten_de_thi, dt.thang_diem
    FROM ket_qua_thi kq
    JOIN de_thi dt ON kq.id_de_thi = dt.id
    WHERE kq.id = '$id_kq'
";

$kq = mysqli_fetch_assoc(mysqli_query($dbc, $sql));

if (!$kq) {
    die("Không tìm thấy kết quả.");
}

// Đếm số câu
$so_cau = mysqli_fetch_assoc(mysqli_query($dbc, "
    SELECT COUNT(*) AS tong
    FROM ket_qua_chi_tiet
    WHERE id_ket_qua = '$id_kq'
"))['tong'];

// Đếm số câu đúng (dựa vào bảng lua_chon)
$so_cau_dung = mysqli_fetch_assoc(mysqli_query($dbc, "
    SELECT COUNT(*) AS dung
    FROM ket_qua_chi_tiet kqct
    JOIN lua_chon lc ON kqct.id_lua_chon = lc.id
    WHERE kqct.id_ket_qua = '$id_kq' AND lc.dung_sai = 1
"))['dung'];

// --- Tính thời gian làm bài ---
$thoi_gian_lam = "Chưa xác định";
if (!empty($kq['thoi_gian_bat_dau']) && !empty($kq['thoi_gian_nop'])) {
    $bat_dau = strtotime($kq['thoi_gian_bat_dau']);
    $nop = strtotime($kq['thoi_gian_nop']);
    $diff = $nop - $bat_dau; 
    $phut = floor($diff / 60);
    $giay = $diff % 60;
    $thoi_gian_lam = $phut . " phút " . $giay . " giây";
}
?>

<div class="container my-4">
    <h3>Kết quả bài thi: <?= $kq['ten_de_thi'] ?></h3>

    <div class="card p-3 my-3">
        <p><strong>Điểm số:</strong> <?= $kq['diem_so'] ?> / <?= $kq['thang_diem'] ?></p>
        <p><strong>Số câu đúng:</strong> <?= $so_cau_dung ?> / <?= $so_cau ?></p>
        <p><strong>Thời gian làm bài:</strong> <?= $thoi_gian_lam ?></p>
        <p><strong>Thời gian nộp:</strong> <?= $kq['thoi_gian_nop'] ?></p>
    </div>

    <a href="xem_dap_an.php?id_kq=<?= $id_kq ?>" class="btn btn-info">
        Xem chi tiết từng câu hỏi
    </a>
</div>