<?php
include("../app/config/config.php");
session_start();

$id_cau_hoi = $_POST['id_cau_hoi'];
$noi_dung = $_POST['noi_dung'];
$id_nguoi_tra_loi = $_SESSION['user_id'];

$id = substr(md5(uniqid(mt_rand(), true)), 0, 20);

$anh_dinh_kem = null;

if (!empty($_FILES['anh_dinh_kem']['name'])) {

    $anh_dinh_kem = time() . "_" . basename($_FILES['anh_dinh_kem']['name']);

    $target = "./image_traloi/" . $anh_dinh_kem;

    move_uploaded_file($_FILES['anh_dinh_kem']['tmp_name'], $target);
}

$sql = "
    INSERT INTO cau_tra_loi_nguoi_dung 
    (id, id_cau_hoi, id_nguoi_tra_loi, noi_dung, anh_dinh_kem, thoi_gian_tao)
    VALUES 
    ('$id', '$id_cau_hoi', '$id_nguoi_tra_loi', '$noi_dung', '$anh_dinh_kem', NOW())
";

mysqli_query($dbc, $sql);

header("Location: chi_tiet_cau_hoi_nguoi_dung.php?id=$id_cau_hoi");
exit;
?>