<?php
include("./header.php");

// Kiểm tra login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?tmp=yeu_cau_dang_nhap");
    exit();
}

$id_user = $_SESSION['user_id'];

// Phân trang
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Tìm kiếm
$search = isset($_GET['search']) ? mysqli_real_escape_string($dbc, $_GET['search']) : '';


// SQL lấy dữ liệu
$sql = "
    SELECT 
        kq.id,
        kq.diem_so,
        kq.thoi_gian_nop,
        kq.thoi_gian_bat_dau,
        dt.ten_de_thi
    FROM ket_qua_thi kq
    JOIN de_thi dt ON kq.id_de_thi = dt.id
    WHERE kq.id_nguoi_dung = '$id_user'
    AND (
        dt.ten_de_thi LIKE '%$search%' OR
        kq.id LIKE '%$search%' OR
        kq.diem_so LIKE '%$search%' OR
        kq.thoi_gian_nop LIKE '%$search%'
    )
    ORDER BY kq.thoi_gian_nop DESC
    LIMIT $start, $limit
";

$result = mysqli_query($dbc, $sql);


// SQL đếm tổng số dòng
$sql_count = "
    SELECT COUNT(*) AS total 
    FROM ket_qua_thi kq
    JOIN de_thi dt ON kq.id_de_thi = dt.id
    WHERE kq.id_nguoi_dung = '$id_user'
    AND (
        dt.ten_de_thi LIKE '%$search%' OR
        kq.id LIKE '%$search%' OR
        kq.diem_so LIKE '%$search%' OR
        kq.thoi_gian_nop LIKE '%$search%'
    )
";

$rs_count = mysqli_query($dbc, $sql_count);
$total = mysqli_fetch_assoc($rs_count)['total'];
$total_pages = ceil($total / $limit);
?>

<div class="container my-4">

    <!-- FORM TÌM KIẾM -->
    <form method="GET">
        <div class="d-flex justify-content-center my-4">
            <div class="input-group search-box" style="max-width: 600px;">
                <input type="text" name="search" class="form-control" placeholder="Nhập nội dung..."
                    value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                <button class="input-group-text bg-black text-white border-start-0" type="submit">
                    <i class="bi bi-search me-2"></i>
                </button>
            </div>
        </div>
    </form>

    <h3 class="table-title">Lịch sử làm bài</h3>

    <div class="table-wrapper mt-3 mb-5">
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>Mã kết quả</th>
                    <th>Đề thi</th>
                    <th>Điểm</th>
                    <th>Thời gian nộp</th>
                    <th>Xem chi tiết</th>
                    <th>Thời gian làm bài</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { 
                    // Tính thời gian làm bài
                    $thoi_gian_lam = "Chưa xác định";
                    if (!empty($row['thoi_gian_bat_dau']) && !empty($row['thoi_gian_nop'])) {
                        $bat_dau = strtotime($row['thoi_gian_bat_dau']);
                        $nop = strtotime($row['thoi_gian_nop']);
                        $diff = $nop - $bat_dau;
                        $phut = floor($diff / 60);
                        $giay = $diff % 60;
                        $thoi_gian_lam = $phut . " phút " . $giay . " giây";
                    }
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><strong><?= $row['ten_de_thi'] ?></strong></td>

                    <td>
                        <?= $row['diem_so'] ?>
                    </td>

                    <td>
                        <p class="fw-semibold mb-0"> <?= date("d/m/Y H:i", strtotime($row["thoi_gian_nop"])) ?> </p>
                    </td>

                    <td>
                        <a href="xem_dap_an.php?id_kq=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                            Xem đáp án
                        </a>
                    </td>

                    <td><?= $thoi_gian_lam ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- PHÂN TRANG -->
    <nav>
        <ul class="pagination justify-content-center">

            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= $search ?>"><i
                        class="bi bi-chevron-left"></i></a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= $search ?>"><i
                        class="bi bi-chevron-right"></i></a>
            </li>

        </ul>
    </nav>

</div>

<?php include("./footer.php"); ?>