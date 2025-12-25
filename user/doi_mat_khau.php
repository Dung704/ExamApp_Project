<?php
include_once('./header.php');
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $re  = $_POST['re_new_password'];

if ($new !== $re) {
    echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Mật khẩu mới không khớp'
            }).then(() => {
              window.location.href = 'doi_mat_khau.php';
            });
          </script>";
    exit;
}
if (strlen($new) < 6) {
    echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Mật khẩu quá ngắn',
              text: 'Mật khẩu mới phải có ít nhất 6 ký tự'
            }).then(() => {
              window.location.href = 'doi_mat_khau.php';
            });
          </script>";
    exit;
}

    // Lấy mật khẩu cũ trong DB
    $sql = "SELECT mat_khau FROM nguoi_dung WHERE id='$user_id'";
    $rs = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($rs);

   if (!password_verify($old, $row['mat_khau'])) {
    echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Sai mật khẩu',
              text: 'Mật khẩu hiện tại không đúng'
            }).then(() => {
              window.location.href = 'doi_mat_khau.php';
            });
            ;
          </script>";       

    exit;
}

    $new_hash = password_hash($new, PASSWORD_DEFAULT);

    mysqli_query($dbc,
        "UPDATE nguoi_dung 
         SET mat_khau='$new_hash' 
         WHERE id='$user_id'"
    );

    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Thành công',
          text: 'Đổi mật khẩu thành công'
        });
      </script>";
}


?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-header  text-black">
            <h5 class="mb-0">Đổi mật khẩu</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="old_password" class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" id="old_password" name="old_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="re_new_password" class="form-label">Nhập lại mật khẩu mới</label>
                    <input type="password" id="re_new_password" name="re_new_password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('./footer.php')
?>