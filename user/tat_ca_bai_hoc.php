<?php
include("./header.php");

$id_dm = $_GET['id_dm'];

$sql_dm = "SELECT ten_danh_muc FROM danh_muc_de_thi WHERE id = $id_dm";
$dm = mysqli_fetch_assoc(mysqli_query($dbc, $sql_dm));

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($dbc, $_GET['keyword']) : '';

$limit = 20; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql_count = "
    SELECT COUNT(*) AS total
    FROM bai_hoc
    WHERE id_danh_muc = $id_dm
    AND (
    tieu_de LIKE '%$keyword%'
    OR noi_dung LIKE '%$keyword%'
    
    )
";
$rs_count = mysqli_query($dbc, $sql_count);
$total = mysqli_fetch_assoc($rs_count)['total'];
$total_pages = ceil($total / $limit);

$sql = "
    SELECT *
    FROM bai_hoc
    WHERE id_danh_muc = $id_dm
   AND (
    tieu_de LIKE '%$keyword%'
    OR noi_dung LIKE '%$keyword%'
    
    )
    ORDER BY id DESC
    LIMIT $start, $limit
";
$result = mysqli_query($dbc, $sql);
?>


<div class="container my-4">
    <!-- FORM TÌM KIẾM -->
    <form action="tat_ca_bai_hoc.php" method="GET">
        <input type="hidden" name="id_dm" value="<?= $id_dm ?>">

        <div class="d-flex justify-content-center my-5">
            <div class="input-group search-box" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control" placeholder="Nhập nội dung..."
                    value="<?= htmlspecialchars($keyword) ?>">
                <button class="input-group-text bg-black text-white" type="submit">
                    <i class="bi bi-search me-2"></i>
                </button>
            </div>
        </div>
    </form>

    <?php if(mysqli_num_rows($result) > 0): ?>
    <div class="row">
        <?php while($bh = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm" style="min-width: 250px border-radius: 10px;">

                <?php if (!empty($bh['anh_bai_hoc'])): ?>
                <img src="./image_baihoc/<?= $bh['anh_bai_hoc'] ?>" class="card-img-top"
                    style="height: 90px; object-fit: cover ; border-radius: 10px 10px 0 0;">
                <?php endif; ?>

                <div class="card-body ">

                    <h6 class="card-title fw-bold"><?= $bh['tieu_de'] ?></h6>

                    <p class="text-secondary small mb-2">
                        <?= substr(strip_tags($bh['noi_dung']), 0, 70) ?>...
                    </p>

                    <?php if (!empty($bh['link_bai_hoc'])): ?>
                    <a href="<?= $bh['link_bai_hoc'] ?>" target="_blank" class="badge bg-info text-dark mb-2">
                        Link tham khảo
                    </a>
                    <?php endif; ?>

                    <a href="chi_tiet_bai_hoc.php?id_bh=<?= $bh['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                        Xem chi tiết
                    </a>

                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-info">Không có đề thi nào.</div>
    <?php endif; ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">

            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?id_dm=<?= $id_dm ?>&page=<?= $page - 1 ?>&keyword=<?= $keyword ?>">Trước</a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?id_dm=<?= $id_dm ?>&page=<?= $i ?>&keyword=<?= $keyword ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?id_dm=<?= $id_dm ?>&page=<?= $page + 1 ?>&keyword=<?= $keyword ?>">Sau</a>
            </li>

        </ul>
    </nav>

</div>

<?php
include("./footer.php");
?>