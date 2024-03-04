<!-- =================================START PROFILE================================== -->

<?php

    $layne = '';
    $dis_this = 'block';

    if (!empty($_GET['profile_id'])) {
        $layne = $_GET['profile_id'];
        $get_u_in4 = get_user_info($pdoConnection, $layne);

        if($get_u_in4['CoverImage'] === null){
            $dis_this = 'none';
        };

        if (empty($get_u_in4['UserID'])) {
            $_SESSION['not_found'] = true;
            header('location: ../../index.php');
        }
    }
    else{
        $_SESSION['not_found'] = true;
        header('location: ../../index.php');
    }


    $margin_left = '0px';
    $width = '80px';
    $p_b = 'black';
    $c_b = 'rgba(22, 22, 26, 0.6)';

    if ($_GET['data_your_pro5'] === 'your_product_in_profile') {
        $margin_left = '0px';
        $width = '80px';
        $p_b = 'black';
        $c_b = 'rgba(22, 22, 26, 0.6)';
    }
    elseif($_GET['data_your_pro5'] === 'your_collection_in_profile'){
        $margin_left = '96px';
        $width = '90px';
        $p_b = 'rgba(22, 22, 26, 0.6)';
        $c_b = 'black';
    }

?>

<div id="profile_page_user">

    <div class="padding_pf_us">

        <div class="box_img_avt_cover_pfofile">
            <div class="img_cover_profile">
                <img style="display:<?php echo $dis_this; ?>" src="<?php echo USER_PATH . $get_u_in4['CoverImage']; ?>" alt="">
            </div>

            <div class="img_avt_profile">
                <img src="<?php echo USER_PATH . $get_u_in4['AvatarImage']; ?>" alt="">
            </div>
        </div>

        <div class="box_info_user_111">

            <div class="des_name_follo_creator">
                <div class="named_user_55">
                    <?php echo $get_u_in4['Username']; ?>
                </div>

                <div class="des_coll_and_profile cl_rgb">
                    <?php echo $get_u_in4['Bio']; ?>                
                </div>  

                <div id="follow_this_khach" class="follow_btn_pro_coll_25">
                    Theo dõi
                </div>
            </div>

            <div class="stats_right_box">
                <div class="pad_box_stats">
                    <div class="t_font_number">
                        <div class="cl_rgb">Được theo dõi</div>
                        <div><?php echo $get_u_in4['followers']; ?></div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Đang theo dõi</div>
                        <div><?php echo $get_u_in4['following']; ?></div>
                    </div>
                </div>
            </div>

            <script>
                const bo_margin = document.getElementsByClassName('t_font_number');
                const margin_last = bo_margin[bo_margin.length - 1];
                margin_last.style.marginBottom = '0px';
            </script>

        </div>

        <div class="bar_detail_pro_css">

            <div class="flex_box_a_main">
                <div class="font-size-18px margin-right-16px">
                    <a href="index.php?act=your_profile&profile_id=<?php echo $layne; ?>&data_your_pro5=your_product_in_profile" class="muc_url" style="color: <?php echo $p_b ?>;">Sản phẩm</a>
                </div>
                <div class="font-size-18px margin-right-16px cl_rgb">
                    <a href="index.php?act=your_profile&profile_id=<?php echo $layne; ?>&data_your_pro5=your_collection_in_profile" class="muc_url" style="color: <?php echo $c_b ?>;">Bộ sưu tập</a>
                </div>
            </div>

            <div class="border_bot_run" style="margin-left: <?php echo $margin_left ?>; width: <?php echo $width ?>;">
                
            </div>

        </div>

 <!-- ==============================CONTAINER PROFILE DETAIL======================================= -->

        <div id="maintain_content_profile" style="margin-top: 30px;">

            <?php
            
                if (!empty($_GET['data_your_pro5'])) {
                    if ($_GET['data_your_pro5'] === 'your_collection_in_profile' || $_GET['data_your_pro5'] === 'your_product_in_profile') {
                        $name_page = $_GET['data_your_pro5'];
                        renderView($name_page);
                    }
                    else{
                        $_SESSION['not_found'] = true;
                        header('location: ../../index.php');
                    }
                };

            ?>

        </div>
 <!-- ==============================END CONTAINER PROFILE DETAIL======================================= -->
    </div>
    
</div>


<script src="<?php echo SITE_SCRIPT_PATH; ?>your_profile.js"></script>
<script src="<?php echo SITE_SCRIPT_PATH; ?>your_product_url_filter.js"></script>

<script src="<?php echo SITE_SCRIPT_PATH; ?>your_ft_collections_profile.js"></script>

<!-- =================================END PROFILE================================== -->
