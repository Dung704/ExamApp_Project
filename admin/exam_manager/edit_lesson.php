<?php

$id_detail = $_GET['id'];

// Xử lý xóa file
if (isset($_GET['delete_file_id'])) {
    $file_id = $_GET['delete_file_id'];

    // Lấy thông tin file để xóa file vật lý
    $query_file_info = "SELECT duong_dan FROM tap_tin_bai_hoc WHERE id = '$file_id'";
    $result_file_info = mysqli_query($conn, $query_file_info);

    if ($row_file = mysqli_fetch_assoc($result_file_info)) {
        $file_path = "../user/file_pdf/" . $row_file['duong_dan'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Xóa record trong database
    $query_delete_file = "DELETE FROM tap_tin_bai_hoc WHERE id = '$file_id'";
    mysqli_query($conn, $query_delete_file);

    // Redirect để tránh resubmit
    echo "<script>
        setTimeout(function() {
            window.location.href = 'index_admin.php?page=edit_lesson&id=$id_detail';
        });
    </script>";
}

// Hàm chuyển đổi kích thước
function return_bytes($val)
{
    $val = trim($val);
    $last = strtolower($val[strlen($val) - 1]);
    $val = (int)$val;
    switch ($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

// Xử lý submit form CẬP NHẬT
if (isset($_POST['submit'])) {
    // Kiểm tra kích thước POST trước
    $max_post_size = ini_get('post_max_size');
    $max_post_bytes = return_bytes($max_post_size);

    if ($_SERVER['CONTENT_LENGTH'] > $max_post_bytes) {
        echo '<div class="alert alert-danger">
            <strong>Lỗi!</strong> Tổng dung lượng file quá lớn. 
            Giới hạn: ' . $max_post_size . '. Vui lòng chọn ít file hơn hoặc file nhỏ hơn.
        </div>';
    } else {
        $tieu_de = trim($_POST['tieu_de']);
        $noi_dung = trim($_POST['noi_dung']);
        $id_danh_muc = $_POST['id_danh_muc'];
        $link_bai_hoc = $_POST['link_bai_hoc'];

        // Xử lý ảnh đại diện
        $anh_bai_hoc = '';

        if (isset($_FILES['anh_bai_hoc']) && $_FILES['anh_bai_hoc']['error'] == 0) {
            // Xóa ảnh cũ
            $query_image = "SELECT anh_bai_hoc FROM bai_hoc WHERE id = '$id_detail'";
            $result_query_image = mysqli_query($conn, $query_image);

            if ($row_image = mysqli_fetch_assoc($result_query_image)) {
                $file_name = $row_image['anh_bai_hoc'];
                $path = "_assets/_images/" . $file_name;
                if (file_exists($path)) unlink($path);
            }

            $anh_bai_hoc = time() . '_' . $_FILES['anh_bai_hoc']['name'];
            move_uploaded_file($_FILES['anh_bai_hoc']['tmp_name'], '../user/image_baihoc/' . $anh_bai_hoc);
        } else {
            // Giữ ảnh cũ
            $query_image = "SELECT anh_bai_hoc FROM bai_hoc WHERE id = '$id_detail'";
            $res_img = mysqli_query($conn, $query_image);
            $row_old = mysqli_fetch_assoc($res_img);
            $anh_bai_hoc = $row_old['anh_bai_hoc'];
        }

        // Kiểm tra tieu_de trùng (trừ chính mình)
        $query_duplicate = "
            SELECT tieu_de FROM bai_hoc 
            WHERE tieu_de = '$tieu_de' AND id != '$id_detail'
        ";

        $duplicate = mysqli_query($conn, $query_duplicate);

        if (mysqli_num_rows($duplicate) > 0) {
            echo '<div class="alert alert-danger">Tiêu đề đã tồn tại!</div>';
        } else {
            $query_update = "
                UPDATE bai_hoc SET
                    tieu_de = '$tieu_de',
                    noi_dung = '$noi_dung',
                    id_danh_muc = '$id_danh_muc',
                    anh_bai_hoc = '$anh_bai_hoc',
                    link_bai_hoc = '$link_bai_hoc'
                WHERE id = '$id_detail'
            ";

            if (mysqli_query($conn, $query_update)) {

                // --- Upload file mới (nếu có)
                if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
                    $files = $_FILES['files'];
                    $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

                    // Lấy danh sách file hiện có của bài học này
                    $query_existing_files = "SELECT duong_dan FROM tap_tin_bai_hoc WHERE id_bai_hoc = '$id_detail'";
                    $result_existing = mysqli_query($conn, $query_existing_files);
                    $existing_files = [];
                    while ($row = mysqli_fetch_assoc($result_existing)) {
                        $existing_files[] = $row['duong_dan'];  // ← Lưu tên file nguyên gốc
                    }

                    // Lấy max ID hiện tại của tap_tin_bai_hoc
                    $query_max_file = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM tap_tin_bai_hoc";
                    $result_max_file = mysqli_query($conn, $query_max_file);
                    $row_max_file = mysqli_fetch_assoc($result_max_file);
                    $file_counter = ($row_max_file['max_id'] ?? 0) + 1;

                    $duplicate_files = [];
                    $uploaded_count = 0;

                    for ($i = 0; $i < count($files['name']); $i++) {
                        if ($files['error'][$i] == 0 && !empty($files['name'][$i])) {
                            $file_name = $files['name'][$i];  // ← Không có timestamp
                            $tmp_name = $files['tmp_name'][$i];
                            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                            if (!in_array($ext, $allowed)) continue;

                            // Kiểm tra file trùng
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
                    VALUES ('$new_file_id', '$id_detail', '$file_name', '$ext')";
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

                echo "
                    <script>
                        setTimeout(function() {
                            window.location.href = 'index_admin.php?page=edit_lesson&id=$id_detail';
                        });
                    </script>
                ";
            } else {
                echo '<div class="alert alert-danger">Lỗi cập nhật: ' . mysqli_error($conn) . '</div>';
            }
        }
    }
}

// Query dữ liệu SAU KHI xử lý POST
$query_detail = "SELECT * FROM bai_hoc WHERE id = '$id_detail'";
$query_detail_result = mysqli_query($conn, $query_detail);

$query_id_danh_muc = "select id, ten_danh_muc from danh_muc_de_thi";
$query_id_danh_muc_result = mysqli_query($conn, $query_id_danh_muc);

// Lấy danh sách file hiện có của bài học
$query_files = "SELECT * FROM tap_tin_bai_hoc WHERE id_bai_hoc = '$id_detail'";
$query_files_result = mysqli_query($conn, $query_files);
?>

<div class="table-card">
    <form method="post" action="" enctype="multipart/form-data" id="mainForm">
        <h3>Cập nhật bài học</h3>
        <?php while ($u = mysqli_fetch_assoc($query_detail_result)) { ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>ID:</label>
                    <input type="text" readonly class="form-control" value="<?php echo $u['id']; ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label>Tiêu đề:</label>
                    <input type="text" name="tieu_de" class="form-control" required value="<?php echo htmlspecialchars($u['tieu_de']); ?>">
                </div>
                <div class="col-md-4">
                    <label>Link bài học</label>
                    <input type="text" name="link_bai_hoc" class="form-control" required value="<?php echo htmlspecialchars($u['link_bai_hoc']); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Nội dung bài học</label>
                    <textarea class="form-control" rows="4" name="noi_dung"><?php echo htmlspecialchars($u['noi_dung']) ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Danh mục bài học:</label>
                    <select name="id_danh_muc" class="form-select" required>
                        <?php
                        mysqli_data_seek($query_id_danh_muc_result, 0);
                        while ($r = mysqli_fetch_assoc($query_id_danh_muc_result)):
                        ?>
                            <option value="<?php echo $r['id']; ?>"
                                <?php echo $u['id_danh_muc'] == $r['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($r['ten_danh_muc']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label>Ảnh bài học:</label>
                    <div class="row">
                        <div class="col">
                            <input type="file" name="anh_bai_hoc" id="anh_bai_hoc" class="form-control" accept="image/*">
                            <input type="hidden" name="anh_bai_hoc_cu" value="<?= htmlspecialchars($u['anh_bai_hoc']) ?>">
                        </div>
                    </div>

                    <!-- Hiển thị ảnh cũ và ảnh mới preview -->
                    <div class="row mt-3">
                        <!-- Ảnh hiện tại -->
                        <div class="col-md-6">
                            <label class="text-muted">Ảnh hiện tại:</label>
                            <?php
                            $avatarPath = "../user/image_baihoc/" . $u['anh_bai_hoc'];
                            if (!empty($u['anh_bai_hoc'])) {
                                echo '<img id="current_image" src="' . htmlspecialchars($avatarPath) . '" 
                    style="width:100%;max-width:600px;object-fit:cover;border-radius:8px;border:2px solid #ddd;">';
                            } else {
                                echo '<div id="current_image" style="width:100%;max-width:300px;height:300px;display:flex;align-items:center;justify-content:center;border:2px dashed #ccc;border-radius:8px;color:#999;">
                    Chưa có ảnh
                </div>';
                            }
                            ?>
                        </div>

                        <!-- Preview ảnh mới -->
                        <div class="col-md-6">
                            <label class="text-success">Preview ảnh mới:</label>
                            <img id="preview_image" src="" alt=""
                                style="width:100%;max-width:600px;object-fit:cover;border-radius:8px;border:2px solid #28a745;display:none;">
                            <div id="no_preview_text" style="width:100%;max-width:300px;height:300px;display:flex;align-items:center;justify-content:center;border:2px dashed #ccc;border-radius:8px;color:#999;">
                                Chọn ảnh để xem preview
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File hiện có -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label><strong>Tập tin hiện có:</strong></label>
                    <div style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; background: #f9f9f9;">
                        <?php
                        $has_files = false;
                        while ($file = mysqli_fetch_assoc($query_files_result)):
                            $has_files = true;
                            // Hiển thị tên file gốc (bỏ timestamp)
                            $display_name = $file['duong_dan'];
                            if (preg_match('/^\d+_(.+)$/', $display_name, $matches)) {
                                $display_name = $matches[1];
                            }
                        ?>
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px; border-bottom: 1px solid #eee;">
                                <div>
                                    <strong><?php echo htmlspecialchars($display_name); ?></strong>
                                    <span class="badge bg-info"><?php echo strtoupper($file['loai_tap_tin']); ?></span>
                                    <a href="../user/file_pdf/<?php echo htmlspecialchars($file['duong_dan']); ?>"
                                        target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                        Tải xuống
                                    </a>
                                </div>
                                <a href="index_admin.php?page=edit_lesson&id=<?php echo $id_detail; ?>&delete_file_id=<?php echo $file['id']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa file này?');">
                                    Xóa
                                </a>
                            </div>
                        <?php endwhile; ?>

                        <?php if (!$has_files): ?>
                            <p class="text-muted mb-0">Chưa có file nào được tải lên.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Upload file mới -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label><strong>Thêm tập tin mới:</strong></label>
                    <input type="file" name="files[]" id="files" class="form-control" multiple
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                    <small class="text-muted">
                        Chọn nhiều file PDF, Word, Excel, PowerPoint... (File trùng tên sẽ bị bỏ qua)<br>
                        <strong>Giới hạn tổng dung lượng: <?php echo ini_get('post_max_size'); ?></strong>
                    </small>
                    <div id="preview_files" style="margin-top:10px; display:flex; flex-direction:column; gap:5px;"></div>
                </div>
            </div>

            <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary">Cập nhật</button>
            <a href="index_admin.php?page=list_lesson" class="btn btn-secondary">Về trang danh sách</a>
        <?php } ?>
    </form>
</div>

<script>
    let selectedFiles = [];
    const MAX_SIZE = <?php echo return_bytes(ini_get('post_max_size')); ?>;

    const filesInput = document.getElementById('files');
    const previewContainer = document.getElementById('preview_files');
    const btnSubmit = document.getElementById('btnSubmit');

    // Preview ảnh bài học
    const anhBaiHocInput = document.getElementById('anh_bai_hoc');
    const previewImage = document.getElementById('preview_image');
    const noPreviewText = document.getElementById('no_preview_text');

    if (anhBaiHocInput) {
        anhBaiHocInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    previewImage.style.display = 'block';
                    if (noPreviewText) noPreviewText.style.display = 'none';
                };

                reader.readAsDataURL(file);
            } else {
                // Nếu không chọn file hoặc file không hợp lệ
                previewImage.style.display = 'none';
                if (noPreviewText) noPreviewText.style.display = 'flex';
            }
        });
    }

    if (filesInput) {
        filesInput.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);

            // Thêm file mới vào danh sách (không trùng tên và kích thước)
            newFiles.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });

            // Cập nhật lại input với tất cả file đã chọn
            updateFileInput();
            updatePreview();
        });
    }

    function updateFileInput() {
        // Tạo DataTransfer mới để chứa tất cả file
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        filesInput.files = dt.files;
    }

    function updatePreview() {
        if (!previewContainer) return;

        previewContainer.innerHTML = '';

        let totalSize = 0;
        selectedFiles.forEach(file => totalSize += file.size);

        // Kiểm tra vượt quá giới hạn
        const isOverLimit = totalSize > MAX_SIZE;

        // Disable/Enable nút submit
        if (btnSubmit) {
            if (isOverLimit) {
                btnSubmit.disabled = true;
                btnSubmit.classList.remove('btn-primary');
                btnSubmit.classList.add('btn-secondary');
                btnSubmit.title = 'Vui lòng giảm dung lượng file';
            } else {
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('btn-secondary');
                btnSubmit.classList.add('btn-primary');
                btnSubmit.title = '';
            }
        }

        // Cảnh báo nếu vượt quá giới hạn
        if (isOverLimit) {
            const warning = document.createElement('div');
            warning.className = 'alert alert-danger';
            warning.innerHTML = '<strong>❌ Lỗi:</strong> Tổng dung lượng file vượt quá giới hạn! Vui lòng bỏ bớt file để có thể cập nhật.';
            previewContainer.appendChild(warning);
        }

        selectedFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.style.cssText = 'display: flex; align-items: center; gap: 10px; padding: 5px; background: #e9ecef; border-radius: 4px;';

            const fileName = document.createElement('span');
            fileName.textContent = file.name + ' (' + formatBytes(file.size) + ')';
            fileName.style.flex = '1';

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Xóa";
            removeBtn.type = "button";
            removeBtn.className = "btn btn-sm btn-danger";
            removeBtn.onclick = () => {
                selectedFiles.splice(index, 1);
                updateFileInput();
                updatePreview();
            };

            div.appendChild(fileName);
            div.appendChild(removeBtn);
            previewContainer.appendChild(div);
        });

        // Hiển thị tổng dung lượng
        if (selectedFiles.length > 0) {
            const totalDiv = document.createElement('div');
            totalDiv.style.cssText = 'padding: 5px; font-weight: bold; color: ' + (isOverLimit ? 'red' : 'green');
            totalDiv.textContent = 'Tổng dung lượng: ' + formatBytes(totalSize) + ' / ' + formatBytes(MAX_SIZE);
            previewContainer.appendChild(totalDiv);
        }
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
</script>