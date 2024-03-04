<?php

if (!isset($_SESSION['limit'])) {
    $_SESSION['limit'] = 5;
};

if (!empty($_GET['products_detail_id'])) {
    $my_pro_id = $_GET['products_detail_id'];
    $my_info_pr = get_product_info($pdoConnection, $my_pro_id);

    if (empty($my_info_pr['UserID'])) {
        $_SESSION['not_found'] = true;
        header('location: ../../index.php');
    }
    elseif (empty($my_info_pr['CollectionID'])) {
        $_SESSION['not_found'] = true;
        header('location: ../../index.php');
    }
    elseif (empty($my_info_pr['ProductID'])) {
        $_SESSION['not_found'] = true;
        header('location: ../../index.php');
    }
}
else{
    $_SESSION['not_found'] = true;
    header('location: ../../index.php');
}


$lastg = $my_info_pr['last_price'];

$hienhayko = 'flex';
if ($lastg === null) {
    $hienhayko = 'none';
}

$mota = $my_info_pr['Description'] ?? '';
$mota = trim($mota) !== '' ? $mota : 'Chưa có mô tả';

$an = 'flex';
$anflase = 'none';

if ($my_info_pr['ListedPrice'] === null || $my_info_pr['ListedPrice'] === 0) {
   $an = 'none';
   $anflase = 'inline-block';
   $hienhayko = 'none';
}

$cmt = get_comment($pdoConnection, $my_pro_id);

?>

<!-- =======================================================PRODUCT DETAIL AND COMMENT==================================================== -->

