<?php
$id_detail = $_GET['id'];
$tt = $_GET['TT'];
// Query dữ liệu SAU KHI xử lý POST
$query_detail = "SELECT * FROM cau_hoi WHERE id = '$id_detail'";
$query_detail_result = mysqli_query($conn, $query_detail);

//Lấy id đề thi
$query_IDdeThi = "select id_de_thi from cau_hoi where id = '$id_detail'";
$query_IDdeThi_result = mysqli_query($conn, $query_IDdeThi);
$IDdeThi = mysqli_fetch_assoc($query_IDdeThi_result);

// Xử lý submit form
if (isset($_POST['submit'])) {
    $noi_dung = trim($_POST['noi_dung']);
    $muc_do = $_POST['muc_do'];
    // Xử lý ảnh đại diện
    $hinh_anh = '';

    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
        // Xóa ảnh cũ
        $query_image = "SELECT hinh_anh FROM cau_hoi WHERE id = '$id_detail'";
        $result_query_image = mysqli_query($conn, $query_image);

        if ($row_image = mysqli_fetch_assoc($result_query_image)) {
            $file_name = $row_image['hinh_anh'];
            $path = "../user/image_user/" . $file_name;
            if (file_exists($path)) unlink($path);
        }

        $hinh_anh = time() . '_' . $_FILES['hinh_anh']['name'];
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], '../user/image_user/' . $hinh_anh);
    } else {
        // Giữ ảnh cũ
        $query_image = "SELECT hinh_anh FROM cau_hoi WHERE id = '$id_detail'";
        $res_img = mysqli_query($conn, $query_image);
        $row_old = mysqli_fetch_assoc($res_img);
        $hinh_anh = $row_old['hinh_anh'];
    }

    $query_update_detail = "
    UPDATE cau_hoi 
    SET 
        noi_dung = '$noi_dung',
        hinh_anh = '$hinh_anh',
        muc_do = '$muc_do'
    WHERE id = '$id_detail' ";
    $result_update = mysqli_query($conn, $query_update_detail);
    if ($result_update) {
        echo '
          <script>
              setTimeout(function() {
                  window.location.href = "index_admin.php?page=edit_exam_question&id=' . $id_detail . '&TT=' . $tt . ' ";
              },);
          </script>';
    } else {
        echo "Lỗi cập nhật loại danh mục đề thi: " . mysqli_error($conn);
    }
}
?>
<div class="table-card">
    <form method="post" action="" enctype="multipart/form-data" id="mainForm">
        <h3>Cập nhật câu hỏi số <?= $tt ?>
        </h3>
        <?php while ($u = mysqli_fetch_assoc($query_detail_result)) { ?>
            <div class="row mb-3">
                <!-- <div class="col-md-1">
                    <label>Mã câu hỏi:</label>
                    <input type="text" readonly class="form-control" value="<?php echo $u['id']; ?>" disabled>
                </div> -->
                <div class="col-md-1">
                    <label>Mức độ</label>
                    <select name="muc_do" class="form-select">
                        <option value="dễ" <?= $u['muc_do'] == 'dễ' ? 'selected' : '' ?>>Dễ</option>
                        <option value="trung bình" <?= $u['muc_do'] == 'trung bình' ? 'selected' : '' ?>>Trung bình</option>
                        <option value="khó" <?= $u['muc_do'] == 'khó' ? 'selected' : '' ?>>Khó</option>
                    </select>
                </div>
                <div class="col-md-10">
                    <label>Ảnh câu hỏi:</label>
                    <div class="row">
                        <div class="col-3">
                            <input type="file" name="hinh_anh" id="hinh_anh" class="form-control" accept="image/*">
                        </div>

                        <div class="col-9 d-flex gap-3">
                            <!-- ẢNH CŨ -->
                            <?php if (!empty($u['hinh_anh'])): ?>
                                <div>
                                    <small>Ảnh hiện tại</small><br>
                                    <img
                                        src="../user/image_user/<?= htmlspecialchars($u['hinh_anh']) ?>"
                                        style="max-width:500px; object-fit:contain; ">
                                </div>
                            <?php endif; ?>

                            <!-- ẢNH MỚI -->
                            <div>
                                <small>Ảnh mới</small><br>
                                <img
                                    id="preview_image"
                                    style="display:none; max-width:500px; object-fit:contain; ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Nội dung câu hỏi</label>
                    <textarea class="form-control" rows="4" name="noi_dung" required><?php echo htmlspecialchars($u['noi_dung']) ?></textarea>
                </div>
            </div>

            <div class="row mb-3">


            </div>

            <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary" onclick="return confirm('Bạn có chắc muốn cập nhật câu hỏi này?')">Cập nhật câu hỏi</button>
            <a href="index_admin.php?page=list_exam_question&id=<?= $IDdeThi['id_de_thi'] ?>
" class="btn btn-secondary">Về trang danh sách</a>
        <?php } ?>
    </form>
</div>

<script>
    const anhInput = document.getElementById('hinh_anh');
    const previewImg = document.getElementById('preview_image');

    if (anhInput) {
        anhInput.addEventListener('change', function() {
            const file = this.files[0];

            if (!file) {
                previewImg.style.display = 'none';
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('Chỉ được chọn file ảnh');
                this.value = '';
                previewImg.style.display = 'none';
                return;
            }

            previewImg.src = URL.createObjectURL(file);
            previewImg.style.display = 'block';
        });
    }
</script>