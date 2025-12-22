<!-- HTML Structure -->
<nav class="sidebar-menu">
    <div class="sidebar-header">
        <a href="#" class="sidebar-logo">
            <i class="fas fa-crown"></i> DDT
        </a>
    </div>



    <div class="menu-group">
        <div class="menu-item has-submenu <?php echo in_array($_GET['page'] ?? '', ['dashboard']) ? 'active' : ''; ?>"
            data-submenu="settings-menu">
            <i class="fas fa-gear"></i>
            <span>Quản lý website</span>
            <i class="fas fa-chevron-down arrow"></i>
        </div>
        <div class="submenu" id="settings-menu">
            <!-- Dashboard -->
            <a href="index_admin.php?page=dashboard"
                class="submenu-item <?php echo ($_GET['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>


        </div>
    </div>

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

</nav>

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