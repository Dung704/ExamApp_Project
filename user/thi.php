<?php
include("./header.php");

if (!isset($_GET['id'])) {
    die("Lỗi: Thiếu tham số id đề thi.");
}

$id_de_thi = $_GET['id'];

// Lấy thông tin đề thi
$dt = mysqli_fetch_assoc(mysqli_query($dbc, 
    "SELECT * FROM de_thi WHERE id = '$id_de_thi'"
));

if (!$dt) {
    die("Đề thi không tồn tại.");
}

// Lấy ID người dùng
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để làm bài.");
}
$id_user = $_SESSION['user_id'];

// Kiểm tra xem đã có bản ghi kết quả chưa (tránh tạo nhiều bản ghi khi reload)
$sql_check = "
    SELECT id FROM ket_qua_thi
    WHERE id_nguoi_dung = '$id_user' AND id_de_thi = '$id_de_thi' AND diem_so IS NULL
    ORDER BY thoi_gian_bat_dau DESC LIMIT 1
";
$res_check = mysqli_query($dbc, $sql_check);
if ($row_check = mysqli_fetch_assoc($res_check)) {
    $id_kq = $row_check['id']; // Lấy kết quả đang làm
} else {
    // Tạo kết quả mới với thời gian bắt đầu
    $query_max = "
        SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id
        FROM ket_qua_thi
    ";
    $row_max = mysqli_fetch_assoc(mysqli_query($dbc, $query_max));
    $so_moi = ($row_max['max_id'] ?? 0) + 1;
    $id_kq = 'KQ' . $so_moi;

    mysqli_query($dbc, "
        INSERT INTO ket_qua_thi(id, id_nguoi_dung, id_de_thi, diem_so, thoi_gian_bat_dau)
        VALUES('$id_kq', '$id_user', '$id_de_thi', NULL, NOW())
    ");
}

// Lấy danh sách câu hỏi
$result_q = mysqli_query($dbc, 
    "SELECT * FROM cau_hoi WHERE id_de_thi = '$id_de_thi'"
);
?>

<div class="container my-4">
    <h3>Thi: <?= $dt['ten_de_thi'] ?></h3>
    <p>Thời gian còn lại: <span id="time"></span></p>

    <!-- FORM NỘP BÀI -->
    <form action="nop_bai.php" method="POST">
        <input type="hidden" name="id_de_thi" value="<?= $id_de_thi ?>">
        <input type="hidden" name="id_kq" value="<?= $id_kq ?>">

        <?php 
        $stt = 1;
        while ($q = mysqli_fetch_assoc($result_q)): 
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5>Câu <?= $stt ?>: <?= $q['noi_dung'] ?></h5>
                <?php if (!empty($q['hinh_anh'])): ?>
                <img src="./image_user/<?= $q['hinh_anh'] ?>" alt="Hình câu hỏi" class="img-fluid my-2"
                    style="max-width: 400px; border: 1px solid #ccc;">
                <?php endif; ?>

                <?php
                $sql_lc = "SELECT * FROM lua_chon 
                           WHERE id_cau_hoi = '{$q['id']}' 
                           ORDER BY id";
                $result_lc = mysqli_query($dbc, $sql_lc);

                while ($lc = mysqli_fetch_assoc($result_lc)):
                ?>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="cau_hoi_<?= $q['id'] ?>"
                        value="<?= $lc['id'] ?>">
                    <label class="form-check-label">
                        <?= $lc['noi_dung'] ?>
                    </label>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php 
        $stt++;
        endwhile; 
        ?>

        <button class="btn btn-success btn-lg" type="submit">Nộp bài</button>
    </form>
</div>

<script>
var time = <?= $dt['thoi_gian'] ?> * 60;

setInterval(function() {
    var min = Math.floor(time / 60);
    var sec = time % 60;

    document.getElementById("time").innerHTML =
        min + ":" + (sec < 10 ? "0" + sec : sec);

    if (time <= 0) document.forms[0].submit();

    time--;
}, 1000);
</script>

<?php include("./footer.php"); ?>