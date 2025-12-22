<?php
session_start();
include_once('_includes/config.php');

$page = isset($_GET['page']) ? $_GET['page'] : null;

if (!$page) {
  header('Location: index_admin.php?page=list_user');
  exit();
}

$pages = [
  'list_user' => 'user_manager/list_user.php',
  'add_user' => 'user_manager/add_user.php',
  'edit_user' => 'user_manager/edit_user.php',
  'list_exam_category' => 'exam_manager/list_exam_category.php',
  'add_exam_category' => 'exam_manager/add_exam_category.php',
  'edit_exam_category' => 'exam_manager/edit_exam_category.php',
  'list_lesson' => 'exam_manager/list_lesson.php',
  'list_file_lesson' => 'exam_manager/list_file_lesson.php',
  'add_lesson' => 'exam_manager/add_lesson.php',
  'edit_lesson' => 'exam_manager/edit_lesson.php',
  'list_exam' => 'exam_manager/list_exam.php',
  'add_exam' => 'exam_manager/add_exam.php',
  'edit_exam' => 'exam_manager/edit_exam.php',
  'list_exam_question' => 'exam_manager/list_exam_question.php',
  'add_exam_question' => 'exam_manager/add_exam_question.php',
  'edit_exam_question' => 'exam_manager/edit_exam_question.php',
  'list_select_question' => 'exam_manager/list_select_question.php',
  'add_select_question' => 'exam_manager/add_select_question.php',
  'edit_select_question' => 'exam_manager/edit_select_question.php',
  'dashboard' => 'dashboard_manager/dashboard.php'
];

