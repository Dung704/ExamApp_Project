<?php
// --- XÓA CÂU HỎI ---
if (isset($_GET['delete_id'])) {
    $id_cau_hoi = $_GET['delete_id'];

    $delete = "DELETE FROM cau_hoi WHERE id = '$id_cau_hoi'";
    if (mysqli_query($conn, $delete)) {
        echo '<div id="alert-box" class="alert alert-success"
            style="position:fixed; top:20px; right:20px; z-index:9999;">
            Đã xoá câu hỏi!
        </div>
        <script>
            setTimeout(function() {
                document.getElementById("alert-box").remove();
                window.location.href = "index_admin.php?page=list_exam_question&id=' . $_GET['id'] . '";
            });
        </script>';
    } else {
        echo "Lỗi xoá câu hỏi: " . mysqli_error($conn);
    }
}

$id_dThi = $_GET['id'];
$query_nameDeThi = "Select ten_de_thi from de_thi where id = '$id_dThi' ";
$query_nameDeThi_result = mysqli_query($conn, $query_nameDeThi);
$nameDeThi = mysqli_fetch_assoc($query_nameDeThi_result);
$query_to_show = "
   SELECT 
    ch.*,
    dt.ten_de_thi,
    COUNT(lc.id) AS tong_lua_chon
FROM cau_hoi AS ch
LEFT JOIN de_thi AS dt
    ON ch.id_de_thi = dt.id
LEFT JOIN lua_chon AS lc
    ON lc.id_cau_hoi = ch.id
WHERE ch.id_de_thi = '$id_dThi'
GROUP BY ch.id
ORDER BY CAST(SUBSTRING(ch.id, 3) AS UNSIGNED) ASC
";
$result_to_show = mysqli_query($conn, $query_to_show);
?>
<div class="table-card">
    <div class="row">
        <div class="col-6">
            <h5 class="mb-3">Danh sách câu hỏi của: <?php echo $nameDeThi['ten_de_thi'] ?></h5>
        </div>
        <div class="col-6 text-end">
            <a href="index_admin.php?page=list_exam" class="btn btn-secondary">Quay lại danh sách đề thi </a>
            <a href="index_admin.php?page=add_exam_question&id=<?= $id_dThi ?>" class="btn btn-primary">Thêm câu hỏi</a>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>Câu</th>
                    <!-- <th>ID câu hỏi</th> -->
                    <!-- <th>Đề thi</th> -->
                    <th>Nội dung</th>
                    <th>Hình ảnh</th>
                    <th>Mức độ</th>
                    <th>Tổng số lựa chọn</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result_to_show)) { ?>
                    <tr>
                        <td><?= $i ?></td>

                        <!-- <td><?= $row['id'] ?></td> -->

                        <!-- <td>
                            <?= $row['id_de_thi'] ?>
                            <?= $row['ten_de_thi'] ? ' (' . $row['ten_de_thi'] . ')' : '' ?>
                        </td> -->

                        <td>
                            <?= $row['noi_dung'] ?>
                        </td>

                        <td>
                            <?php if (!empty($row['hinh_anh'])): ?>
                                <img src="../user/image_cauhoi/<?= $row['hinh_anh'] ?>"
                                    style="width:200px;object-fit:cover;border-radius:6px;">
                            <?php else: ?>
                                <span class="text-muted">Không có</span>
                            <?php endif; ?>
                        </td>

                        <td><?= $row['muc_do'] ?? 'Chưa xác định' ?></td>
                        <td>
                            <span class="badge <?= $row['tong_lua_chon'] == 0 ? 'bg-danger' : 'bg-success' ?>">
                                <?= $row['tong_lua_chon'] ?>
                            </span>
                        </td>



                        <td>
                            <div class="align-items-center ">
                                <a href="index_admin.php?page=edit_exam_question&id=<?= $row['id'] ?>&TT=<?= $i ?>"
                                    class="btn btn-sm btn-warning">
                                    Sửa
                                </a>

                                <a href="index_admin.php?page=list_exam_question&delete_id=<?= $row['id'] ?>&id=<?= $id_dThi ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xoá câu hỏi này?')">
                                    Xoá
                                </a>


                                <a href="index_admin.php?page=list_select_question&id=<?= $row['id'] ?>&TT=<?= $i ?>"
                                    class="btn btn-sm btn-info text-white text-nowrap">
                                    Xem lựa chọn
                                </a>
                            </div>
                        </td>

                    </tr>
                <?php
                    $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>