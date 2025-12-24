<?php
// --- Tạo mã ID tự động (ND001, ND002, ...) ---
$query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM nguoi_dung";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);

$new_id = 'ND' . ($row_max['max_id'] + 1);

// Xử lý submit form
if (isset($_POST['submit'])) {
    $ho_ten       = trim($_POST['ho_ten']);
    $email        = trim($_POST['email']);
    $mat_khau     = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $id_quyen     = $_POST['id_quyen'];
    $ngay_sinh    = $_POST['ngay_sinh'];
    $gioi_tinh    = $_POST['gioi_tinh'];
    $dia_chi      = trim($_POST['dia_chi']);
    // Xử lý upload hình ảnh
    $hinh_anh = '';
    if (isset($_FILES['Hinh_anh']) && $_FILES['Hinh_anh']['error'] == 0) {
        $hinh_anh = time() . '_' . $_FILES['Hinh_anh']['name'];
        move_uploaded_file($_FILES['Hinh_anh']['tmp_name'], '../user/image_user/' . $hinh_anh);
    }
    // Kiểm tra trùng email hoặc số điện thoại
    $query_duplicate = "
        SELECT id FROM nguoi_dung 
        WHERE email = '$email' OR so_dien_thoai = '$so_dien_thoai'
    ";
    $res_dup = mysqli_query($conn, $query_duplicate);

    if (mysqli_num_rows($res_dup) > 0) {
        echo '<div class="alert alert-danger">Email hoặc số điện thoại đã tồn tại!</div>';
    } else {

        $insert = "
            INSERT INTO nguoi_dung 
            (id, ho_ten, email, mat_khau, so_dien_thoai, anh_dai_dien, id_quyen, ngay_sinh, gioi_tinh, dia_chi) 
            VALUES 
            ('$new_id', '$ho_ten', '$email', '$mat_khau', '$so_dien_thoai', '$hinh_anh', '$id_quyen', '$ngay_sinh', '$gioi_tinh', '$dia_chi')
        ";

        if (mysqli_query($conn, $insert)) {
            echo '<div class="alert alert-success">Thêm người dùng thành công! Mã: ' . $new_id . '</div>';
        } else {
            echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>
<div class="table-card">
    <h3>Thêm Người dùng mới</h3>

    <form method="post" class="mt-3" enctype="multipart/form-data">

        <div class="row mb-3">

            <div class="col-md-6">
                <label>Mã người dùng:</label>
                <input type="text" class="form-control" value="<?php echo $new_id; ?>" disabled>
            </div>

            <div class="col-md-6">
                <label>Họ tên:</label>
                <input type="text" name="ho_ten" class="form-control"
                    value="<?php echo $_POST['ho_ten'] ?? ''; ?>" required>
            </div>

            <div class="col-md-6">
                <label>Email:</label>
                <input type="email" name="email" class="form-control"
                    value="<?php echo $_POST['email'] ?? ''; ?>" required>
            </div>

            <div class="col-md-6">
                <label>Mật khẩu:</label>
                <input type="password" name="mat_khau" class="form-control"
                    value="<?php echo $_POST['mat_khau'] ?? ''; ?>" required>
            </div>

            <div class="col-md-6">
                <label>Số điện thoại:</label>
                <input type="text" name="so_dien_thoai" class="form-control"
                    value="<?php echo $_POST['so_dien_thoai'] ?? ''; ?>">
            </div>

            <div class="col-md-6">
                <label>Quyền:</label>
                <select name="id_quyen" class="form-control" required>
                    <option value="">-- Chọn quyền --</option>
                    <option value="Q1" <?php echo (($_POST['id_quyen'] ?? '') == 'Q1') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Q2" <?php echo (($_POST['id_quyen'] ?? '') == 'Q2') ? 'selected' : ''; ?>>User</option>
                </select>
            </div>

            <div class="col-md-6">
                <label>Ngày sinh:</label>
                <input type="date" name="ngay_sinh" class="form-control"
                    min="1900-01-01"
                    max="<?php echo date('Y-m-d'); ?>"
                    value="<?php echo $_POST['ngay_sinh'] ?? ''; ?>">
            </div>

            <div class="col-md-6">
                <label>Giới tính:</label>
                <select name="gioi_tinh" class="form-control">
                    <option value="">-- Chọn --</option>
                    <option value="1" <?php echo (($_POST['gioi_tinh'] ?? '') == '1') ? 'selected' : ''; ?>>Nam</option>
                    <option value="0" <?php echo (($_POST['gioi_tinh'] ?? '') == '0') ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>

            <div class="col-md-12">
                <label>Địa chỉ:</label>
                <input type="text" name="dia_chi" class="form-control"
                    value="<?php echo $_POST['dia_chi'] ?? ''; ?>" required>
            </div>

            <div class="col-md-4">
                <label>Hình ảnh:</label>
                <input type="file" name="Hinh_anh" id="Hinh_anh" class="form-control" accept="image/*" required>

                <!-- Khung preview -->
                <img id="preview_img" src="#"
                    style="display:none; width:100%; min-height:50%; object-fit:cover; border-radius:8px; margin-top:10px;">

                <?php if (isset($hinh_anh) && $hinh_anh != ''): ?>
                    <small class="text-success">File đã tải lên: <?php echo $hinh_anh; ?></small>
                <?php endif; ?>
            </div>

        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm Người dùng</button>
        <a href="index_admin.php?page=list_user" class="btn btn-secondary">Về danh sách</a>
    </form>
</div>

<script>
    document.querySelector('input[name="ngay_sinh"]').addEventListener('input', function() {
        let max = this.max;
        if (this.value > max) {
            this.value = max;
        }
    });
</script>

<script>
    document.getElementById('Hinh_anh').addEventListener('change', function(event) {
        const preview = document.getElementById('preview_img');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    });
</script>