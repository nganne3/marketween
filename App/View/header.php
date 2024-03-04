<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketween</title>
    
    <link rel="shortcut icon" href="../../Public/Images/Group 230 (1).png" type="image/x-icon">
    <!-- =========================FAVICON============================ -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- =========================BOX ICON============================ -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- =========================GOOGLE FONT============================ -->

    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>style.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>exploreCollections.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>exploreUsers.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>addproduct.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>addgallery.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>home.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>attendance.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>drops.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>productDetails.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>exploreProduct.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>settingProfile.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>profile.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>log_sell.css">

    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>exploreCollectionsduythai.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>exploreUsers_responsive_duythai.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>exploreProducts_responsive_duythai.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>dammelayvoban.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>nhucdau.css">

    <!-- =========================CSS============================ -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- =========================JQUERY============================ -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
    <!-- =========================COLOR-THIER============================ -->

    

</head>

<body id="body">

<!-- ====================================================START HEADER========================================================== -->
<div id="header">
    <div id="container-header">
        <a href="index.php?act=home" id="logo-header">
            <div id="logo">
                <img id="logo-image" src="https://i.pinimg.com/originals/fb/54/84/fb54849f358f7825923f7d0517f3678f.png" alt="">
            </div>
            <div id="text-brand">
                Marketween
            </div>
        </a>
        <div id="search-at-header">
            <input id="barsearch-input" type="text" placeholder="Tìm kiếm tên bộ sưu tập, sản phẩm, người dùng">
            <div id="gachcheo-input-barsearch">
                /
            </div>
        </div>
        <div id="bar-all-click-to-page">
            <div id="create-at-header" class="create-at-header" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'inline-block'; ?>;">
                <div id="create-text-at-header" class="position-relactive">
                    <a href="index.php?act=<?php echo isset($_SESSION['iduser']) ? 'createProduct' : 'login';?>" class="hover-yet-or-not">Tạo</a>
                </div>
                <div class="position-fixed height-hover-create padding-top-20px" id="hover-menu-create">

                    <div class="background-white padding-15px border-radius-12px width-200px show-menu-create menu-xo-at-header" >
                        <a href="index.php?act=<?php echo isset($_SESSION['iduser']) ? 'createProduct' : 'login';?>" class="display-flex align-items-center colmn-gap-20px padding-15px border-radius-12px hover-menu-create">
                            <i class='bx bxs-box'></i>
                            <div>Sản phẩm</div>
                        </a>
                        <a href="index.php?act=<?php echo isset($_SESSION['iduser']) ? 'createCollection' : 'login';?>" class="display-flex align-items-center colmn-gap-20px padding-15px border-radius-12px hover-menu-create">
                            <i class='bx bxs-layer'></i>
                            <div>Bộ sưu tập</div>
                        </a>
                    </div>  

                </div> 
            </div>
            <div id="explore-at-header">
                <div id="explore-text-at-header">
                    <a href="index.php?act=explore&explorepage=exploreCollections" class="hover-yet-or-not">Khám phá</a>
                </div>
                <div class="position-fixed height-hover-create padding-top-20px" id="hover-menu-explore">

                    <div class="background-white padding-15px border-radius-12px width-200px show-menu-create menu-xo-at-header" >
                        <a href="index.php?act=explore&explorepage=exploreProducts" class="display-flex align-items-center colmn-gap-20px padding-15px border-radius-12px hover-menu-create">
                            <i class='bx bxs-box'></i>
                            <div>Sản phẩm</div>
                        </a>
                        <a href="index.php?act=explore&explorepage=exploreCollections" class="display-flex align-items-center colmn-gap-20px padding-15px border-radius-12px hover-menu-create">
                            <i class='bx bxs-layer'></i>
                            <div>Bộ sưu tập</div>
                        </a>
                        <a href="index.php?act=explore&explorepage=exploreUsers" class="display-flex align-items-center colmn-gap-20px padding-15px border-radius-12px hover-menu-create">
                            <i class='bx bxs-user-circle'></i>
                            <div>Người dùng</div>
                        </a>
                    </div>  

                </div> 
            </div>
            <div id="sell-at-header" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'flex'; ?>;">
                <div id="sell-text-at-header" >
                    <a href="index.php?act=<?php echo isset($_SESSION['iduser']) ? 'profile&profile_data=product' : 'login';?>" class="hover-yet-or-not">Bán</a>
                </div>
            </div>
            <div id="collections-at-header">
                <div id="newcollection-text-at-header">
                    <a href="index.php?act=newCollections" class="hover-yet-or-not">Bộ sưu tập mới</a>
                </div>
            </div>
        </div>
        <div id="login-and-bag-of-header">

            <div id="login-at-header" style="display: <?php echo $yet_lg ?>;">
                <div id="text-login-button">
                    <a href="index.php?act=login" class="text-white">Đăng nhập</a>
                </div>
            </div>

            <div class="wallect_coins" style="display: <?php echo $none_flex ?>;">
                <div class="wall_lect_box_t">
                    <span class="wallect_lect_text"><?php echo $_SESSION['Coins'] ?? ""; ?></span>&nbsp;<span class="wallect_lect_text">coins</span>
                </div>
            </div>

            <div style="height: 100%; display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'flex' : 'none'; ?>; align-items:center; font-weight:500" >
                <?php echo $role_marketween; ?>
            </div>

            <div id="userlogined-at-header" class="userlogined-at-header" style="display: <?php echo $none_hien ?>;">
                <div class="overflow-hidden height-width-userlogined-at-header border-radius-50phantram">
                    <img class="width-100-height-100" src="<?php  echo USER_PATH . ($_SESSION['avatarus'] ?? ""); ?>" alt="">
                </div>
            </div>

            <div id="noti-at-header" style="display: <?php echo $none_flex ?>;">
                <i class='bx bxs-bell'></i>
            </div>

            <div id="bag-at-header" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'flex'; ?>;">
                <i class='bx bxs-shopping-bag'></i>
                <div class="index_qtt_bag">
                    1
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ====================================================END HEADER========================================================== -->

