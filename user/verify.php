<?php
include './header.php';

if (!isset($_GET['token'])) {
    die("Token không hợp lệ.");
}

$token = mysqli_real_escape_string($dbc, $_GET['token']);

$sql = "SELECT id FROM nguoi_dung
        WHERE verify_token = '$token'
        AND is_verified = 0";

$result = mysqli_query($dbc, $sql);

if (mysqli_num_rows($result) == 1) {

    mysqli_query($dbc, "
        UPDATE nguoi_dung
        SET is_verified = 1,
            verify_token = NULL
        WHERE verify_token = '$token'
    ");

    echo "<div class='alert alert-success'>
            Xác nhận email thành công! Bạn có thể đăng nhập.
          </div>";
} else {
    echo "<div class='alert alert-danger'>
            Link không hợp lệ hoặc đã được xác nhận.
          </div>";
}