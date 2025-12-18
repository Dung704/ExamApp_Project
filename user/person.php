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

<div class="container my-5" style="max-width: 850px;">

    <h2 class="text-center fw-bold mb-4">
        <i class="bi bi-person-circle me-2"></i>Thông tin cá nhân
    </h2>

    <div class="card shadow-lg border-0">
        <div class="card-body p-4">

            <div class="d-flex flex-column flex-md-row align-items-center">

                <!-- Ảnh đại diện -->
                <div class="text-center me-md-4 mb-3 mb-md-0">
                    <img src="./image_user/<?= $anh_dai_dien ?>" class="rounded-circle shadow-sm"
                        style="width: 130px; height: 130px; object-fit: cover;" alt="Ảnh đại diện">

                    <p class="mt-3 fw-bold text-primary"><?= $ho_ten ?></p>
                </div>

                <!-- Thông tin -->
                <!-- Thông tin -->
                <div class="flex-grow-1">

                    <div class="p-3 bg-light rounded shadow-sm mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-envelope me-2"></i>Email</h6>
                        <p class="fw-semibold mb-0"><?= $email ?></p>
                    </div>

                    <div class="p-3 bg-light rounded shadow-sm mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-telephone me-2"></i>Số điện thoại</h6>
                        <p class="fw-semibold mb-0"><?= $so_dien_thoai ?></p>
                    </div>

                    <div class="p-3 bg-light rounded shadow-sm mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-calendar me-2"></i>Ngày sinh</h6>
                        <p class="fw-semibold mb-0"> <?= date("d/m/Y", strtotime($ngay_sinh)) ?> </p>
                    </div>

                    <div class="p-3 bg-light rounded shadow-sm mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-person me-2"></i>Giới tính</h6>
                        <p class="fw-semibold mb-0">
                            <?php
                if($gioi_tinh == "0") echo "Nam";
                elseif($gioi_tinh == "1") echo "Nữ";
                else echo "Chưa có";
            ?>
                        </p>
                    </div>

                    <div class="p-3 bg-light rounded shadow-sm mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-geo-alt-fill me-2"></i>Địa chỉ</h6>
                        <p class="fw-semibold mb-0"><?= $dia_chi ?></p>
                    </div>

                    <div class="p-3 bg-light rounded shadow-sm mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-person-badge me-2"></i>Quyền</h6>
                        <p class="fw-semibold mb-0"><?= $id_quyen == "Q1" ? "Admin" : "Học viên" ?></p>
                    </div>

                    <div class="p-3 bg-light rounded shadow-sm">
                        <h6 class="text-muted mb-1"><i class="bi bi-calendar-check me-2"></i>Ngày gia nhập: </h6>
                        <p class="fw-semibold mb-0"> <?= date("d/m/Y", strtotime($ngay_tao)) ?> </p>
                    </div>

                </div>


            </div>

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="./chinh_sua_thong_tin.php" class="btn btn-primary btn-lg px-4 fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa thông tin
        </a>
    </div>

</div>


<?php
include("./footer.php")

?>