<?php
include("./header.php");
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mat_khau = isset($_POST['mat_khau']) ? trim($_POST['mat_khau']) : '';
    $re_mat_khau = isset($_POST['re_mat_khau']) ? trim($_POST['re_mat_khau']) : '';
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : '';
    $id_quyen = "Q2"; 
    $ngay_tao = date("Y-m-d H:i:s");

    if ($mat_khau !== $re_mat_khau) {
        echo "<div class='alert alert-danger'>Mật khẩu không khớp!</div>";
    } elseif ($ho_ten == '' || $email == '' || $mat_khau == '') {
        echo "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin bắt buộc!</div>";
    } else {
        $check_email = "SELECT * FROM nguoi_dung WHERE email = '$email'";
        $result = mysqli_query($dbc, $check_email);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger'>Email đã được đăng ký!</div>";
        } else {
            $res = mysqli_query($dbc, "SELECT id FROM nguoi_dung ORDER BY id DESC LIMIT 1");
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $last_id = $row['id']; 
                $num = intval(substr($last_id, 2)) + 1;
                $new_id = "ND" . $num;
            } else {
                $new_id = "ND1";
            }

            $anh_dai_dien_sql = "NULL";
            if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] == 0) {
                $fileName = time() . "_" . basename($_FILES['anh_dai_dien']['name']);
                $fileTmp = $_FILES['anh_dai_dien']['tmp_name'];
                $uploadDir = "./image_user";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                move_uploaded_file($fileTmp, $uploadDir . "/" . $fileName);
                $anh_dai_dien_sql = "'$fileName'";
            }

            $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);

            $insert = "INSERT INTO nguoi_dung 
                (id, ho_ten, email, mat_khau, so_dien_thoai, anh_dai_dien, id_quyen, ngay_tao)
                VALUES (
                    '$new_id',
                    '$ho_ten',
                    '$email',
                    '$mat_khau_hash',
                    '$so_dien_thoai',
                    $anh_dai_dien_sql,
                    '$id_quyen',
                    '$ngay_tao'
                )";

            if (mysqli_query($dbc, $insert)) {
                echo "<div class='alert alert-success'>Đăng ký thành công! <a href='./login.php'>Đăng nhập ngay</a></div>";
            } else {
                echo "<div class='alert alert-danger'>Lỗi đăng ký: " . mysqli_error($dbc) . "</div>";
            }
        }
    }
}
?>

<form class="container my-5" style="max-width: 600px;" method="POST" enctype="multipart/form-data">
    <h3 class="mb-4 text-center">Đăng ký tài khoản</h3>

    <div class="mb-3">
        <label for="hoTen" class="form-label">Họ tên</label>
        <input type="text" class="form-control" id="hoTen" name="ho_ten" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email đăng nhập</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
        <label for="matKhau" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="matKhau" name="mat_khau" required>
    </div>

    <div class="mb-3">
        <label for="re_matKhau" class="form-label">Nhập Lại Mật khẩu</label>
        <input type="password" class="form-control" id="re_matKhau" name="re_mat_khau" required>
    </div>

    <div class="mb-3">
        <label for="soDienThoai" class="form-label">Số điện thoại</label>
        <input type="tel" class="form-control" id="soDienThoai" name="so_dien_thoai">
    </div>

    <div class="mb-3">
        <label for="anhDaiDien" class="form-label">Ảnh đại diện</label>
        <input type="file" class="form-control" id="anhDaiDien" name="anh_dai_dien" accept="image/*">
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </div>

    <div class="text-center mt-3">
        <p>Đã có tài khoản? <a href="./login.php" class="text-decoration-none">Đăng nhập</a></p>
    </div>

    <div class="text-center mt-3">
        <p>Hoặc đăng nhập bằng:</p>
        <div class="d-flex justify-content-center gap-4">
            <a href="#" class="btn btn-outline-danger"><i class="bi bi-google me-1"></i> Google</a>
            <a href="#" class="btn btn-outline-primary"><i class="bi bi-facebook me-1"></i> Facebook</a>
        </div>
    </div>
</form>

<?php
include("./footer.php");
?>