<div id="product-detail-page" class="padding-top-90px" style="padding-bottom: 62px;">
<!-- ============================================================START DETAIL=============================================================== -->
    <div id="details-product-has-image" class="padding-left-right-39px">
        <div class="display-flex justify-content-space-between combo-thanh-ben-parent hide-scrollbar">
            <!-- ======================================START PART 1========================= -->
            <div class="width-70phantram margin-right-32px combo-thanh-ben-children-0">
                <div class="width-100phantram margin-bottom-30px">
                    <div class="overflow-hidden border-radius-12px height-500px width-100phantram display-flex justify-content-center align-items-center" >
                        <img class="border-radius-12px max-width-100phantram max-height-100phantram object-fit-contain" src=" <?php echo IMAGE_PATH.$my_info_pr['ImageURL']; ?>" alt="">
                    </div>
                </div>
                <div class="display-flex justify-content-center width-100phantram">

                    <div class="display-flex align-items-center justify-content-center "  style="width: 100%;">
                        <div class="padding-22px-24px combo-border-xam-items" style="width: 100%;">
                            <p class="font-weight-500 font-size-28px margin-bot-20px">
                                Mô tả sản phẩm
                            </p>
                            <p>
                                <?php echo $mota ?>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <!-- ======================================END PART 1========================= -->

            <!-- ======================================START PART 2========================= -->
            <div class="width-30phantram combo-thanh-ben-parent-children-1">

                <div class="padding-32px padding-top-0px">

                    <div class="margin-bot-62px">
                        <div class="display-flex align-items-center margin-bottom-10px">
                            <div class="overflow-hidden border-radius-8px height-width-36px margin-right-10px">
                                <img class="width-100-height-100" src="<?php echo  COLLECTION_PATH.$my_info_pr['LogoImage'] ?>" alt="">
                            </div>
                            <div class="font-weight-600 font-size-20px">
                                <?php echo  $my_info_pr['name_bosuutap'] ?>
                            </div>
                        </div>
    
                        <div class="font-size-40px font-weight-500 ">
                            <?php echo  $my_info_pr['Name'] ?>
                        </div>
        
                        <div class="display-flex align-items-center">
                            <p>Loại tệp:</p>
                            &nbsp;
                            <span><?php echo  $my_info_pr['namecate'] ?></span>
                        </div>
                    </div>
    
                    <div class="display-flex align-items-center margin-bot-20px">
                        <div class="overflow-hidden border-radius-50phantram height-width-56px margin-right-10px">
                            <img class="width-100-height-100" src="<?php echo  USER_PATH.$my_info_pr['AvatarImage'] ?>" alt="">
                        </div>
    
                        <div>
                            <p class="color-text-xam">Người bán</p>
                            <a><p class="font-weight-500"><?php echo $my_info_pr['Username'] ?></p></a>
                        </div>
                    </div>

                    <div class=" height-1px width-100phantram margin-bottom-10px" style="background-color: rgba(22, 22, 26, 0.08);">
                    </div>

                    <div class="display-flex align-items-center justify-content-space-between">
                        <div class="display-flex align-items-center">
                            <!-- <button id="click-tym-product" class="display-flex align-items-center color-text-xam btn-destroy border-radius-8px background-color-hover-xam margin-right-20px">
                                <i class='bx bx-heart margin-right-10px font-size-20px'></i>
                                <div class="font-size-20px">
                                    0
                                </div>
                            </button> -->
    
                            <button id="click-refresh-product" class="display-flex align-items-center color-text-xam btn-destroy border-radius-8px background-color-hover-xam">
                                <i class='bx bx-refresh margin-right-10px font-size-20px'></i>
                                <div class="font-size-16px">
                                    Cập nhật lại
                                </div>
                            </button>

                            <script>
                                document.getElementById('click-refresh-product').addEventListener('click', ()=>{
                                    location.reload();
                                });
                            </script>
                        </div>
                        
                        <div class="display-flex align-items-center justify-content-center">
                            <button id="click-options-product" class="display-flex align-items-center color-text-xam btn-destroy border-radius-8px background-color-hover-xam justify-content-center">
                                <i class='bx bx-dots-horizontal-rounded font-size-20px'></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="width-100phantram">
                    <div class="padding-22px-24px combo-border-xam-items">
                        <div class="display-flex align-items-center margin-bottom-20px" style="display: <?php echo $hienhayko; ?>">
                            <p style="display: <?php echo $hienhayko; ?>">Cập nhật lần cuối:</p>
                            &nbsp;
                            <p>
                                <?php     
                                    if ($lastg !== null) {
                                        $date = date_create_from_format('Y-m-d H:i:s', $lastg);
                                        $formatted_date = date_format($date, 'H\h i\p d-m-Y');
                                        echo 'lúc ' . $formatted_date;
                                    } else {
                                        echo '';
                                    }
                                ?>
                            </p>
                        </div>

                        <div class="padding-16px border-radius-12px background-color-input margin-bottom-10px">
                            <p class="color-xam-not-13px">Giá</p>
                            <div class="display-flex align-items-center font-size-22px font-weight-500">
                                <p>
                                    <?php 
                                       $yang = $my_info_pr['ListedPrice'];

                                        if ($yang === null || $yang === 0) {
                                            echo 'Chưa mở bán';
                                        }else{
                                            echo $yang;
                                        }
                                    ?>
                                </p>
                                &nbsp;
                                <p style="display: <?php echo $hienhayko; ?>">coins</p>
                            </div>
                            <div class="display-flex align-items-center color-xam-not-13px">
                                <p>
                                    <?php 
                                        $formatted_number = number_format($yang  * 1000, 0, ',', '.');
                                        if ($formatted_number == 0) {
                                            echo 'Chưa có giá';
                                        }
                                        else{
                                            echo $formatted_number;
                                        }
                                     ?>
                                </p>
                                &nbsp;
                                <p style="display: <?php echo $hienhayko; ?>">VND</p>
                            </div>
                        </div>

                        <input type="hidden" id="chitiet_idpro" value="<?php echo $my_info_pr['ProductID']; ?>">
                        <input type="hidden" id="chitiet_driver" value="<?php echo $my_info_pr['FileURL']; ?>">
                        <input type="hidden" id="chitiet_imgsp" value="<?php echo IMAGE_PATH.$my_info_pr['ImageURL']; ?>">
                        <input type="hidden" id="chitiet_namesp" value="<?php echo $my_info_pr['Name']; ?>">
                        <input type="hidden" id="chitiet_collection" value="<?php echo $my_info_pr['name_bosuutap']; ?>">
                        <input type="hidden" id="chitiet_price" value="<?php echo $my_info_pr['ListedPrice']; ?>">

                        <div class="display-flex align-items-center justify-content-space-between colmn-gap-10px" >
                            <button id="sale_mydetail" style="display: <?php echo $anflase ?>;" class="pg-detail-buy-product-with-price-this text-white display-flex align-items-center justify-content-center width-100phantram "><div>Đặt bán</div></button>
                            <button id="huyban_choroi" style="display: <?php echo $an ?>;" class="pg-detail-buy-product-with-price-this text-white display-flex align-items-center justify-content-center width-100phantram "><div>Hủy bán</div></button>
                            <button id="edit_sl_mydetail" style="display: <?php echo $an ?>;" class="btn-destroy pg-detail-add-to-cart text-white display-flex align-items-center"><i class='bx bxs-edit-alt'></i></button>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ======================================END PART 2========================= -->
        </div>
    </div>
