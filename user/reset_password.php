<?php
include("./header.php");

// Kiểm tra token
if (!isset($_GET['token']) || empty($_GET['token'])) {
    echo "<div class='alert alert-danger text-center mt-5'>Token không hợp lệ.</div>";
    include("./footer.php");
    exit();
}

$token = mysqli_real_escape_string($dbc, $_GET['token']);

// ✅ BỎ kiểm tra thời gian, chỉ kiểm tra token có tồn tại không
$check_query = "SELECT id, ho_ten, email FROM nguoi_dung 
                WHERE reset_token = '$token'
                AND reset_token IS NOT NULL";
$check_result = mysqli_query($dbc, $check_query);

if (mysqli_num_rows($check_result) != 1) {
    echo "<div class='alert alert-danger text-center mt-5'>
            <h4>⚠️ Link không hợp lệ hoặc đã được sử dụng</h4>
            <p>Mỗi link đặt lại mật khẩu chỉ có thể sử dụng một lần.</p>
            <a href='forgot_password.php' class='btn btn-primary mt-3'>Gửi lại link</a>
          </div>";
    include("./footer.php");
    exit();
}

$user = mysqli_fetch_assoc($check_result);

// Xử lý form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mat_khau_moi = isset($_POST['mat_khau_moi']) ? trim($_POST['mat_khau_moi']) : '';
    $xac_nhan_mat_khau = isset($_POST['xac_nhan_mat_khau']) ? trim($_POST['xac_nhan_mat_khau']) : '';

    if ($mat_khau_moi == '' || $xac_nhan_mat_khau == '') {
        echo "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin!</div>";
    } elseif ($mat_khau_moi !== $xac_nhan_mat_khau) {
        echo "<div class='alert alert-danger'>Mật khẩu xác nhận không khớp!</div>";
    } elseif (strlen($mat_khau_moi) < 6) {
        echo "<div class='alert alert-danger'>Mật khẩu phải có ít nhất 6 ký tự!</div>";
    } else {
        $mat_khau_hash = password_hash($mat_khau_moi, PASSWORD_DEFAULT);
        $mat_khau_hash_escaped = mysqli_real_escape_string($dbc, $mat_khau_hash);
        
        // ✅ Cập nhật mật khẩu và XÓA token ngay (token chỉ dùng 1 lần)
        $update_query = "UPDATE nguoi_dung 
                        SET mat_khau = '$mat_khau_hash_escaped',
                            reset_token = NULL
                        WHERE reset_token = '$token'";
        
        if (mysqli_query($dbc, $update_query)) {
            echo "<div class='alert alert-success text-center mt-5'>
                    <h4>✅ Đặt lại mật khẩu thành công!</h4>
                    <p>Bạn có thể đăng nhập bằng mật khẩu mới.</p>
                    <a href='login.php' class='btn btn-primary mt-3'>Đăng nhập ngay</a>
                  </div>";
            include("./footer.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Có lỗi xảy ra: " . mysqli_error($dbc) . "</div>";
        }
    }
}
?>

<form class="container my-5" style="max-width: 500px;" method="POST">
    <h3 class="mb-4 text-center">Đặt lại mật khẩu</h3>

    <div class="alert alert-info">
        <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
    </div>

    <div class="mb-3">
        <label for="mat_khau_moi" class="form-label">Mật khẩu mới</label>
        <input type="password" class="form-control" id="mat_khau_moi" name="mat_khau_moi" required minlength="6"
            placeholder="Tối thiểu 6 ký tự">
    </div>

    <div class="mb-3">
        <label for="xac_nhan_mat_khau" class="form-label">Xác nhận mật khẩu mới</label>
        <input type="password" class="form-control" id="xac_nhan_mat_khau" name="xac_nhan_mat_khau" required
            minlength="6">
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-key"></i> Đặt lại mật khẩu
        </button>
    </div>

    <div class="text-center mt-3">
        <a href="./login.php" class="text-decoration-none">Quay lại đăng nhập</a>
    </div>
</form>

<?php
include("./footer.php");
?>