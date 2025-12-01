<?php
session_start();

// Xóa tất cả session
session_unset();

// Hủy session
session_destroy();

// Xóa cookie session (nếu có)
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Chuyển về trang đăng nhập
header("Location: _login.php");
exit();
