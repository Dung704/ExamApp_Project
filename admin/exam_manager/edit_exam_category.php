<?php
$id_detail = $_GET['id'];
$query_detail = "SELECT * FROM danh_muc_de_thi WHERE id = '$id_detail'";
$query_detail_result = mysqli_query($conn, $query_detail);

// Xử lý submit form
if (isset($_POST['submit'])) {

    $ten = trim($_POST['Ten_danh_muc_de_thi']);
    $mo_ta = trim($_POST['mo_ta']);
    //Kiểm tra trùng
    $query_duplicate = "SELECT id, ten_danh_muc from danh_muc_de_thi where ten_danh_muc = '$ten' and id != '$id_detail'";
    $query_duplicate_result = mysqli_query($conn, $query_duplicate);
    $duplicate_result = mysqli_fetch_assoc($query_duplicate_result);

    if (mysqli_num_rows($query_duplicate_result) > 0) {
        echo '<div class="alert alert-danger">Tên loại danh mục đề thi đã tồn tại! Mã LDT: ' . $duplicate_result['id'] . '</div>';
    } else {
        $query_update_detail = "
    UPDATE danh_muc_de_thi 
    SET 
        ten_danh_muc = '$ten',
        mo_ta = '$mo_ta'
    WHERE id = '$id_detail' ";
        $result_update = mysqli_query($conn, $query_update_detail);
        if ($result_update) {
            echo '
          <script>
              setTimeout(function() {
                  window.location.href = "index_admin.php?page=edit_exam_category&id=' . $id_detail . '";
              },);
          </script>';
        } else {
            echo "Lỗi cập nhật loại danh mục đề thi: " . mysqli_error($conn);
        }
    }
}
?>

<form method="post" action="" enctype="multipart/form-data">
    <h3>Cập nhât loại danh mục đề thi</h3>
    <?php while ($sp = mysqli_fetch_assoc($query_detail_result)) { ?>
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mã loại danh mục đề thi:</label>
                <input type="text" name="Ma_danh_muc_de_thi" class="form-control" value="<?php echo $sp['id']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label>Tên loại danh mục đề thi:</label>
                <input type="text" name="Ten_danh_muc_de_thi" class="form-control" required value="<?php echo $sp['ten_danh_muc'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Mô tả: </label>
                <textarea name="mo_ta" class="form-control" placeholder="Có thể để trống" rows="5"><?php echo $sp['mo_ta']; ?></textarea>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc muốn cập nhật loại danh mục đề thi này?')">Cập nhật loại danh mục đề thi</button>
        <a href="index_admin.php?page=list_exam_category" class="btn btn-secondary">Về trang loại danh mục đề thi</a>
    <?php } ?>
</form>