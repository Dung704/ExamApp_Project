<?php
include("./header.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?tmp=yeu_cau_dang_nhap");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['noi_dung'])) {

    $id_user = $_SESSION['user_id'];
    $noi_dung = $_POST['noi_dung'];

    // Tạo mã tự động: CHND_YYYYMMDD_random10
    $unique = substr(md5(uniqid(mt_rand(), true)), 0, 10);
    $id_cau_hoi = "CHND_" . date("Ymd") . "_" . $unique;

    $ten_file_anh = "";

    if (isset($_FILES['anh_dinh_kem']) && $_FILES['anh_dinh_kem']['error'] === 0) {

        $ext = pathinfo($_FILES['anh_dinh_kem']['name'], PATHINFO_EXTENSION);
        $ten_file_anh = $id_cau_hoi . "." . $ext;

        move_uploaded_file($_FILES['anh_dinh_kem']['tmp_name'], "./image_cauhoi/" . $ten_file_anh);
    }

    $sql_insert = "
        INSERT INTO cau_hoi_nguoi_dung (id, noi_dung, id_nguoi_hoi, anh_dinh_kem, thoi_gian_tao)
        VALUES ('$id_cau_hoi', '$noi_dung', '$id_user', '$ten_file_anh', NOW())
    ";

    $rs_insert = mysqli_query($dbc, $sql_insert);

    if ($rs_insert) {
        echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Thành Công',
              text: 'Câu hỏi của bạn đã được đăng tải lên hệ thống'
            }).then(() => {
              window.location.href = 'cong_dong.php';
            });
          </script>";
        exit();
    } else {
        echo "<script>alert('Lỗi khi đăng câu hỏi');window.location='cong_dong.php'</script>";
        exit();
    }
}

?>

<div class="container mt-4">
    <!-- Ô tìm kiếm -->
    <form method="GET">
        <div class="d-flex justify-content-center my-5">
            <div class="input-group search-box" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control" placeholder="Nhập nội dung"
                    value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <button class="input-group-text bg-black text-white border-start-0" type="submit">
                    <i class="bi bi-search me-2"></i>
                </button>
            </div>
        </div>
    </form>



    <div class="row">

        <!-- CỘNG ĐỒNG HỎI ĐÁP -->
        <div class="col-lg-8 mb-4">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Cộng Đồng Hỏi Đáp</h4>
                </div>

                <div class="card-body">

                    <!-- Form đặt câu hỏi -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Đặt câu hỏi của bạn</label>
                            <textarea name="noi_dung" class="form-control" rows="3"
                                placeholder="Nhập câu hỏi..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ảnh đính kèm </label>
                            <input type="file" name="anh_dinh_kem" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Đăng câu hỏi</button>
                    </form>


                </div>
            </div>

            <?php
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($dbc, $_GET['keyword']) : '';

// Phân trang
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Đếm tổng số câu hỏi để phân trang
$sql_count = "
    SELECT COUNT(*) AS total
    FROM cau_hoi_nguoi_dung AS ch
    JOIN nguoi_dung AS nd ON ch.id_nguoi_hoi = nd.id
    WHERE ch.noi_dung LIKE '%$keyword%'
";
$rs_count = mysqli_query($dbc, $sql_count);
$total = mysqli_fetch_assoc($rs_count)['total'];
$total_pages = ceil($total / $limit);

// Lấy danh sách câu hỏi
$sql_q = "
    SELECT ch.id, ch.noi_dung, ch.thoi_gian_tao, ch.anh_dinh_kem,
           nd.ho_ten, nd.anh_dai_dien
    FROM cau_hoi_nguoi_dung AS ch
    JOIN nguoi_dung AS nd ON ch.id_nguoi_hoi = nd.id
    WHERE ch.noi_dung LIKE '%$keyword%'
    ORDER BY ch.thoi_gian_tao DESC
    LIMIT $start, $limit
";

