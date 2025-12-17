<?php
$id_detail = $_GET['id'];

// Lấy thông tin bài học
$query_detail = "SELECT * FROM bai_hoc WHERE id = '$id_detail'";
$query_detail_result = mysqli_query($conn, $query_detail);

$query_id_danh_muc = "select id, ten_danh_muc from danh_muc_de_thi";
$query_id_danh_muc_result = mysqli_query($conn, $query_id_danh_muc);


// Xử lý submit form
if (isset($_POST['submit'])) {
    $tieu_de = trim($_POST['tieu_de']);
    $noi_dung = trim($_POST['noi_dung']);
    $id_danh_muc = $_POST['id_danh_muc'];
    $link_bai_hoc = $_POST['link_bai_hoc'];


    // Xử lý ảnh đại diện
    $anh_bai_hoc = '';

    if (isset($_FILES['anh_bai_hoc']) && $_FILES['anh_bai_hoc']['error'] == 0) {

        // Xóa ảnh cũ
        $query_image = "SELECT anh_bai_hoc FROM bai_hoc WHERE id = '$id_detail'";
        $result_query_image = mysqli_query($conn, $query_image);

        if ($row_image = mysqli_fetch_assoc($result_query_image)) {
            $file_name = $row_image['anh_bai_hoc'];
            $path = "_assets/_images/" . $file_name;
            if (file_exists($path)) unlink($path);
        }

        $anh_bai_hoc = time() . '_' . $_FILES['anh_bai_hoc']['name'];
        move_uploaded_file($_FILES['anh_bai_hoc']['tmp_name'],     '../user/image_user/' . $anh_bai_hoc);
    } else {
        // Giữ ảnh cũ
        $query_image = "SELECT anh_bai_hoc FROM bai_hoc WHERE id = '$id_detail'";
        $res_img = mysqli_query($conn, $query_image);
        $row_old = mysqli_fetch_assoc($res_img);
        $anh_bai_hoc = $row_old['anh_bai_hoc'];
    }
}
?>
<div class="table-card">
    <form method="post" action="" enctype="multipart/form-data">
        <h3>Cập nhật bài học</h3>
        <?php while ($u = mysqli_fetch_assoc($query_detail_result)) { ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>ID:</label>
                    <input type="text" readonly class="form-control" value="<?php echo $u['id']; ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label>Tiêu đề:</label>
                    <input type="text" name="tieu_de" class="form-control" required value="<?php echo $u['tieu_de']; ?>">
                </div>
                <div class="col-md-4">
                    <label>Link bài học</label>
                    <input type="text" name="link_bai_hoc" class="form-control" required value="<?php echo $u['link_bai_hoc']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Nội dung bài học</label>
                    <textarea class="form-control" rows="4" name="noi_dung"><?php echo $u['noi_dung'] ?></textarea>
                </div>
            </div>
            <div class="row mb-3">

            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Danh mục bài học:</label>
                    <select name="id_danh_muc" class="form-select" required>
                        <?php while ($r = mysqli_fetch_assoc($query_id_danh_muc_result)): ?>
                            <option value="<?php echo $r['id']; ?>"
                                <?php echo $u['id'] == $r['id'] ? 'selected' : ''; ?>>
                                <?php echo $r['ten_danh_muc']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label>Ảnh bài học:</label>
                    <div class="row">
                        <div class="col">
                            <input type="file" name="anh_bai_hoc" class="form-control" accept="image/*">
                        </div>
                        <div class="col">
                            <?php
                            // Đường dẫn tương đối để hiển thị ảnh
                            $avatarPath = "_assets/_images/" . $u['anh_bai_hoc'];
                            if (!empty($u['anh_bai_hoc'])) {
                                echo '<img src="' . $avatarPath . '" 
                style="width:300px;height:300px;object-fit:cover;border-radius:8px;">';
                            } else {
                                echo '<span style="color:gray;">Không có ảnh</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index_admin.php?page=list_lesson" class="btn btn-secondary">Về trang danh sách</a>

        <?php } ?>
    </form>
</div>