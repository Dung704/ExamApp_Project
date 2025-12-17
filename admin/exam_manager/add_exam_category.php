<?php
$query_max = "SELECT MAX(CAST(SUBSTRING(id, 1) AS UNSIGNED)) AS max_id FROM danh_muc_de_thi";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);

$new_ldt = ($row_max['max_id'] + 1);

// Xử lý submit form
if (isset($_POST['submit'])) {
    $ten_ldt = trim($_POST['ten_danh_muc']);
    $mo_ta = trim($_POST['mo_ta']);
    //Kiểm tra trùng
    $query_duplicate = "SELECT id, ten_danh_muc from danh_muc_de_thi where ten_danh_muc = '$ten_ldt'";
    $query_duplicate_result = mysqli_query($conn, $query_duplicate);
    $duplicate_result = mysqli_fetch_assoc($query_duplicate_result);

    if (mysqli_num_rows($query_duplicate_result) > 0) {
        echo '<div class="alert alert-danger">Tên danh mục đề thi đã tồn tại! Mã ldt: ' . $duplicate_result['id'] . '</div>';
    } else {
        $insert = "INSERT INTO danh_muc_de_thi (id, ten_danh_muc, mo_ta)
               VALUES ('$new_ldt', '$ten_ldt', '$mo_ta')";

        if (mysqli_query($conn, $insert)) {
            echo '<div class="alert alert-success">Thêm danh mục đề thi thành công! Mã loại đề thi: ' . $new_ldt . '</div>';
        } else {
            echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>
<div class="table-card">

    <h3>Thêm danh mục đề thi mới</h3>
    <form action="" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mã danh mục đề thi:</label>
                <input type="text" name="Ma_danh_muc_de_thi" class="form-control" value="<?php echo $new_ldt; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label>Tên danh mục đề thi:</label>
                <input type="text" name="ten_danh_muc" class="form-control" required value="<?php echo isset($_POST['ten_danh_muc']) ? $_POST['ten_danh_muc'] : ''; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Mô tả</label>
                <textarea name="mo_ta" class="form-control" placeholder="Có thể để trống" rows="5" value="<?php echo isset($_POST['mo_ta']) ? $_POST['mo_ta'] : ''; ?>"></textarea>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm danh mục đề thi</button>
        <a href="index_admin.php?page=list_exam_category" class="btn btn-secondary">Về trang danh mục đề thi</a>
    </form>
</div>