<?php
session_start();
include("../app/config/config.php");
date_default_timezone_set('Asia/Ho_Chi_Minh');


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>DDT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="./CSS/style_user.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <img src="../app/image/hinh-gau-truc-chibi-cute_082047594.jpg" alt="Gấu trúc cute" style="width: 50px;">
        <a class="navbar-brand fw-bold" href="./index.php">DDT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-bold">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="./index.php">Trang
                        chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'de_thi.php') ? 'active' : '' ?>" href="./de_thi.php">Đề
                        Thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'bai_hoc.php') ? 'active' : '' ?>" href="./bai_hoc.php">Bài
                        Học</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'gioi_thieu.php') ? 'active' : '' ?>"
                        href="./gioi_thieu.php">Giới
                        Thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'cong_dong.php') ? 'active' : '' ?>"
                        href="./cong_dong.php">Cộng
                        đồng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'lich_su_lam_bai.php') ? 'active' : '' ?>"
                        href="./lich_su_lam_bai.php">Lịch Sử Làm Bài</a>
                </li>
                <?php if (isset($_SESSION['id_quyen']) && $_SESSION['id_quyen'] == 'Q1'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/index_admin.php">Trang quản lý</a>
                </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle ms-2 me-2"
                        id="userDropdown" data-bs-toggle="dropdown">
                        <?php $anh_avatar =  $_SESSION['anh_dai_dien'] ?? 'default.png'; ?>
                        <img src="./image_user/<?php echo $anh_avatar ?>" alt="Ảnh đại diện" class="rounded-circle me-2"
                            style="width: 40px; height: 40px; object-fit: cover;">
                        <span><?php echo $_SESSION['ho_ten']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="./person.php">Trang cá nhân</a></li>
                        <li><a class="dropdown-item" href="./logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
                <?php else: ?>
                <a href="./login.php"><button class="btn btn-outline-primary me-2">Đăng nhập</button></a>
                <a href="./register.php"><button class="btn btn-primary">Đăng ký</button></a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>