$rs_q = mysqli_query($dbc, $sql_q);
?>


            <!-- DANH SÁCH CÂU HỎI -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="m-0">Câu hỏi mới nhất</h5>
                </div>

                <ul class="list-group list-group-flush">

                    <?php 
                        $anh_mac_dinh = "./image_user/icons8-user-default-64.png";
                        $anh_mac_dinh1 = "./image_cauhoi/No-Image-Found-400x264.png";

                        while ($q = mysqli_fetch_assoc($rs_q)):

                            $avatar = (!empty($q['anh_dai_dien']))
                                        ? "./image_user/" . $q['anh_dai_dien']
                                        : $anh_mac_dinh;
                            // Ảnh đính kèm câu hỏi
                            $anh_cau_hoi = (!empty($q['anh_dinh_kem']))
                                            ? "./image_cauhoi/" . $q['anh_dinh_kem']
                                            : null;
                    ?>

                    <li class="list-group-item">

                        <div class="d-flex align-items-start">

                            <!-- Avatar -->
                            <img src="<?= $avatar ?>" class="rounded-circle me-3"
                                style="width: 40px; height: 40px; object-fit: cover;">

                            <div>
                                <!-- Nội dung câu hỏi -->
                                <a href="chi_tiet_cau_hoi_nguoi_dung.php?id=<?= $q['id'] ?>" class="fw-bold text-dark">
                                    <?= $q['noi_dung'] ?>
                                </a>
                                <!-- Ảnh đính kèm -->
                                <?php if ($anh_cau_hoi): ?>
                                <div class="mt-2">
                                    <img src="<?= $anh_cau_hoi ?>" style="max-width: 200px; border-radius: 6px;"
                                        alt="Ảnh câu hỏi">
                                </div>
                                <?php endif; ?>

                                <!-- Tên người hỏi + thời gian -->
                                <div class="text-muted small mt-1">
                                    <?= $q['ho_ten'] ?> • <?= $q['thoi_gian_tao'] ?>
                                </div>
                            </div>

                        </div>

                    </li>

                    <?php endwhile; ?>

                </ul>
                <nav class="mt-3">
                    <ul class="pagination justify-content-center">

                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&keyword=<?= $keyword ?>"><i
                                    class="bi bi-chevron-left"></i></a>
                        </li>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&keyword=<?= $keyword ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&keyword=<?= $keyword ?>"><i
                                    class="bi bi-chevron-right"></i></a>
                        </li>

                    </ul>
                </nav>


            </div>

        </div>
        <?php
    // Lấy danh sách xếp hạng theo số đề đã làm (mỗi đề chỉ tính 1 lần)
    $sql_rank = "
    SELECT 
        nd.id,
        nd.ho_ten,
        nd.anh_dai_dien,
        COALESCE(COUNT(kq_max.id_de_thi), 0) AS so_de_da_lam,
        COALESCE(SUM(kq_max.diem_cao_nhat), 0) AS tong_diem
    FROM nguoi_dung nd
    LEFT JOIN (
        SELECT 
            id_nguoi_dung,
            id_de_thi,
            MAX(diem_so) AS diem_cao_nhat
        FROM ket_qua_thi
        GROUP BY id_nguoi_dung, id_de_thi
    ) AS kq_max
    ON nd.id = kq_max.id_nguoi_dung
    GROUP BY nd.id, nd.ho_ten, nd.anh_dai_dien
    ORDER BY tong_diem DESC, so_de_da_lam DESC
    LIMIT 10
";


    $anh_mac_dinh = "./image_user/icons8-user-default-64.png";

    $result_rank = mysqli_query($dbc, $sql_rank);
?>


        <!-- BẢNG XẾP HẠNG -->
        <div class="col-lg-4 mb-4">


            <h4 class="mb-3">Bảng Xếp Hạng</h4>

            <div class="card shadow-sm">
                <div class="card-body p-0">

                    <table class="table table-hover text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Top</th>
                                <th>Tên</th>
                                <th>Số đề</th>
                                <th>Điểm</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php 
                            $stt = 1;
                            while ($row = mysqli_fetch_assoc($result_rank)): 
                                $avatar = (!empty($row['anh_dai_dien'])) 
                                            ? "./image_user/" . $row['anh_dai_dien'] 
                                            : $anh_mac_dinh;

                                $mau = ($stt == 1) ? "table-warning" : (($stt == 2) ? "table-secondary" : (($stt == 3) ? "table-info" : ""));
                            ?>

                            <tr class="<?= $mau ?>">
                                <td class="fw-bold"><?= $stt ?></td>
                                <td> <a href="trang_ca_nhan_nguoi_dung.php?id=<?= $row['id'] ?>"
                                        class="text-decoration-none text-dark">
                                        <img src="<?= $avatar ?>" class="rounded-circle me-2"
                                            style="width: 35px; height: 35px; object-fit: cover;"> <?= $row['ho_ten'] ?>
                                    </a> </td>
                                <td><?= $row['so_de_da_lam'] ?></td>
                                <td><?= $row['tong_diem'] ?> </td>

                            </tr>

                            <?php 
                            $stt++;
                            endwhile; 
                            ?>

                        </tbody>
                    </table>
                    <p class="text-align = center">....</p>

                </div>
            </div>

        </div>

    </div>

</div>
<?php
include("./footer.php")
?>