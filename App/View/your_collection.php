<?php 

    if (!empty($_GET['yourcollection'])) {
        $is_yourman = $_GET['yourcollection'];
        $is_your_info = get_your_info($pdoConnection, $is_yourman);

        if (empty($is_your_info['UserID'])) {
            $_SESSION['not_found'] = true;
            header('location: ../../index.php');
        } elseif (empty($is_your_info['CollectionID'])){
            $_SESSION['not_found'] = true;
            header('location: ../../index.php');
        }
    }
    else{
        $_SESSION['not_found'] = true;
        header('location: ../../index.php');
    }

    if ($is_your_info['BannerImage'] === null) {
        $dis_this =  'none';
    }
    else{
        $dis_this =  'inline-block';
    }

?> 

<!-- =================================START PROFILE================================== -->

<div id="profile_page_user">

    <div class="padding_pf_us">

        <div class="box_img_avt_cover_pfofile">

            <div class="img_cover_profile">
                <img style="display:<?php echo $dis_this; ?>" src="<?php echo COLLECTION_PATH . $is_your_info['BannerImage']; ?>" alt="">
            </div>

            <div class="img_avt_profile">
                <img src="<?php  echo COLLECTION_PATH . $is_your_info['LogoImage']; ?>" alt="">
            </div>
        </div>

        <div class="box_info_user_111">

            <div class="des_name_follo_creator">

                <div class="named_user_55">
                    <?php  echo $is_your_info['Name']; ?>
                </div>

                <div class="creator_coll_details">
                    <div class="cl_rgb">
                        Người tạo
                    </div>
                    <a class="creator_id" href=""><?php  echo $is_your_info['Username']; ?></a>
                </div>
                
                <div class="des_coll_and_profile cl_rgb">
                    <?php  echo $is_your_info['Description']; ?>
                </div>  
            </div>

            <div class="stats_right_box">
                <div class="pad_box_stats">
                    <div class="t_font_number">
                        <div class="cl_rgb">Giá sàn</div>
                        <div>
                            <?php  echo $is_your_info['Floor']; ?> &nbsp; <span>coins</span>
                        </div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Doanh thu</div>
                        <div>
                            <?php  echo $is_your_info['Volume']; ?> &nbsp; <span>coins</span>
                        </div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Tổng sản phẩm</div>
                        <div>
                            <?php  echo $is_your_info['TotalProducts']; ?>
                        </div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Đã bán</div>
                        <div>
                            <?php  echo $is_your_info['Sold']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const bo_margin = document.getElementsByClassName('t_font_number');
                const margin_last = bo_margin[bo_margin.length - 1];
                margin_last.style.marginBottom = '0px';
            </script>

        </div>

 <!-- ==============================CONTAINER PROFILE DETAIL======================================= -->

        <div id="maintain_content_profile" style="margin-top: 30px;">
            <?php 
                renderView('your_product_in_collection');   
            ?>
        </div>
 <!-- ==============================END CONTAINER PROFILE DETAIL======================================= -->

    </div>

</div>

<input id="idcollec_ajax" type="hidden" value="<?php echo $is_yourman; ?>">

<script src="<?php echo SITE_SCRIPT_PATH; ?>yourcollection.js"></script>

<!-- =================================END PROFILE================================== -->
