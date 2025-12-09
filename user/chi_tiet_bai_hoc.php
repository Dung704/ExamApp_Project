<?php
include("./header.php");

// Lấy id bài học từ GET
$id_bai_hoc = $_GET['id_bh'] ?? '';

if ($id_bai_hoc) {
    // Lấy thông tin bài học
    $sql_bh = "SELECT * FROM bai_hoc WHERE id = '$id_bai_hoc'";
    $result_bh = mysqli_query($dbc, $sql_bh);

    if(mysqli_num_rows($result_bh) > 0){
        $bai_hoc = mysqli_fetch_assoc($result_bh);

        // Lấy các tập tin kèm theo
        $sql_files = "SELECT * FROM tap_tin_bai_hoc WHERE id_bai_hoc = '$id_bai_hoc'";
        $result_files = mysqli_query($dbc, $sql_files);
    } else {
        echo "<div class='alert alert-warning text-center mt-5'>Bài học không tồn tại.</div>";
        include("./footer.php");
        exit;
    }
} else {
    echo "<div class='alert alert-warning text-center mt-5'>Chưa chọn bài học.</div>";
    include("./footer.php");
    exit;
}
?>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><?= $bai_hoc['tieu_de'] ?></h4>
            <small>Ngày tạo: <?= $bai_hoc['ngay_tao'] ?></small>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if(!empty($bai_hoc['anh_bai_hoc'])): ?>
                <div class="col-md-4 mb-3">
                    <img src="./image_baihoc/<?= $bai_hoc['anh_bai_hoc'] ?>" alt="<?= $bai_hoc['tieu_de'] ?>"
                        class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-8">
                    <?php else: ?>
                    <div class="col-12">
                        <?php endif; ?>
                        <div style="max-height: 500px; overflow-y:auto;">
                            <p><?= nl2br($bai_hoc['noi_dung']) ?></p>
                            <?php if(!empty($bai_hoc['link_bai_hoc'])): ?>
                            <p>Link tham khảo: <a href="<?= $bai_hoc['link_bai_hoc'] ?>"
                                    target="_blank"><?= $bai_hoc['link_bai_hoc'] ?></a></p>
                            <?php endif; ?>
                        </div>

                        <?php if(mysqli_num_rows($result_files) > 0): ?>
                        <div class="mt-3">
                            <h5>Tài liệu đính kèm:</h5>
                            <ul class="list-group">
                                <?php while($file = mysqli_fetch_assoc($result_files)): ?>
                                <li class="list-group-item">
                                    <a href="./file_pdf/<?= $file['duong_dan'] ?>" target="_blank">
                                        <?= $file['loai_tap_tin'] ?> - <?= basename($file['duong_dan']) ?>
                                    </a>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("./footer.php"); ?>