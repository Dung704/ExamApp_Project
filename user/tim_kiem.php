<?php
include_once("./header.php");

$keyword = $_GET['q'] ?? '';
$keyword = mysqli_real_escape_string($dbc, $keyword);

/* ====== PHÂN TRANG ====== */
$limit = 10;

/* --- PHÂN TRANG ĐỀ THI --- */
$page_de = isset($_GET['page_de']) ? (int)$_GET['page_de'] : 1;
if ($page_de < 1) $page_de = 1;
$start_de = ($page_de - 1) * $limit;

/* --- PHÂN TRANG BÀI HỌC --- */
$page_bh = isset($_GET['page_bh']) ? (int)$_GET['page_bh'] : 1;
if ($page_bh < 1) $page_bh = 1;
$start_bh = ($page_bh - 1) * $limit;

/* ====== ĐẾM TỔNG SỐ ĐỀ THI ====== */
$total_de_thi = mysqli_fetch_assoc(mysqli_query($dbc,
    "SELECT COUNT(*) AS total FROM de_thi 
     WHERE ten_de_thi LIKE '%$keyword%' 
        OR mo_ta LIKE '%$keyword%'"
))['total'];

$total_pages_de = ceil($total_de_thi / $limit);

/* ====== LẤY ĐỀ THI CÓ PHÂN TRANG ====== */
$sql_de_thi = "
    SELECT * FROM de_thi 
    WHERE ten_de_thi LIKE '%$keyword%' 
        OR mo_ta LIKE '%$keyword%'
    LIMIT $start_de, $limit
";
$result_de_thi = mysqli_query($dbc, $sql_de_thi);

/* ====== ĐẾM TỔNG SỐ BÀI HỌC ====== */
$total_bai_hoc = mysqli_fetch_assoc(mysqli_query($dbc,
    "SELECT COUNT(*) AS total FROM bai_hoc
     WHERE tieu_de LIKE '%$keyword%' 
        OR noi_dung LIKE '%$keyword%'"
))['total'];

$total_pages_bh = ceil($total_bai_hoc / $limit);

/* ====== LẤY BÀI HỌC CÓ PHÂN TRANG ====== */
$sql_bai_hoc = "
    SELECT * FROM bai_hoc
    WHERE tieu_de LIKE '%$keyword%' 
        OR noi_dung LIKE '%$keyword%'
    LIMIT $start_bh, $limit
";
$result_bai_hoc = mysqli_query($dbc, $sql_bai_hoc);

$khong_co_bai_hoc = ($total_bai_hoc == 0);
$khong_co_de_thi = ($total_de_thi == 0);
?>


<div class="container my-4">

    <form action="tim_kiem.php" method="GET">
        <div class="d-flex justify-content-center my-5">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" name="q" class="form-control" placeholder="Nhập nội dung..." required>
                <button class="input-group-text bg-white border-start-0" type="submit">
                    <i class="bi bi-search me-2"></i>
                </button>
            </div>
        </div>
    </form>

    <h3>Đang hiển thị kết quả cho : "<?= htmlspecialchars($keyword) ?>"</h3>

    <?php if ($khong_co_bai_hoc && $khong_co_de_thi): ?>
    <p class="text-center text-muted mt-4">
        Không tìm thấy kết quả với từ khóa <?= htmlspecialchars($keyword) ?>
    </p>
    <?php endif; ?>


    <!-- ====================== ĐỀ THI ====================== -->
    <?php if (mysqli_num_rows($result_de_thi) > 0): ?>
    <h4 class="mt-4">Đề thi</h4>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result_de_thi)): ?>
        <li>
            <div class="card shadow-sm mt-4 mb-4" style="min-width: 250px;">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['ten_de_thi'] ?></h5>

                    <p class="card-text mb-1">📝 <?= substr($row['mo_ta'], 0, 60) ?>...</p>
                    <p class="card-text mb-1">⏱️ <?= $row['thoi_gian'] ?> phút</p>
                    <p class="card-text mb-1">🎯 Thang điểm: <?= $row['thang_diem'] ?></p>

                    <a href="chi_tiet_de_thi.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Bắt đầu</a>
                </div>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>

    <!-- PHÂN TRANG ĐỀ THI -->
    <?php if ($total_pages_de > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">

            <li class="page-item <?= ($page_de <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?q=<?= $keyword ?>&page_de=<?= $page_de - 1 ?>">Trước</a>
            </li>

            <?php for ($i = 1; $i <= $total_pages_de; $i++): ?>
            <li class="page-item <?= ($i == $page_de) ? 'active' : '' ?>">
                <a class="page-link" href="?q=<?= $keyword ?>&page_de=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page_de >= $total_pages_de) ? 'disabled' : '' ?>">
                <a class="page-link" href="?q=<?= $keyword ?>&page_de=<?= $page_de + 1 ?>">Sau</a>
            </li>

        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>



    <!-- ====================== BÀI HỌC ====================== -->
    <?php if (mysqli_num_rows($result_bai_hoc) > 0): ?>
    <h4 class="mt-4">Bài học</h4>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result_bai_hoc)): ?>
        <li>
            <div class="card shadow-sm mt-4 mb-4" style="min-width: 260px;">

                <?php if (!empty($row['anh_bai_hoc'])): ?>
                <img src="./image_baihoc/<?= $row['anh_bai_hoc'] ?>" class="card-img-top"
                    style="height: 150px; object-fit: cover;">
                <?php endif; ?>

                <div class="card-body">

                    <h6 class="card-title fw-bold"><?= $row['tieu_de'] ?></h6>

                    <p class="text-secondary mb-2">
                        <?= substr($row['noi_dung'], 0, 20) ?>...
                    </p>

                    <?php if (!empty($row['link_bai_hoc'])): ?>
                    <p>
                        Tài liệu tham khảo: <?= substr($row['link_bai_hoc'], 0, 15) ?>...
                    </p>
                    <?php endif; ?>

                    <a href="chi_tiet_bai_hoc.php?id_bh=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                        Xem chi tiết
                    </a>

                </div>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>

    <!-- PHÂN TRANG BÀI HỌC -->
    <?php if ($total_pages_bh > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">

            <li class="page-item <?= ($page_bh <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?q=<?= $keyword ?>&page_bh=<?= $page_bh - 1 ?>"><i
                        class="bi bi-chevron-left"></i></a>
            </li>

            <?php for ($i = 1; $i <= $total_pages_bh; $i++): ?>
            <li class="page-item <?= ($i == $page_bh) ? 'active' : '' ?>">
                <a class="page-link" href="?q=<?= $keyword ?>&page_bh=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page_bh >= $total_pages_bh) ? 'disabled' : '' ?>">
                <a class="page-link" href="?q=<?= $keyword ?>&page_bh=<?= $page_bh + 1 ?>"><i
                        class="bi bi-chevron-right"></i></a>
            </li>

        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>

</div>

<?php
include_once("./footer.php");
?>