<!-- ============================================================END DETAIL=============================================================== -->

<!-- ============================================================START COMMENT=============================================================== -->
    <div id="comment-at-product" class="margin-bot-62px" style="padding-bottom: 100px;">
        <div class="padding-left-right-39px display-flex justify-content-center margin-bot-20px">
           <div class="combo-border-xam-items padding-22px-24px" style="width: 100%;">
           <div class="display-flex align-items-center margin-bottom-30px">
                <div class="font-weight-500 font-size-28px margin-right-10px">Bình luận</div>
                    <div id="dembinhluan" class="display-flex align-items-center justify-content-center background-color-red quantity-cmt">
                        <?php          
                            $vvvv = 0;
                            foreach($cmt as $t){
                                $vvvv++;
                            };
                            echo $vvvv;
                        ?>
                    </div>
                </div>

                <?php
                
                if (isset($_SESSION["iduser"], $_SESSION["avatarus"], $_SESSION['Username'])){

                    $usid = $_SESSION["iduser"] ?? '';
                    $avts = $_SESSION["avatarus"] ?? '';
                    $usn = $_SESSION['Username'] ?? '';

                    echo '     

                    <div class="display-flex margin-bottom-30px colmn-gap-20px box_big_cmt">
                        <div class="overflow-hidden border-radius-50phantram height-60px-width-60px min-height-60px-min-width-60px">
                            <img class="width-100-height-100" src="'.USER_PATH.''.$avts.'" alt="">
                        </div>
                        <input type="hidden" id="usernao" value="'.$usid.'">
                        <input type="hidden" id="spnaovay" value="'.$my_info_pr['ProductID'].'">
                        <div class="box_cmt_this">
                            <div class="input_my_cmt">
                                <input class="enter_my_cmt" type="text" placeholder="Nhập bình luận" value="">
                            </div>
                            <div>
                                <button id="guibinhluan" class="cmt_vao_sanpham">Gửi</button>
                            </div>
                        </div>
                    </div> 

                    ';
                }
                else{
                    echo '<div class="box_lg_for_cmt"><button class="dangnhapdebinhluan">Đăng nhập để bình luận</button></div>';
                }
                
                ?>


                <!-- ================================================= -->
                <div class="body-comment">

                    <?php

                        foreach($cmt as $cmt){

                            $timeAgo = $cmt['CreatedAt'];
                            $timelast = $cmt['UpdatedAt'];
                            if ($timeAgo !== null) {
                                if ($timelast > $timeAgo) {
                                    $date = date_create_from_format('Y-m-d H:i:s', $timelast);
                                    $formatted_date = date_format($date, 'H\h i\p d-m-Y');
                                    $now_time =  'lúc ' . $formatted_date;
                                }
                                else{
                                    $date = date_create_from_format('Y-m-d H:i:s', $timeAgo);
                                    $formatted_date = date_format($date, 'H\h i\p d-m-Y');
                                    $now_time =  'lúc ' . $formatted_date;
                                }
                            } else {
                                $now_time = '';
                            }
                            
                           $display = 'none';
                           $displayflex = 'none';
                           if (isset($_SESSION["iduser"]) && $cmt['UserID']==$_SESSION["iduser"]) {
                                $display = 'inline-block';
                                $displayflex = 'flex';
                           };

                            echo '
                            
                            <div class="user-comment margin-bottom-30px">

                                <div class="in4-user-comment display-flex margin-bottom-20px colmn-gap-20px">
                                    <div class="overflow-hidden border-radius-50phantram height-60px-width-60px min-height-60px-min-width-60px">
                                        <img class="width-100-height-100" src="'.USER_PATH.''.$cmt['AvatarImage'].'" alt="">
                                    </div>
        
                                    <div style="width:100%;">
                                        <div class="display-flex align-items-center margin-bottom-10px">
                                            <div class="font-weight-600 font-size-18px margin-right-10px">'.$cmt['Username'].'</div>
                                            <div class="chamtron-ngan-cach-time-and-name margin-right-10px">                              
                                            </div>
                                            <div class="margin-right-10px">'.$now_time.'</div>
                                        </div>   
        
                                        <div class="margin-bottom-20px">
                                            '.$cmt['Content'].'
                                        </div>
        
                                        <div class="display-flex align-items-center" style="display: '.$displayflex.'; margin-bottom:10px;">
                                            <div class="margin-right-20px text-not-yet-hover edit_cmt">Chỉnh sửa</div>
                                            <div class="text-not-yet-hover xoa_binhluan_pd">
                                            Xóa
                                            <input class="id_xoacmt" type="hidden" value="'.$cmt['CommentID'].'">
                                            </div>
                                        </div>
        
                                        <div class="box_cmt_this suacmt_cai" style="display: none; width:100%;">
                                            <div class="input_my_cmt edit_inputmy_cmt" style="width:auto;">
                                                <input class="enter_my_cmt " type="text" placeholder="Nhập bình luận" value="'.$cmt['Content'].'">
                                            </div>
                                            <div>
                                                <input class="noidungcmtsesua" type="hidden" value="'.$cmt['CommentID'].'">
                                                <button class="cmt_vao_sanpham dasuaxong">Xong</button>
                                            </div>
                                        </div>
        
                                    </div>
        
                                </div>
                            </div>
                            
                            ';
                        }
                    
                    ?>


                    <!-- ------------------------------- -->     
                </div>
           </div> 
        </div>

        <div class="display-flex justify-content-center ">
            <button class="btn-destroy font-weight-600 btn-view-more" id="loadMoreComments">Tải thêm</button>
        </div>
    </div>
