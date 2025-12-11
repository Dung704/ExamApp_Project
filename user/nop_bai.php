<?php
include("./header.php");

// --- Kiểm tra dữ liệu POST ---
if (!isset($_POST['id_de_thi'])) {
    die("Lỗi: Không nhận được id_de_thi.");
}

$id_de_thi = $_POST['id_de_thi'];

if (!isset($_SESSION['user_id'])) {
    die("Lỗi: Chưa đăng nhập.");
}

$id_user = $_SESSION['user_id'];
$diem = 0;

// --- Kiểm tra xem đã có kết quả đang làm chưa ---
$id_kq = $_POST['id_kq'] ?? null;

if (!$id_kq) {
    // Nếu chưa có thì tạo mới kết quả và lưu thời gian bắt đầu
    $query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM ket_qua_thi";
    $result_max = mysqli_query($dbc, $query_max);
    $row_max = mysqli_fetch_assoc($result_max);
    $so_moi = ($row_max['max_id'] ?? 0) + 1;
    $id_kq = 'KQ' . $so_moi;

    // Thêm cột thoi_gian_bat_dau trong ket_qua_thi nếu muốn tính thời gian
    $sql_insert = "
        INSERT INTO ket_qua_thi(id, id_nguoi_dung, id_de_thi, diem_so, thoi_gian_bat_dau)
        VALUES('$id_kq', '$id_user', '$id_de_thi', 0, NOW())
    ";
    mysqli_query($dbc, $sql_insert);
}

// --- Lấy danh sách câu hỏi ---
$q_list = mysqli_query($dbc, "SELECT * FROM cau_hoi WHERE id_de_thi = '$id_de_thi'");
$tong_cau = mysqli_num_rows($q_list);
if ($tong_cau == 0) {
    die("Lỗi: Đề thi không có câu hỏi.");
}

// --- Chấm điểm và lưu lựa chọn ---
$ket_qua_chi_tiet = []; // Lưu tạm để insert sau

while ($q = mysqli_fetch_assoc($q_list)) {
    $id_cau_hoi = $q['id'];
    $field = "cau_hoi_" . $id_cau_hoi;

    // Nếu người dùng không chọn thì bỏ qua (NULL)
    if (!isset($_POST[$field])) {
        $ket_qua_chi_tiet[] = [
            'id_cau_hoi' => $id_cau_hoi,
            'id_lua_chon' => null
        ];
        continue;
    }

    $id_lc_chon = $_POST[$field];

    // Lấy thông tin đáp án
    $lc = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT dung_sai FROM lua_chon WHERE id = '$id_lc_chon'"));

    // Chấm điểm (dung_sai = 1 là đúng)
    if ($lc && $lc['dung_sai'] == 1) {
        $diem++;
    }

    // Lưu chi tiết
    $ket_qua_chi_tiet[] = [
        'id_cau_hoi' => $id_cau_hoi,
        'id_lua_chon' => $id_lc_chon
    ];
}

// --- Lấy thang điểm ---
$dt = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT thang_diem FROM de_thi WHERE id = '$id_de_thi'"));
$diem_quy_doi = round(($diem / $tong_cau) * $dt['thang_diem'], 2);

// --- Cập nhật kết quả tổng và thời gian nộp ---
$sql_update = "
    UPDATE ket_qua_thi
    SET diem_so = $diem_quy_doi,
        thoi_gian_nop = NOW()
    WHERE id = '$id_kq'
";
mysqli_query($dbc, $sql_update);

// --- Xóa chi tiết cũ (nếu có) để lưu lại chi tiết mới ---
mysqli_query($dbc, "DELETE FROM ket_qua_chi_tiet WHERE id_ket_qua = '$id_kq'");

// --- Lưu chi tiết từng câu ---
foreach ($ket_qua_chi_tiet as $item) {
    $id_cau = $item['id_cau_hoi'];
    $id_lc = $item['id_lua_chon'] ?? "NULL";
//  KQCT = code tạo mã KQCT + uniqid 
    if ($id_lc === "NULL") {
        $query_ct = "
            INSERT INTO ket_qua_chi_tiet(id_ket_qua, id_cau_hoi, id_lua_chon)
            VALUES('$id_kq', '$id_cau', NULL)
        ";
    } else {
        $query_ct = "
            INSERT INTO ket_qua_chi_tiet(id_ket_qua, id_cau_hoi, id_lua_chon)
            VALUES('$id_kq', '$id_cau', '$id_lc')
        ";
    }

    mysqli_query($dbc, $query_ct);
}

// --- Chuyển đến trang xem kết quả ---
header("Location: ket_qua.php?id=$id_kq");
exit;
?>