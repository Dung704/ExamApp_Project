<?php
$query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM de_thi";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);
$new_dt = 'DT' . ($row_max['max_id'] + 1);

// Xử lý submit form
if (isset($_POST['submit'])) {
    $ten_dt = trim($_POST['ten_de_thi']);
    $mo_ta = trim($_POST['mo_ta']);
    $thoi_gian = trim($_POST['thoi_gian']);
    $thang_diem = trim($_POST['thang_diem']);
    $id_danh_muc = $_POST['id_danh_muc'];
    //Kiểm tra trùng
    $query_duplicate = "
    SELECT id
    FROM de_thi
    WHERE ten_de_thi = '$ten_dt'
      AND id_danh_muc = $id_danh_muc
    LIMIT 1";

    $query_duplicate_result = mysqli_query($conn, $query_duplicate);
    $duplicate_result = mysqli_fetch_assoc($query_duplicate_result);

    if (mysqli_num_rows($query_duplicate_result) > 0) {
        echo '<div class="alert alert-danger">Tên đề thi đã tồn tại! Mã đề thi: ' . $duplicate_result['id'] . '</div>';
    } else {
        $insert = "INSERT INTO de_thi (id, ten_de_thi, mo_ta, thoi_gian, thang_diem, id_danh_muc)
               VALUES ('$new_dt', '$ten_dt', '$mo_ta','$thoi_gian', '$thang_diem', '$id_danh_muc')";

        if (mysqli_query($conn, $insert)) {
            echo '<div class="alert alert-success">Thêm đề thi thành công! Mã đề thi: ' . $new_dt . '</div>';
        } else {
            echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>
<div class="table-card">
    <h3>Thêm đề thi mới</h3>
    <form action="" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mã đề thi:</label>
                <input type="text" name="Ma_de_thi" class="form-control" value="<?php echo $new_dt; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label>Tên đề thi:</label>
                <input type="text" name="ten_de_thi" class="form-control" required value="<?php echo isset($_POST['ten_de_thi']) ? $_POST['ten_de_thi'] : ''; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Thời gian (phút):</label>
                <input min="0" max="3600" type="number" name="thoi_gian" class="form-control" required
                    onkeydown="if(event.key === '-' || event.key === '+'){event.preventDefault();}"
                    value="<?php echo isset($_POST['thoi_gian']) ? $_POST['thoi_gian'] : ''; ?>">
            </div>
            <div class="col-md-4">
                <label>Thang điểm:</label>
                <input min="0" max="1200" type="number" name="thang_diem" class="form-control" required
                    onkeydown="if(event.key === '-' || event.key === '+'){event.preventDefault();}"
                    value="<?php echo isset($_POST['thang_diem']) ? $_POST['thang_diem'] : ''; ?>">
            </div>
            <div class="col-md-4">
                <label>Danh mục:</label>
                <select name="id_danh_muc" class="form-select" required>
                    <?php
                    $rs = mysqli_query($conn, "SELECT id, ten_danh_muc FROM danh_muc_de_thi");
                    while ($r = mysqli_fetch_assoc($rs)) {
                        $selected = (isset($_POST['id_danh_muc']) && $_POST['id_danh_muc'] == $r['id']) ? 'selected' : '';
                        echo '<option value="' . $r['id'] . '" ' . $selected . '>' . $r['ten_danh_muc'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label>Mô tả</label>
                <textarea name="mo_ta" class="form-control" placeholder="Có thể để trống" rows="5"><?= isset($_POST['mo_ta']) ? $_POST['mo_ta'] : '' ?></textarea>

            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm đề thi</button>
        <a href="index_admin.php?page=list_exam" class="btn btn-secondary">Về trang đề thi</a>
    </form>
</div>