<!-- ============================================================END COMMENT=============================================================== -->

<!-- ============================================================START PRODUCT RELATED=============================================================== -->

    <div id="product-related-at-product" class="margin-bot-62px">
        <div class="padding-left-right-39px position-relactive margin-bot-62px">

            <button class="btn-banner-scroll btn_lq" id="btn-detail-scroll-left">
                <i class='bx bx-chevron-left'></i>
            </button>
            <button class="btn-banner-scroll btn_lq" id="btn-detail-scroll-right">
                <i class='bx bx-chevron-right'></i>
            </button>

            <div class="font-weight-500 font-size-28px margin-bottom-20px display-flex">
                Sản phẩm cùng bộ sưu tập này
            </div>

            <div class="container-product-related overflow-hidden display-flex align-items-center">

                <!-- -------------------------------------- -->

                <?php
                
                $hiencode = related_product($pdoConnection, $my_info_pr['CollectionID'], $my_info_pr['ProductID']);
                
                foreach($hiencode as $prs){
                    $lis = 'none';
                    $ns = 'inline-block';
                    if ($prs['ListedPrice'] !== 0 || $prs['ListedPrice'] !== null) {
                        $lis = 'inline-block';
                        $ns = 'none';
                    }
                    
                    echo '

                    <div class="container-product-related-central sanpham_relatedss">
                        <div class="container-product-related-central-canh-trai">
                            <a class="container-product-related-central-vi-tri-trung-tam">
                                <div class="in4-vi-tri-trung-tam-of-product-img position-relactive">

                                    <img class="width-100-height-100" src="'.IMAGE_PATH.''.$prs['ImageURL'].'" alt="">

                                    <input type="hidden">
                                    <input type="hidden">
                                    <input type="hidden">
                                    <input type="hidden">
                                    
                                    <div class="btn-buy-at-product-at-details-related display-flex align-items-center justify-content-space-between colmn-gap-10px position-absolute">
                                        <button class="pg-detail-buy-product-with-price-this text-white display-flex align-items-center justify-content-center width-100phantram "><span>Mua Ngay</span></button>
                                        <button class="btn-destroy pg-detail-add-to-cart text-white display-flex align-items-center"><i class="bx bx-plus"></i></button>
                                    </div>

                                </div>
                                <div class="in4-vi-tri-trung-tam-of-product-name">
                                    <div class="font-weight-600 font-size-20px">
                                        '.$prs['Name'].'
                                    </div>

                                    <div class="display-flex align-items-center">
                                        <span style="display: '.$lis.'">Giá:</span>
                                        &nbsp;
                                        <span style="display: '.$lis.'">'.$prs['ListedPrice'].'</span>
                                        &nbsp;
                                        <span>coins</span>
                                        <span style="display: '.$ns.';">Chưa mở bán</span>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                    ';

                    }

                ?>

            </div>

        </div>

        <a class="display-flex justify-content-center">
            <button class="btn-destroy font-weight-600 btn-view-more">Khám phá bộ sưu tập</button>
        </a>
    </div>

<!-- ============================================================END PRODUCT RELATED================================================================= -->

</div>

<!-- =======================================================PRODUCT DETAIL==================================================== -->

<script src="<?php echo SITE_SCRIPT_PATH; ?>sell_at_detail.js"></script>
<script src="<?php echo SITE_SCRIPT_PATH; ?>comment.js"></script>

