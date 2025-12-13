<?php
// --- Xóa người dùng ---
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_user = "DELETE FROM nguoi_dung WHERE id='$id'";

    $query_image = "SELECT anh_dai_dien FROM nguoi_dung WHERE id = '$id'";
    $result_query_image = mysqli_query($conn, $query_image);
    if ($row_image = mysqli_fetch_assoc($result_query_image)) {
        $file_name = $row_image['anh_dai_dien'];
        $path = "../user/image_user/" . $file_name;
        if (!empty($file_name) && file_exists($path)) {
            unlink($path);
        }
    }
    if (mysqli_query($conn, $delete_user)) {
        echo '<div id="alert-box" class="alert alert-success"
            style="position:fixed; top:20px; right:20px; z-index:9999;">Đã xoá!</div>
            <script>
                setTimeout(function() {
                    document.getElementById("alert-box").remove();
                    window.location.href = "index_admin.php?page=list_user";
                });
            </script>';
    } else {
        echo "Lỗi xóa người dùng: " . mysqli_error($conn);
    }
}

// --- Lấy dữ liệu người dùng ---
$query_to_show = "SELECT 
    nd.*, 
    pq.ten_quyen
FROM nguoi_dung AS nd
LEFT JOIN phan_quyen AS pq
    ON nd.id_quyen = pq.id
ORDER BY nd.id ASC;
";
$result_to_show = mysqli_query($conn, $query_to_show);
?>


<!-- Table -->

<div class="table-card">

    <div class="row">
        <div class="col-6">
            <h5 class="mb-3">Danh sách người dùng</h5>
        </div>
        <div class="col-6 text-end">
            <a href="index_admin.php?page=add_user" class="btn btn-primary">Thêm người dùng</a>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã người dùng</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Ảnh đại diện</th>
                    <th>Quyền</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Địa chỉ</th>
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
                        <td><?= $row['ho_ten'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['so_dien_thoai'] ?></td>
                        <td>
                            <?php if ($row['anh_dai_dien'] != null): ?>
                                <img src="../user/image_user/<?php echo $row['anh_dai_dien']; ?>"
                                    style="width:100px; height:100px; object-fit:cover;">
                            <?php else: ?>
                                Không có
                            <?php endif; ?>
                        </td>
                        <td><?= $row['ten_quyen'] ?></td>
                        <td><?= $row['ngay_sinh'] ?></td>
                        <td><?= ($row['gioi_tinh'] == 1 ? "Nam" : "Nữ") ?></td>
                        <td><?= $row['dia_chi'] ?></td>
                        <td><?= $row['ngay_tao'] ?></td>
                        <td>
                            <a href="index_admin.php?page=edit_user&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-warning">Sửa</a>
                            <a href="index_admin.php?page=list_user&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-danger"
                                title="Bạn có chắc muốn xoá người dùng này? vì dữ liệu này liên quan tới..."
                                onclick="return confirm('Bạn có chắc muốn xoá người dùng này? vì dữ liệu này liên quan tới những dữ liệu kết quả khác và nó sẽ bị xoá cùng nhau ')">
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