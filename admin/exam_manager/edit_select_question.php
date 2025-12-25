<?php
$id_detail = $_GET['idLC'];
$lc = $_GET['lc'];
$tt = $_GET['TT'];
$id_cau_hoi = $_GET['idCH'];
// Query dữ liệu SAU KHI xử lý POST
$query_detail = "SELECT * FROM lua_chon WHERE id = '$id_detail'";
$query_detail_result = mysqli_query($conn, $query_detail);

// Xử lý submit form
if (isset($_POST['submit'])) {
    foreach ($_POST as $key => $value) {
        if (is_string($value)) {
            $_POST[$key] = mysqli_real_escape_string($conn, trim($value));
        }
    }
    $noi_dung = trim($_POST['noi_dung']);
    $dung_sai = $_POST['dung_sai'];
    $query_update_detail = "
    UPDATE lua_chon 
    SET 
        noi_dung = '$noi_dung',
        dung_sai = '$dung_sai'
    WHERE id = '$id_detail' ";
    $result_update = mysqli_query($conn, $query_update_detail);
    if ($result_update) {
        echo '
          <script>
              setTimeout(function() {
                  window.location.href = "index_admin.php?page=edit_select_question&idLC=' . $id_detail .  '&lc=' . $lc . '&TT=' . $tt . '&idCH=' . $id_cau_hoi . ' ";
              },);
          </script>';
    } else {
        echo "Lỗi cập nhật lựa chọn: " . mysqli_error($conn);
    }
}
?>
<div class="table-card">
    <form method="post" action="" enctype="multipart/form-data" id="mainForm">
        <h3>Cập nhật lựa chọn <?= $lc ?>
        </h3>
        <?php while ($u = mysqli_fetch_assoc($query_detail_result)) { ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Mã lựa chọn:</label>
                    <input type="text" readonly class="form-control" value="<?php echo $u['id']; ?>" disabled>
                </div>
                <div class="col-md-6">
                    <label>Mức độ</label>
                    <select name="dung_sai" class="form-select">
                        <option value="0" <?= $u['dung_sai'] == '0' ? 'selected' : '' ?>>Sai</option>
                        <option value="1" <?= $u['dung_sai'] == '1' ? 'selected' : '' ?>>Đúng</option>
                    </select>
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Nội dung lựa chọn</label>
                    <textarea class="form-control" rows="4" name="noi_dung" required><?php echo $u['noi_dung'] ?></textarea>
                </div>
            </div>
            <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary" onclick="return confirm('Bạn có chắc muốn cập nhật lựa chọn này?')">Cập nhật lựa chọn</button>
            <a href="index_admin.php?page=list_select_question&id=<?= $id_cau_hoi ?>&TT=<?= $tt ?>" class="btn btn-secondary">Về trang danh sách lựa chọn</a>
        <?php } ?>
    </form>
</div>