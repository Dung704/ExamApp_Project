<?php if (false): ?>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <?php if (isset($_SESSION['id_quyen']) && $_SESSION['id_quyen'] == 'Q1'): ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index_admin.php?page=dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">3TL Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index_admin.php?page=dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Thống kê</span>
                </a>
            </li>
        <?php else: ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index_admin.php?page=list_bill">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />


        <?php endif; ?>


        <!-- Divider -->
        <hr class="sidebar-divider" />

        <?php if (isset($_SESSION['id_quyen']) && $_SESSION['id_quyen'] == 'Q1'): ?>
            <div class="sidebar-heading">Quản lý</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseexam_categorys"
                    aria-expanded="true" aria-controls="collapseexam_categorys">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
                <div id="collapseexam_categorys" class="collapse" aria-labelledby="headingexam_categorys" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sản phẩm:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_exam_category">Danh sách sản phẩm</a>
                        <a class="collapse-item" href="index_admin.php?page=list_exam_category_category">Danh sách loại sản phẩm</a>
                        <a class="collapse-item" href="index_admin.php?page=list_exam_category_brand">Danh sách nhà cung cấp</a>
                    </div>
                </div>
            </li>

            <!-- Quản lý người dùng -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer"
                    aria-expanded="true" aria-controls="collapseCustomer">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Quản lý người dùng</span>
                </a>
                <div id="collapseCustomer" class="collapse" aria-labelledby="headingCustomers" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Khách hàng:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_user_customer">Danh sách khách hàng</a>
                        <h6 class="collapse-header">Nhân viên:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_user_employee">Danh sách nhân viên</a>
                    </div>
                </div>
            </li>

            <!-- Quản lý doanh thu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRevenue"
                    aria-expanded="true" aria-controls="collapseRevenue">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Quản lý doanh thu</span>
                </a>
                <div id="collapseRevenue" class="collapse" aria-labelledby="headingRevenue" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Hoá đơn:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_bill">Danh sách hoá đơn</a>
                    </div>
                </div>
            </li>

            <!-- Phân quyền và tài khoản -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount_Authorization"
                    aria-expanded="true" aria-controls="collapseAccount_Authorization">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Phân quyền và tài khoản</span>
                </a>
                <div id="collapseAccount_Authorization" class="collapse" aria-labelledby="headingAccount_Authorization"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tài khoản và quyền:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_authorization">Danh sách quyền</a>
                        <a class="collapse-item" href="index_admin.php?page=list_account">Danh sách tài khoản</a>
                    </div>
                </div>
            </li>

        <?php elseif (isset($_SESSION['id_quyen']) && $_SESSION['id_quyen'] == 'Q2'): ?>
            <!-- Nhân viên: chỉ danh sách hóa đơn -->
            <div class="sidebar-heading">Quản lý</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRevenue"
                    aria-expanded="true" aria-controls="collapseRevenue">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Quản lý doanh thu</span>
                </a>
                <div id="collapseRevenue" class="collapse" aria-labelledby="headingRevenue" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Hoá đơn:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_bill">Danh sách hoá đơn</a>
                    </div>
                </div>
            </li>
            <!-- Phân quyền và tài khoản -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount_Authorization"
                    aria-expanded="true" aria-controls="collapseAccount_Authorization">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Tài khoản khách hàng</span>
                </a>
                <div id="collapseAccount_Authorization" class="collapse" aria-labelledby="headingAccount_Authorization"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Danh sách tài khoản:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_account">Danh sách tài khoản</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <script src="_assets\admin\js\sb-admin-2.min.js"></script>
<?php endif; ?>

<?php if (false): ?>
    <div class="sidebar-header">
        <a href="#" class="sidebar-logo">
            <i class="fas fa-crown"></i> AdminPro
        </a>
    </div>
    <nav class="sidebar-menu">
        <a href="index_admin.php?page=dashboard"
            class="menu-item <?php echo ($_GET['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="index_admin.php?page=list_user"
            class="menu-item <?php echo ($_GET['page'] ?? '') == 'list_user' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Người dùng
        </a>
        <a href="#" class="menu-item" onclick="loadModule('exam_categorys')">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="#" class="menu-item" onclick="loadModule('orders')">
            <i class="fas fa-shopping-cart"></i> Đơn hàng
        </a>
        <a href="#" class="menu-item" onclick="loadModule('analytics')">
            <i class="fas fa-chart-line"></i> Thống kê
        </a>
        <a href="#" class="menu-item" onclick="loadModule('settings')">
            <i class="fas fa-cog"></i> Cài đặt
        </a>

    </nav>
