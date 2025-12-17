<?php
include("./header.php");

// Kiểm tra ID kết quả
if (!isset($_GET['id_kq'])) {
    die("Lỗi: Không có mã kết quả.");
}

$id_kq = $_GET['id_kq'];

// Lấy thông tin đề thi từ kết quả
$sql = "
    SELECT kq.id_de_thi, dt.ten_de_thi
    FROM ket_qua_thi kq
    JOIN de_thi dt ON kq.id_de_thi = dt.id
    WHERE kq.id = '$id_kq'
";
$info = mysqli_fetch_assoc(mysqli_query($dbc, $sql));

if (!$info) {
    die("Không tìm thấy kết quả thi.");
}

// Lấy toàn bộ câu hỏi + người dùng đã chọn
$sql_ct = "
    SELECT 
    ch.id AS id_cau_hoi,
    ch.noi_dung AS cau_hoi,
    ch.hinh_anh,
    kqct.id_lua_chon AS lua_chon_user,

    lc_user.noi_dung AS nd_user,
    lc_user.dung_sai AS user_dung_sai,

    lc_dung.id AS id_lc_dung,
    lc_dung.noi_dung AS nd_dung
FROM ket_qua_chi_tiet kqct
JOIN cau_hoi ch ON kqct.id_cau_hoi = ch.id
LEFT JOIN lua_chon lc_user ON kqct.id_lua_chon = lc_user.id
JOIN lua_chon lc_dung ON lc_dung.id_cau_hoi = ch.id AND lc_dung.dung_sai = 1
WHERE kqct.id_ket_qua = '$id_kq'
ORDER BY ch.id

";

$result = mysqli_query($dbc, $sql_ct);
?>

<div class="container my-4">
    <h3>Đáp án chi tiết: <?= $info['ten_de_thi'] ?></h3>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="card p-3 my-3">

        <h5><strong>Câu hỏi:</strong> <?= $row['cau_hoi'] ?></h5>

        <?php if (!empty($row['hinh_anh'])) { ?>
        <img src="./image_user/<?= $row['hinh_anh'] ?>" alt="Hình câu hỏi" style="max-width:300px;" class=" my-2">

        <?php } ?>

        <p>
            <strong>Đáp án bạn chọn:</strong><br>
            <?php if ($row['lua_chon_user'] === null) { ?>
            <span style="color: orange; font-weight:bold;">
                Chưa chọn đáp án
            </span>
            <?php } else if ($row['user_dung_sai'] == 1) { ?>
            <span style="color: green; font-weight:bold;">
                <?= $row['nd_user'] ?> (Đúng)
            </span>
            <?php } else { ?>
            <span style="color: red; font-weight:bold;">
                <?= $row['nd_user'] ?> (Sai)
            </span>
            <?php } ?>
        </p>


        <p>
            <strong>Đáp án đúng:</strong><br>
            <span style="color: green; font-weight:bold;">
                <?= $row['nd_dung'] ?>
            </span>
        </p>

    </div>
    <?php } ?>

</div>