<?php
include("./header.php");


/* ================= KIỂM TRA ID ĐỀ THI ================= */
if (!isset($_GET['id'])) {
    die("Lỗi: Thiếu tham số id đề thi.");
}
$id_de_thi = $_GET['id'];
// Đánh dấu bắt đầu phiên thi
$_SESSION['exam_active'] = true;
$_SESSION['exam_id'] = $id_de_thi;

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



/* ================= LẤY DANH SÁCH CÂU HỎI ================= */
$result_q = mysqli_query($dbc,
    "SELECT * FROM cau_hoi WHERE id_de_thi = '$id_de_thi'ORDER BY RAND()"
 
);
?>



<div class="container my-4">

    <div class="exam-header">
        <div>
            <div class="exam-title"><?= $dt['ten_de_thi'] ?></div>
            <div class="text-muted small">Mã đề: <?= $dt['id'] ?></div>
        </div>
        <div class="exam-timer">
            Còn: <span id="time"></span>
        </div>
    </div>

    <form action="nop_bai.php" method="POST" id="examForm">
        <input type="hidden" name="id_de_thi" value="<?= $id_de_thi ?>">
        <input type="hidden" name="id_kq" value="<?= $id_kq ?>">

        <div class="exam-container">
            <?php
            $stt = 1;
            while ($q = mysqli_fetch_assoc($result_q)):
                $row_dung = mysqli_fetch_assoc(mysqli_query($dbc, "
                    SELECT COUNT(*) AS so_dung
                    FROM lua_chon
                    WHERE id_cau_hoi = '{$q['id']}'
                      AND dung_sai = 1
                "));
                $la_nhieu = ($row_dung['so_dung'] > 1);
                $input_type = $la_nhieu ? 'checkbox' : 'radio';
                $input_name = $la_nhieu
                    ? "cau_hoi[{$q['id']}][]"
                    : "cau_hoi[{$q['id']}]";
            ?>

            <div class="exam-question" data-index="<?= $stt ?>">
                <h4>Câu <?= $stt ?>:</h4>
                <p><?= $q['noi_dung'] ?></p>

                <?php if (!empty($q['hinh_anh'])): ?>
                <img src="./image_cauhoi/<?= $q['hinh_anh'] ?>" class="exam-image">
                <?php endif; ?>

                <?php if ($la_nhieu): ?>
                <p class="text-danger fst-italic">(Câu hỏi có nhiều đáp án đúng)</p>
                <?php endif; ?>

                <?php
                $result_lc = mysqli_query($dbc, "
                    SELECT * FROM lua_chon
                    WHERE id_cau_hoi = '{$q['id']}'
                    ORDER BY id
                ");
                while ($lc = mysqli_fetch_assoc($result_lc)):
                ?>
                <div class="form-check exam-option">
                    <input class="form-check-input answer-input" type="<?= $input_type ?>" name="<?= $input_name ?>"
                        value="<?= $lc['id'] ?>" id="lc_<?= $lc['id'] ?>">
                    <label class="form-check-label" for="lc_<?= $lc['id'] ?>">
                        <?= $lc['noi_dung'] ?>
                    </label>
                </div>
                <?php endwhile; ?>
            </div>

            <?php $stt++; endwhile; ?>
        </div>

        <div class="d-flex justify-content-between my-3">
            <button type="button" class="btn btn-outline-secondary" id="prevBtn"> Câu trước</button>
            <button type="button" class="btn btn-outline-primary" id="nextBtn">Câu tiếp </button>
        </div>

        <div class="text-center">
            <button class="btn btn-success btn-lg w-40" type="submit">
                Nộp bài
            </button>
        </div>


        <!-- BẢNG DANH SÁCH CÂU HỎI -->
        <h5 class="mt-4 fw-bold text-center">Danh sách câu hỏi</h5>

        <div class="question-list">
            <?php for ($i = 1; $i < $stt; $i++): ?>
            <div class="q-item unanswered" id="q_item_<?= $i ?>" onclick="goToQuestion(<?= $i ?>)">
                <?= $i ?>
            </div>
            <?php endfor; ?>
        </div>

    </form>
</div>

<script>
function beforeUnloadHandler(e) {
    navigator.sendBeacon("huy_phien_thi.php");

    e.preventDefault();
    e.returnValue = "";
}
window.addEventListener("beforeunload", beforeUnloadHandler);

/* ===== TIMER ===== */
var time = <?= (int)$dt['thoi_gian'] ?> * 60;

var timer = setInterval(function() {
    var min = Math.floor(time / 60);
    var sec = time % 60;

    document.getElementById("time").innerHTML =
        min + ":" + (sec < 10 ? "0" + sec : sec);

    if (time <= 0) {

        window.removeEventListener("beforeunload", beforeUnloadHandler);

        clearInterval(timer);
        document.getElementById("examForm").submit();
    }

    time--;
}, 1000);


/* ===== ĐIỀU HƯỚNG CÂU HỎI ===== */
let currentQuestion = 1;
const questions = document.querySelectorAll('.exam-question');
const totalQuestions = questions.length;

function showQuestion(index) {
    questions.forEach(q => q.classList.remove('active'));
    const q = document.querySelector('.exam-question[data-index="' + index + '"]');
    if (q) q.classList.add('active');

    document.getElementById('prevBtn').disabled = (index === 1);
    document.getElementById('nextBtn').disabled = (index === totalQuestions);
}

showQuestion(currentQuestion);

document.getElementById('nextBtn').onclick = function() {
    if (currentQuestion < totalQuestions) {
        currentQuestion++;
        showQuestion(currentQuestion);
    }
};
document.getElementById('prevBtn').onclick = function() {
    if (currentQuestion > 1) {
        currentQuestion--;
        showQuestion(currentQuestion);
    }
};

/* ===== NHẢY ĐẾN CÂU ===== */
function goToQuestion(i) {
    currentQuestion = i;
    showQuestion(i);
}

/* ===== ĐÁNH DẤU CÂU ĐÃ LÀM ===== */
document.querySelectorAll(".answer-input").forEach(input => {
    input.addEventListener("change", function() {
        let qIndex = this.closest(".exam-question").dataset.index;
        let item = document.getElementById("q_item_" + qIndex);

        item.classList.remove("unanswered");
        item.classList.add("answered");
    });
});
/* ===== ĐÁNH DẤU CÂU ĐANG LÀM ===== */
document.querySelectorAll(".exam-question").forEach(q => {

    q.addEventListener("click", function() {

        // Bỏ trạng thái current của tất cả câu
        document.querySelectorAll(".q-item").forEach(i => {
            i.classList.remove("current");
        });

        // Lấy index câu hiện tại
        let qIndex = this.dataset.index;
        let item = document.getElementById("q_item_" + qIndex);

        if (item) {
            item.classList.add("current");
        }
    });
});




document.getElementById("examForm").addEventListener("submit", function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Xác nhận nộp bài",
        text: "Bạn có chắc chắn muốn nộp bài không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Nộp bài",
        cancelButtonText: "Hủy",
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33"
    }).then((result) => {
        if (result.isConfirmed) {

            window.removeEventListener("beforeunload", beforeUnloadHandler);

            this.submit();
        }
    });
});

let allowSubmit = false;

/* Khi người dùng rời trang mà KHÔNG nộp bài */
window.addEventListener("beforeunload", function() {
    if (!allowSubmit) {
        navigator.sendBeacon(
            "huy_phien_thi.php",
            new URLSearchParams({
                exam_id: "<?= $id_de_thi ?>"
            })
        );
    }
});

/* Khi nộp bài hợp lệ */
document.getElementById("examForm").addEventListener("submit", function() {
    allowSubmit = true;
});
</script>

<?php include("./footer.php"); ?>