// Kiểm tra đăng nhập
if (!isset($_SESSION['email'])) {
  include('../user/login.php');
  exit();
}
$isValidPage = isset($pages[$page]) && file_exists($pages[$page]);
// Chỉ cho phép quyền Q1
if (!isset($_SESSION['id_quyen']) || $_SESSION['id_quyen'] !== 'Q1') {
  include('./_includes/index_404.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet" />


  <link rel="stylesheet" href="_assets/custom_css/bootstrap_538.css">
  <script src="_assets/custom_js/bootstrap_bundle_min_538.js"></script>
  <!-- Nếu có dashboard dùng biểu đồ -->
  <script src="_assets/custom_js/chart.js"></script>

  <!-- jQuery UI cho autocomplete -->
  <link rel="stylesheet" href="_assets/custom_css/jquery-ui.css">

  <link rel="stylesheet" href="_assets/custom_css/dataTable_235.css">
  <script src="_assets/custom_js/jquery_371.js"></script>
  <script src="_assets/custom_js/dataTable_235.js"></script>
  <link rel="stylesheet" href="_assets/custom_css/style.css">
  <script src="https://cdn.ckeditor.com/ckeditor5/latest/super-build/ckeditor.js"></script>
</head>
<?php if ($isValidPage): ?>

  <body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <?php include('_includes/sidebar.php') ?>
    </div>
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
      <!-- Topbar -->
      <div class="topbar">
        <?php include('_includes/topbar.php') ?>
      </div>
      <div class="table-card">
        <?php include($pages[$page]); ?>
      </div>
      <?php if (false): ?>
        <!-- Dashboard Content -->
        <div class="dashboard-content" id="moduleContent">
          <h2 class="mb-4">Dashboard</h2>

          <!-- Stats Cards -->
          <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="stat-card">
                <div
                  class="stat-icon"
                  style="background: #dbeafe; color: #3b82f6">
                  <i class="fas fa-users"></i>
                </div>
                <div class="stat-title">Tổng người dùng</div>
                <div class="stat-value">2,543</div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="stat-card">
                <div
                  class="stat-icon"
                  style="background: #dcfce7; color: #22c55e">
                  <i class="fas fa-box"></i>
                </div>
                <div class="stat-title">Sản phẩm</div>
                <div class="stat-value">1,234</div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="stat-card">
                <div
                  class="stat-icon"
                  style="background: #fef3c7; color: #f59e0b">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-title">Đơn hàng</div>
                <div class="stat-value">856</div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="stat-card">
                <div
                  class="stat-icon"
                  style="background: #fce7f3; color: #ec4899">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-title">Doanh thu</div>
                <div class="stat-value">$45K</div>
              </div>
            </div>
          </div>

          <!-- Chart -->
          <div class="row">
            <div class="col-lg-8">
              <div class="chart-card">
                <h5 class="mb-3">Thống kê doanh thu</h5>
                <canvas id="revenueChart" height="80"></canvas>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="chart-card">
                <h5 class="mb-3">Hoạt động gần đây</h5>
                <div class="list-group list-group-flush">
                  <div class="list-group-item border-0 px-0">
                    <small class="text-muted">2 phút trước</small>
                    <p class="mb-0">Đơn hàng mới #1234</p>
                  </div>
                  <div class="list-group-item border-0 px-0">
                    <small class="text-muted">15 phút trước</small>
                    <p class="mb-0">Người dùng mới đăng ký</p>
                  </div>
                  <div class="list-group-item border-0 px-0">
                    <small class="text-muted">1 giờ trước</small>
                    <p class="mb-0">Sản phẩm được cập nhật</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="table-card">
            <h5 class="mb-3">Đơn hàng gần đây</h5>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Giá trị</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#1001</td>
                    <td>Nguyễn Văn A</td>
                    <td>iPhone 15 Pro</td>
                    <td>$999</td>
                    <td><span class="badge bg-success">Hoàn thành</span></td>
                  </tr>
                  <tr>
                    <td>#1002</td>
                    <td>Trần Thị B</td>
                    <td>MacBook Air</td>
                    <td>$1,299</td>
                    <td><span class="badge bg-warning">Đang xử lý</span></td>
                  </tr>
                  <tr>
                    <td>#1003</td>
                    <td>Lê Văn C</td>
                    <td>iPad Pro</td>
                    <td>$799</td>
                    <td><span class="badge bg-info">Đang giao</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </body>
<?php else: ?>
  <?php include('_includes/index_404.php') ?>
<?php endif; ?>

</html>


<script>
  $(document).ready(function() {
    $('#userTable').DataTable({
      "pageLength": 10, // số dòng mỗi trang
      "ordering": true, // cho sắp xếp cột
      "searching": true, // bật tìm kiếm
      "lengthChange": true, // chọn số dòng/trang
      "language": {
        "lengthMenu": "Hiển thị _MENU_ dòng",
        "zeroResults": "Không tìm thấy dữ liệu",
        "info": "Trang _PAGE_ / _PAGES_",
        "infoEmpty": "Không có dữ liệu",
        "search": "Tìm:",
        "paginate": {
          "previous": "Trước",
          "next": "Sau"
        }
      }
    });
  });
</script>

<script>
  // Toggle Sidebar
  function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");

    if (window.innerWidth <= 768) {
      sidebar.classList.toggle("active");
    } else {
      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("expanded");
    }
  }


  // Chart
  const ctx = document.getElementById("revenueChart");
  if (ctx) {
    new Chart(ctx, {
      type: "line",
      data: {
        labels: ["T1", "T2", "T3", "T4", "T5", "T6", "T7"],
        datasets: [{
          label: "Doanh thu",
          data: [12, 19, 3, 5, 2, 3, 9],
          borderColor: "#4f46e5",
          backgroundColor: "rgba(79, 70, 229, 0.1)",
          tension: 0.4,
          fill: true,
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: false,
          },
        },
      },
    });
  }

  // // Load Module
  // function loadModule(module) {
  //   const menuItems = document.querySelectorAll(".menu-item");
  //   menuItems.forEach((item) => item.classList.remove("active"));
  //   event.target.closest(".menu-item").classList.add("active");

  //   const content = document.getElementById("moduleContent");
  //   content.innerHTML = `
  //               <h2 class="mb-4">${
  //                 module.charAt(0).toUpperCase() + module.slice(1)
  //               }</h2>
  //               <div class="alert alert-info">
  //                   Nội dung module ${module} sẽ được hiển thị ở đây.
  //                   Bạn có thể tùy chỉnh từng module một cách độc lập.
  //               </div>
  //           `;

  //   if (window.innerWidth <= 768) {
  //     document.getElementById("sidebar").classList.remove("active");
  //   }
  // }
</script>




<script>
  ClassicEditor.create(document.querySelector('#noi_dung'), {
    toolbar: [
      'bold', 'italic', 'underline',
      'bulletedList', 'numberedList',
      'link', 'blockQuote',
      'insertTable',
      'undo', 'redo'
    ]
  });
</script>