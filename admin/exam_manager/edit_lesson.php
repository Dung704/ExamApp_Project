<?php
$id_detail = $_GET['id'];

// Xử lý xóa file
if (isset($_GET['delete_file_id'])) {
    $file_id = $_GET['delete_file_id'];

    // Lấy thông tin file để xóa file vật lý
    $query_file_info = "SELECT duong_dan FROM tap_tin_bai_hoc WHERE id = '$file_id'";
    $result_file_info = mysqli_query($conn, $query_file_info);

    if ($row_file = mysqli_fetch_assoc($result_file_info)) {
        $file_path = "_assets/_files/" . $row_file['duong_dan'];
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

// Xử lý submit form CẬP NHẬT
if (isset($_POST['submit'])) {
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
        move_uploaded_file($_FILES['anh_bai_hoc']['tmp_name'], '_assets/_images/' . $anh_bai_hoc);
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

                // Lấy max ID hiện tại của tap_tin_bai_hoc
                $query_max_file = "SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id FROM tap_tin_bai_hoc";
                $result_max_file = mysqli_query($conn, $query_max_file);
                $row_max_file = mysqli_fetch_assoc($result_max_file);
                $file_counter = ($row_max_file['max_id'] ?? 0) + 1;

                for ($i = 0; $i < count($files['name']); $i++) {
                    if ($files['error'][$i] == 0 && !empty($files['name'][$i])) {
                        $original_name = $files['name'][$i];
                        $file_name = time() . '_' . $original_name;
                        $tmp_name = $files['tmp_name'][$i];
                        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                        if (!in_array($ext, $allowed)) continue;

                        if (move_uploaded_file($tmp_name, '_assets/_files/' . $file_name)) {
                            // Tạo ID cho file
                            $new_file_id = 'TT' . $file_counter;
                            $file_counter++;

                            // Insert vào tap_tin_bai_hoc
                            $insert_file = "INSERT INTO tap_tin_bai_hoc 
                                (id, id_bai_hoc, duong_dan, loai_tap_tin) 
                                VALUES ('$new_file_id', '$id_detail', '$file_name', '$ext')";
                            mysqli_query($conn, $insert_file);
                        }
                    }
                }
            }

            echo '<div class="alert alert-success">Cập nhật bài học thành công!</div>';
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
                            <input type="file" name="anh_bai_hoc" class="form-control" accept="image/*">
                        </div>
                        <div class="col">
                            <?php
                            $avatarPath = "_assets/_images/" . $u['anh_bai_hoc'];
                            if (!empty($u['anh_bai_hoc'])) {
                                echo '<img src="' . htmlspecialchars($avatarPath) . '" 
                                    style="width:300px;height:300px;object-fit:cover;border-radius:8px;">';
                            } else {
                                echo '<span style="color:gray;">Không có ảnh</span>';
                            }
                            ?>
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
                        ?>
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px; border-bottom: 1px solid #eee;">
                                <div>
                                    <strong><?php echo htmlspecialchars($file['duong_dan']); ?></strong>
                                    <span class="badge bg-info"><?php echo strtoupper($file['loai_tap_tin']); ?></span>
                                    <a href="_assets/_files/<?php echo htmlspecialchars($file['duong_dan']); ?>"
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
                    <small class="text-muted">Chọn nhiều file PDF, Word, Excel, PowerPoint...</small>
                    <div id="preview_files" style="margin-top:10px; display:flex; flex-direction:column; gap:5px;"></div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index_admin.php?page=list_lesson" class="btn btn-secondary">Về trang danh sách</a>
        <?php } ?>
    </form>
</div>

<script>
    let selectedFiles = [];

    const filesInput = document.getElementById('files');
    const previewContainer = document.getElementById('preview_files');

    if (filesInput) {
        filesInput.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);

            newFiles.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });

            updatePreview();
        });
    }

    function updatePreview() {
        if (!previewContainer) return;

        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.style.cssText = 'display: flex; align-items: center; gap: 10px; padding: 5px; background: #e9ecef; border-radius: 4px;';

            const fileName = document.createElement('span');
            fileName.textContent = file.name;
            fileName.style.flex = '1';

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Xóa";
            removeBtn.type = "button";
            removeBtn.className = "btn btn-sm btn-danger";
            removeBtn.onclick = () => {
                selectedFiles.splice(index, 1);
                updatePreview();

                const dt = new DataTransfer();
                selectedFiles.forEach(f => dt.items.add(f));
                filesInput.files = dt.files;
            };

            div.appendChild(fileName);
            div.appendChild(removeBtn);
            previewContainer.appendChild(div);
        });
    }
</script>