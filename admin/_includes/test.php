
<?php // Mã hóa mật khẩu
$password = "1";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // PASSWORD_DEFAULT thường dùng bcrypt
echo $hashedPassword;
// Lưu $hashedPassword vào database 
?>
