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
            <!-- Admin: full menu -->
            <div class="sidebar-heading">Quản lý</div>

            <!-- Quản lý sản phẩm -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
                    aria-expanded="true" aria-controls="collapseProducts">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
                <div id="collapseProducts" class="collapse" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sản phẩm:</h6>
                        <a class="collapse-item" href="index_admin.php?page=list_product">Danh sách sản phẩm</a>
                        <a class="collapse-item" href="index_admin.php?page=list_product_category">Danh sách loại sản phẩm</a>
                        <a class="collapse-item" href="index_admin.php?page=list_product_brand">Danh sách nhà cung cấp</a>
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


<div class="sidebar-header">
    <a href="#" class="sidebar-logo">
        <i class="fas fa-crown"></i> AdminPro
    </a>
</div>
<nav class="sidebar-menu">
    <a href="index_admin.php?page=dashboard" class="menu-item active">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="index_admin.php?page=list_user" class="menu-item">
        <i class="fas fa-users"></i> Người dùng
    </a>
    <a href="#" class="menu-item" onclick="loadModule('products')">
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