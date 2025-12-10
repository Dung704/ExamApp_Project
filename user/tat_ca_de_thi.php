<?php
include("./header.php");
$id_dm = $_GET['id_dm'];

$sql_dm = "SELECT ten_danh_muc FROM danh_muc_de_thi WHERE id = $id_dm";
$dm = mysqli_fetch_assoc(mysqli_query($dbc, $sql_dm));

$sql = "SELECT * FROM de_thi WHERE id_danh_muc = $id_dm ORDER BY id DESC";
$result = mysqli_query($dbc, $sql);
?>

<div class="container my-4">
    <h3 class="mb-4">Tất cả đề thi: <?= $dm['ten_danh_muc'] ?></h3>

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
</div>

<?php
include("./footer.php");
?>