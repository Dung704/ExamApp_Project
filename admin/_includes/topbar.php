<?php
$ho_ten = $_SESSION['ho_ten'];
$anh_dai_dien = $_SESSION['anh_dai_dien'];
?>

<button class="toggle-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<div class="dropdown user-profile">
    <a href="#"
        class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
        id="userDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false">

        <span>Xin chào <?= htmlspecialchars($ho_ten) ?></span>

        <div class="user-avatar">
            <img src="../user/image_user/<?= htmlspecialchars($anh_dai_dien) ?>" alt="">
        </div>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li>
            <a class="dropdown-item" href="../user/index.php">
                <i class="fas fa-home me-2"></i> Về trang chủ
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item text-danger"
                href="../user/logout.php"
                onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">
                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>