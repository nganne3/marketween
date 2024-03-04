<?php 

$cl_pr1 = 'fter_priced';
$cl_pr2 = 'fter_unpriced';
$cl_pr11 = 'fter_all_ced';

$cl_pr3 = 'fter_sound';
$cl_pr4 = 'fter_video';
$cl_pr5 = 'fter_img';
$cl_pr12 = 'fter_all_cate';

$cl_pr6 = 'fter_trend';
$cl_pr7 = 'fter_ascprice';
$cl_pr8 = 'fter_descprice';

$cl_pr9 = 'fter_checkprice';

$hayquata = '';


?>

<!-- ==============================================START EXPLORE PRODUCT PAGE================================================ -->
<div id="expoloreProduct-Page">
        <!-- ----------------SEARCH SELECT-------------------- -->
        <div class="search-and-select-154">
            <div class="search-154 search_reponsive3_duythai">
                <i class='bx bx-search' ></i>
                <input type="text" placeholder="Tìm kiếm tên sản phẩm">
            </div>
            <div id="<?php echo $hayquata; ?>" class="dropdown-select-box145">
                <div class="dropdown-select-box145-display-flex">
                    <div id="order_expro" class="dropdown-select-box145-display-flex-text">
                        Xu hướng
                    </div>
                    <i class='bx bx-chevron-down'></i>
                </div>
                <div id="myDropdownexplore" class="dropdown-select-box145-content">
                  <a id="trend_expro" class="<?php echo $cl_pr6; ?>">Xu hướng</a>
                  <a id="price_asc_expro" class="<?php echo $cl_pr7; ?>">Giá từ thấp đến cao</a>
                  <a id="price_desc_expro" class="<?php echo $cl_pr8; ?>">Giá từ cao đến thấp</a>
                </div>             
            </div>
            
        </div>
         <!-- ----------------SEARCH SELECT-------------------- -->
        <div class="bar-and-items-products-154">
            <!-- ---------------------BAR LEFT------------------------ -->
            <div class="hop-box-bar-left huy-border_responsive3_duythai border_moi_ressponsive3_duythai">
                <div class="hop-box-bar-left-padding max-width_responsive3_duythai">
                    <div class="border-bottom-solid-bar-left display-flex_reponsive3_duythai align-items_ressponsive3_duythai border-bottom-solid-bar-left_responsive3_duythai">
                        <div class="titile-box-left-bar fontsize_responsive3_duythai">
                            Trạng thái
                        </div>
                        <div class="flex-box-left-bar-the-a ">
                            <div id="tatca-expro-pri" class="the-a-box-left-bar padding-den-nen un_or_priced_btn padding_ressponsive3_duythai font-size_duythai3_responsive <?php echo $cl_pr11; ?>">
                                <input type="hidden" value="all_price">
                                Tất cả
                            </div>
                            <div id="dangban-expro-pri" class="the-a-box-left-bar padding-xamn-nen un_or_priced_btn padding_ressponsive3_duythai <?php echo $cl_pr1; ?>">
                                <input type="hidden" value="priced">
                                Đang bán
                            </div>
                            <div id="chuaban-expro-pri" class="the-a-box-left-bar padding-xamn-nen un_or_priced_btn padding_ressponsive3_duythai <?php echo $cl_pr2; ?>">
                                <input type="hidden" value="unpriced">
                                Chưa bán
                            </div>
                        </div>
                    </div>

                    <!-- --------------------------------- -->
                    <div class="border-bottom-solid-bar-left display-flex_reponsive3_duythai align-items_ressponsive3_duythai border-bottom-solid-bar-left_responsive3_duythai">
                        
                        <div class="titile-box-left-bar fontsize_duythai_responsive3">
                            Giá
                        </div>

                        <div class="flex-box-left-bar-the-input">

                            <input id="min_pric_expro" type="number" class="input-box-left-bar input-box-left-bar_responsive3_duythai" placeholder="Min">

                            <span class="span_responsive3_duythai" >
                                -
                            </span>

                            <input id="max_price_expro" type="number" class="input-box-left-bar input-box-left-bar_responsive3_duythai" placeholder="Max">

                            <div class="input-box-left-bar display-flex justify-content-center click-tim-btn-left-bar btn-tim-price khac_input-box-left-bar_responsive3_duythai <?php echo $cl_pr9; ?>"  style="font-weight: 500;">
                                Tìm
                            </div>
                        </div>

                    </div>

                    <!-- --------------------------------- -->
                    
                    <div class="border-bottom-solid-bar-left huy-bottom-border display-flex_reponsive3_duythai align-items_ressponsive3_duythai border-bottom-solid-bar-left_responsive3_duythai">
                        <div class="titile-box-left-bar fontsize_duythai_responsive3 padding_right_responsive3_duythai">
                            Kiểu
                        </div>
                        <div class="flex-box-left-bar-the-a">
                            <div id="explo-tatcadanhmuc" class="the-a-box-left-bar padding-den-nen ctgr-btn_all padding_ressponsive3_duythai font-size_duythai3_responsive <?php echo $cl_pr12; ?>">
                                <input type="hidden" value="all_category">
                                Tất cả
                            </div>

                            <?php

                            global $pdoConnection;
                            
                            $cate_show = cate_show($pdoConnection);
                            $phattrien = 3;
                            foreach($cate_show as $ct){
                                extract($ct, EXTR_PREFIX_ALL, 'ctgory');
                                
                                echo '
                                
                                <div id="explo-ctgory-'.$ctgory_CategoryID.'" class="padding_duythai3_responsive the-a-box-left-bar padding-xamn-nen ctgr-btn_'. $ctgory_CategoryID .' '.${'cl_pr' . $phattrien}.'">
                                    <input type="hidden" value="'. $ctgory_CategoryID .'" >
                                    '. $ctgory_Name .'
                                </div>
                
                                ';

                                $phattrien++;
                            }
                            ?>
                        </div>
                    </div>
                    

                    <!-- --------------------------------- -->
                </div>
            </div>
            <!-- ---------------------BAR LEFT------------------------ -->

            <!-- ---------------------lIST ITEMS------------------------ -->
            <div class="list-items-dantrang">
                <div id="expro_show_list" class="dantrangmoi-container-pr">
                    <?php

                        $is_your_collection = $_GET['yourcollection'];

                        $exPro = get_your_is_products($pdoConnection, $is_your_collection);
                        $displayex = "";
                        $cartexNone = "";
                        
                        $login_ex = $_SESSION['iduser'] ?? 'marketween';

                        if (is_array($exPro) && !empty($exPro)) {
                            foreach($exPro as $k){
                                extract($k, EXTR_PREFIX_ALL, 'exProlore');
                                if ($exProlore_ListedPrice == 0 || $exProlore_ListedPrice == null) {
                                    $displayex = "<span>Chưa mở bán</span>";
                                    $cartexNone = "";
                                }
                                else{
                                    $displayex = "<span>Giá:</span> &nbsp; 
                                                <span johan='cc' class='result_format'> $exProlore_ListedPrice </span> 
                                                <span class='vo_K_curn'></span>&nbsp;
                                                <span class='who_curn'>Coins</span>";
                                    $cartexNone = 
                                    '
                                        <div class="display-flex justify-content-center box-add-to-cart-this-pro">
                                            <div class="display-flex align-items-center ">
                                                <input class="idpro_ex" type="hidden" value="'. $exProlore_ProductID .'">
                                                <input class="name_ex" type="hidden" value="'. $exProlore_Name .'">
                                                <input class="username_ex" type="hidden" value="'. $exProlore_Username .'">
                                                <input class="category_ex" type="hidden" value="'. $exProlore_namecate .'">
                                                <input class="price_ex" type="hidden" value="'. $exProlore_ListedPrice .'">
                                                <input class="img_ex" type="hidden" value="'. IMAGE_PATH .''. $exProlore_ImageURL .'">
                                                <input class="login_ex" type="hidden" value="'. $login_ex .'">
                                                <div class="btn-buy-now-this-pro">
                                                    Mua
                                                </div>
                                                <div class="btn-add-cart products_at_expro">
                                                    <i class="bx bx-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }
                                echo '    
                                    <div class="items-pr-tang-thuong-154" data-id="'. $exProlore_ProductID .'">
                                        <div class="items-pr-154">
                                            <div class="items-pr-154-t1">
                                                <a class="items-pr-154-t2" href="index.php?act=your_product_detail&pro_dt_id_khach='. $exProlore_ProductID .'">
                                                    <div class="items-pr-154-t2-img">
                                                        <img src="'. IMAGE_PATH .''. $exProlore_ImageURL .'" alt="">
                                                        '. $cartexNone .'
                                                    </div>
                                                    <div class="items-pr-154-t2-text">
                                                        <div class="items-pr-154-t2-text-name">
                                                            '. $exProlore_Name .'
                                                        </div>
                                                        <div class="display-flex align-items-center items-pr-154-t2-text-price">
                                                            '. $displayex .'
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>                
                                    </div>         
                                ';
                            }
                        }else{
                            echo '<div style="text-align:center; padding: 50px 0; color:grey;">Chưa có sản phẩm nào!</div>';
                        }

                    ?>
                </div>
            </div>
            <!-- ---------------------lIST ITEMS------------------------ -->
        </div>
    </div>

    <script src="<?php echo SITE_SCRIPT_PATH; ?>filter_btn_click.js"></script>

<!-- ==============================================END EXPLORE PRODUCT PAGE================================================ -->