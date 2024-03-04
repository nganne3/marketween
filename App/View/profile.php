<!-- =================================START PROFILE================================== -->

<?php
    $layne = 'marketween';
    $follow_this = 'follow_this';
    $conte_this = 'Theo dõi';
    $dis_this = 'block';
    if(isset($_SESSION['iduser'])) {
        $layne = $_SESSION['iduser'];
        $get_u_in4 = get_user_info($pdoConnection, $layne);
        $follow_this = 'edit_this_set';
        $conte_this = "Chỉnh sửa trang cá nhân";

        if($get_u_in4['CoverImage'] === null){
            $dis_this = 'none';
        }
    }
    
?>

<div id="profile_page_user">

    <div class="padding_pf_us">

        <div class="box_img_avt_cover_pfofile">
            <div class="img_cover_profile">
                <img style="display:<?php echo $dis_this; ?>" src="<?php echo USER_PATH . $get_u_in4['CoverImage']; ?>" alt="">
            </div>

            <div class="img_avt_profile">
                <img src="<?php  echo USER_PATH . ($_SESSION['avatarus'] ?? ""); ?>" alt="">
            </div>
        </div>

        <div class="box_info_user_111">

            <div class="des_name_follo_creator">
                <div class="named_user_55">
                    <?php echo $get_u_in4['Username']; ?>
                </div>

                <!-- <div class="creator_coll_details">
                    <div class="cl_rgb">
                        Người tạo
                    </div>
                    <a class="creator_id" href="">Johan</a>
                </div> -->
                
                <div class="des_coll_and_profile cl_rgb">
                    <?php echo $get_u_in4['Bio']; ?>                
                </div>  

                <div id="<?php echo $follow_this; ?>" class="follow_btn_pro_coll_25">
                    <?php echo $conte_this; ?>
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
                    <a href="../../App/Model/get_conntent.php?content_profile=exploreProducts" id="click_products_profile" style="color: black;">Sản phẩm</a>
                </div>
                <div class="font-size-18px margin-right-16px cl_rgb">
                    <a href="../../App/Model/get_conntent.php?content_profile=collection_profile" id="click_collections_profile" style="color: rgba(22, 22, 26, 0.6);">Bộ sưu tập</a>
                </div>
                <div class="font-size-18px margin-right-16px cl_rgb">
                    <a href="../../App/Model/get_conntent.php?content_profile=log_sell_profile" id="click_log_sell_profile" style="color: rgba(22, 22, 26, 0.6);">Nhật ký bán</a>
                </div>
            </div>

            <div class="border_bot_run" >
                
            </div>

        </div>

 <!-- ==============================CONTAINER PROFILE DETAIL======================================= -->

        <div id="maintain_content_profile" style="margin-top: 30px;">

        </div>
 <!-- ==============================END CONTAINER PROFILE DETAIL======================================= -->

    </div>

</div>


<script src="<?php echo SITE_SCRIPT_PATH; ?>profile.js"></script>
<script src="<?php echo SITE_SCRIPT_PATH; ?>my_product_url_filter.js"></script>
<script src="<?php echo SITE_SCRIPT_PATH; ?>ft_collections_profile.js"></script>
<script src="<?php echo SITE_SCRIPT_PATH; ?>sell_myproduct.js"></script>


<!-- =================================END PROFILE================================== -->