<?php endif; ?>

<!-- HTML Structure -->
<nav class="sidebar-menu">
    <div class="sidebar-header">
        <a href="#" class="sidebar-logo">
            <i class="fas fa-crown"></i> AdminPro
        </a>
    </div>
    <!-- Dashboard -->
    <a href="index_admin.php?page=dashboard"
        class="menu-item <?php echo ($_GET['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
        <i class="fas fa-home"></i> Dashboard
    </a>

    <!-- Quản lý người dùng (có submenu) -->
    <div class="menu-group">
        <div class="menu-item has-submenu <?php echo in_array($_GET['page'] ?? '', ['list_user', 'add_user', 'edit_user']) ? 'active' : ''; ?>"
            data-submenu="user-menu">
            <i class="fas fa-users"></i>
            <span>Quản lý người dùng</span>
            <i class="fas fa-chevron-down arrow"></i>
        </div>
        <div class="submenu" id="user-menu">
            <a href="index_admin.php?page=list_user"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'list_user' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> Danh sách người dùng
            </a>
            <a href="index_admin.php?page=add_user"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'add_user' ? 'active' : ''; ?>">
                <i class="fas fa-user-plus"></i> Thêm người dùng
            </a>

        </div>
    </div>

    <div class="menu-group">
        <div class="menu-item has-submenu <?php echo in_array($_GET['page'] ?? '', ['list_exam_category', 'add_exam_category']) ? 'active' : ''; ?>"
            data-submenu="exam-menu">
            <i class="fas fa-file-lines"></i>
            <span>Quản lý đề thi-bài học</span>
            <i class="fas fa-chevron-down arrow"></i>
        </div>
        <div class="submenu" id="exam-menu">
            <a href="index_admin.php?page=list_exam_category"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'list_exam_category' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> Danh sách danh mục đề thi
            </a>
            <a href="index_admin.php?page=add_exam_category"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'add_exam_category' ? 'active' : ''; ?>">
                <i class="fas fa-plus"></i> Thêm danh mục đề thi
            </a>
            <a href="index_admin.php?page=list_lesson"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'list_lesson' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> Danh sách bài học
            </a>
            <a href="index_admin.php?page=add_lesson"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'add_lesson' ? 'active' : ''; ?>">
                <i class="fas fa-plus"></i> Thêm bài học
            </a>
            <a href="index_admin.php?page=list_file_lesson"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'list_file_lesson' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> Danh sách tập tin bài học
            </a>
            <a href="index_admin.php?page=list_exam"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'list_exam' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> Danh sách đề thi
            </a>
        </div>

    </div>

    <!-- Báo cáo (không có submenu) -->
    <a href="index_admin.php?page=reports"
        class="menu-item <?php echo ($_GET['page'] ?? '') == 'reports' ? 'active' : ''; ?>">
        <i class="fas fa-chart-line"></i> Báo cáo
    </a>

    <!-- Cài đặt -->
    <a href="index_admin.php?page=settings"
        class="menu-item <?php echo ($_GET['page'] ?? '') == 'settings' ? 'active' : ''; ?>">
        <i class="fas fa-cog"></i> Cài đặt
    </a>
</nav>