<!-- --------------------SHOPPING CART---------------------------- -->
<div id="shopping-cart" data-nm="<?php $login_ex = $_SESSION['iduser'] ?? 'marketween'; echo $login_ex; ?>" class="border-radius-12px position-fixed width-max-content height-max-content margin-16-24">

    <div class="container-3tang display-flex align-items-center padding-16px justify-content-space-between">
        <div class="display-flex align-items-center">
            <div class="font-size-22px margin-right-10px">Sản phẩm</div>
            <div id="quantity-all-cart" class="background-color-red text-white height-max-content font-size-10px padding-for-number-shopping-cart border-radius-3px"> </div>
        </div>
        <div class="display-flex align-items-center">
            <div id="clear_all_pro_in_bag" class="text-not-yet-hover font-size-14px margin-right-10px">Xóa tất cả</div>
            <i id="close-shopping-cart" class='bx bx-x height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px font-size-22px'></i>
        </div>
    </div>

    <div id="container-all-product-at-cart" class="container-3tang padding-16px height-440px overflow-hidden overflow-y-scroll-auto css-for-scroll-of-shoppingcart">

        <!-- <div class="margin-bot-20px display-flex align-items-center justify-content-space-between hide-cart-from-parent-product product-at-shoppingcart this_cart_bag">
            <div class="display-flex align-items-center margin-right-10px">
                <div class="overflow-hidden height-width-56px border-radius-12px margin-right-20px">
                    <img class="width-100-height-100" src="https://i.pinimg.com/originals/1f/76/b6/1f76b6843381436a6567da7dd06337e6.jpg" alt="">
                </div>
                <div class="width-for-in4-product-at-shoppingcart"> 
                    <div class="font-size-18px font-weight-600 hide-text-after-3cham">
                        Sengaku #2020
                    </div>
                    <div class="display-flex align-items-center width-100phantram">
                        <div class="display-flex align-items-center margin-right-20px width-50phantram">
                            <span>Bởi</span>
                            &nbsp;
                            <a class="hide-text-after-3cham width-100phantram">JohanasdadwsadaJs</a>
                        </div>
                        <div class="font-size-10px padding-5px-10px background-color-input border-radius-8px width-50phantram">
                            Âm nhạc
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-100phantram">
                <div class="display-flex align-items-center width-100phantram flex-end price-at-shoppingcart">
                    <span>14</span>
                    &nbsp;
                    <span>coins</span>
                </div>
                <div class="width-100phantram display-flex align-items-center flex-end trash-at-shoppingcart">
                    <i class='bx bxs-trash-alt font-size-22px height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px'></i>
                </div>
            </div>
        </div> -->
        <!-- --------------------------------------- -->

        <div id="have_or_not_pr_in_bag" style="margin:auto; font-size:18px; display:flex; align-items:center; justify-content:center; height:100%;">
            Chưa có sản phẩm nào
        </div>

    </div>

    <div class="container-3tang padding-16px">
        <button id="btn_pm_from_bag" class="btn-destroy background-color-brand width-100phantram border-radius-12px font-size-16px padding-15px-18px font-weight-600 display-flex align-items-center justify-content-center text-white">
            <span>Mua với</span>
            &nbsp;
            <span class="total_price_at_bag">14</span>
            &nbsp;
            <span>coins</span>
        </button>
    </div>

