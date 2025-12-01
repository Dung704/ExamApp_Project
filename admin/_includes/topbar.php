 <?php
    $maNV = $_SESSION["Ma_nhan_vien"];
    $query_TenTK = "select Ten_nhan_vien from nhan_vien where Ma_nhan_vien = '$maNV'";
    $query_TenTK_result = mysqli_query($conn, $query_TenTK);
    $tenTK = mysqli_fetch_assoc($query_TenTK_result);
    ?>
 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
     <!-- Sidebar Toggle (Topbar) -->
     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>

     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">
         <!-- Nav Item - Search Dropdown (Visible Only XS) -->
         <div class="topbar-divider d-none d-sm-block"></div>
         <!-- Nav Item - User Information -->
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">

                 <span class="mr-2 d-none d-lg-inline text-gray-600 small">Xin chào <?php echo $tenTK['Ten_nhan_vien'] ?> </span>
                 <img class="img-profile rounded-circle" src="../_assets/admin/img/undraw_profile.svg" />
             </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 <a class="dropdown-item" href="../user/index.php">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Về trang chủ shop
                 </a>
                 <a class="dropdown-item" href="../user/logout.php" data-toggle="modal" data-target="#logoutModal">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Đăng xuất
                 </a>
             </div>
         </li>
     </ul>
 </nav>