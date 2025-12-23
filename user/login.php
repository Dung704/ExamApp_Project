<?php

include_once("./header.php");

if (isset($_GET['tmp']) && $_GET['tmp'] == 'yeu_cau_dang_nhap') {
    echo "<div class='alert alert-warning text-center mt-3'>Vui lòng đăng nhập để tiếp tục sử dụng tính năng này !</div>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mat_khau = isset($_POST['mat_khau']) ? trim($_POST['mat_khau']) : '';

    if ($email == '' || $mat_khau == '') {
        echo "<div class='alert alert-danger text-center mt-3'>Vui lòng điền đầy đủ thông tin!</div>";
    } else {
        $query = "SELECT * FROM nguoi_dung WHERE email = '$email'";
        $result = mysqli_query($dbc, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($mat_khau, $row['mat_khau'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['ho_ten'] = $row['ho_ten'];
                $_SESSION['id_quyen'] = $row['id_quyen'];
                $_SESSION['anh_dai_dien'] = $row['anh_dai_dien'];
                $_SESSION['ngay_tao'] = $row['ngay_tao'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['gioi_tinh'] = $row['gioi_tinh'];
                $_SESSION['dia_chi'] = $row['dia_chi'];
                $_SESSION['ngay_sinh'] = $row['ngay_sinh'];
                $_SESSION['id_quyen'] = $row['id_quyen'];
                $_SESSION['so_dien_thoai'] = $row['so_dien_thoai'];
                if ($row['id_quyen'] === 'Q1') {
                    header("Location: ../admin/index_admin.php");
                } else {
                    header("Location: index.php"); 
                }
                        
                exit();
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Mật khẩu không đúng!</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Email không tồn tại!</div>";
        }
    }
}
?>

<form class="container my-5" style="max-width: 400px;" method="POST">
    <h3 class="mb-4 text-center">Đăng nhập</h3>

    <div class="mb-3">
        <label for="emailLogin" class="form-label">Email</label>
        <input type="email" class="form-control" id="emailLogin" name="email" required>
    </div>

    <div class="mb-3">
        <label for="matKhauLogin" class="form-label">Mật khẩu</label>
        <div class="input-group">
            <input type="password" class="form-control" id="matKhauLogin" name="mat_khau" required>
            <button class="btn btn-outline-secondary" type="button" id="togglePasswordLogin">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </div>

    <div class="text-center mt-3">
        <p>Chưa có tài khoản?
            <a href="./register.php" class="text-decoration-none">Đăng ký</a>
        </p>
    </div>

    <div class="text-center mt-3">
        <a href="forgot_password.php" class="text-decoration-none">Quên mật khẩu?</a>
    </div>

    <div class="text-center mt-3">
        <p>Hoặc đăng nhập bằng:</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="#" class="btn btn-outline-danger">
                <i class="bi bi-google me-1"></i> Google
            </a>
            <a href="#" class="btn btn-outline-primary">
                <i class="bi bi-facebook me-1"></i> Facebook
            </a>
        </div>
    </div>
</form>

<?php
include("./footer.php");
?>