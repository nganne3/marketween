<?php

    $time_ft = null;

    if(isset($_SESSION['iduser'])) {
        $idlayve = $_SESSION['iduser'];
        
        $collec_this = get_collection_user($pdoConnection, $idlayve, $time_ft);
    } else {
        $idlayve = 'marketween';
    }

?>

<!-- ==========================================COLLECTION PROFILE====================================================== -->

<div class="display-flex align-items-center parent-box-input-check-floor-price supper-parent-box-input-check-floor-price flex_responsive_duythai bottom_responsive1_duythai">
    <div class="taphop-time-btn-filter display-flex align-items-center bottom_responsive_duythai ">
        <button id="btn_collec_hour_profile" class="btn-destroy time-btn-filter-at-trending-collections-at-page-home padding_responsive_duythai peric_ft_collections">1G</button>
        <button id="btn_collec_day_profile" class="btn-destroy time-btn-filter-at-trending-collections-at-page-home box-input-bg-color-white padding_responsive_duythai peric_ft_collections">1N</button>
        <button id="btn_collec_week_profile"  class="btn-destroy time-btn-filter-at-trending-collections-at-page-home padding_responsive_duythai peric_ft_collections">7D</button>
        <button id="btn_collec_30days_profile" class="btn-destroy time-btn-filter-at-trending-collections-at-page-home padding_responsive_duythai peric_ft_collections">30N</button>
    </div>
    <div class="search_duythai search_responsive_duythai">
        <div class="search_input_duythai search_input_responsive_duythai"> 
            <input type="search" placeholder="Tìm kiếm tên bộ sưu tập">
            <i class='bx bx-search'></i>
        </div>
    </div>
</div>

<!-- ========================================================================== -->
<div class="text-back display-flex  align-items-center justify-content-space-between bangxephang-at-trending-collections-page-home huydisplay_flex_responsive_duythai">
    <div class="display-flex align-items-center justify-content-space-between col-rank-at-trending-collections-page-home col-margin-right-rank huydisplay_flex_responsive_duythai">
        <div class="display-flex justify-content-center dauthang-rank an_responsive_duythai">
            #
        </div>
    </div>
    <div class="display-flex align-items-center col-margin-right-rank width-100phantram col-collections-at-trending-collections-page-home">
        <div class="display-flex col-margin-right-rank width-100phantram an_responsive_duythai">
            BỘ SƯU TẬP
        </div>
    </div>
    <div class="display-flex align-items-center justify-content-space-between width-100phantram col-floor-at-trending-collections-page-home huydisplay_flex_responsive_duythai">
        <div class="display-flex flex-end col-margin-right-rank width-100phantram an_responsive_duythai">
            GIÁ SÀN
        </div>
        <div class="display-flex flex-end col-margin-right-rank width-100phantram an_responsive_duythai">
            SỰ THAY ĐỔI
        </div>
    </div>
    <div class="display-flex align-items-center justify-content-space-between col-volume-at-trending-collections-page-home width-100phantram huydisplay_flex_responsive_duythai">
        <div class="display-flex flex-end col-margin-right-rank width-100phantram an_responsive_duythai">
            DOANH THU
        </div>
        <div class="display-flex flex-end col-margin-right-rank width-100phantram an_responsive_duythai">
            SỰ THAY ĐỔI
        </div>
    </div>
    <div class="col-selled-at-trending-collections-page-home display-flex flex-end col-margin-right-rank an_responsive_duythai">
        <div class="display-flex flex-end col-margin-right-rank width-100phantram">
            ĐÃ BÁN
        </div>
    </div>
</div>

