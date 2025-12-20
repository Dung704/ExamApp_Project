<?php
$id_dThi = $_GET['id'];

$query_to_show = "
    SELECT 
        ch.*, 
        dt.ten_de_thi
    FROM cau_hoi AS ch
    LEFT JOIN de_thi AS dt
        ON ch.id_de_thi = dt.id
    WHERE ch.id_de_thi = '$id_dThi'
    ORDER BY ch.id ASC
";

$result_to_show = mysqli_query($conn, $query_to_show);
?>
<div class="table-card">
    <h5 class="mb-3">Danh sách câu hỏi</h5>

    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID câu hỏi</th>
                    <th>Đề thi</th>
                    <th>Nội dung</th>
                    <th>Hình ảnh</th>
                    <th>Mức độ</th>
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

                        <td>
                            <?= $row['id_de_thi'] ?>
                            <?= $row['ten_de_thi'] ? ' (' . $row['ten_de_thi'] . ')' : '' ?>
                        </td>

                        <td>
                            <?= mb_strimwidth($row['noi_dung'], 0, 100, '...') ?>
                        </td>

                        <td>
                            <?php if (!empty($row['hinh_anh'])): ?>
                                <img src="_assets/_images/<?= $row['hinh_anh'] ?>"
                                    style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                            <?php else: ?>
                                <span class="text-muted">Không có</span>
                            <?php endif; ?>
                        </td>

                        <td><?= $row['muc_do'] ?? 'Chưa xác định' ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
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
                <?php
                    $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>