<!-- <style>
    /* Menu item cơ bản */
    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #ecf0f1;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border-left: 3px solid transparent;
    }

    .menu-item:hover {
        background: #34495e;
        border-left-color: #3498db;
    }

    .menu-item.active {
        background: #34495e;
        border-left-color: #3498db;
        color: #3498db;
    }

    .menu-item i {
        width: 20px;
        margin-right: 10px;
    }

    /* Menu có submenu */
    .menu-item.has-submenu {
        justify-content: space-between;
        position: relative;
    }

    .menu-item.has-submenu .arrow {
        transition: transform 0.3s ease;
        font-size: 12px;
        width: auto;
        margin-right: 0;
    }

    .menu-item.has-submenu.open .arrow {
        transform: rotate(180deg);
    }

    /* Submenu */
    .submenu {
        max-height: 0;
        overflow: hidden;
        background: #1a252f;
        transition: max-height 0.3s ease;
    }

    .submenu.open {
        max-height: 500px;
    }

    .submenu-item {
        display: flex;
        align-items: center;
        padding: 10px 20px 10px 50px;
        color: #bdc3c7;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .submenu-item:hover {
        background: #263a4a;
        color: #ecf0f1;
        border-left-color: #3498db;
    }

    .submenu-item.active {
        background: #263a4a;
        color: #3498db;
        border-left-color: #3498db;
    }

    .submenu-item i {
        width: 16px;
        margin-right: 10px;
        font-size: 14px;
    }

    /* Menu group */
    .menu-group {
        margin-bottom: 5px;
    }
</style> -->

<script>
    $(document).ready(function() {
        // Tự động mở submenu nếu có item con đang active
        $('.menu-item.has-submenu').each(function() {
            var $menuItem = $(this);
            var submenuId = $menuItem.data('submenu');
            var $submenu = $('#' + submenuId);

            // Nếu menu cha active HOẶC có item con active thì mở submenu
            if ($menuItem.hasClass('active') || $submenu.find('.submenu-item.active').length > 0) {
                $submenu.addClass('open');
                $menuItem.addClass('open');
            }
        });
        // Xử lý click vào menu có submenu
        $('.menu-item.has-submenu').on('click', function(e) {
            e.preventDefault();

            var $this = $(this);
            var submenuId = $this.data('submenu');
            var $submenu = $('#' + submenuId);

            // Đóng tất cả submenu khác (bỏ 2 dòng dưới nếu muốn mở nhiều submenu cùng lúc)
            $('.submenu').not($submenu).removeClass('open');
            $('.menu-item.has-submenu').not($this).removeClass('open');

            // Toggle submenu hiện tại
            $submenu.toggleClass('open');
            $this.toggleClass('open');
        });
    });
</script>

<?php
/* 
HƯỚNG DẪN SỬ DỤNG:

1. Để thêm menu mới KHÔNG CÓ submenu:
   <a href="index_admin.php?page=YOUR_PAGE" 
      class="menu-item <?php echo ($_GET['page'] ?? '') == 'YOUR_PAGE' ? 'active' : ''; ?>">
       <i class="fas fa-YOUR-ICON"></i> Tên Menu
   </a>

2. Để thêm menu CÓ submenu:
   <div class="menu-group">
       <div class="menu-item has-submenu <?php echo in_array($_GET['page'] ?? '', ['page1', 'page2']) ? 'active' : ''; ?>"
            data-submenu="unique-menu-id">
           <i class="fas fa-YOUR-ICON"></i> 
           <span>Tên Menu</span>
           <i class="fas fa-chevron-down arrow"></i>
       </div>
       <div class="submenu" id="unique-menu-id">
           <a href="index_admin.php?page=page1" 
              class="submenu-item <?php echo ($_GET['page'] ?? '') == 'page1' ? 'active' : ''; ?>">
               <i class="fas fa-icon1"></i> Submenu 1
           </a>
           <a href="index_admin.php?page=page2" 
              class="submenu-item <?php echo ($_GET['page'] ?? '') == 'page2' ? 'active' : ''; ?>">
               <i class="fas fa-icon2"></i> Submenu 2
           </a>
       </div>
   </div>

3. Lưu ý:
   - data-submenu và id của submenu phải giống nhau
   - Thêm tất cả các page của submenu vào mảng in_array() ở menu cha
   - Mỗi submenu cần có id duy nhất

4. Nếu muốn cho phép mở nhiều submenu cùng lúc:
   - Xóa hoặc comment phần code đóng tất cả submenu khác trong JavaScript

5. Nếu muốn lưu trạng thái đóng/mở menu khi reload trang:
   - Uncomment phần code localStorage trong JavaScript
*/
?>