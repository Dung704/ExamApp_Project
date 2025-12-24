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
    FROM de_thi
    WHERE id_danh_muc = $id_dm AND trang_thai = 1

    AND (
    ten_de_thi LIKE '%$keyword%'
    OR mo_ta  LIKE '%$keyword%'
    )
";
$rs_count = mysqli_query($dbc, $sql_count);
$total = mysqli_fetch_assoc($rs_count)['total'];
$total_pages = ceil($total / $limit);

$sql = "
    SELECT *
    FROM de_thi
    WHERE id_danh_muc = $id_dm AND trang_thai = 1
     AND (
    ten_de_thi LIKE '%$keyword%'
    OR mo_ta  LIKE '%$keyword%'
    )
    ORDER BY id DESC
    LIMIT $start, $limit
";
$result = mysqli_query($dbc, $sql);
?>

?>

<div class="container my-4">
    <!-- FORM TÌM KIẾM -->
    <form action="tat_ca_de_thi.php" method="GET">
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
        <?php while($dt = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5><?= $dt['ten_de_thi'] ?></h5>
                    <p><?= substr($dt['mo_ta'], 0, 100) ?>...</p>
                    <a href="chi_tiet_de_thi.php?id=<?= $dt['id'] ?>" class="btn btn-primary btn-sm">Bắt đầu</a>
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