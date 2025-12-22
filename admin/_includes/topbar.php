 <?php
    $ho_ten =  $_SESSION['ho_ten'];
    $anh_dai_dien =  $_SESSION['anh_dai_dien'];
    ?>
 <button class="toggle-btn" onclick="toggleSidebar()">
     <i class="fas fa-bars"></i>
 </button>
 <div class="user-profile">
     <span>Xin chào <?= $ho_ten ?></span>
     <div class="user-avatar">
         <img src="../user/image_user/<?= $anh_dai_dien ?>" alt="">
     </div>
 </div>