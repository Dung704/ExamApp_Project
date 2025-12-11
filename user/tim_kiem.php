<?php
include_once("./header.php");
?>

<?php
$keyword = $_GET['q'] ?? '';
$keyword = mysqli_real_escape_string($dbc, $keyword);
$sql_de_thi = "
    SELECT * FROM de_thi 
    WHERE ten_de_thi LIKE '%$keyword%' 
        OR mo_ta LIKE '%$keyword%'
";
$result_de_thi = mysqli_query($dbc, $sql_de_thi);
$sql_bai_hoc = "
    SELECT * FROM bai_hoc
    WHERE tieu_de LIKE '%$keyword%' 
        OR noi_dung LIKE '%$keyword%'
";
$result_bai_hoc = mysqli_query($dbc, $sql_bai_hoc);

$khong_co_bai_hoc = mysqli_num_rows($result_bai_hoc)== 0;
$khong_co_de_thi = mysqli_num_rows($result_de_thi)== 0;
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
    <?php if ($khong_co_bai_hoc && $khong_co_de_thi ):?>
    <p class="text-center text-muted mt-4">
        Không tìm thấy kết quả với từ khóa <?= htmlspecialchars($keyword) ?>
    </p>


    <?php endif;?>

    <?php if (mysqli_num_rows($result_de_thi) > 0): ?>
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
    <?php endif;?>


    <?php if (mysqli_num_rows($result_bai_hoc) > 0): ?>
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

                    <p class="text-secondary  mb-2">
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
    <?php endif;?>


</div>

<?php
include_once("./footer.php");
?>