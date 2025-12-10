<?php
include("./header.php");
?>

<div class="container my-5">

    <h3 class="mb-4 fw-bold">Bài học liên quan</h3>

    <?php
    // Lấy danh mục
    $sql_dm = "SELECT * FROM danh_muc_de_thi";
    $result_dm = mysqli_query($dbc, $sql_dm);
    ?>

    <?php while ($dm = mysqli_fetch_assoc($result_dm)): ?>
    <?php
        $id_dm = $dm['id'];

        // Lấy bài học theo danh mục
        $sql_bh = "SELECT * FROM bai_hoc WHERE id_danh_muc = '$id_dm' ORDER BY ngay_tao DESC";
        $result_bh = mysqli_query($dbc, $sql_bh);
        ?>

    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0"><?= $dm['ten_danh_muc'] ?></h5>

            <a href="tat_ca_bai_hoc.php?id_dm=<?= $dm['id'] ?>" class="btn btn-outline-primary btn-sm">
                Xem tất cả bài học
            </a>
        </div>

        <div class="d-flex flex-row overflow-auto gap-3 pb-2">

            <?php if (mysqli_num_rows($result_bh) > 0): ?>

            <?php while ($bh = mysqli_fetch_assoc($result_bh)): ?>
            <div class="card shadow-sm" style="min-width: 260px;">

                <?php if (!empty($bh['anh_bai_hoc'])): ?>
                <img src="./image_baihoc/<?= $bh['anh_bai_hoc'] ?>" class="card-img-top"
                    style="height: 150px; object-fit: cover;">
                <?php endif; ?>

                <div class="card-body">

                    <h6 class="card-title fw-bold"><?= $bh['tieu_de'] ?></h6>

                    <p class="text-secondary  mb-2">
                        <?= substr($bh['noi_dung'], 0, 20) ?>...
                    </p>

                    <?php if (!empty($bh['link_bai_hoc'])): ?>
                    <p>
                        Tài liệu tham khảo: <?= substr($bh['link_bai_hoc'], 0, 15) ?>...
                    </p>
                    <?php endif; ?>


                    <a href="chi_tiet_bai_hoc.php?id_bh=<?= $bh['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                        Xem chi tiết
                    </a>

                </div>
            </div>
            <?php endwhile; ?>

            <?php else: ?>
            <div class="alert alert-info w-100">
                Chưa có bài học nào trong danh mục này.
            </div>
            <?php endif; ?>

        </div>
    </div>

    <?php endwhile; ?>

</div>

<?php
include("./footer.php");
?>