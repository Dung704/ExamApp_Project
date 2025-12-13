<?php
include("./header.php");
$id = $_GET['id'];

$sql = "SELECT * FROM de_thi WHERE id = '$id'";
$result = mysqli_query($dbc, $sql);
$dt = mysqli_fetch_assoc($result);

// đếm câu hỏi
$q_count = mysqli_fetch_assoc(mysqli_query($dbc, 
    "SELECT COUNT(*) AS tong FROM cau_hoi WHERE id_de_thi = '$id'"
));
?>

<div class="container my-4">
    <h3><?= $dt['ten_de_thi'] ?></h3>
    <p><?= $dt['mo_ta'] ?></p>
    <p>Thời gian: <?= $dt['thoi_gian'] ?> phút</p>
    <p>Số câu hỏi: <?= $q_count['tong'] ?></p>

    <a href="thi.php?id=<?= $id ?>" class="btn btn-primary btn-lg">Bắt đầu thi</a>
</div>

<?php include("./footer.php"); ?>