<div class="menu-group">
    <div class="menu-item has-submenu <?php echo in_array($_GET['page'] ?? '', ['dashboard']) ? 'active' : ''; ?>"
        data-submenu="settings-menu">
        <i class="fas fa-settings"></i>
        <span>Quản lý người dùng</span>
        <i class="fas fa-chevron-down arrow"></i>
    </div>
    <div class="submenu" id="settings-menu">
        <a href="index_admin.php?page=list_settings"
            class="submenu-item <?php echo ($_GET['page'] ?? '') == 'list_settings' ? 'active' : ''; ?>">
            <i class="fas fa-list"></i> Danh sách người dùng
        </a>
        <a href="index_admin.php?page=add_settings"
            class="submenu-item <?php echo ($_GET['page'] ?? '') == 'add_settings' ? 'active' : ''; ?>">
            <i class="fas fa-settings-plus"></i> Thêm người dùng
        </a>

    </div>
</div>