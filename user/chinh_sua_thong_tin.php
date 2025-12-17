<?php
include("./header.php");

$ho_ten       = $_SESSION['ho_ten'] ?? '';
$so_dien_thoai= $_SESSION['so_dien_thoai'] ?? '';
$anh_dai_dien = $_SESSION['anh_dai_dien'] ?? 'default.png';
$user_id      = $_SESSION['user_id'] ?? '';
$ngay_sinh    = $_SESSION['ngay_sinh'] ?? '';
$gioi_tinh    = $_SESSION['gioi_tinh'] ?? '';
$dia_chi      = $_SESSION['dia_chi'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ho_ten_new        = trim($_POST['ho_ten']);
    $so_dien_thoai_new = trim($_POST['so_dien_thoai']);
    $ngay_sinh_new     = trim($_POST['ngay_sinh']);
    $gioi_tinh_new     = $_POST['gioi_tinh'] ?? '';
    $dia_chi_new       = trim($_POST['dia_chi']);

    $anh_dai_dien_sql = $anh_dai_dien;

    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] == 0) {
        $fileName = time() . "_" . basename($_FILES['anh_dai_dien']['name']);
        $fileTmp = $_FILES['anh_dai_dien']['tmp_name'];
        $uploadDir = "./image_user/";

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if ($anh_dai_dien != 'default.png' && file_exists($uploadDir . $anh_dai_dien)) {
            unlink($uploadDir . $anh_dai_dien);
        }

        move_uploaded_file($fileTmp, $uploadDir . $fileName);
        $anh_dai_dien_sql = $fileName;
    }

    $update = "UPDATE nguoi_dung 
               SET ho_ten='$ho_ten_new',
                   so_dien_thoai='$so_dien_thoai_new',
                   ngay_sinh='$ngay_sinh_new',
                   gioi_tinh='$gioi_tinh_new',
                   dia_chi='$dia_chi_new',
                   anh_dai_dien='$anh_dai_dien_sql'
               WHERE id='$user_id'";

    if (mysqli_query($dbc, $update)) {

        $_SESSION['ho_ten']        = $ho_ten_new;
        $_SESSION['so_dien_thoai'] = $so_dien_thoai_new;
        $_SESSION['ngay_sinh']     = $ngay_sinh_new;
        $_SESSION['gioi_tinh']     = $gioi_tinh_new;
        $_SESSION['dia_chi']       = $dia_chi_new;
        $_SESSION['anh_dai_dien']  = $anh_dai_dien_sql;

        header("Location: person.php");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Lỗi cập nhật: ".mysqli_error($dbc)."</div>";
    }
}
?>


<div class="container my-5" style="max-width: 600px;">
    <h3 class="mb-4 text-center">Chỉnh sửa thông tin cá nhân</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3 text-center">
            <img src="./image_user/<?php echo $anh_dai_dien ?>" alt="Ảnh đại diện" class="rounded-circle mb-3"
                style="width: 100px; height: 100px; object-fit: cover;">
            <input type="file" class="form-control" name="anh_dai_dien" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="ho_ten" value="<?= htmlspecialchars($ho_ten) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" name="so_dien_thoai" value="<?= htmlspecialchars($so_dien_thoai) ?>">
        </div>


        <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="ngay_sinh" value="<?= htmlspecialchars($ngay_sinh) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gioi_tinh" class="form-select">
                <option value="">Chọn giới tính</option>
                <option value="0" <?= $gioi_tinh == "0" ? "selected" : "" ?>>Nam</option>
                <option value="1" <?= $gioi_tinh == "1" ? "selected" : "" ?>>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="dia_chi" value="<?= htmlspecialchars($dia_chi) ?>">
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="person.php" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
include("./footer.php");
?>