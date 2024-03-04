<?php
// Lấy tên action từ URL (ví dụ: actad=user từ index.php?actad=user)
$currentAction = isset($_GET['actad']) ? $_GET['actad'] : 'home';
?>
<!-- =======================SIDER BAR============================= -->
<div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item <?php echo $currentAction === 'home' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=home">
                <span class="menu-title" style="color: black;">Tổng quan</span>
                <i class='bx bxs-home menu-icon'></i>
              </a>
            </li>
            <li class="nav-item <?php echo $currentAction === 'user' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=user">
                <span class="menu-title" style="color: black;">Tài khoản</span>
                <i class='bx bxs-user menu-icon'></i>
              </a>
            </li>
            <li class="nav-item <?php echo $currentAction === 'categories' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=categories">
                <span class="menu-title" style="color: black;">Danh mục</span>
                <i class='bx bxs-category menu-icon' ></i>
              </a>
            </li>
            <li class="nav-item <?php echo $currentAction === 'products' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=products">
                <span class="menu-title" style="color: black;">Sản phẩm</span>
                <i class='bx bxs-image-alt menu-icon'></i>
              </a>
            </li>
            <li class="nav-item <?php echo $currentAction === 'collections' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=collections">
                <span class="menu-title" style="color: black;">Bộ sưu tập</span>
                <i class='bx bxs-folder menu-icon'></i>
              </a>
            </li>
            <li class="nav-item <?php echo $currentAction === 'comments' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=comments">
                <span class="menu-title" style="color: black;" >Bình luận</span>
                <i class='bx bxs-comment menu-icon'></i>
              </a>
            </li>
            <li class="nav-item <?php echo $currentAction === 'attendance' ? 'active' : ''; ?>">
              <a class="nav-link" href="index.php?actad=attendance" >
                <span class="menu-title" style="color: black;">Nhật ký điểm danh</span>
                <i class='bx bx-history menu-icon'></i>
              </a>
            </li>
          </ul>
        </nav>
    <!-- partial -->