<?php
include("./header.php");

//  danh mục đề thi
$sql = "SELECT * FROM danh_muc_de_thi ORDER BY ten_danh_muc ASC";
$result = mysqli_query($dbc, $sql);

// Lấy bài học
$sql_bai_hoc = "SELECT * FROM bai_hoc ORDER BY ngay_tao DESC";
$result_bai_hoc = mysqli_query($dbc, $sql_bai_hoc);
?>

<!-- FORM TÌM KIẾM -->
<form action="tim_kiem.php" method="GET">
    <div class="d-flex justify-content-center my-5">
        <div class="input-group search-box" style="max-width: 600px;">
            <input type="text" name="q" class="form-control" placeholder="Nhập nội dung..." required>
            <button class="input-group-text bg-black text-white border-start-0" type="submit">
                <i class="bi bi-search me-2"></i>
            </button>
        </div>
    </div>
</form>



<!-- Nội dung chính -->
<div class="container my-5">
    <div class="row">

        <!--  Cột trái: Danh mục đề thi -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Danh mục bài thi</div>
                <ul class="list-group list-group-flush">
                    <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <li class="list-group-item">
                        <a href="./bai_thi_theo_muc.php?id_dm=<?= $row['id'] ?>">
                            <?= $row['ten_danh_muc'] ?>
                        </a>
                    </li>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <li class="list-group-item">Không có danh mục nào.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Cột giữa: Bài học mới nhất -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">Bài học Mới Nhất</div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($result_bai_hoc) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result_bai_hoc)): ?>
                    <a href="./chi_tiet_bai_hoc.php?id_bh=<?= $row['id'] ?>" class="text-decoration-none text-dark">
                        <div class="card mb-3 shadow-sm lesson-card">
                            <div class="card-body">
                                <div class="row align-items-center">

                                    <div class="col-8">
                                        <h5 class="card-title fw-bold"><?= $row['tieu_de'] ?></h5>
                                        <p class="text-muted mb-1">Ngày tạo: <?= $row['ngay_tao'] ?></p>

                                        <p class="card-text text-truncate" style="max-height: 4.5em;">
                                            <?= $row['noi_dung'] ?>
                                        </p>

                                        <?php if(!empty($row['link_bai_hoc'])): ?>
                                        <p class="mt-2">
                                            <small>Link tham khảo:</small><br>
                                            <a href="<?= $row['link_bai_hoc'] ?>" target="_blank" class="text-primary">
                                                <?= $row['link_bai_hoc'] ?>
                                            </a>
                                        </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-4 text-end">
                                        <?php if(!empty($row['anh_bai_hoc'])): ?>
                                        <img src="./image_baihoc/<?= $row['anh_bai_hoc'] ?>"
                                            alt="<?= $row['tieu_de'] ?>" class="img-fluid rounded"
                                            style="max-height: 110px; object-fit: cover;">
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <p>Hiện chưa có bài học nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>



        <!--  Cột phải: Đề thi nổi bật -->

        <?php
            $sql_top = "
                SELECT d.ten_de_thi, k.id_de_thi, COUNT(*) AS so_lan_lam
                FROM ket_qua_thi k
                JOIN de_thi d ON k.id_de_thi = d.id
                GROUP BY k.id_de_thi, d.ten_de_thi
                ORDER BY so_lan_lam DESC
                LIMIT 5
            ";
            $rs_top = mysqli_query($dbc, $sql_top);
        ?>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">Đề Thi Nổi Bật</div>
                <div class="card-body">
                    <?php while($row = mysqli_fetch_assoc($rs_top)): ?>
                    <a href="chi_tiet_de_thi.php?id=<?= $row['id_de_thi'] ?>" class="text-decoration-none">
                        <span class="badge bg-secondary mb-2 d-inline-block">
                            <?= htmlspecialchars($row['ten_de_thi']) ?> (<?= $row['so_lan_lam'] ?> lần)
                        </span>
                    </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>




    </div>
</div>

<?php include("./footer.php"); ?>