</div>
<!-- --------------------SHOPPING CART---------------------------- -->

<!-- --------------------NOTIFICATIONS---------------------------- -->
<div id="notifications" class="border-radius-12px overflow-hidden position-fixed z-index-9 height-max-content margin-16-24">

    <div class="container-3tang display-flex align-items-center padding-16px justify-content-space-between">
        <div class="display-flex align-items-center">
            <div class="font-size-22px margin-right-10px">Thông báo</div>
        </div>
        <div class="display-flex align-items-center">
            <i id="close-notifications" class='bx bx-x height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px font-size-22px'></i>
        </div>
    </div>

    <div id="container-all-notifications" class="container-3tang padding-16px height-440px overflow-y-scroll-auto css-for-scroll-of-shoppingcart">

    <?php
        
       $noti_this = notifcations($pdoConnection);

       if (is_array($noti_this) && !empty($noti_this)) {
            foreach($noti_this as $nt){

            if ($nt['CollectionID'] !== NULL) {
                $linknot = 'index.php?act=your_collection&yourcollection='.$nt['CollectionID'].'';
                $joanji = ''.COLLECTION_PATH.''.$nt['FeaturedImage'].'';
            }
            else{
                $linknot = 'index.php?act=your_product_detail&pro_dt_id_khach='.$nt['ProductID'].'';
                $joanji = ''.IMAGE_PATH.''.$nt['ImageURL'].'';
            };
    
            echo '
            
            <a href="'.$linknot.'" class="display-flex align-items-center background-color-hover-xam noti-at-table-of-header margin-bot-10px border-radius-12px" href="">
                <div class="hide-cart-from-parent-product product-at-shoppingcart">
                    <div class="display-flex align-items-center">
                        <div class="overflow-hidden height-width-56px border-radius-12px margin-right-20px avt-img-notifications">
                            <img class="width-100-height-100" src="'.$joanji.'" alt="">
                        </div>
                        <div class="width-100phantram"> 
                            <p class="font-size-16px" >
                                <strong>'.$nt['Username'].'</strong> '.$nt['Title'].'
                            </p>
                            <div class="display-flex align-items-center margin-right-20px">
                                <span class="date-time-noti class_sosanhngay">'.$nt['CreatedAt'].'</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            
            ';
        
            }
       }
       else {
            echo '<div style="text-align:center;"> Chưa có thông báo!</div>';
       }
    ?>


        <!-- --------------------------------------- -->

    </div>

</div>
<!-- --------------------NOTIFICATIONS---------------------------- -->

