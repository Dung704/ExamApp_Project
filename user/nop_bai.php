<?php
include("./header.php");

if (!isset($_POST['id_de_thi'], $_POST['id_kq'])) {
    die("Thiếu dữ liệu.");
}

$id_de_thi = $_POST['id_de_thi'];
$id_kq     = $_POST['id_kq'];
$id_user   = $_SESSION['user_id'] ?? die("Chưa đăng nhập");

$diem = 0;

/* ===== XÓA KẾT QUẢ CHI TIẾT CŨ (RẤT QUAN TRỌNG) ===== */
mysqli_query($dbc, "
    DELETE FROM ket_qua_chi_tiet
    WHERE id_ket_qua = '$id_kq'
");

/* ===== LẤY DANH SÁCH CÂU HỎI ===== */
$q_list = mysqli_query($dbc, "
    SELECT id FROM cau_hoi WHERE id_de_thi = '$id_de_thi'
");
$tong_cau = mysqli_num_rows($q_list);

/* ===== CHẤM TỪNG CÂU ===== */
while ($q = mysqli_fetch_assoc($q_list)) {

    $id_cau_hoi = $q['id'];

    /* --- ĐÁP ÁN NGƯỜI DÙNG CHỌN --- */
    $user_answers = $_POST['cau_hoi'][$id_cau_hoi] ?? [];

    if (!is_array($user_answers)) {
        $user_answers = [$user_answers];
    }

    /* --- ĐÁP ÁN ĐÚNG --- */
    $rs_dung = mysqli_query($dbc, "
        SELECT id FROM lua_chon
        WHERE id_cau_hoi = '$id_cau_hoi'
          AND dung_sai = 1
    ");

    $correct_answers = [];
    while ($row = mysqli_fetch_assoc($rs_dung)) {
        $correct_answers[] = $row['id'];
    }

    /* --- SO SÁNH TUYỆT ĐỐI --- */
    sort($user_answers);
    sort($correct_answers);

    if ($user_answers === $correct_answers) {
        $diem++; // +1 điểm cho 1 câu
    }

    /* --- LƯU CHI TIẾT --- */
    if (empty($user_answers)) {
        mysqli_query($dbc, "
            INSERT INTO ket_qua_chi_tiet(id_ket_qua, id_cau_hoi, id_lua_chon)
            VALUES('$id_kq', '$id_cau_hoi', NULL)
        ");
    } else {
        foreach ($user_answers as $id_lc) {
            mysqli_query($dbc, "
                INSERT INTO ket_qua_chi_tiet(id_ket_qua, id_cau_hoi, id_lua_chon)
                VALUES('$id_kq', '$id_cau_hoi', '$id_lc')
            ");
        }
    }
}

/* ===== QUY ĐỔI ĐIỂM ===== */
$dt = mysqli_fetch_assoc(mysqli_query($dbc,
    "SELECT thang_diem FROM de_thi WHERE id = '$id_de_thi'"
));

$diem_quy_doi = round(($diem / $tong_cau) * $dt['thang_diem'], 2);

/* ===== CẬP NHẬT KẾT QUẢ ===== */
mysqli_query($dbc, "
    UPDATE ket_qua_thi
    SET diem_so = $diem_quy_doi,
        thoi_gian_nop = NOW()
    WHERE id = '$id_kq'
");

header("Location: ket_qua.php?id=$id_kq");
exit;