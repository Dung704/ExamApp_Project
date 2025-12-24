<?php 
include("./header.php");

$ten_dm = " "; 

if(isset($_GET['id_dm'])){
    $id_dm = $_GET['id_dm'];

    $sql_dm = "SELECT ten_danh_muc FROM danh_muc_de_thi WHERE id = $id_dm";
    $result_dm = mysqli_query($dbc, $sql_dm);
    if(mysqli_num_rows($result_dm) > 0){
        $ten_dm = mysqli_fetch_assoc($result_dm)['ten_danh_muc'];
    }

    $sql_de = "SELECT * FROM de_thi WHERE id_danh_muc = $id_dm ORDER BY ngay_tao DESC";
    $result_de = mysqli_query($dbc, $sql_de);
} else {
    $result_de = mysqli_query($dbc, "SELECT * FROM de_thi ORDER BY ngay_tao DESC");
}
?>

<div class="container my-5">
    <h4 class="mb-4 fw-bold"><?= $ten_dm ?></h4>

    <div class="row g-3">
        <?php if(mysqli_num_rows($result_de) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result_de)): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['ten_de_thi'] ?></h5>
                    <p class="card-text mb-1">Thời gian: <?= $row['thoi_gian'] ?> phút</p>
                    <p class="card-text mb-2">Mô tả : <?php echo $row['mo_ta']?></p>
                    <p class="card-text mb-2">Thang Điểm: <?php echo $row['thang_diem']?></p>
                    <p class="card-text mb-2">Ngày Tạo : <?php echo $row['thang_diem']?></p>
                    <a href="./chi_tiet_de_thi.php?id=<?= $row['id'] ?>" class="btn btn-primary w-100">Bắt đầu</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <p>Chưa có đề thi nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
</div>

<?php include("./footer.php"); ?>