<!-- --------------------MENU USER---------------------------- -->
<div id="menu-user" class="border-radius-12px overflow-hidden height-max-content margin-16-24 position-fixed z-index-9">
    <div class="container-3tang display-flex align-items-center padding-16px justify-content-space-between">
        <div class="display-flex align-items-center">
            <div class="overflow-hidden border-radius-50phantram avt-user-menu-Marketween margin-right-10px">
                <img class="width-100-height-100" src="<?php  echo USER_PATH . ($_SESSION['avatarus'] ?? ""); ?>" alt="">
            </div>
            <div>
                <div class="font-size-22px">
                    <?php echo $_SESSION['Username'] ?? ''; ?>
                </div>
                <div class="font-size-13px color-text-xam">
                    <?php echo $role_marketween; ?>
                </div>
            </div>
        </div>
        <div class="display-flex align-items-center">
            <i id="close-menu-user" class='bx bx-x height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px font-size-22px'></i>
        </div>
    </div>
    <div class="container-3tang padding-16px height-440px overflow-y-scroll-auto css-for-scroll-of-shoppingcart">
        <a href="index.php?act=profile&profile_data=product" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'block'; ?>;">
            Đi đến trang cá nhân 
        </a>
        <a href="index.php?act=admin" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] !== 'admin') ? 'none' : 'block'; ?>;">
            Đi đến trang quản trị
        </a>
        <a href="index.php?act=profile&profile_data=product" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'block'; ?>;">
            Sản phẩm của tôi
        </a>
        <a href="index.php?act=profile&profile_data=collection" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'block'; ?>;">
            Bộ sưu tập của tôi
        </a>
        <a href="index.php?act=profile&profile_data=log_sell" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'block'; ?>;">
            Lịch sử bán
        </a>
        <a href="index.php?act=<?php echo isset($_SESSION['iduser']) ? 'profile&profile_data=product' : 'login';?>" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'block'; ?>;">
            Bán
        </a>
        <a href="index.php?act=settingprofile" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" style="display: <?php echo (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') ? 'none' : 'block'; ?>;">
            Cài đặt tài khoản
        </a>
        <a href="index.php?act=logout" class="not-hover-at-menu cusor-pointer display-block font-size-28px font-weight-500" >
            Đăng xuất
        </a>
    </div>
</div>
<!-- --------------------MENU USER---------------------------- -->

<!-- --------------------BACKDOOR---------------------------- -->
<div id="backdoor-marketween">
</div>
<!-- --------------------BACKDOOR---------------------------- -->

<!-- --------------------ATTENDANCE EVERYDAY--------------------------- -->

<?php 

    $xiao_chen = attendance_basic($pdoConnection); 

    if ($xiao_chen) {
       $time_att = $xiao_chen['PeriodicTime'];
       $coins_att = $xiao_chen['Coins'];
    }
    else{
        $time_att = '00:03:00';
        $coins_att = '0';
    };

    if (isset($_SESSION['iduser'])) {
       $display_att = 'block';
       $che_us = check_att_user($pdoConnection, $_SESSION['iduser']);
       if ($che_us) {
        $che_us = 'okay';
       }else{
        $che_us = 'not';
       }
    }
    else{
        $display_att = 'none';
    }

?>

<!-- ------BUTTON CHECK attendance---------- -->
<div id="attendance-everyday" checkatt="no" style="display: <?php echo $display_att; ?>;">
    <div class="time-unlock-att background-color-brand display-flex align-items-center">

        <input id="check_att_thoima" type="hidden" value="<?php echo $che_us; ?>">

        <input id="time_un_att" type="hidden" value="<?php echo $time_att; ?>">

        <div id="timer-unlock-att">00:00:00</div>
    </div>
    <div class="attendance-user">
        <div class="background-color-brand text-white attendance-central">
            <i id="change-bx-i-time-att" class='bx bxs-calendar-check'></i>
        </div>
        <div class="background-color-red noti-not-check-red"></div>
    </div>
</div>
<!-- ------BUTTON CHECK attendance---------- -->

<!-- ------WINDOWNS CHECK ATTENDANCE------------- -->
<div id="atttendance-windowns-check-question">

    <div class="central-atttendance-windowns-check-question">
        <div class="central-atttendance-windowns-check-question-img overflow-hidden">
            <img class="width-100-height-100" src="<?php echo SITE_IMAGES_PATH ?>att1.jpg" alt="">
        </div>
        <div class="central-atttendance-windowns-check-question-inf">
            <div class="atttendance-windowns-check-question-inf-central">
                <div class="font-size-28px display-flex justify-content-center margin-bot-20px font-weight-600">
                    Điểm danh mỗi ngày
                </div>
                <div class="display-flex justify-content-center margin-bot-20px" style="margin-bottom: 30px;">
                    Điểm danh để nhận một lượng coins miễn phí
                </div>
                <div id="btn-checknow" class="display-flex justify-content-center background-color-brand">
                    <input id="click_take_coins" type="hidden" value="<?php echo $coins_att; ?>">
                    Điểm danh ngay
                </div>
                <div id="btn-tubo" class="display-flex justify-content-center">
                    Thôi vậy
                </div>
            </div>
        </div>
    </div>

</div>

<div id="atttendance-windowns-check-done">
    <div class="central-atttendance-windowns-check-question">
        <div class="central-atttendance-windowns-check-question-img overflow-hidden">
            <img class="width-100-height-100" src="<?php echo SITE_IMAGES_PATH ?>att2.jpg" alt="">
        </div>
        <div class="central-atttendance-windowns-check-question-inf">
            <div class="atttendance-windowns-check-question-inf-central">
                <div class="font-size-28px display-flex justify-content-center margin-bot-20px font-weight-600">
                    Bạn nhận được &nbsp;<span class="quantity-coins-get"><?php echo $coins_att; ?></span> &nbsp; <span class="quantity-coins-get">coins</span>
                </div>
                <div class="display-flex justify-content-center margin-bot-20px" style="margin-bottom: 30px; text-align: center; padding: 0 10px;">
                    Bạn có thể sử dụng số Coins này để tham gia các họat động trả phí tại Marketween
                </div>
                <div id="btn-checkdone" class="display-flex justify-content-center background-color-brand font-weight-500">
                    Cảm ơn
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ------WINDOWNS CHECK ATTENDANCE------------- -->

<!-- -------------------ATTENDANCE EVERYDAY--------------------------- -->

<!-- -------------------CONFIG PAYMENT--------------------------- -->
<div id="config-payment-window">
    <div class="pad-central-conf-pr">

        <div class="display-flex align-items-center justify-content-space-between margin-bot-20px">
            <div class="display-flex align-items-center">
                <div class="font-size-22px margin-right-10px">Xác nhận thanh toán</div>
            </div>
            <div class="display-flex align-items-center">
                <i id="close-conf-pm-window" class='bx bx-x height-width-40px display-flex align-items-center justify-content-center background-color-hover-xam border-radius-12px font-size-22px'></i>
            </div>
        </div>
    
        <div id="container_pr_config" class="container-pro-for-config margin-bottom-20px css-for-scroll-of-shoppingcart">
            <!-- <div class="pr-conf">
                <a class="display-flex align-items-center justify-content-space-between pr-conf-padd hover-menu-create">
                    <div class="display-flex align-items-center khu-in4-pr-conf">
                        <div class="overflow-hidden img-pr-config">
                            <img class="width-100-height-100" src="https://cdn.discordapp.com/attachments/1071839285445132370/1071846490663813191/michaellima_Deus_em_seu_trono_de_gloria_0dd5daf2-7980-48ab-b4cc-c1d8c67490e1.png" alt="">
                        </div>
                        <div class="khu-in4-pr-conf">
                            <p class="font-size-18px font-weight-500">Sengaku #2020</p>
                            <div class="display-flex align-items-center">
                                <p class="margin-right-10px display-block">Bởi Johan</p>
                                <div class="sound-pad">Âm nhạc</div>
                            </div>
                        </div>
                    </div>
                    <div class="display-flex align-items-center">
                        <div>
                            14
                        </div>
                        &nbsp;
                        <div>
                            coins
                        </div>
                    </div>
                </a>

            </div> -->
            <!-- -------------------------------------------------- -->
        </div>

        <div class="display-flex align-items-center colmn-gap-12px">
            <div id="accp_bought" class="width-100phantram display-flex justify-content-center btn-bought-or-back background-color-brand text-white border-radius-12px cusor-pointer">
                Mua ngay
            </div>
            <div id="not_payment" class="width-100phantram display-flex justify-content-center combo-border-xam border-radius-12px btn-bought-or-back cusor-pointer">
                Thôi vậy
            </div>
        </div>
    </div>

</div>
<!-- -------------------CONFIG PAYMENT--------------------------- -->

<!-- -------------------SUCCESS PAYMENT--------------------------- -->
<div id="success-payment">
    <div class="background-white border-radius-12px pad-central-success-pay">
        <div class="icon-success">
            <i class='bx bxs-check-circle' ></i>
        </div>
        <div class="font-size-28px font-weight-600 text-align-center margin-bot-20px">
            Thanh toán thành công!
        </div>
        <div class="text-align-center margin-bottom-30px">
            Hãy kiểm tra email đã liên kết với  tài khoản để nhận đường dẫn liên kết đến nơi lưu trữ file của sản phẩm.
        </div>
        <div id="i_understand" class="background-color-brand text-align-center text-white btn-understand cusor-pointer">
            Tôi hiểu rồi
        </div>
    </div>
</div>
<!-- -------------------SUCCESS PAYMENT--------------------------- -->

<!-- -------------------SELL MY PRODUCTS--------------------------- -->

<div id="sell_my_products_at_profile">
    <div class="padding_sell_my">
        <div class="box_info_myproduct_sell">
            <div class="img_my_sales_products">
                <img id="src_sale_mypr" src="https://i.pinimg.com/originals/a7/7a/7e/a77a7e8f045ef2d9da8814fe61068b2e.jpg" alt="">
            </div>
            <div class="cothe_info">
                <div id="tensanpham_biban" class="name_mypro_this_sell" style="font-weight: 500; font-size:18px;">
                    Align #244
                </div>
                <div class="tang_ozon">
                    <span style="color:grey;">Bộ sưu tập</span>&nbsp;<span id="tenbosuutap_banchung">OZON MAZ</span> 
                </div>
            </div>
        </div>

        <div class="sell_input_box">
            <div class="dat_mot_cai_gia">
                Đặt một mức giá
            </div>

            <div class="input_hop_sell_okay" id="thang12_1">
                <div class="central_input_box_sell">
                    <input id="set_sales_myproduct_profile_this" type="number" value="" placeholder="Nhập giá">
                </div>
                <div class="coins_curren_sell">
                    coins
                </div>
            </div>

            <div id="er_google_price_mysell" class="box_error_price_sell">
                <i class='bx bx-error-circle'></i>
                <span> </span>
            </div>
            
            <br>

            <div class="dat_mot_cai_gia">
                Bắt buộc bổ sung nếu chưa có
            </div>

            <div class="input_hop_sell_okay" id="thang12_2">
                <div class="central_input_box_sell">
                    <input id="set_driver_myproduct_profile_this" type="text" value="" placeholder="Đường dẫn Google Driver">
                </div>
            </div>

            <div id="er_google_driver_mysell" class="box_error_price_sell">
                <i class='bx bx-error-circle'></i>
                <span> </span>
            </div>
        </div>

        <button class="banluonemnay disabled" id="ban_luon_em_nay">
            Xác nhận bán với mức giá này
        </button>
        <button class="khongsales_nua" id="not_sales_okay">
            Thôi vậy
        </button>

        <input id="value_product_jeu" type="hidden" value="">
        <input id="file_product_jeu" type="hidden" value="">
    </div>
</div>

<!-- -------------------SELL MY PRODUCTS--------------------------- -->

<!-- -------------------HUY SALES---------------------------------- -->
<div id="destroy_sales">
    
    <div class="padding_sell_my">
        <!-- <div class="box_info_myproduct_sell">
            <div class="img_my_sales_products">
                <img id="src_sale_mypr" src="https://i.pinimg.com/originals/a7/7a/7e/a77a7e8f045ef2d9da8814fe61068b2e.jpg" alt="">
            </div>
            <div class="cothe_info">
                <div id="tensanpham_biban" class="name_mypro_this_sell huybanname" style="font-weight: 500; font-size:18px;">
                    Align #244
                </div>
                <div class="tang_ozon">
                    <span style="color:grey;">Bộ sưu tập</span>&nbsp;<span id="tenbosuutap_banchung">OZON MAZ</span> 
                </div>
            </div>
        </div> -->

        <div style="font-size: 30px; font-weight:600; margin-bottom:30px;">
            Hủy bán sản phẩm
        </div>

        <div class="sell_input_box">
            <div class="dat_mot_cai_gia">
                Xác nhận hủy bán? Nếu xác nhận sản phẩm của bạn sẽ không còn được niêm yết, và bạn có thể phải thiết lập mức giá mới nếu muốn bán nó trở lại.
            </div>
        </div>

        <button class="banluonemnay" id="huyban_okay">
            Xác nhận hủy bán
        </button>
        <button class="khongsales_nua" id="debantiep">
            Thôi vậy
        </button>

        <input id="huy_id_prices" type="hidden" value="">
        <!-- <input id="file_product_jeu" type="hidden" value=""> -->
    </div>
</div>
<!-- -------------------HUY SALES---------------------------------- -->