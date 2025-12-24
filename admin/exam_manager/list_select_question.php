<?php
$id_cau_hoi = $_GET['id'];
$tt = $_GET['TT'];
//Lấy tên đề thi
$query_DT = "SELECT dt.ten_de_thi, dt.id
FROM cau_hoi ch
JOIN de_thi dt ON ch.id_de_thi = dt.id
WHERE ch.id = '$id_cau_hoi'
";
$query_DT_result = mysqli_query($conn, $query_DT);
$ten_de_thi = mysqli_fetch_assoc($query_DT_result);

$query_to_show = "
    SELECT *
FROM lua_chon
WHERE id_cau_hoi = '$id_cau_hoi'
ORDER BY CAST(SUBSTRING(id, 3) AS UNSIGNED) ASC;
";

if (isset($_GET['delete_id'])) {
    $id_lua_chon = $_GET['delete_id'];

    $delete = "DELETE FROM lua_chon WHERE id = '$id_lua_chon'";
    if (mysqli_query($conn, $delete)) {
        echo '<div id="alert-box" class="alert alert-success"
            style="position:fixed; top:20px; right:20px; z-index:9999;">
            Đã xoá câu hỏi!
        </div>
        <script>
            setTimeout(function() {
                document.getElementById("alert-box").remove();
                window.location.href = "index_admin.php?page=list_select_question&id=' . $_GET['id'] . '&TT=' . $_GET['TT'] . '";
            });
        </script>';
    } else {
        echo "Lỗi xoá lựa chọn: " . mysqli_error($conn);
    }
}

$result_to_show = mysqli_query($conn, $query_to_show);
?>

<div class="table-card">
    <div class="row">
        <div class="col-6">
            <h5 class="mb-3">
                Danh sách lựa chọn của câu hỏi <?= $tt ?>
            </h5>
        </div>
        <div class="col-6 text-end">
            <a href="index_admin.php?page=list_exam_question&id=<?= $ten_de_thi['id'] ?>" class="btn btn-secondary">Quay lại đề thi <?= $ten_de_thi['ten_de_thi'] ?></a>
            <a href="index_admin.php?page=add_select_question&id=<?= $id_cau_hoi ?>&TT=<?= $tt  ?>" class="btn btn-primary">Thêm lựa chọn</a>
        </div>
    </div>
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
                            <a href="index_admin.php?page=edit_select_question&idLC=<?= $row['id'] ?>&lc=<?= chr(64 + $i) ?>&TT=<?= $tt ?>&idCH=<?= $id_cau_hoi ?>"
                                class="btn btn-sm btn-warning">
                                Sửa
                            </a>

                            <a href="index_admin.php?page=list_select_question&id=<?= $id_cau_hoi ?>&TT=<?= $tt ?>&delete_id=<?= $row['id'] ?>"
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