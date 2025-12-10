<?php
include("./header.php");

// Kiểm tra login
if (!isset($_SESSION['user_id'])) {
    die("Bạn chưa đăng nhập.");
}

$id_user = $_SESSION['user_id'];

$sql = "
    SELECT 
        kq.id,
        kq.diem_so,
        kq.thoi_gian_nop,
        kq.thoi_gian_bat_dau,  -- thêm cột bắt đầu
        dt.ten_de_thi
    FROM ket_qua_thi kq
    JOIN de_thi dt ON kq.id_de_thi = dt.id
    WHERE kq.id_nguoi_dung = '$id_user'
    ORDER BY kq.thoi_gian_nop DESC
";

$result = mysqli_query($dbc, $sql);
?>

<div class="container my-4">
    <h3>Lịch sử làm bài</h3>

    <table class="table table-bordered mt-3 mb-5">
        <thead>
            <tr>
                <th>Mã kết quả</th>
                <th>Đề thi</th>
                <th>Điểm</th>
                <th>Thời gian nộp</th>
                <th>Xem chi tiết</th>
                <th>Thời gian làm bài</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                // Tính thời gian làm bài
                $thoi_gian_lam = "Chưa xác định";
                if (!empty($row['thoi_gian_bat_dau']) && !empty($row['thoi_gian_nop'])) {
                    $bat_dau = strtotime($row['thoi_gian_bat_dau']);
                    $nop = strtotime($row['thoi_gian_nop']);
                    $diff = $nop - $bat_dau;
                    $phut = floor($diff / 60);
                    $giay = $diff % 60;
                    $thoi_gian_lam = $phut . " phút " . $giay . " giây";
                }
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['ten_de_thi'] ?></td>
                <td><?= $row['diem_so'] ?></td>
                <td><?= $row['thoi_gian_nop'] ?></td>
                <td>
                    <a href="xem_dap_an.php?id_kq=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                        Xem đáp án
                    </a>
                </td>
                <td><?= $thoi_gian_lam ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
include("./footer.php");
?>