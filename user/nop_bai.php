<?php
include("./header.php");

/* ===== KIỂM TRA ĐĂNG NHẬP ===== */
if (!isset($_SESSION['user_id'])) {
    die("Chưa đăng nhập.");
}

/* ===== KIỂM TRA PHIÊN THI ===== */
if (!isset($_SESSION['exam_active'], $_SESSION['exam_id']) || $_SESSION['exam_active'] !== true) {
    die("Phiên làm bài không hợp lệ hoặc đã bị hủy.");
}

if (!isset($_POST['id_de_thi'])) {
    die("Thiếu dữ liệu đề thi.");
}

$id_de_thi = $_POST['id_de_thi'];
$id_user   = $_SESSION['user_id'];

if ($_SESSION['exam_id'] != $id_de_thi) {
    die("Dữ liệu phiên không khớp.");
}

/* ===== TẠO KẾT QUẢ ===== */
$row_max = mysqli_fetch_assoc(mysqli_query($dbc, "
    SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id
    FROM ket_qua_thi
"));
$so_moi = ($row_max['max_id'] ?? 0) + 1;
$id_kq = 'KQ' . $so_moi;

mysqli_query($dbc, "
    INSERT INTO ket_qua_thi(id, id_nguoi_dung, id_de_thi, diem_so, thoi_gian_bat_dau)
    VALUES('$id_kq', '$id_user', '$id_de_thi', 0, NOW())
");

/* ===== CHẤM BÀI ===== */
$diem = 0;
$q_list = mysqli_query($dbc, "
    SELECT id FROM cau_hoi WHERE id_de_thi = '$id_de_thi'
");
$tong_cau = mysqli_num_rows($q_list);

while ($q = mysqli_fetch_assoc($q_list)) {

    $id_cau_hoi = $q['id'];
    $user_answers = $_POST['cau_hoi'][$id_cau_hoi] ?? [];
    if (!is_array($user_answers)) {
        $user_answers = [$user_answers];
    }

    $rs_dung = mysqli_query($dbc, "
        SELECT id FROM lua_chon
        WHERE id_cau_hoi = '$id_cau_hoi'
          AND dung_sai = 1
    ");

    $correct_answers = [];
    while ($r = mysqli_fetch_assoc($rs_dung)) {
        $correct_answers[] = $r['id'];
    }

    sort($user_answers);
    sort($correct_answers);

    if ($user_answers === $correct_answers) {
        $diem++;
    }

    foreach ($user_answers as $id_lc) {
        mysqli_query($dbc, "
            INSERT INTO ket_qua_chi_tiet(id_ket_qua, id_cau_hoi, id_lua_chon)
            VALUES('$id_kq', '$id_cau_hoi', '$id_lc')
        ");
    }
}

/* ===== QUY ĐỔI ĐIỂM ===== */
$dt = mysqli_fetch_assoc(mysqli_query($dbc,
    "SELECT thang_diem FROM de_thi WHERE id = '$id_de_thi'"
));
$diem_quy_doi = round(($diem / $tong_cau) * $dt['thang_diem'], 2);

mysqli_query($dbc, "
    UPDATE ket_qua_thi
    SET diem_so = $diem_quy_doi,
        thoi_gian_nop = NOW()
    WHERE id = '$id_kq'
");

/* ===== KẾT THÚC PHIÊN ===== */
unset($_SESSION['exam_active'], $_SESSION['exam_id']);

header("Location: ket_qua.php?id=$id_kq");
exit;