<?php
// --- Xóa danh mục đề thi ---
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_exam_category = "DELETE FROM danh_muc_de_thi WHERE id='$id'";
    if (mysqli_query($conn, $delete_exam_category)) {
        echo '<div id="alert-box" class="alert alert-success"
            style="position:fixed; top:20px; right:20px; z-index:9999;">Đã xoá!</div>
            <script>
                setTimeout(function() {
                    document.getElementById("alert-box").remove();
                    window.location.href = "index_admin.php?page=list_exam_category";
                });
            </script>';
    } else {
        echo "Lỗi xóa danh mục đề thi: " . mysqli_error($conn);
    }
}

// --- Lấy dữ liệu danh mục đề thi ---
$query_to_show = "SELECT * from danh_muc_de_thi";
$result_to_show = mysqli_query($conn, $query_to_show);
?>

<!-- Table -->
<div class="table-card">
    <div class="row">
        <div class="col-6">
            <h5 class="mb-3">Danh sách danh mục đề thi</h5>
        </div>
        <div class="col-6 text-end">
            <a href="index_admin.php?page=add_exam_category" class="btn btn-primary">Thêm danh mục đề thi</a>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã danh mục đề thi</th>
                    <th>Tên danh mục đề thi</th>
                    <th>Mô tả</th>
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
                        <td><?= $row['ten_danh_muc'] ?></td>
                        <td class="text-start"><?= $row['mo_ta'] ?></td>
                        <td>
                            <a href="index_admin.php?page=edit_exam_category&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-warning">Sửa</a>
                            <a href="index_admin.php?page=list_exam_category&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc muốn xoá danh mục đề thi này?')">
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
</div>