<?php
$id_cau_hoi = $_GET['id'];
$tt = $_GET['TT'];
//Lấy tên đề thi
$query_DT = "SELECT dt.ten_de_thi
FROM cau_hoi ch
JOIN de_thi dt ON ch.id_de_thi = dt.id
WHERE ch.id = '$id_cau_hoi'
";
$query_DT_result = mysqli_query($conn, $query_DT);
$ten_de_thi = mysqli_fetch_assoc($query_DT_result);
//Lấy tổng số lựa chọn
$query_tong = "SELECT COUNT(*) AS tong_lua_chon
FROM lua_chon
WHERE id_cau_hoi = '$id_cau_hoi'
";
$query_tongLC_result = mysqli_query($conn, $query_tong);
$tongLC = mysqli_fetch_assoc($query_tongLC_result);

$query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM lua_chon";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);
$new_id = 'LC' . ($row_max['max_id'] + 1);

//truy vấn danh sách lựa chọn
$query_to_show = "
    SELECT *
FROM lua_chon
WHERE id_cau_hoi = '$id_cau_hoi'
ORDER BY CAST(SUBSTRING(id, 3) AS UNSIGNED) ASC;
";

$result_to_show = mysqli_query($conn, $query_to_show);

// Xử lý submit form
if (isset($_POST['submit'])) {
    $noi_dung = trim($_POST['noi_dung']);
    $dung_sai = $_POST['dung_sai'];
    $insert = "INSERT INTO lua_chon (id, id_cau_hoi, noi_dung, dung_sai)
               VALUES ('$new_id', '$id_cau_hoi', '$noi_dung', $dung_sai)";

    if (mysqli_query($conn, $insert)) {
        echo '<script>
    setTimeout(function() {
        window.location.href = "index_admin.php?page=add_select_question&id=' . $id_cau_hoi . '&TT=' . $tt . '";
    });
    </script>';
    } else {
        echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
    }
}
?>
<div class="table-card">
    <h3>Thêm lựa chọn <?= chr(64 + $tongLC['tong_lua_chon'] + 1) ?> cho câu hỏi số <?= $tt ?>
    </h3>
    <form action="" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mã lựa chọn:</label>
                <input type="text" name="Ma_lua_chon" class="form-control" value="<?php echo $new_id; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label>Đúng / Sai:</label>
                <select name="dung_sai" class="form-control" required>
                    <option value="1" <?= (isset($_POST['dung_sai']) && $_POST['dung_sai'] == '1') ? 'selected' : '' ?>>
                        Đúng
                    </option>
                    <option value="0" <?= (isset($_POST['dung_sai']) && $_POST['dung_sai'] == '0') ? 'selected' : '' ?>>
                        Sai
                    </option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Mô tả</label>
                <textarea name="noi_dung" class="form-control" required rows="5"><?= isset($_POST['noi_dung']) ? $_POST['noi_dung'] : '' ?></textarea>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Thêm lựa chọn</button>
        <a href="index_admin.php?page=list_select_question&id=<?= $id_cau_hoi ?>&TT=<?= $tt ?>" class="btn btn-secondary">Về trang lựa chọn</a>
    </form>


    <table class="table table-hover" id="examTable">
        <thead>
            <tr>
                <th>STT</th>
                <th>Lựa chọn</th>
                <!-- <th>ID lựa chọn</th> -->
                <!-- <th>ID câu hỏi</th> -->
                <th>Nội dung</th>
                <th>Đúng / Sai</th>
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
                </tr>
            <?php
                $i++;
            } ?>
        </tbody>
    </table>
</div>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>