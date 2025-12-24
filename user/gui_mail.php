<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer/src/SMTP.php';

function sendRegisterMail($toEmail, $toName, $verify_token) {
    
    // Tạo link xác thực
    $verify_link = "http://localhost/ExamApp_Project/user/verify.php?token=" . urlencode($verify_token);
    
    // Tạo instance PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'truong.pn.64cntt@ntu.edu.vn';
        $mail->Password = 'bipojklszflinghb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Người gửi và người nhận
        $mail->setFrom('truong.pn.64cntt@ntu.edu.vn', 'He Thong Thi Trac Nghiem DDT');
        $mail->addAddress($toEmail, $toName);

        // Nội dung email
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Xác nhận đăng ký tài khoản";
        $mail->Body = "
        Xin chào <strong>$toName</strong>,<br><br>
        Cảm ơn bạn đã đăng ký tài khoản tại Hệ Thống Thi Trắc Nghiệm DDT.<br><br>
        Vui lòng bấm vào link sau để xác nhận email của bạn:<br>
        <a href='$verify_link' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Xác nhận email</a><br><br>
        <em>Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email này.</em><br><br>
        Trân trọng,<br>
        <strong>Hệ Thống Thi Trắc Nghiệm DDT</strong>
        ";
        
        $mail->send();
        return true; // Gửi thành công
        
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo}");
        return false; // Gửi thất bại
    }
}

function sendResetPasswordMail($toEmail, $toName, $reset_token) {
    
    if (empty($toEmail) || empty($toName) || empty($reset_token)) {
        error_log("ERROR: Missing parameters for reset password email");
        return false;
    }
    
    $reset_link = "http://localhost/ExamApp_Project/user/reset_password.php?token=" . urlencode($reset_token);
    
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'truong.pn.64cntt@ntu.edu.vn';
        $mail->Password = 'bipojklszflinghb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Người gửi và người nhận
        $mail->setFrom('truong.pn.64cntt@ntu.edu.vn', 'He Thong Thi Trac Nghiem DDT');
        $mail->addAddress($toEmail, $toName);

        // Nội dung email
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Đặt lại mật khẩu tài khoản";
        $mail->Body = "
        Xin chào <strong>$toName</strong>,<br><br>
        Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.<br><br>
        Vui lòng bấm vào nút bên dưới để đặt lại mật khẩu:<br><br>
        <a href='$reset_link' style='display: inline-block; padding: 12px 30px;  color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>Đặt lại mật khẩu</a><br><br>
        <em>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này và mật khẩu của bạn sẽ không bị thay đổi.</em><br><br>
        Trân trọng,<br>
        <strong>Hệ Thống Thi Trắc Nghiệm DDT</strong>
        ";
        
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("PHPMailer Error (Reset Password): {$mail->ErrorInfo}");
        return false;
    }
}
?>