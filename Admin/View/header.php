<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản lý Marketween - Tổng quan</title>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- boxicon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">   
    <!-- Layout styles -->
    <link rel="stylesheet" href="../Public/Css/forAdmin/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo ADMIN_IMAGES_PATH; ?>images/logo_circle.png" />
  </head>
  <body>

    <div class="container-scroller">
<!-- --------------------HEADER---------------------------- -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="index.php?actad=home"><img src="<?php echo ADMIN_IMAGES_PATH; ?>images/logo_marketween.png" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="bx bx-menu"></span>
          </button>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="../Public/Images/forAdmin/images/faces/face1.jpg" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">Nguyễn Ngân</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#">
                  <i class="bx bx-arrow-to-right me-2 text-success"></i> Về trang chủ </a>
                <a class="dropdown-item" href="#">
                  <i class="bx bxs-cog me-2 text-secondary"></i> Cài đặt tài khoản </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="bx bx-log-out me-2 text-primary"></i> Đăng xuất </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="bx bx-menu"></span>
          </button>
        </div>
      </nav>
<!-- --------------------HEADER---------------------------- -->
