<?php
include("./header.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?tmp=yeu_cau_dang_nhap");
    exit();
}
$id = $_GET['id'];

$sql = "SELECT * FROM de_thi WHERE id = '$id'";
$result = mysqli_query($dbc, $sql);
$dt = mysqli_fetch_assoc($result);

$q_count = mysqli_fetch_assoc(mysqli_query($dbc, 
    "SELECT COUNT(*) AS tong FROM cau_hoi WHERE id_de_thi = '$id'"
));
?>

<div class="container my-5" style="max-width: 800px;">

    <div class="card shadow-lg border-0">
        <div class="card-body p-4">

            <!-- Tiêu đề -->
            <h2 class="fw-bold text-primary mb-3">
                <i class="bi bi-journal-text me-2"></i>
                <?= $dt['ten_de_thi'] ?>
            </h2>

            <!-- Mô tả -->
            <p class="text-secondary fs-5">
                <?= $dt['mo_ta'] ?>
            </p>

            <hr>

            <!-- Thông tin đề thi -->
            <div class="row mb-3">

                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-light rounded shadow-sm h-100">
                        <h6 class="text-muted mb-1">
                            <i class="bi bi-clock-history me-1"></i> Thời gian làm bài
                        </h6>
                        <p class="fs-4 fw-bold mb-0"><?= $dt['thoi_gian'] ?> phút</p>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-light rounded shadow-sm h-100">
                        <h6 class="text-muted mb-1">
                            <i class="bi bi-list-check me-1"></i> Số câu hỏi
                        </h6>
                        <p class="fs-4 fw-bold mb-0"><?= $q_count['tong'] ?></p>
                    </div>
                </div>

            </div>

            <!-- Nút bắt đầu -->
            <div class="text-center mt-4">
                <a href="thi.php?id=<?= $id ?>" class="btn btn-primary btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-play-circle me-2"></i> Bắt đầu thi
                </a>
            </div>

        </div>
    </div>

</div>


<?php include("./footer.php"); ?>