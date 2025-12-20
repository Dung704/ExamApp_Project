<?php
// --- Lấy dữ liệu từ bảng tap_tin_bai_hoc ---
$query_to_show = "
    SELECT 
        ttb.*, 
        bh.tieu_de
    FROM tap_tin_bai_hoc AS ttb
    LEFT JOIN bai_hoc AS bh
        ON ttb.id_bai_hoc = bh.id
    ORDER BY ttb.id_bai_hoc ASC
";
$result_to_show = mysqli_query($conn, $query_to_show);
?>

<div class="table-card">
    <h5 class="mb-3">Danh sách tập tin bài học</h5>
    <div class="table-responsive">
        <table class="table table-hover" id="userTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID tập tin</th>
                    <th>ID bài học</th>
                    <th>Đường dẫn</th>
                    <th>Loại tập tin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result_to_show)) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['id_bai_hoc'] . ' (' . $row['tieu_de'] . ')' ?></td>
                        <td>
                            <a href="_assets/_files/<?= $row['duong_dan'] ?>" target="_blank">
                                <?= $row['duong_dan'] ?>
                            </a>
                        </td>
                        <td><?= $row['loai_tap_tin'] ?? 'Không có' ?></td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>