<?php
session_start(); // Bắt đầu session
include_once('../app/config.php');
$page = isset($_GET['page']) ? $_GET['page'] : null;
// Nếu chưa có page, redirect sang dashboard
if (!$page) {
  header('Location: index_admin.php?page=list_bill');
  exit();
}
// --- Mảng ánh xạ page => file ---
$pages = [
  'list_product' => 'product_manager/list_product.php',
  'add_product' => 'product_manager/add_product.php',
  'edit_product' => 'product_manager/edit_product.php',
  'list_product_category' => 'product_manager/list_product_category.php',
  'add_product_category' => 'product_manager/add_product_category.php',
  'edit_product_category' => 'product_manager/edit_product_category.php',
  'list_product_brand' => 'product_manager/list_product_brand.php',
  'add_product_brand' => 'product_manager/add_product_brand.php',
  'edit_product_brand' => 'product_manager/edit_product_brand.php',
  'list_user_customer' => 'user_manager/list_user_customer.php',
  'add_user_customer' => 'user_manager/add_user_customer.php',
  'edit_user_customer' => 'user_manager/edit_user_customer.php',
  'list_user_employee' => 'user_manager/list_user_employee.php',
  'add_user_employee' => 'user_manager/add_user_employee.php',
  'edit_user_employee' => 'user_manager/edit_user_employee.php',
  'list_bill' => 'revenue_manager/list_bill.php',
  'list_bill_detail' => 'revenue_manager/list_bill_detail.php',
  'add_bill' => 'revenue_manager/add_bill.php',
  'list_authorization' => 'authorization_acount_manager/list_authorization.php',
  'list_account' => 'authorization_acount_manager/list_account.php',
  'edit_account' => 'authorization_acount_manager/edit_account.php',
  'add_account_customer' => 'authorization_acount_manager/add_account_customer.php',
  'add_account_employee' => 'authorization_acount_manager/add_account_employee.php',
  'dashboard' => 'dashboard_manager/dashboard.php'
];
// Kiểm tra page hợp lệ
$isValidPage = isset($pages[$page]) && file_exists($pages[$page]);
$q2_allowed_pages = [
  'list_bill',
  'list_bill_detail',
  'add_bill',
  'list_account',
  'add_account_customer'
];

// Kiểm tra đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
  include('_includes/_login.php'); // chưa đăng nhập → bắt login
  exit();
}

// Kiểm tra quyền
if (!isset($_SESSION['ma_quyen'])) {
  include('./_includes/index_404.php');
  exit();
}

if ($_SESSION['ma_quyen'] == 'Q2') {
  // Q2 chỉ được phép truy cập các page trong danh sách
  if (!in_array($page, $q2_allowed_pages)) {
    include('./_includes/index_404.php');
    exit();
  }
} elseif ($_SESSION['ma_quyen'] != 'Q1') {
  // Những quyền khác ngoài Q1 và Q2 → 404
  include('./_includes/index_404.php');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Admin</title>

  <!-- Custom fonts for this template-->
  <link href="../_assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="../_assets/admin/css/sb-admin-2.min.css" rel="stylesheet" />

  <!-- Bootstrap core JavaScript-->
  <script src="../_assets/admin/vendor/jquery/jquery.min.js"></script>
  <script src="../_assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../_assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Nếu có dashboard dùng biểu đồ -->
  <script src="../_assets/admin/custom_js/chart.js"></script>

  <!-- jQuery UI cho autocomplete -->
  <link rel="stylesheet" href="../_assets/admin/custom_js/jquery-ui.css">
  <script src="../_assets/admin/custom_js/jquery-ui.min.js"></script>
</head>

<?php if ($isValidPage): ?>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <?php include('_includes/sidebar.php') ?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <?php include_once('_includes/topbar.php') ?>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <?php include($pages[$page]); ?>
          </div>

          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include('_includes/footer.php') ?>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <?php include('_includes/logout_modal.php') ?>
  </body>

<?php else: ?>

  <?php include('./_includes/index_404.php'); ?>

<?php endif; ?>

</html>

<!-- Custom scripts for all pages-->
<script src="../_assets/admin/js/sb-admin-2.min.js"></script>