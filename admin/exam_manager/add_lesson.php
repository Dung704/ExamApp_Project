<?php
// --- Tạo ID tự động BH1, BH2... cho bài học
$query_max = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM bai_hoc";
$result_max = mysqli_query($conn, $query_max);
$row_max = mysqli_fetch_assoc($result_max);
$new_id = 'BH' . (($row_max['max_id'] ?? 0) + 1);

// --- Submit form
if (isset($_POST['submit'])) {
    $tieu_de      = trim($_POST['tieu_de']);
    $noi_dung     = trim($_POST['noi_dung']);
    $link_bai_hoc = trim($_POST['link_bai_hoc']);
    $id_danh_muc  = $_POST['id_danh_muc'];

    // --- Upload ảnh bài học
    $anh_bai_hoc = '';
    if (isset($_FILES['anh_bai_hoc']) && $_FILES['anh_bai_hoc']['error'] == 0) {
        $anh_bai_hoc = time() . '_' . $_FILES['anh_bai_hoc']['name'];
        move_uploaded_file($_FILES['anh_bai_hoc']['tmp_name'], '../user/image_baihoc/' . $anh_bai_hoc);
    }

    // Kiểm tra tiêu đề trùng
    $query_duplicate = "
    SELECT bh.id 
    FROM bai_hoc AS bh
    INNER JOIN danh_muc_de_thi AS dmdt
        ON bh.id_danh_muc = dmdt.id
    WHERE bh.tieu_de = '$tieu_de' 
      AND dmdt.id = $id_danh_muc
    LIMIT 1
";
    $result_duplicate = mysqli_query($conn, $query_duplicate);
    if (mysqli_num_rows($result_duplicate) > 0) {
        echo '<div class="alert alert-danger">Tiêu đề đã tồn tại!</div>';
    } else {
        // --- Insert bài học vào bảng bai_hoc
        $insert = "
    INSERT INTO bai_hoc 
    (id, tieu_de, noi_dung, anh_bai_hoc, link_bai_hoc, id_danh_muc)
    VALUES 
    ('$new_id', '$tieu_de', '$noi_dung', '$anh_bai_hoc', '$link_bai_hoc', '$id_danh_muc')
";
        if (mysqli_query($conn, $insert)) {

            // --- Lấy max ID hiện tại của tap_tin_bai_hoc
            $query_max_file = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM tap_tin_bai_hoc";
            $result_max_file = mysqli_query($conn, $query_max_file);
            $row_max_file = mysqli_fetch_assoc($result_max_file);
            $file_counter = ($row_max_file['max_id'] ?? 0) + 1;

            // --- Upload nhiều tập tin bài học
            if (isset($_FILES['files'])) {
                $files = $_FILES['files'];
                $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

                // Lấy danh sách file đã có trong database (tất cả bài học)
                $query_existing_files = "SELECT duong_dan FROM tap_tin_bai_hoc";
                $result_existing = mysqli_query($conn, $query_existing_files);
                $existing_files = [];
                while ($row = mysqli_fetch_assoc($result_existing)) {
                    $existing_files[] = $row['duong_dan'];
                }

                // Lấy max ID hiện tại của tap_tin_bai_hoc
                $query_max_file = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM tap_tin_bai_hoc";
                $result_max_file = mysqli_query($conn, $query_max_file);
                $row_max_file = mysqli_fetch_assoc($result_max_file);
                $file_counter = ($row_max_file['max_id'] ?? 0) + 1;

                $duplicate_files = [];
                $uploaded_count = 0;

                for ($i = 0; $i < count($files['name']); $i++) {
                    if ($files['error'][$i] == 0) {
                        $file_name = $files['name'][$i];  // ← Không có timestamp
                        $tmp_name  = $files['tmp_name'][$i];
                        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                        if (!in_array($ext, $allowed)) continue;

                        // ✅ Kiểm tra file trùng trong toàn bộ database
                        if (in_array($file_name, $existing_files)) {
                            $duplicate_files[] = $file_name;
                            continue;
                        }

                        if (move_uploaded_file($tmp_name, '../user/file_pdf/' . $file_name)) {
                            // Tạo ID cho file
                            $new_file_id = 'TT' . $file_counter;
                            $file_counter++;

                            // Insert vào tap_tin_bai_hoc
                            $insert_file = "INSERT INTO tap_tin_bai_hoc 
                    (id, id_bai_hoc, duong_dan, loai_tap_tin) 
                    VALUES ('$new_file_id', '$new_id', '$file_name', '$ext')";
                            mysqli_query($conn, $insert_file);
                            $uploaded_count++;
                        }
                    }
                }

                // Thông báo kết quả
                if (!empty($duplicate_files)) {
                    echo '<div class="alert alert-warning">
            <strong>File trùng (đã bỏ qua):</strong><br>' .
                        implode('<br>', array_map('htmlspecialchars', $duplicate_files)) .
                        '</div>';
                }

                if ($uploaded_count > 0) {
                    echo '<div class="alert alert-success">Đã tải lên ' . $uploaded_count . ' file mới.</div>';
                }
            }

            echo '<div class="alert alert-success">Thêm bài học thành công! Mã: ' . $new_id . '</div>';
        } else {
            echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>


<div class="table-card">
    <h3>Thêm bài học mới</h3>

    <form method="post" enctype="multipart/form-data">

        <div class="row mb-3">

            <div class="col-md-6">
                <label>Mã bài học:</label>
                <input type="text" class="form-control" value="<?= $new_id ?>" disabled>
            </div>

            <div class="col-md-6">
                <label>Tiêu đề:</label>
                <input type="text" name="tieu_de" class="form-control"
                    value="<?= $_POST['tieu_de'] ?? '' ?>" required>
            </div>

            <div class="col-md-12">
                <label>Nội dung:</label>
                <textarea name="noi_dung" class="form-control" rows="4"><?= $_POST['noi_dung'] ?? '' ?></textarea>
            </div>

            <div class="col-md-6">
                <label>Link bài học:</label>
                <input type="text" name="link_bai_hoc" class="form-control"
                    value="<?= $_POST['link_bai_hoc'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Danh mục:</label>
                <select name="id_danh_muc" class="form-control" required>
                    <?php
                    $rs = mysqli_query($conn, "SELECT id, ten_danh_muc FROM danh_muc_de_thi");
                    while ($r = mysqli_fetch_assoc($rs)) {
                        $selected = (isset($_POST['id_danh_muc']) && $_POST['id_danh_muc'] == $r['id']) ? 'selected' : '';
                        echo '<option value="' . $r['id'] . '" ' . $selected . '>' . $r['ten_danh_muc'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4">
                <label>Ảnh bài học:</label>
                <input type="file" name="anh_bai_hoc" id="anh_bai_hoc" class="form-control" accept="image/*">
                <img id="preview_img" src="#" style="display:none; width:200px; height:200px; object-fit:cover; margin-top:10px;">
            </div>

            <div class="col-md-8">
                <label>Tập tin bài học:</label>
                <input type="file" name="files[]" id="files" class="form-control" multiple
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                <small class="text-muted">Chọn nhiều file PDF, Word, Excel, PowerPoint...</small>
                <div id="preview_files" style="margin-top:10px; display:flex; flex-direction:column; gap:5px;"></div>
            </div>



        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm bài học</button>
    </form>
</div>

<script>
    // Preview ảnh bài học
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

<script>
    let selectedFiles = [];

    const filesInput = document.getElementById('files');
    const previewContainer = document.getElementById('preview_files');

    filesInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);

        // Thêm file mới vào selectedFiles (tránh trùng)
        files.forEach(file => {
            if (!selectedFiles.some(f => f.name === file.name && f.size === f.size)) {
                selectedFiles.push(file);
            }
        });

        // ✅ Cập nhật lại input.files bằng DataTransfer
        updateInputFiles();

        // Hiển thị preview
        renderPreview();
    });

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        filesInput.files = dataTransfer.files;
    }

    function renderPreview() {
        previewContainer.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.style.cssText = 'display:flex; align-items:center; gap:10px; padding:5px; border:1px solid #ddd; border-radius:4px;';

            div.innerHTML = `
            <span style="flex:1;">${file.name}</span>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeFile(${index})">Xóa</button>
        `;

            previewContainer.appendChild(div);
        });
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        updateInputFiles();
        renderPreview();
    }
</script>