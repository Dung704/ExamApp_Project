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