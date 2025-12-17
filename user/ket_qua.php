<?php
include("./header.php");

/* =========================
   1. KIỂM TRA ID KẾT QUẢ
========================= */
if (!isset($_GET['id'])) {
    die("Lỗi: Không có ID kết quả.");
}

$id_kq = $_GET['id'];

/* =========================
   2. LẤY THÔNG TIN KẾT QUẢ + ĐỀ THI
========================= */
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

/* =========================
   3. ĐẾM TỔNG SỐ CÂU HỎI (CHUẨN)
========================= */
$so_cau = mysqli_fetch_assoc(mysqli_query($dbc, "
    SELECT COUNT(*) AS tong
    FROM cau_hoi
    WHERE id_de_thi = '{$kq['id_de_thi']}'
"))['tong'];

/* =========================
   4. TÍNH SỐ CÂU ĐÚNG (KHÔNG ĐẾM TỪ ket_qua_chi_tiet)
========================= */
$so_cau_dung = round(
    ($kq['diem_so'] / $kq['thang_diem']) * $so_cau
);

/* =========================
   5. TÍNH THỜI GIAN LÀM BÀI
========================= */
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



<div class="container my-5" style="max-width: 700px;">

    <!-- CHÚC MỪNG -->
    <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
        <i class="bi bi-trophy-fill fs-3 me-3"></i>
        <div>
            <h5 class="mb-0 fw-bold">Chúc mừng bạn đã hoàn thành bài thi!</h5>
            <small>Bạn có thể xem lại đáp án để cải thiện kết quả.</small>
        </div>
    </div>

    <!-- ẢNH GẤU TRÚC -->
    <div class="card border-0 shadow-sm my-4">
        <img src="./image_giao_dien/gau_truc_chuc_mung.jpg" class="card-img-top"
            style="width: 50%; height: 50%; object-fit: cover; margin: auto; display: block;" alt="Gấu trúc chúc mừng">
        <div class="card-body text-center">
            <p class="card-text">Bạn đã làm rất tốt, tiếp tục phát huy nhé!</p>
        </div>
    </div>

    <!-- KẾT QUẢ BÀI THI -->
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">
            Kết quả bài thi: <?= htmlspecialchars($kq['ten_de_thi']) ?>
        </h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="list-group list-group-flush">

                <div class="list-group-item d-flex justify-content-between">
                    <strong>Điểm số:</strong>
                    <span style="color : red"><?= $kq['diem_so'] ?> / <?= $kq['thang_diem'] ?></span>
                </div>

                <div class="list-group-item d-flex justify-content-between">
                    <strong>Số câu đúng:</strong>
                    <span><?= $so_cau_dung ?> / <?= $so_cau ?></span>
                </div>

                <div class="list-group-item d-flex justify-content-between">
                    <strong>Thời gian làm bài:</strong>
                    <span><?= $thoi_gian_lam ?></span>
                </div>

                <div class-group-item d-flex justify-content-between">
                    <strong>Thời gian nộp:</strong>
                    <span><?= $kq['thoi_gian_nop'] ?></span>
                </div>

            </div>

        </div>
    </div>

    <!-- NÚT XEM CHI TIẾT -->
    <div class="mt-4">
        <a href="xem_dap_an.php?id_kq=<?= $id_kq ?>" class="btn btn-info w-100 fw-bold">
            Xem chi tiết từng câu hỏi
        </a>
    </div>

</div>

<?php
include_once("./footer.php")
?>