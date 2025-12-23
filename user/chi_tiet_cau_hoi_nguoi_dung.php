<?php
include("./header.php");
?>

<?php
$id = $_GET['id'];

$sql = "
    SELECT c.*, u.ho_ten AS ten_nguoi_hoi, u.anh_dai_dien AS avatar_nguoi_hoi, c.anh_dinh_kem AS anh_dinh_kem
    FROM cau_hoi_nguoi_dung c
    JOIN nguoi_dung u ON c.id_nguoi_hoi = u.id
    WHERE c.id = '$id'
";
$q = mysqli_fetch_assoc(mysqli_query($dbc, $sql));
$anh_cau_hoi = (!empty($q['anh_dinh_kem'])) ? "./image_cauhoi/" . $q['anh_dinh_kem'] : null;
?>

<div class="container mt-4">

    <!-- KHUNG CÂU HỎI -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white py-3">
        </div>

        <div class="card-body">

            <h5 class="fw-bold mb-3"><?= $q['noi_dung'] ?></h5>

            <?php if ($anh_cau_hoi): ?>
            <div class="text-center mb-3">
                <img src="<?= $anh_cau_hoi ?>" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
            </div>
            <?php endif; ?>

            <div class="d-flex align-items-center mt-3 p-2 bg-light rounded">
                <img src="./image_user/<?= $q['avatar_nguoi_hoi'] ?>" width="45" height="45"
                    class="rounded-circle me-3 shadow-sm">

                <div>
                    <strong><?= $q['ten_nguoi_hoi'] ?></strong><br>
                    <small class="text-muted"><?= $q['thoi_gian_tao'] ?></small>
                </div>
            </div>

        </div>
    </div>

    <!-- DANH SÁCH CÂU TRẢ LỜI -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3 ">
            <h5 class="m-0"><i class="bi bi-chat-dots "></i> Các câu trả lời</h5>
        </div>

        <div class="card-body">

            <?php
            $sql_answer = "
                SELECT a.*, u.ho_ten AS ten_nguoi_tra_loi, u.anh_dai_dien AS avatar_tra_loi
                FROM cau_tra_loi_nguoi_dung a
                JOIN nguoi_dung u ON a.id_nguoi_tra_loi = u.id
                WHERE a.id_cau_hoi = '$id'
                ORDER BY a.thoi_gian_tao DESC
            ";
            $rs_answer = mysqli_query($dbc, $sql_answer);

            while ($ans = mysqli_fetch_assoc($rs_answer)):
                $anh_tra_loi = (!empty($ans['anh_dinh_kem']))
                                ? "./image_traloi/" . $ans['anh_dinh_kem']
                                : null;
            ?>

            <div class="p-3 mb-3 bg-white rounded shadow-sm">

                <div class="d-flex align-items-center mb-2">
                    <a href="trang_ca_nhan_nguoi_dung.php?id=<?= $ans['id_nguoi_tra_loi'] ?>">
                        <img src="./image_user/<?= $ans['avatar_tra_loi'] ?>" width="36" height="36"
                            class="rounded-circle me-2 shadow-sm">
                        <strong><?= $ans['ten_nguoi_tra_loi'] ?></strong>

                    </a>


                </div>

                <p class="mb-2"><?= nl2br($ans['noi_dung']) ?></p>

                <?php if ($anh_tra_loi): ?>
                <div class="text-center mb-2">
                    <img src="<?= $anh_tra_loi ?>" class="img-fluid rounded shadow-sm" style="max-width: 250px;">
                </div>
                <?php endif; ?>

                <small class="text-muted"><?= $ans['thoi_gian_tao'] ?></small>

            </div>

            <?php endwhile; ?>

            <!-- FORM TRẢ LỜI -->
            <div class="mt-4">
                <h6 class="fw-bold mb-2">Đưa ra câu trả lời của bạn nhanh nào</h6>

                <form action="xu_ly_tra_loi.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_cau_hoi" value="<?= $id ?>">

                    <textarea name="noi_dung" class="form-control mb-3" rows="3"
                        placeholder="Nhập câu trả lời..."></textarea>

                    <label class="form-label small">Ảnh đính kèm (tùy chọn):</label>
                    <input type="file" name="anh_dinh_kem" accept="image/*" class="form-control mb-3">

                    <button class="btn btn-success px-4">
                        <i class="bi bi-send"></i> Gửi trả lời
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>

<?php
include("./footer.php");
?>