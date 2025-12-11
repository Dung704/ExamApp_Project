<?php
$id_detail = $_GET['id'];

// Lấy thông tin người dùng
$query_detail = "SELECT * FROM nguoi_dung WHERE id = '$id_detail'";
$query_detail_result = mysqli_query($conn, $query_detail);

// Lấy danh sách quyền (nếu bạn có bảng quyền)
$query_role = "SELECT * FROM phan_quyen";
$query_role_result = mysqli_query($conn, $query_role);

// Xử lý submit form
if (isset($_POST['submit'])) {
    $ho_ten = trim($_POST['ho_ten']);
    $email = trim($_POST['email']);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $dia_chi = trim($_POST['dia_chi']);
    $id_quyen = $_POST['id_quyen'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $ngay_sinh = $_POST['ngay_sinh'];

    // Xử lý ảnh đại diện
    $anh_dai_dien = '';

    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] == 0) {

        // Xóa ảnh cũ
        $query_image = "SELECT anh_dai_dien FROM nguoi_dung WHERE id = '$id_detail'";
        $result_query_image = mysqli_query($conn, $query_image);

        if ($row_image = mysqli_fetch_assoc($result_query_image)) {
            $file_name = $row_image['anh_dai_dien'];
            $path = __DIR__ . "/../user/image_user/" . $file_name;
            if (file_exists($path)) unlink($path);
        }

        $anh_dai_dien = time() . '_' . $_FILES['anh_dai_dien']['name'];
        move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'],     '../user/image_user/' . $anh_dai_dien);
    } else {
        // Giữ ảnh cũ
        $query_image = "SELECT anh_dai_dien FROM nguoi_dung WHERE id = '$id_detail'";
        $res_img = mysqli_query($conn, $query_image);
        $row_old = mysqli_fetch_assoc($res_img);
        $anh_dai_dien = $row_old['anh_dai_dien'];
    }

    // Kiểm tra email trùng (trừ chính mình)
    $query_duplicate = "
        SELECT email FROM nguoi_dung 
        WHERE email = '$email' AND id != '$id_detail'
    ";

    $duplicate = mysqli_query($conn, $query_duplicate);

    if (mysqli_num_rows($duplicate) > 0) {
        echo '<div class="alert alert-danger">Email đã tồn tại!</div>';
    } else {

        $query_update = "
            UPDATE nguoi_dung SET
                ho_ten = '$ho_ten',
                email = '$email',
                so_dien_thoai = '$so_dien_thoai',
                dia_chi = '$dia_chi',
                id_quyen = '$id_quyen',
                gioi_tinh = '$gioi_tinh',
                ngay_sinh = '$ngay_sinh',
                anh_dai_dien = '$anh_dai_dien'
            WHERE id = '$id_detail'
        ";

        if (mysqli_query($conn, $query_update)) {
            echo "
                <script>
                    setTimeout(function() {
                        window.location.href = 'index_admin.php?page=edit_user&id=$id_detail';
                    }, 200);
                </script>
            ";
        } else {
            echo 'Lỗi cập nhật: ' . mysqli_error($conn);
        }
    }
}
?>
<div class="table-card">
    <form method="post" action="" enctype="multipart/form-data">
        <h3>Cập nhật người dùng</h3>
        <?php while ($u = mysqli_fetch_assoc($query_detail_result)) { ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>ID:</label>
                    <input type="text" readonly class="form-control" value="<?php echo $u['id']; ?>">
                </div>
                <div class="col-md-6">
                    <label>Họ tên:</label>
                    <input type="text" name="ho_ten" class="form-control" required value="<?php echo $u['ho_ten']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required value="<?php echo $u['email']; ?>">
                </div>
                <div class="col-md-6">
                    <label>Số điện thoại:</label>
                    <input type="text" name="so_dien_thoai" class="form-control" value="<?php echo $u['so_dien_thoai']; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label>Địa chỉ:</label>
                <input type="text" name="dia_chi" class="form-control" value="<?php echo $u['dia_chi']; ?>">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Giới tính:</label>
                    <select name="gioi_tinh" class="form-control">
                        <option value="1" <?php echo $u['gioi_tinh'] == 1 ? 'selected' : ''; ?>>Nam</option>
                        <option value="0" <?php echo $u['gioi_tinh'] == 0 ? 'selected' : ''; ?>>Nữ</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Ngày sinh:</label>
                    <input type="date" name="ngay_sinh" class="form-control" value="<?php echo $u['ngay_sinh']; ?>">
                </div>
                <div class="col-md-4">
                    <label>Quyền:</label>
                    <select name="id_quyen" class="form-control" required>
                        <?php while ($r = mysqli_fetch_assoc($query_role_result)): ?>
                            <option value="<?php echo $r['id']; ?>"
                                <?php echo $u['id_quyen'] == $r['id'] ? 'selected' : ''; ?>>
                                <?php echo $r['ten_quyen']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>


            </div>

            <div class="mb-3">
                <div class="col-md-8">
                    <label>Ảnh đại diện:</label>
                    <div class="row">
                        <div class="col">
                            <input type="file" name="anh_dai_dien" class="form-control" accept="image/*">
                        </div>
                        <div class="col">
                            <?php
                            // Đường dẫn tương đối để hiển thị ảnh
                            $avatarPath = "../user/image_user/" . $u['anh_dai_dien'];
                            if (!empty($u['anh_dai_dien'])) {
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
            <a href="index_admin.php?page=list_user" class="btn btn-secondary">Về trang danh sách</a>

        <?php } ?>
    </form>
</div>