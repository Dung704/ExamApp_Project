<?php
// --- Xóa đề thi ---
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_exam_category = "DELETE FROM de_thi WHERE id='$id'";

    $query_image = "SELECT hinh_anh FROM cau_hoi WHERE id = '$id'";
    $result_query_image = mysqli_query($conn, $query_image);
    if ($row_image = mysqli_fetch_assoc($result_query_image)) {
        $file_name = $row_image['hinh_anh'];
        $path = "_assets/_images/" . $file_name;
        if (!empty($file_name) && file_exists($path)) {
            unlink($path);
        }
    }
    if (mysqli_query($conn, $delete_exam_category)) {
        echo '<div id="alert-box" class="alert alert-success"
            style="position:fixed; top:20px; right:20px; z-index:9999;">Đã xoá!</div>
            <script>
                setTimeout(function() {
                    document.getElementById("alert-box").remove();
                    window.location.href = "index_admin.php?page=list_exam";
                });
            </script>';
    } else {
        echo "Lỗi xóa đề thi: " . mysqli_error($conn);
    }
}


// --- Lấy dữ liệu đề thi ---
$query_to_show = "
    SELECT 
        dt.*,
        dmdt.ten_danh_muc,
        COUNT(ch.id) AS tong_cau_hoi
    FROM de_thi AS dt
    LEFT JOIN danh_muc_de_thi AS dmdt
        ON dt.id_danh_muc = dmdt.id
    LEFT JOIN cau_hoi AS ch
        ON ch.id_de_thi = dt.id
    GROUP BY dt.id
    ORDER BY dt.ngay_tao DESC
";

$result_to_show = mysqli_query($conn, $query_to_show);
?>

<!-- Table -->
<div class="table-card">
    <div class="row">
        <div class="col-6">
            <h5 class="mb-3">Danh sách đề thi</h5>
        </div>
        <div class="col-6 text-end">
            <a href="index_admin.php?page=add_exam" class="btn btn-primary">Thêm đề thi</a>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đề thi</th>
                    <th>Danh mục</th>
                    <th>Tên đề thi</th>
                    <th>Mô tả</th>
                    <th>Thời gian (phút)</th>
                    <th>Thang điểm</th>
                    <th>Ngày tạo</th>
                    <th>Tổng câu hỏi</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result_to_show)) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['ten_danh_muc'] ?></td>
                        <td><?= $row['ten_de_thi'] ?></td>
                        <td class="text-start text-ellipsis">
                            <?= $row['mo_ta'] ?>
                        </td>
                        <td><?= $row['thoi_gian'] ?></td>
                        <td><?= $row['thang_diem'] ?></td>
                        <td><?= $row['ngay_tao'] ?></td>
                        <td>
                            <?php
                            $count = $row['tong_cau_hoi'];

                            if ($count == 0) {
                                $class = 'bg-danger';
                            } elseif ($count < 10) {
                                $class = 'bg-warning text-dark';
                            } else {
                                $class = 'bg-success';
                            }
                            ?>
                            <span class="badge <?= $class ?>"><?= $count ?></span>
                        </td>

                        <td>
                            <span class="badge <?= $row['trang_thai'] == 0 ? 'bg-danger' : 'bg-success' ?>">
                                <?= $row['trang_thai'] == 0 ? 'Đang ẩn' : 'Đang hiển thị' ?>
                            </span>
                        </td>

                        <td>
                            <div class="align-items-center ">
                                <a href="index_admin.php?page=edit_exam&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-warning">
                                    Sửa
                                </a>

                                <!-- Nút xoá nằm giữa -->
                                <a href="index_admin.php?page=list_exam&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-danger mx-auto"
                                    onclick="return confirm('Bạn có chắc muốn xoá đề thi này?')">
                                    Xoá
                                </a>

                                <a href="index_admin.php?page=list_exam_question&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-info text-white text-nowrap">
                                    Xem câu hỏi
                                </a>
                            </div>
                        </td>

                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>
</div>