<!-- ========================================================================== -->
<div id="container_collectiond_profile" class="new-collections-page-home all-collections-rank-trending-at-page-home huyborder_responsive_duythai">
    
    <?php
        $yan = '';
        $stt = '1';
        $tangtruongfloor = '+';
        $tangtruongvolu = '+';
        $color_floor = 'text-green';
        $color_volu = 'text-green';
        foreach($collec_this as $onii_chan_nee){
            // var_dump($onii_chan_nee);
            extract($onii_chan_nee, EXTR_PREFIX_ALL, 'this');
            if ($this_Sold >= 1000 ) {
               $yan = 'K';
            }
            elseif($this_Sold >= 1000000) {
                $yan = 'M';
            }

            if ($this_floorChangeRate < 0) {
                $tangtruongfloor = '';
                $color_floor = 'text-red';
            }
            elseif($this_floorChangeRate == 0){
                $tangtruongfloor = '';
                $color_floor = '';
            };

            if ($this_revenueChangeRate < 0) {
                $tangtruongvolu = '';
                $color_volu = 'text-red';
            }
            elseif($this_revenueChangeRate == 0){
                $tangtruongvolu = '';
                $color_volu = '';
            }


            echo '
            
            <a href="index.php?act=my_collection&mycollection='.$this_CollectionID.'" class="display-flex align-items-center justify-content-space-between bangxephang-at-trending-collections-page-home row-rank-collections margin-top-bot-0px huydisplay_flex_responsive_duythai bodermoi_responsive_duythai huyhover_responsive_duythai thucdong">
                <div class="display-flex align-items-center justify-content-space-between col-rank-at-trending-collections-page-home col-margin-right-rank">
                    <div class="display-flex justify-content-center dauthang-rank an_responsive_duythai">
                        '.$stt .'
                    </div>
                </div>
                <div class="display-flex align-items-center col-margin-right-rank width-100phantram  display_flexmoi_responsive_duythai">
                    <div class="display-flex col-margin-right-rank width-100phantram align-items-center display_flexmoi_responsive_duythai">
                        <div class="img-avt-collections-at-rank-table">
                            <img class="img-avt-collections-at-rank-table-main" src="'. COLLECTION_PATH .''.$this_LogoImage.'" alt="">
                        </div>
                        <div class="font-weight-500 font_sizemoi_responsive_duythai">
                            '.$this_Name.'
                        </div>
                        <div class="i_responsive_duythai">
                            <i class="bx bx-right-arrow-alt i_responsive_duythai14"></i>
                        </div>
                    </div>
                </div>
                <div class="display-flex align-items-center justify-content-space-between width-100phantram anchinh_responsive_duythai display_flexmoi_responsive_duythai font_size_responsive_duythai">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram huydisplay_flex_responsive_duythai font-weight_responsive_duythai">
                        Doanh Thu
                    </div>
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram huydisplay_flex_responsive_duythai right_responsive_duythaii font-weight_responsive_duythai">
                        Giá sàn
                    </div>
                </div>
                <div class="display-flex align-items-center justify-content-space-between width-100phantram huydisplay_flex_responsive_duythai">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram huydisplay_flex_responsive_duythai">
                        <span class="coins_responsive_duythai">'.$this_Floor.'</span>&nbsp;<span class="coins_responsive_duythai14">Coins</span> 
                    </div>
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram '.$color_floor.' tyle-thaydoi-floor huydisplay_flex_responsive_duythai red_responsive_duythai">
                        <span>'.$tangtruongfloor.'</span><span>'.$this_floorChangeRate.'</span><span>%</span>
                    </div>
                </div>
                <div class="display-flex align-items-center justify-content-space-between col-volume-at-trending-collections-page-home width-100phantram huydisplay_flex_responsive_duythai margin_responsive_duythai ">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram margin-top_responsive_duythai">
                        <span class="coins_responsive_duythai">'.$this_Volume.'</span>&nbsp;<span class="coins_responsive_duythai14">Coins</span> 
                    </div>
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram tyle-thaydoi-volume '.$color_volu.' left_responsive_duythai red_responsive_duythai" >
                        <span>'.$tangtruongvolu.'</span><span>'.$this_revenueChangeRate.'</span><span>%</span>
                    </div>
                </div>
                <div class="col-selled-at-trending-collections-page-home display-flex flex-end col-margin-right-rank huydisplay_flex_responsive_duythai">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram an_responsive_duythai">
                        <span>'.$this_Sold.'</span><span>'.$yan.'</span>
                    </div>
                </div>
            </a>
            
            ';

            $stt++;
        }
    
    ?>
</div>

<!-- ==========================================COLLECTION PROFILE====================================================== -->

