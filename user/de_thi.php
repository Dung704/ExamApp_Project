<?php
include("./header.php");
?>

<div class="container my-5">
    <div class="row">

        <!-- danh sách bài kiểm tra -->
        <div class="col-lg-8 mb-4">

            <h4 class="mb-4">Danh sách bài kiểm tra</h4>

            <?php
            $sql_dm = "SELECT * FROM danh_muc_de_thi ORDER BY id ASC";
            $result_dm = mysqli_query($dbc, $sql_dm);
            ?>

            <?php while($dm = mysqli_fetch_assoc($result_dm)): ?>

            <div class="mb-4">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="m-0"><?= $dm['ten_danh_muc'] ?></h5>

                    <a href="tat_ca_de_thi.php?id_dm=<?= $dm['id'] ?>" class="btn btn-outline-primary btn-sm">
                        Xem tất cả đề thi
                    </a>
                </div>

                <div class="d-flex flex-row overflow-auto gap-3">

                    <?php
                    $sql_dt = "SELECT * FROM de_thi WHERE id_danh_muc = {$dm['id']} ORDER BY id DESC";
                    $result_dt = mysqli_query($dbc, $sql_dt);
                    ?>

                    <?php if(mysqli_num_rows($result_dt) > 0): ?>

                    <?php while($dt = mysqli_fetch_assoc($result_dt)): ?>
                    <div class="card shadow-sm" style="min-width: 250px;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $dt['ten_de_thi'] ?></h5>

                            <p class="card-text mb-1">📝 <?= substr($dt['mo_ta'], 0, 60) ?>...</p>
                            <p class="card-text mb-1">⏱️ <?= $dt['thoi_gian'] ?> phút</p>
                            <p class="card-text mb-1">🎯 Thang điểm: <?= $dt['thang_diem'] ?></p>

                            <a href="chi_tiet_de_thi.php?id=<?= $dt['id'] ?>" class="btn btn-primary btn-sm">Bắt đầu</a>
                        </div>
                    </div>
                    <?php endwhile; ?>

                    <?php else: ?>

                    <div class="alert alert-info">Chưa có đề thi.</div>

                    <?php endif; ?>

                </div>
            </div>

            <?php endwhile; ?>

        </div>

        <!-- bảng xếp hạng -->
        <div class="col-lg-4 mb-4">
            <h4 class="mb-3"> Bảng Xếp Hạng</h4>

            <?php
    // Lấy danh sách xếp hạng theo số đề đã làm (mỗi đề chỉ tính 1 lần)
    $sql_rank = "
    SELECT 
        nd.id,
        nd.ho_ten,
        nd.anh_dai_dien,
        COALESCE(COUNT(kq_max.id_de_thi), 0) AS so_de_da_lam,
        COALESCE(SUM(kq_max.diem_cao_nhat), 0) AS tong_diem
    FROM nguoi_dung nd
    LEFT JOIN (
        SELECT 
            id_nguoi_dung,
            id_de_thi,
            MAX(diem_so) AS diem_cao_nhat
        FROM ket_qua_thi
        GROUP BY id_nguoi_dung, id_de_thi
    ) AS kq_max
    ON nd.id = kq_max.id_nguoi_dung
    GROUP BY nd.id, nd.ho_ten, nd.anh_dai_dien
    ORDER BY tong_diem DESC, so_de_da_lam DESC
    LIMIT 10
";


    $anh_mac_dinh = "./image_user/icons8-user-default-64.png";

    $result_rank = mysqli_query($dbc, $sql_rank);
    ?>

            <div class="card shadow-sm">
                <div class="card-body p-0">

                    <table class="table w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="w-10">Top</th>
                                <th class="w-75">Tên</th>
                                <th class="w-10">Số đề</th>
                                <th class="w-5">Tổng điểm </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                    $stt = 1;
                    while ($row = mysqli_fetch_assoc($result_rank)): 
                        $avatar = (!empty($row['anh_dai_dien'])) 
                                    ? "./image_user/" . $row['anh_dai_dien'] 
                                    : $anh_mac_dinh;
                        $mau_xep_hang = "";
                        if($stt == 1){
                            $mau_xep_hang = "table-warning";
                        }
                        elseif($stt == 2){
                            $mau_xep_hang = "table-secondary";

                        }
                        elseif($stt == 3){
                            $mau_xep_hang = "table-info";
                        }

                    ?>

                            <tr class="<?php echo $mau_xep_hang?>">
                                <th><?= $stt ?></th>

                                <td>
                                    <img src="<?= $avatar ?>" class="rounded-circle me-2"
                                        style="width: 35px; height: 35px; object-fit: cover;">
                                    <?= $row['ho_ten'] ?>
                                </td>

                                <td><?= $row['so_de_da_lam'] ?></td>
                                <td><?= $row['tong_diem'] ?> </td>

                            </tr>

                            <?php 
                    $stt++;
                    endwhile; 
                    ?>

                        </tbody>
                    </table>
                    <p style="text-align: center;">.....</p>


                </div>
            </div>

        </div>


    </div>
</div>

<?php include("./footer.php"); ?>