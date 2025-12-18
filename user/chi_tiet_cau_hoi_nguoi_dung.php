<?php
include("./header.php");
?>

<?php
$id = $_GET['id'];

// Lấy thông tin câu hỏi + người hỏi
$sql = "
    SELECT c.*, u.ho_ten AS ten_nguoi_hoi, u.anh_dai_dien AS avatar_nguoi_hoi, c.anh_dinh_kem  AS anh_dinh_kem
    FROM cau_hoi_nguoi_dung c
    JOIN nguoi_dung u ON c.id_nguoi_hoi = u.id
    WHERE c.id = '$id'
";
$q = mysqli_fetch_assoc(mysqli_query($dbc, $sql));
$anh_cau_hoi = (!empty($q['anh_dinh_kem'])) ? "./image_cauhoi/" . $q['anh_dinh_kem']: null;
?>

<div class="container mt-4">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h4 class="m-0">Chi tiết câu hỏi</h4>
        </div>

        <div class="card-body">

            <h5 class="fw-bold"><?= $q['noi_dung'] ?></h5>
            <?php if ($anh_cau_hoi): ?>
            <div class="mt-2">
                <img src="<?= $anh_cau_hoi ?>" style="max-width: 200px; border-radius: 6px;" alt="Ảnh câu hỏi">
            </div>
            <?php endif; ?>



            <div class="d-flex align-items-center mt-2">
                <img src="./image_user/<?= $q['avatar_nguoi_hoi'] ?>" width="40" height="40"
                    class="rounded-circle me-2">

                <div>
                    <strong><?= $q['ten_nguoi_hoi'] ?></strong><br>
                    <small class="text-muted"><?= $q['thoi_gian_tao'] ?></small>
                </div>
            </div>

        </div>
    </div>

    <!-- BÌNH LUẬN -->
    <!-- CÁC CÂU TRẢ LỜI -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="m-0">Các Câu Trả Lời</h5>
        </div>

        <div class="card-body">

            <?php
        // Lấy danh sách câu trả lời
        $sql_answer = "
            SELECT a.*, u.ho_ten AS ten_nguoi_tra_loi, u.anh_dai_dien AS avatar_tra_loi
            FROM cau_tra_loi_nguoi_dung a
            JOIN nguoi_dung u ON a.id_nguoi_tra_loi = u.id
            WHERE a.id_cau_hoi = '$id'
            ORDER BY a.thoi_gian_tao DESC
        ";
        $rs_answer = mysqli_query($dbc, $sql_answer);

        while ($ans = mysqli_fetch_assoc($rs_answer)):

            // Lấy ảnh đính kèm của câu trả lời
            $anh_tra_loi = (!empty($ans['anh_dinh_kem']))
                            ? "./image_traloi/" . $ans['anh_dinh_kem']
                            : null;
        ?>

            <div class="border-bottom pb-2 mb-3">

                <div class="d-flex align-items-center mb-1">
                    <img src="./image_user/<?= $ans['avatar_tra_loi'] ?>" width="32" height="32"
                        class="rounded-circle me-2">
                    <strong><?= $ans['ten_nguoi_tra_loi'] ?></strong>
                </div>

                <p class="m-0"><?= $ans['noi_dung'] ?></p>

                <?php if ($anh_tra_loi): ?>
                <div class="mt-2">
                    <img src="<?= $anh_tra_loi ?>" style="max-width: 200px; border-radius: 6px;" alt="Ảnh trả lời">
                </div>
                <?php endif; ?>

                <small class="text-muted"><?= $ans['thoi_gian_tao'] ?></small>

            </div>

            <?php endwhile; ?>


            <!-- FORM TRẢ LỜI -->
            <form action="xu_ly_tra_loi.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_cau_hoi" value="<?= $id ?>">

                <textarea name="noi_dung" class="form-control mb-2" rows="3"
                    placeholder="Nhập câu trả lời của bạn..."></textarea>

                <!-- Upload ảnh -->
                <div class="mb-2">
                    <label class="form-label small">Ảnh đính kèm (tùy chọn):</label>
                    <input type="file" name="anh_dinh_kem" accept="image/*" class="form-control">
                </div>

                <button class="btn btn-primary">Gửi trả lời</button>
            </form>

        </div>
    </div>



</div>

<?php
include("./footer.php");
?>