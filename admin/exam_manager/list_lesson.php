<?php
// --- Xóa bài học ---
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_image = "SELECT anh_bai_hoc FROM bai_hoc WHERE id = '$id'";
    $result_query_image = mysqli_query($conn, $query_image);
    if ($row_image = mysqli_fetch_assoc($result_query_image)) {
        $file_name = $row_image['anh_bai_hoc'];
        $path = "_assets/_images/" . $file_name;
        if (!empty($file_name) && file_exists($path)) {
            unlink($path);
        }
    }

    $delete_lesson = "DELETE FROM bai_hoc WHERE id='$id'";
    if (mysqli_query($conn, $delete_lesson)) {
        echo '<div id="alert-box" class="alert alert-success"
            style="position:fixed; top:20px; right:20px; z-index:9999;">Đã xoá!</div>
            <script>
                setTimeout(function() {
                    document.getElementById("alert-box").remove();
                    window.location.href = "index_admin.php?page=list_lesson";
                });
            </script>';
    } else {
        echo "Lỗi xóa bài học: " . mysqli_error($conn);
    }
}

// --- Lấy dữ liệu bài học ---
$query_to_show = "SELECT 
    bh.*, 
    dmdt.ten_danh_muc
FROM bai_hoc AS bh
LEFT JOIN danh_muc_de_thi AS dmdt
    ON bh.id_danh_muc = dmdt.id;
";
$result_to_show = mysqli_query($conn, $query_to_show);
?>


<!-- Table -->

<div class="table-card">

    <div class="row">
        <div class="col-6">
            <h5 class="mb-3">Danh sách bài học</h5>
        </div>
        <div class="col-6 text-end">
            <a href="index_admin.php?page=add_lesson" class="btn btn-primary">Thêm bài học</a>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã bài học</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Ảnh bài học</th>
                    <th>Link bài học</th>
                    <th>Danh mục</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result_to_show)) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['tieu_de'] ?></td>
                        <td><?= $row['noi_dung'] ?></td>
                        <td>
                            <?php if ($row['anh_bai_hoc'] != null): ?>
                                <img src="_assets/_images/<?php echo $row['anh_bai_hoc']; ?>"
                                    style="width:100px; height:100px; object-fit:cover;">
                            <?php else: ?>
                                Không có
                            <?php endif; ?>
                        </td>
                        <td><?= $row['link_bai_hoc'] ?></td>
                        <td><?= $row['ten_danh_muc'] ?></td>
                        <td><?= $row['ngay_tao'] ?></td>
                        <td>
                            <a href="index_admin.php?page=edit_lesson&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-warning">Sửa</a>
                            <a href="index_admin.php?page=list_lesson&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc muốn xoá bài học này?')">
                                Xoá
                            </a>
                        </td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>