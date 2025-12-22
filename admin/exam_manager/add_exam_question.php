<?php
$id_dThi = $_GET['id'];
//Lấy tên đề thi
$query_nameDeThi = "Select ten_de_thi from de_thi where id = '$id_dThi' ";
$query_nameDeThi_result = mysqli_query($conn, $query_nameDeThi);
$nameDeThi = mysqli_fetch_assoc($query_nameDeThi_result);
//Lấy id
$query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM cau_hoi";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);
$new_id = 'CH' . ($row_max['max_id'] + 1);
//Lấy tổng câu hỏi
$sql = "SELECT COUNT(*) AS tong FROM cau_hoi WHERE id_de_thi = '$id_dThi'";
$rs  = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
// Xử lý submit form
if (isset($_POST['submit'])) {
    $mo_ta = trim($_POST['mo_ta']);
    $muc_do = $_POST['muc_do'];
    $id_de_thi = $id_dThi;
    // --- Upload ảnh bài học
    $hinh_anh = '';
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
        $hinh_anh = time() . '_' . $_FILES['hinh_anh']['name'];
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], '../user/image_user/' . $hinh_anh);
    }

    $insert = "INSERT INTO cau_hoi (id, id_de_thi, noi_dung, hinh_anh, muc_do)
               VALUES ('$new_id', '$id_de_thi', '$mo_ta', '$hinh_anh', '$muc_do')";
    if (mysqli_query($conn, $insert)) {
        echo '<div class="alert alert-success">
        Thêm câu hỏi số ' . ($row['tong'] + 1) . ' thành công!
      </div>';
    } else {
        echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
    }
}
?>
<div class="table-card">

    <h3>Thêm câu hỏi số <?php echo $row['tong'] + 1 ?> cho <?php echo $nameDeThi['ten_de_thi'] ?></h3>
    <form action="" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="row mb-3">
            <div class="col-md-2">
                <label>Mã câu hỏi:</label>
                <input type="text" name="Ma_cau_hoi" class="form-control" value="<?php echo $new_id; ?>" disabled>
            </div>
            <div class="col-md-2">
                <label>Mức độ:</label>
                <select name="muc_do" class="form-control">
                    <option value="easy">Dễ</option>
                    <option value="medium">Trung bình</option>
                    <option value="hard">Khó</option>
                </select>
            </div>
            <div class="col-md-8">
                <label>Ảnh bài học:</label>
                <div class="row">
                    <div class="col"><input type="file" name="hinh_anh" id="hinh_anh" class="form-control" accept="image/*"></div>
                    <div class="col"> <img id="preview_img" src="#" style="display:none; width:400px; object-fit:cover; margin-top:10px;"></div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Nội dung</label>
                <textarea id="noi_dung" name="mo_ta" class="form-control" required rows="10"><?php echo isset($_POST['mo_ta']) ? $_POST['mo_ta'] : ''; ?></textarea>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm câu hỏi</button>
        <a href="index_admin.php?page=list_exam_question&id=<?= $id_dThi ?>" class="btn btn-secondary">Về trang câu hỏi</a>
    </form>
</div>

<script>
    // Preview ảnh bài học
    document.getElementById('hinh_anh').addEventListener('change', function(event) {
        const preview = document.getElementById('preview_img');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    });
</script>