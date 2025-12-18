<?php
include("./header.php");

/* ================= KIỂM TRA ID ĐỀ THI ================= */
if (!isset($_GET['id'])) {
    die("Lỗi: Thiếu tham số id đề thi.");
}

$id_de_thi = $_GET['id'];

/* ================= LẤY THÔNG TIN ĐỀ THI ================= */
$dt = mysqli_fetch_assoc(mysqli_query($dbc, 
    "SELECT * FROM de_thi WHERE id = '$id_de_thi'"
));

if (!$dt) {
    die("Đề thi không tồn tại.");
}

/* ================= KIỂM TRA ĐĂNG NHẬP ================= */
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để làm bài.");
}
$id_user = $_SESSION['user_id'];

/* =======================================================
   KIỂM TRA / TẠO BẢN GHI KẾT QUẢ
   ======================================================= */
$sql_check = "
    SELECT id FROM ket_qua_thi
    WHERE id_nguoi_dung = '$id_user'
      AND id_de_thi = '$id_de_thi'
      AND diem_so IS NULL
    ORDER BY thoi_gian_bat_dau DESC
    LIMIT 1
";
$res_check = mysqli_query($dbc, $sql_check);

if ($row_check = mysqli_fetch_assoc($res_check)) {
    $id_kq = $row_check['id'];
} else {
    $row_max = mysqli_fetch_assoc(mysqli_query($dbc, "
        SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) AS max_id
        FROM ket_qua_thi
    "));
    $so_moi = ($row_max['max_id'] ?? 0) + 1;
    $id_kq = 'KQ' . $so_moi;

    mysqli_query($dbc, "
        INSERT INTO ket_qua_thi(id, id_nguoi_dung, id_de_thi, diem_so, thoi_gian_bat_dau)
        VALUES('$id_kq', '$id_user', '$id_de_thi', NULL, NOW())
    ");
}

/* ================= LẤY DANH SÁCH CÂU HỎI ================= */
$result_q = mysqli_query($dbc, 
    "SELECT * FROM cau_hoi WHERE id_de_thi = '$id_de_thi'"
);
?>

<div class="container my-4">
    <h3>Thi: <?= $dt['ten_de_thi'] ?></h3>
    <p>Thời gian còn lại: <span id="time"></span></p>

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
                <img src="./image_cauhoi/<?= $q['hinh_anh'] ?>" class="img-fluid my-2"
                    style="max-width:400px; border:1px solid #ccc;">
                <?php endif; ?>

                <?php
                /* ===== KIỂM TRA CÂU 1 HAY NHIỀU ĐÁP ÁN ===== */
                $row_dung = mysqli_fetch_assoc(mysqli_query($dbc, "
                    SELECT COUNT(*) AS so_dung
                    FROM lua_chon
                    WHERE id_cau_hoi = '{$q['id']}'
                      AND dung_sai = 1
                "));

                $la_nhieu_dap_an = ($row_dung['so_dung'] > 1);

                $input_type = $la_nhieu_dap_an ? 'checkbox' : 'radio';
                $input_name = $la_nhieu_dap_an
                    ? "cau_hoi[{$q['id']}][]"
                    : "cau_hoi[{$q['id']}]";

                if ($la_nhieu_dap_an):
                ?>
                <p class="text-danger fst-italic">
                    (Câu hỏi có nhiều đáp án đúng)
                </p>
                <?php endif; ?>

                <?php
                $result_lc = mysqli_query($dbc, "
                    SELECT * FROM lua_chon
                    WHERE id_cau_hoi = '{$q['id']}'
                    ORDER BY id
                ");
                ?>

                <?php while ($lc = mysqli_fetch_assoc($result_lc)): ?>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="<?= $input_type ?>" name="<?= $input_name ?>"
                        value="<?= $lc['id'] ?>" id="lc_<?= $lc['id'] ?>">

                    <label class="form-check-label" for="lc_<?= $lc['id'] ?>">
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

        <button class="btn btn-success btn-lg" type="submit">
            Nộp bài
        </button>
    </form>
</div>

<script>
var time = <?= $dt['thoi_gian'] ?> * 60;

setInterval(function() {
    var min = Math.floor(time / 60);
    var sec = time % 60;

    document.getElementById("time").innerHTML =
        min + ":" + (sec < 10 ? "0" + sec : sec);

    if (time <= 0) {
        document.forms[0].submit();
    }
    time--;
}, 1000);
</script>

<?php include("./footer.php"); ?>