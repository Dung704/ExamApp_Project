<?php
$id_detail = $_GET['id'];

// Lấy chi tiết đề thi
$query_detail = "
    SELECT * 
    FROM de_thi 
    WHERE id = '$id_detail'
";
$query_detail_result = mysqli_query($conn, $query_detail);

// Lấy danh mục
$query_dm = "SELECT id, ten_danh_muc FROM danh_muc_de_thi";
$result_dm = mysqli_query($conn, $query_dm);

// Submit form
if (isset($_POST['submit'])) {

    $ten_de_thi   = trim($_POST['ten_de_thi']);
    $id_danh_muc  = (int)$_POST['id_danh_muc'];
    $mo_ta        = trim($_POST['mo_ta']);
    $thoi_gian    = (int)$_POST['thoi_gian'];
    $thang_diem   = (int)$_POST['thang_diem'];
    $trang_thai = $_POST['trang_thai'];
    // Check trùng tên + danh mục (loại trừ chính nó)
    $query_duplicate = "
        SELECT 1 
        FROM de_thi 
        WHERE ten_de_thi = '$ten_de_thi'
          AND id_danh_muc = $id_danh_muc
          AND id != '$id_detail'
        LIMIT 1
    ";
    $result_duplicate = mysqli_query($conn, $query_duplicate);

    if (mysqli_num_rows($result_duplicate) > 0) {
        echo '<div class="alert alert-danger">
                Tên đề thi đã tồn tại trong danh mục này!
              </div>';
    } else {

        $query_update = "
            UPDATE de_thi 
            SET 
                ten_de_thi = '$ten_de_thi',
                id_danh_muc = $id_danh_muc,
                mo_ta = '$mo_ta',
                thoi_gian = $thoi_gian,
                thang_diem = $thang_diem,
                trang_thai = $trang_thai
            WHERE id = '$id_detail'
        ";

        if (mysqli_query($conn, $query_update)) {
            echo '
            <script>
                setTimeout(function() {
                         window.location.href = "index_admin.php?page=edit_exam&id=' . $id_detail . '";
                    });
            </script>';
        } else {
            echo "Lỗi cập nhật: " . mysqli_error($conn);
        }
    }
}
?>
<div class="table-card">
    <form method="post">
        <h3 class="text-center">Cập nhật đề thi</h3>

        <?php $dt = mysqli_fetch_assoc($query_detail_result); ?>
        <div class="row mb-3">
            <h3>Thông tin đề thi</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Mã đề thi:</label>
                    <input type="text" class="form-control" value="<?= $dt['id'] ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Tên đề thi:</label>
                    <input type="text" name="ten_de_thi" class="form-control" required
                        value="<?= $dt['ten_de_thi'] ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Danh mục:</label>
                    <select name="id_danh_muc" class="form-select" required>
                        <?php while ($dm = mysqli_fetch_assoc($result_dm)) { ?>
                            <option value="<?= $dm['id'] ?>"
                                <?= $dm['id'] == $dt['id_danh_muc'] ? 'selected' : '' ?>>
                                <?= $dm['ten_danh_muc'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Thời gian (phút):</label>
                    <input type="number" min="0" name="thoi_gian" class="form-control"
                        value="<?= $dt['thoi_gian'] ?>">
                </div>

                <div class="col-md-3">
                    <label>Thang điểm:</label>
                    <input type="number" min="0" name="thang_diem" class="form-control"
                        value="<?= $dt['thang_diem'] ?>">
                </div>
                <div class="col-md-3">
                    <label>Trạng thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="0" <?= $dt['trang_thai'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                        <option value="1" <?= $dt['trang_thai'] == 1 ? 'selected' : '' ?>>Hiện</option>
                    </select>
                </div>


            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Mô tả:</label>
                    <textarea id="noi_dung" name="mo_ta" class="form-control" rows="5"><?= $dt['mo_ta'] ?></textarea>
                </div>
            </div>
        </div>


        <button type="submit" name="submit" class="btn btn-primary"
            onclick="return confirm('Bạn có chắc muốn cập nhật đề thi này?')">
            Cập nhật đề thi
        </button>

        <a href="index_admin.php?page=list_exam" class="btn btn-secondary">Quay lại</a>
    </form>
</div>