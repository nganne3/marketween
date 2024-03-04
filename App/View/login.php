<?php

    session_start();
    ob_start();

    if(isset($_SESSION['login'])) { 
        unset($_SESSION['login']); 
    }

    include "../../Config/database.php";
    include "../../Config/paths.php";

    $class1 ="";
    $class2 ="";
    $titlePage = "";
    $desPage = "";
    if (isset($_GET['pagelogin'])){
        $pagename = $_GET['pagelogin'];
        if ($pagename == "login") {
            $class1 = "chu-mau-den border-bot-4px-solid-den";
            $class2 ="color-text-xam";
            $titlePage = "Đăng nhập";
            $desPage = "Nếu bạn đã có một tài khoản hay đăng nhập ngay bây giờ";
        }
        elseif($pagename == "signup"){
            $class2 ="chu-mau-den border-bot-4px-solid-den";
            $class1 ="color-text-xam";
            $titlePage = "Đăng ký";
            $desPage = "Tạo một tài khoản để khám phá các hoạt động hấp dẫn";
        }
        else{
            $class1 = "chu-mau-den border-bot-4px-solid-den";
            $class2 ="color-text-xam";
            $titlePage = "Đăng nhập";
            $desPage = "Nếu bạn đã có một tài khoản hay đăng nhập ngay bây giờ";
        }
    } else {
        $pagename = "";
        $class1 = "chu-mau-den border-bot-4px-solid-den";
        $class2 ="color-text-xam";
        $titlePage = "Đăng nhập";
        $desPage = "Nếu bạn đã có một tài khoản hay đăng nhập ngay bây giờ";
    }

    if (isset($_GET['backhome'])){
        header('location: ../../index.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="shortcut icon" href="../../Public/Images/Group 230 (1).png" type="image/x-icon">
    <!-- =========================FAVICON============================ -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- =========================BOX ICON============================ -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- =========================GOOGLE FONT============================ -->

    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>style.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>login.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>responsive.css">
    <!-- =========================CSS============================ -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- =========================JQUERY============================ -->
</head>

<body >

    <div id="container">

        <div class="display-flex">

            <div id="banner">
                <div class="overflow-hidden quyetdinh-ronganh">
                    <img id="banner-img" style="width: 100%; height:100%;" src="https://i.pinimg.com/originals/c7/a0/27/c7a0277a75fa2b3ca857f2ba7ccd929b.jpg"  alt="">
                </div>
                <a href="login.php?backhome" id="logo">
                    <div class="img-box">
                        <img src="https://i.pinimg.com/originals/fb/54/84/fb54849f358f7825923f7d0517f3678f.png">
                    </div>
                    <div class="name-brand-logo">Marketween</div>
                </a>
            </div>

            <div id="form">
                <div id="form-child">
                    <div id="login-title" style="font-size: 40px; font-weight:600;margin-bottom:20px;">
                        <?php echo $titlePage; ?>
                    </div>

                    <div id="login-des" style="font-size: 20px; margin-bottom:40px;">
                        <?php echo $desPage; ?>
                    </div>

                    <div id="login-option" style="margin-bottom: 30px;">

                        <a href="login.php?pagelogin=login" class="<?php echo $class1; ?>" id="login-btn">
                            Đăng nhập
                        </a>
                        <a href="login.php?pagelogin=signup" class="<?php echo $class2; ?>" id="regis-btn">
                            Đăng ký
                        </a>
                    </div>
                    
                    <?php
                        
                        $html_lg = '
                        <div class="login-form" id="login-form">    
                                    
                            <div class="box_have_er">
                                <div class="padding_input border_not">
                                    <input id="email_dangnhap" type="text" placeholder="Địa chỉ email" >
                                </div>
                                <div class="form_flex">
                                    <span id="p_er_emaildangnhap" class="the_p_lgsn"> </span>
                                    <i id="icon_er_emaildangnhap" class="bx bxs-error-circle"></i>
                                </div>
                            </div>

                            <div class="box_have_er">
                                <div class="padding_input border_not">
                                    <input id="pass_dangnhap" type="password" placeholder="Mật khẩu" >
                                </div>
                                <div class="form_flex">
                                    <span id="p_er_passdangnhap" class="the_p_lgsn"> </span>
                                    <i id="icon_er_passdangnhap" class="bx bxs-error-circle"></i>
                                </div>
                            </div>
            
                            <a style="font-size: 14px; text-decoration: none; color:#5E17EB;padding-left:20px; margin-bottom: 20px;" href="">Bạn quên mật khẩu?</a>
            
                            <button id="btn-login" class="padding-18px Azdg disabled_btn" style="color:white;" id="btn-login">Đăng nhập</button>
                        </div> ';

                        $html_sn = '
                        <div class="login-form" id="regis-form">
                            <div class="box_have_er">
                                <div class="padding_input border_not">
                                    <input id="ten_account_sn" type="text" placeholder="Tên tài khoản" class="border_not">
                                </div>
                                <div class="form_flex">
                                    <span id="er_sn_name" class="the_p_lgsn"> </span>
                                    <i id="icon_er_sn_name" class="bx bxs-error-circle"></i>
                                </div>
                            </div>

                            <div class="box_have_er">
                                <div class="padding_input border_not">
                                    <input id="email_sn_sn" type="text" placeholder="Địa chỉ email" class="border_not">
                                </div>
                                <div class="form_flex">
                                    <p id="er_sn_email" class="the_p_lgsn"> </p>
                                    <i id="icon_er_sn_email" class="bx bxs-check-circle"></i>
                                </div>
                            </div>

                            <div class="box_have_er"> 
                                <div class="padding_input border_not">
                                    <input id="nhappass_sn" type="password" placeholder="Mật khẩu" class="border_not">
                                </div>
                                <div class="form_flex">
                                    <p id="er_sn_pass" class="the_p_lgsn"> </p>
                                    <i id="icon_er_sn_pass" class="bx bxs-check-circle "></i>
                                </div>
                            </div>

                            <span class="check-error-input"> Mật khẩu phải có ít nhất 6 ký tự </span>

                            <div class="box_have_er "> 
                                <div class="padding_input border_not">
                                    <input id="nhaplaipass_sn" type="password" placeholder="Nhập lại mật khẩu">
                                </div>
                                <div class="form_flex">
                                    <p id="er_sn_again_pass" class="the_p_lgsn"> </p>
                                    <i id="icon_er_sn_again_pass" class="bx bxs-check-circle "></i>
                                </div>
                            </div>

                            <div style="margin-bottom:20px; padding-left:20px; font-size:14px;"> 
                                Bằng cách tạo tại khoản, bạn đồng ý với Điều kiện sử dụng và Thông báo quyên riêng tư của Marketween 
                            </div>

                            <button id="btn-signup" class="Azdg disabled_btn">Đăng ký</button>
                        </div>        
                        ';

                        if ($pagename == 'login') {
                            echo $html_lg;
                        }
                        elseif($pagename == 'signup'){
                            echo $html_sn;
                        }
                        else{
                            echo $html_lg;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo SITE_SCRIPT_PATH; ?>signup.js"></script>
    <script src="<?php echo SITE_SCRIPT_PATH; ?>login.js"></script>
</body>
</html>