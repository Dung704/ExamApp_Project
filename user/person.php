<?php
include("./header.php");
$ho_ten       = $_SESSION['ho_ten'] ?? 'Chưa có tên';
$email        = $_SESSION['email'] ?? 'Chưa có email';
$so_dien_thoai= $_SESSION['so_dien_thoai'] ?? 'Chưa có số điện thoại';
$anh_dai_dien = $_SESSION['anh_dai_dien'] ?? 'default.png';
$id_quyen     = $_SESSION['id_quyen'] ?? 'Q2';
$ngay_tao     = $_SESSION['ngay_tao'] ?? '---';
$ngay_sinh = $_SESSION['ngay_sinh'] ?? 'Chưa có ngày sinh';
$gioi_tinh = $_SESSION['gioi_tinh'] ?? 'Chưa có giới tính' ;
$dia_chi = $_SESSION['dia_chi'] ?? 'Chưa có địa chỉ';
?>

<div class="container my-5" style="max-width: 800px;">
    <h3 class="mb-4 text-center">Thông tin cá nhân</h3>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center">
            <img src="./image_user/<?php echo $anh_dai_dien ?>" alt="Ảnh đại diện" class="rounded-circle me-4"
                style="width: 100px; height: 100px; object-fit: cover;">
            <div>
                <h5 class="card-title fw-bold"><?= $ho_ten ?></h5>
                <p class="card-text mb-1"><i class="bi bi-envelope me-2"></i><?= $email ?></p>
                <p class="card-text mb-1"><i class="bi bi-telephone me-2"></i><?= $so_dien_thoai ?></p>
                <p class="card-text mb-1"><i class="bi bi-calendar me-2"></i><?= $ngay_sinh ?></p>
                <p class="card-text mb-1"><i class="bi bi-person me-2 "></i>
                    <?php
                    if($gioi_tinh == "0")
                        echo "Nam";
                    elseif($gioi_tinh == "1")
                        echo "Nữ";

                ?>
                </p>
                <p class="card-text mb-1"><i class="bi bi-geo-alt-fill me-2"></i><?= $dia_chi ?></p>
                <p class="card-text mb-1"><i class="bi bi-person-badge me-2">

                    </i>Quyền: <?php
                    if($id_quyen == "Q2")
                        echo "Học Viên";
                    elseif($id_quyen == "Q1")
                        echo "Admin"
                ?></p>
                <p class="card-text"><i class="bi bi-calendar me-2"></i>Ngày tạo: <?= $ngay_tao ?></p>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="./chinh_sua_thong_tin.php" class="btn btn-primary">Chỉnh sửa thông tin</a>
    </div>
</div>

<?php
include("./footer.php")

?>