<?php
include("./header.php");

/* =========================
   1. KIỂM TRA ID KẾT QUẢ
========================= */
if (!isset($_GET['id_kq'])) {
    die("Lỗi: Không có mã kết quả.");
}

$id_kq = $_GET['id_kq'];

/* =========================
   2. LẤY THÔNG TIN ĐỀ THI
========================= */
$sql_info = "
    SELECT kq.id_de_thi, dt.ten_de_thi
    FROM ket_qua_thi kq
    JOIN de_thi dt ON kq.id_de_thi = dt.id
    WHERE kq.id = '$id_kq'
";
$rs_info = mysqli_query($dbc, $sql_info);
$info = mysqli_fetch_assoc($rs_info);

if (!$info) {
    die("Không tìm thấy kết quả thi.");
}

/* =========================
   3. LẤY CHI TIẾT CÂU HỎI + ĐÁP ÁN
========================= */
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
JOIN lua_chon lc_dung 
    ON lc_dung.id_cau_hoi = ch.id 
    AND lc_dung.dung_sai = 1
WHERE kqct.id_ket_qua = '$id_kq'
ORDER BY ch.id
";

$result = mysqli_query($dbc, $sql_ct);

/* =========================
   4. GOM DỮ LIỆU THEO CÂU HỎI
   (QUAN TRỌNG: xử lý câu nhiều đáp án)
========================= */
$questions = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_cau_hoi'];

    if (!isset($questions[$id])) {
        $questions[$id] = [
            'cau_hoi' => $row['cau_hoi'],
            'hinh_anh' => $row['hinh_anh'],
            'user_answers' => [],
            'correct_answers' => []
        ];
    }

    // Đáp án người dùng chọn
    if ($row['lua_chon_user'] !== null) {
        if (!in_array(
            $row['nd_user'],
            array_column($questions[$id]['user_answers'], 'noi_dung')
        )) {
            $questions[$id]['user_answers'][] = [
                'noi_dung' => $row['nd_user'],
                'dung_sai' => $row['user_dung_sai']
            ];
        }

    }

    // Đáp án đúng (tránh trùng)
    if (!in_array(
        $row['nd_dung'],
        array_column($questions[$id]['correct_answers'], 'noi_dung')
    )) {
        $questions[$id]['correct_answers'][] = [
            'noi_dung' => $row['nd_dung']
        ];
    }
}
?>

<!-- =========================
     5. HIỂN THỊ GIAO DIỆN
========================= -->
<div class="container my-4">
    <h3>Đáp án chi tiết: <?= $info['ten_de_thi'] ?></h3>

    <?php foreach ($questions as $q): ?>
    <div class="card p-3 my-3">

        <h5><strong>Câu hỏi:</strong> <?= $q['cau_hoi'] ?></h5>

        <?php if (!empty($q['hinh_anh'])): ?>
        <img src="./image_cauhoi/<?= $q['hinh_anh'] ?>" alt="Hình câu hỏi" style="max-width:300px" class="my-2">
        <?php endif; ?>

        <hr>

        <p><strong>Đáp án bạn chọn:</strong></p>

        <?php if (empty($q['user_answers'])): ?>
        <span class="text-warning fw-bold">Chưa chọn đáp án</span>
        <?php else: ?>
        <ul>
            <?php foreach ($q['user_answers'] as $ua): ?>
            <li style="color: <?= $ua['dung_sai'] ? 'green' : 'red' ?>; font-weight:bold">
                <?= $ua['noi_dung'] ?>
                (<?= $ua['dung_sai'] ? 'Đúng' : 'Sai' ?>)
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <p class="mt-2"><strong>Đáp án đúng:</strong></p>
        <ul>
            <?php foreach ($q['correct_answers'] as $ca): ?>
            <li class="text-success fw-bold"><?= $ca['noi_dung'] ?></li>
            <?php endforeach; ?>
        </ul>

    </div>
    <?php endforeach; ?>
    <!-- Nút bắt đầu -->
    <div class="text-center mt-4">
        <a href="thi.php?id=<?= $info["id_de_thi"] ?>" class="btn btn-primary btn-lg px-5 py-3 fw-bold">
            <i class="bi bi-arrow-counterclockwise"></i> Làm lại bài thi này
        </a>
    </div>
</div>
<?php include("./footer.php"); ?>