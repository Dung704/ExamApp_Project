<?php
include("./header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if ($email == '') {
        echo "<div class='alert alert-danger text-center mt-3'>Vui lòng nhập email!</div>";
    } else {
        $email_escaped = mysqli_real_escape_string($dbc, $email);
        $query = "SELECT id, ho_ten, email FROM nguoi_dung WHERE email = '$email_escaped'";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Tạo reset token
            $reset_token = bin2hex(random_bytes(32));
            $reset_token_escaped = mysqli_real_escape_string($dbc, $reset_token);
            
    
            $update = "UPDATE nguoi_dung 
                      SET reset_token = '$reset_token_escaped'
                      WHERE email = '$email_escaped'";
            
            if (mysqli_query($dbc, $update)) {
                require_once './gui_mail.php';
                
                // Gửi email reset mật khẩu
                $mail_sent = sendResetPasswordMail($user['email'], $user['ho_ten'], $reset_token);
                
                if ($mail_sent) {
                    echo "<div class='alert alert-success text-center mt-3'>
                            Đã gửi link đặt lại mật khẩu đến email của bạn!<br>
                            Vui lòng kiểm tra hộp thư (bao gồm cả thư rác).
                          </div>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>
                            Có lỗi khi gửi email. Vui lòng thử lại sau.
                          </div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Lỗi: " . mysqli_error($dbc) . "</div>";
            }
        } else {
            // Vẫn hiển thị thông báo thành công để tránh lộ thông tin
            echo "<div class='alert alert-success text-center mt-3'>
                    Nếu email tồn tại trong hệ thống, bạn sẽ nhận được link đặt lại mật khẩu.
                  </div>";
        }
    }
}
?>

<form class="container my-5" style="max-width: 500px;" method="POST">
    <h3 class="mb-4 text-center">Quên mật khẩu</h3>

    <div class="alert alert-info">
        Nhập email đã đăng ký, chúng tôi sẽ gửi link đặt lại mật khẩu cho bạn.
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email đã đăng ký</label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="example@email.com">
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">
            Gửi link đặt lại mật khẩu
        </button>
    </div>

    <div class="text-center mt-3">
        <p>Đã nhớ mật khẩu? <a href="./login.php" class="text-decoration-none">Đăng nhập</a></p>
    </div>
</form>

<?php
include("./footer.php");
?>