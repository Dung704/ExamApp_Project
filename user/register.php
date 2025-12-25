<?php
include("./header.php");
require_once 'gui_mail.php';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mat_khau = isset($_POST['mat_khau']) ? trim($_POST['mat_khau']) : '';
    $re_mat_khau = isset($_POST['re_mat_khau']) ? trim($_POST['re_mat_khau']) : '';
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : '';
    $ngay_sinh = isset($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : NULL;
    $gioi_tinh = isset($_POST['gioi_tinh']) ? trim($_POST['gioi_tinh']) : '';
    $dia_chi = isset($_POST['dia_chi']) ? trim($_POST['dia_chi']) : '';

    $id_quyen = "Q2";
    $ngay_tao = date("Y-m-d H:i:s");

    if ($mat_khau !== $re_mat_khau) {
        echo "<div class='alert alert-danger'>Mật khẩu không khớp!</div>";
    } elseif ($ho_ten == '' || $email == '' || $mat_khau == '') {
        echo "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin bắt buộc!</div>";
    } elseif (strlen($mat_khau) < 6) {
        echo "<div class='alert alert-danger'>Mật khẩu phải có ít nhất 6 ký tự!</div>";
    } else {
        // Escape dữ liệu đầu vào
        $email_escaped = mysqli_real_escape_string($dbc, $email);
        $so_dien_thoai_escaped = mysqli_real_escape_string($dbc, $so_dien_thoai);
        
        //  KIỂM TRA EMAIL ĐÃ TỒN TẠI
        $check_email = "SELECT email FROM nguoi_dung WHERE email = '$email_escaped'";
        $result_email = mysqli_query($dbc, $check_email);

        //  KIỂM TRA SỐ ĐIỆN THOẠI ĐÃ TỒN TẠI (nếu có nhập)
        $result_phone = null;
        if (!empty($so_dien_thoai)) {
            $check_phone = "SELECT so_dien_thoai FROM nguoi_dung WHERE so_dien_thoai = '$so_dien_thoai_escaped'";
            $result_phone = mysqli_query($dbc, $check_phone);
        }

        // Kiểm tra kết quả
        if (mysqli_num_rows($result_email) > 0) {
            echo "<div class='alert alert-danger'>
                    </i> Email <strong>$email</strong> đã được đăng ký!
                  </div>";
        } elseif ($result_phone && mysqli_num_rows($result_phone) > 0) {
            echo "<div class='alert alert-danger'>
                    </i> Số điện thoại <strong>$so_dien_thoai</strong> đã được đăng ký!
                  </div>";
        } else {
            // Tạo ID mới
            $res = mysqli_query($dbc, "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM nguoi_dung");
            $row = mysqli_fetch_assoc($res);
            if ($row['max_id']) {
                $num = $row['max_id'] + 1;
            } else {
                $num = 1;
            }
            $new_id = "ND" . $num;


            // Xử lý upload ảnh
            $anh_dai_dien_sql = "NULL";
            if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] == 0) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                $file_type = $_FILES['anh_dai_dien']['type'];
                
                if (in_array($file_type, $allowed_types)) {
                    $fileName = time() . "_" . basename($_FILES['anh_dai_dien']['name']);
                    $fileTmp = $_FILES['anh_dai_dien']['tmp_name'];
                    $uploadDir = "./image_user";
                    
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    if (move_uploaded_file($fileTmp, $uploadDir . "/" . $fileName)) {
                        $anh_dai_dien_sql = "'" . mysqli_real_escape_string($dbc, $fileName) . "'";
                    }
                } else {
                    echo "<div class='alert alert-warning'>Chỉ chấp nhận file ảnh (JPG, PNG, GIF)!</div>";
                }
            }

            // Tạo token và hash mật khẩu
            $verify_token = bin2hex(random_bytes(32));
            $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);
            
            // Escape tất cả dữ liệu
            $new_id_escaped = mysqli_real_escape_string($dbc, $new_id);
            $ho_ten_escaped = mysqli_real_escape_string($dbc, $ho_ten);
            $mat_khau_hash_escaped = mysqli_real_escape_string($dbc, $mat_khau_hash);
            $id_quyen_escaped = mysqli_real_escape_string($dbc, $id_quyen);
            $gioi_tinh_escaped = mysqli_real_escape_string($dbc, $gioi_tinh);
            $dia_chi_escaped = mysqli_real_escape_string($dbc, $dia_chi);
            $ngay_tao_escaped = mysqli_real_escape_string($dbc, $ngay_tao);
            $verify_token_escaped = mysqli_real_escape_string($dbc, $verify_token);
            
            $ngay_sinh_sql = $ngay_sinh ? "'" . mysqli_real_escape_string($dbc, $ngay_sinh) . "'" : "NULL";

            // Insert vào database
            $insert = "INSERT INTO nguoi_dung 
            (id, ho_ten, email, mat_khau, so_dien_thoai, anh_dai_dien, id_quyen, ngay_sinh, gioi_tinh, dia_chi, ngay_tao, is_verified, verify_token)
            VALUES (
                '$new_id_escaped',
                '$ho_ten_escaped',
                '$email_escaped',
                '$mat_khau_hash_escaped',
                '$so_dien_thoai_escaped',
                $anh_dai_dien_sql,
                '$id_quyen_escaped',
                $ngay_sinh_sql,
                '$gioi_tinh_escaped',
                '$dia_chi_escaped',
                '$ngay_tao_escaped',
                0,
                '$verify_token_escaped'
            )";

            if (mysqli_query($dbc, $insert)) {
                require_once './gui_mail.php';
                
                // Gửi email xác thực
                $mail_sent = sendRegisterMail($email, $ho_ten, $verify_token);

                if ($mail_sent) {
                    echo "<div class='alert alert-success'>
                             <strong>Đăng ký thành công!</strong><br>
                            Vui lòng kiểm tra email <strong>$email</strong> để xác nhận tài khoản.
                          </div>";
                } else {
                    echo "<div class='alert alert-warning'>
                            <i class='bi bi-exclamation-circle'></i>  Không gửi được email xác thực.<br>
                            Vui lòng liên hệ admin để được hỗ trợ.
                          </div>";
                }
            } else {
                echo "<div class='alert alert-danger'>
                        <i class='bi bi-x-circle'></i> Lỗi đăng ký: " . mysqli_error($dbc) . "
                      </div>";
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
        <label for="ngaySinh" class="form-label">Ngày sinh</label>
        <input type="date" class="form-control" id="ngaySinh" name="ngay_sinh">
    </div>

    <div class="mb-3">
        <label for="gioiTinh" class="form-label">Giới tính</label>
        <select class="form-select" id="gioiTinh" name="gioi_tinh">
            <option value="">Chọn giới tính</option>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="diaChi" class="form-label">Địa chỉ</label>
        <textarea class="form-control" id="diaChi" name="dia_chi" rows="2"></textarea>
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
        <input type="text" class="form-control" id="soDienThoai" name="so_dien_thoai" maxlength="11" required
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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