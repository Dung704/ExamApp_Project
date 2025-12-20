<?php
$id_cau_hoi = $_GET['id'];

$query_to_show = "
    SELECT *
    FROM lua_chon
    WHERE id_cau_hoi = '$id_cau_hoi'
    ORDER BY id ASC
";

$result_to_show = mysqli_query($conn, $query_to_show);
?>

<div class="table-card">
    <h5 class="mb-3">
        Danh sách lựa chọn của câu hỏi: <?= $id_cau_hoi ?>
    </h5>

    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Lựa chọn</th>
                    <!-- <th>ID lựa chọn</th> -->
                    <!-- <th>ID câu hỏi</th> -->
                    <th>Nội dung</th>
                    <th>Đúng / Sai</th>
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
                        <td><?= chr(64 + $i) ?></td>
                        <!-- <td><?= $row['id_cau_hoi'] ?></td> -->

                        <td><?= $row['noi_dung'] ?></td>

                        <td>
                            <span class="<?= $row['dung_sai'] == 1 ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                                <?= $row['dung_sai'] == 1 ? 'Đúng' : 'Sai' ?>
                            </span>
                        </td>

                        <td>
                            <a href="index_admin.php?page=edit_select&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-warning">
                                Sửa
                            </a>

                            <a href="index_admin.php?page=delete_select&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc muốn xoá lựa chọn này?')">
                                Xoá
                            </a>
                        </td>
                    </tr>
                <?php
                    $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>