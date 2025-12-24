<?php
include("./header.php");

// Lấy ID người dùng từ GET
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger text-center mt-3'>Không tìm thấy người dùng</div>";
    exit();
}

$user_id = ($_GET['id']);

// Lấy thông tin người dùng
$sql = "SELECT * FROM nguoi_dung WHERE id = '$user_id'";
$result = mysqli_query($dbc, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-danger text-center mt-3'>Người dùng không tồn tại</div>";
    exit();
}

$u = mysqli_fetch_assoc($result);

// Kiểm tra chính chủ
$chu_tai_khoan = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id;

// Gán dữ liệu
$ho_ten       = $u['ho_ten'];
$anh_dai_dien = $u['anh_dai_dien'] ?: 'default.png';
$id_quyen     = $u['id_quyen'];
$gioi_tinh    = $u['gioi_tinh'];
$ngay_tao     = $u['ngay_tao'];
$ngay_sinh    = $u['ngay_sinh'];

// Ẩn thông tin riêng tư nếu không phải chính chủ
$email        = $chu_tai_khoan ? $u['email'] : "Không công khai";
$so_dien_thoai= $chu_tai_khoan ? $u['so_dien_thoai'] : "Không công khai";
$dia_chi      = $chu_tai_khoan ? $u['dia_chi'] : "Không công khai";

// Format ngày
$ngay_sinh_fmt = $ngay_sinh ? date("d/m/Y", strtotime($ngay_sinh)) : "Không công khai";
$ngay_tao_fmt  = $ngay_tao  ? date("d/m/Y", strtotime($ngay_tao))  : "---";

// Tab
$tab = $_GET['tab'] ?? 'info';

// Truy vấn câu hỏi đóng gớp

$sql_count = "
    SELECT COUNT(*) AS total
    FROM cau_hoi_nguoi_dung
    WHERE id_nguoi_hoi = '$user_id'
";
$rs_count = mysqli_query($dbc, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);
$total_records = $row_count['total'];

// ====== PHÂN TRANG ======
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;
$total_pages = ceil($total_records / $limit);

// ====== LẤY DANH SÁCH ======
$sql_q = "
    SELECT *
    FROM cau_hoi_nguoi_dung
    WHERE id_nguoi_hoi = '$user_id'
    ORDER BY id DESC
    LIMIT $limit OFFSET $offset
";
$rs_q = mysqli_query($dbc, $sql_q);



?>





<div class="container my-5" style="max-width: 900px;">

    <!-- Avatar + Tên -->
    <div class="text-center mb-4">
        <img src="./image_user/<?= $anh_dai_dien ?>" class="rounded-circle shadow"
            style="width: 160px; height: 160px; object-fit: cover; border: 4px solid white;">

        <h2 class="fw-bold mt-3"><?= $ho_ten ?></h2>

        <?php if ($chu_tai_khoan): ?>
        <a href="./chinh_sua_thong_tin.php" class="btn btn-primary btn-sm mt-2">
            <i class="bi bi-pencil-square me-1"></i>Chỉnh sửa trang cá nhân
        </a>
        <?php endif; ?>
    </div>

    <!-- Menu kiểu Facebook -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-center gap-4">

            <a href="?id=<?= $user_id ?>&tab=info"
                class="text-decoration-none fw-semibold <?= $tab=='info'?'text-primary':'text-dark' ?>">
                Giới thiệu
            </a>



            <a href="?id=<?= $user_id ?>&tab=questions"
                class="text-decoration-none fw-semibold <?= $tab=='questions'?'text-primary':'text-dark' ?>">
                Đóng góp (<?= $total_records ?>)

            </a>

        </div>
    </div>

    <!-- Nội dung từng tab -->
    <?php if ($tab == 'info'): ?>

    <!-- GIỚI THIỆU -->
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Giới thiệu</div>
        <div class="card-body">

            <p><i class="bi bi-envelope me-2 text-primary"></i><strong>Email:</strong> <?= $email ?></p>
            <p><i class="bi bi-telephone me-2 text-primary"></i><strong>Số điện thoại:</strong> <?= $so_dien_thoai ?>
            </p>
            <p><i class="bi bi-calendar me-2 text-primary"></i><strong>Ngày sinh:</strong> <?= $ngay_sinh_fmt ?></p>

            <p><i class="bi bi-person me-2 text-primary"></i><strong>Giới tính:</strong>
                <?php
                        if($gioi_tinh == "0") echo "Nam";
                        elseif($gioi_tinh == "1") echo "Nữ";
                        else echo "Không công khai";
                    ?>
            </p>

            <p><i class="bi bi-geo-alt-fill me-2 text-primary"></i><strong>Địa chỉ:</strong> <?= $dia_chi ?></p>
            <p><i class="bi bi-person-badge me-2 text-primary"></i><strong>Quyền:</strong>
                <?= $id_quyen == "Q1" ? "Admin" : "Học viên" ?></p>
            <p><i class="bi bi-calendar-check me-2 text-primary"></i><strong>Ngày tham gia:</strong>
                <?= $ngay_tao_fmt ?></p>

        </div>
    </div>

    <?php elseif ($tab == 'exam'): ?>



    <?php elseif ($tab == 'questions'): ?>



    <div class="card shadow-sm">


        <div class="card-body">

            <?php if (mysqli_num_rows($rs_q) == 0): ?>
            <p class="text-muted">Người này chưa đăng câu hỏi nào.</p>
            <?php else: ?>
            <?php while ($q = mysqli_fetch_assoc($rs_q)): ?>
            <?php
                $anh_cau_hoi = !empty($q['anh_dinh_kem'])
                    ? "./image_cauhoi/" . $q['anh_dinh_kem']
                    : null;
                ?>
            <a href="chi_tiet_cau_hoi_nguoi_dung.php?id=<?= $q['id'] ?>" class="text-decoration-none text-dark">
                <div class="mb-3 p-3 border rounded hover-shadow">
                    <?php if ($anh_cau_hoi): ?>
                    <img src="<?= $anh_cau_hoi ?>" style="max-width:50px; border-radius:6px;">
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($q['noi_dung']) ?></strong><br>
                    <span class="text-muted">
                        Ngày đăng: <?= date("d/m/Y", strtotime($q['thoi_gian_tao'])) ?>
                    </span>
                </div>
            </a>
            <?php endwhile; ?>
            <?php endif; ?>

            <!-- PHÂN TRANG -->
            <?php if ($total_pages > 1): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">«</a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">»</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>

        </div>
    </div>



    <?php endif; ?>

</div>

<?php include("./footer.php"); ?>