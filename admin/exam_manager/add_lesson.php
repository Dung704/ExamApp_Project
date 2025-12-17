<?php
// Tạo ID tự động BH1, BH2...
$query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM bai_hoc";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);

$new_id = 'BH' . (($row_max['max_id'] ?? 0) + 1);

// Submit form
if (isset($_POST['submit'])) {
    $tieu_de     = trim($_POST['tieu_de']);
    $noi_dung    = trim($_POST['noi_dung']);
    $link_bai_hoc = trim($_POST['link_bai_hoc']);
    $id_danh_muc = $_POST['id_danh_muc'];

    // Upload ảnh
    $anh_bai_hoc = '';
    if (isset($_FILES['anh_bai_hoc']) && $_FILES['anh_bai_hoc']['error'] == 0) {
        $anh_bai_hoc = time() . '_' . $_FILES['anh_bai_hoc']['name'];
        move_uploaded_file($_FILES['anh_bai_hoc']['tmp_name'], '_assets/_images/' . $anh_bai_hoc);
    }

    // Insert
    $insert = "
        INSERT INTO bai_hoc 
        (id, tieu_de, noi_dung, anh_bai_hoc, link_bai_hoc, id_danh_muc)
        VALUES 
        ('$new_id', '$tieu_de', '$noi_dung', '$anh_bai_hoc', '$link_bai_hoc', '$id_danh_muc')
    ";

    if (mysqli_query($conn, $insert)) {
        echo '<div class="alert alert-success">Thêm bài học thành công! Mã: ' . $new_id . '</div>';
    } else {
        echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<div class="table-card">
    <h3>Thêm bài học mới</h3>

    <form method="post" enctype="multipart/form-data">

        <div class="row mb-3">

            <div class="col-md-6">
                <label>Mã bài học:</label>
                <input type="text" class="form-control" value="<?php echo $new_id; ?>" disabled>
            </div>

            <div class="col-md-6">
                <label>Tiêu đề:</label>
                <input type="text" name="tieu_de" class="form-control"
                    value="<?php echo $_POST['tieu_de'] ?? ''; ?>" required>
            </div>

            <div class="col-md-12">
                <label>Nội dung:</label>
                <textarea name="noi_dung" class="form-control" rows="4"><?php echo $_POST['noi_dung'] ?? ''; ?></textarea>
            </div>

            <div class="col-md-6">
                <label>Link bài học:</label>
                <input type="text" name="link_bai_hoc" class="form-control"
                    value="<?php echo $_POST['link_bai_hoc'] ?? ''; ?>">
            </div>

            <div class="col-md-6">
                <label>Danh mục:</label>
                <select name="id_danh_muc" class="form-control" required>
                    <?php
                    $rs = mysqli_query($conn, "SELECT id, ten_danh_muc FROM danh_muc_de_thi");
                    while ($r = mysqli_fetch_assoc($rs)) {
                        echo '<option value="' . $r['id'] . '">' . $r['ten_danh_muc'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4">
                <label>Ảnh bài học:</label>
                <input type="file" name="anh_bai_hoc" id="anh_bai_hoc" class="form-control" accept="image/*">

                <img id="preview_img" src="#"
                    style="display:none; width:200px; height:200px; object-fit:cover; margin-top:10px;">
            </div>

        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm bài học</button>
    </form>
</div>

<script>
    document.getElementById('anh_bai_hoc').addEventListener('change', function(event) {
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