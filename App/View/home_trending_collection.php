<div class="new-collections-page-home margin-sections-at-home-page">

        <div class="border-hr cachxuong-margin-bot">
            <h2 class="title-h2">Bộ sưu tập đang tiêu biểu</h2>
        </div>

        <div class="display-flex align-items-center parent-box-input-check-floor-price supper-parent-box-input-check-floor-price">
            <div class="taphop-time-btn-filter display-flex align-items-center">
                <button class="btn-destroy time-btn-filter-at-trending-collections-at-page-home">1G</button>
                <button class="btn-destroy time-btn-filter-at-trending-collections-at-page-home box-input-bg-color-white">1N</button>
                <button class="btn-destroy time-btn-filter-at-trending-collections-at-page-home">7N</button>
                <button class="btn-destroy time-btn-filter-at-trending-collections-at-page-home">30N</button>
            </div>
        
            <div class="display-flex align-items-center parent-box-input-check-floor-price">
                <div>
                    Giá sàn
                </div>
                
                <div class="display-flex align-items-center box-input-check-floor-price"> 
                    <input type="number" placeholder="Tối thiểu">
                    <span>-</span>
                    <input type="number" placeholder="Tối đa">
                </div>
                
                <div>
                    COINS
                </div>
            </div>
        </div>

        <div class="display-flex align-items-center justify-content-space-between bangxephang-at-trending-collections-page-home">
            <div class="display-flex align-items-center justify-content-space-between col-rank-at-trending-collections-page-home col-margin-right-rank">
                <div class="display-flex justify-content-center dauthang-rank">
                    #
                </div>
            </div>
            <div class="display-flex align-items-center col-margin-right-rank width-100phantram col-collections-at-trending-collections-page-home">
                <div class="display-flex col-margin-right-rank width-100phantram ">
                    BỘ SƯU TẬP
                </div>
            </div>
            <div class="display-flex align-items-center justify-content-space-between width-100phantram col-floor-at-trending-collections-page-home">
                <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                    GIÁ SÀN
                </div>
                <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                    SỰ THAY ĐỔI
                </div>
            </div>
            <div class="display-flex align-items-center justify-content-space-between col-volume-at-trending-collections-page-home width-100phantram">
                <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                    DOANH THU
                </div>
                <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                    SỰ THAY ĐỔI
                </div>
            </div>
            <div class="col-selled-at-trending-collections-page-home display-flex flex-end col-margin-right-rank ">
                <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                    ĐÃ BÁN
                </div>
            </div>
        </div>

        <div data-href="" class="all-collections-rank-trending-at-page-home click_to_page_that">

            <?php
            
                $time_period = null;
                $tr_coll = stats_collections($pdoConnection, $time_period);

                $yan = '';
                $stt = '1';
                $tangtruongfloor = '+';
                $tangtruongvolu = '+';
                $color_floor = 'text-green';
                $color_volu = 'text-green';

                $html = '';

                foreach($tr_coll as $onii_chan_nee){
                    extract($onii_chan_nee, EXTR_PREFIX_ALL, 'this');
                    if ($this_Sold >= 1000 ) {
                    $yan = 'K';
                    }
                    elseif($this_Sold >= 1000000) {
                        $yan = 'M';
                    }

                    if ($this_Sold >= 1000 ) {
                        $yan = 'K';
                    };
                    if($this_Sold >= 1000000) {
                        $yan = 'M';
                    };

                    if ($this_floorChangeRate < 0) {
                        $tangtruongfloor = '';
                        $color_floor = 'text-red';
                    };
                    if($this_floorChangeRate == 0){
                        $tangtruongfloor = '';
                        $color_floor = '';
                    };
                    if ($this_floorChangeRate > 0) {
                        $color_floor = 'text-green';
                        $tangtruongfloor = '+';
                    };

                    if ($this_revenueChangeRate < 0) {
                        $tangtruongvolu = '';
                        $color_volu = 'text-red';
                    };
                    if($this_revenueChangeRate == 0){
                        $tangtruongvolu = '';
                        $color_volu = '';
                    };
                    if($this_revenueChangeRate > 0){
                        $tangtruongvolu = '+';
                        $color_volu = 'text-green';
                    };

                    if (isset($_SESSION['iduser'])) {
                        if ($this_CreatorID == $_SESSION['iduser']) {
                            $href = 'index.php?act=my_collection&mycollection='.$this_CollectionID.'';
                        }else{
                            $href = 'index.php?act=your_collection&yourcollection='.$this_CollectionID.'';
                        }
                    }
                    else{
                        $href = 'index.php?act=your_collection&yourcollection='.$this_CollectionID.'';
                    }

                    $html .= '
                    
                    <a href="'.$href.'" class="display-flex align-items-center justify-content-space-between bangxephang-at-trending-collections-page-home row-rank-collections margin-top-bot-0px huydisplay_flex_responsive_duythai bodermoi_responsive_duythai huyhover_responsive_duythai thucdong">
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

                if (is_array($tr_coll) &&  !empty($tr_coll)) {
                    echo $html;
                }else{
                    echo '<div style="text-align:center; padding:50px 0px;">Chưa có thay đổi gì mới</div>';
                } 
            
            ?>

            <!-- <div class="display-flex align-items-center justify-content-space-between bangxephang-at-trending-collections-page-home row-rank-collections">
                <div class="display-flex align-items-center justify-content-space-between col-rank-at-trending-collections-page-home col-margin-right-rank">
                    <div class="display-flex justify-content-center dauthang-rank">
                        1
                    </div>
                </div>
                <div class="display-flex align-items-center col-margin-right-rank width-100phantram">
                    <div class="display-flex col-margin-right-rank width-100phantram align-items-center">
                        <div class="img-avt-collections-at-rank-table">
                            <img class="img-avt-collections-at-rank-table-main" src="https://i.pinimg.com/originals/dd/d0/d7/ddd0d72b082a8574ecc10947a18848bd.jpg" alt="">
                        </div>
                        <div class="name-collections-at-rank-table">
                            Bored Ape Yacht Club
                        </div>
                    </div>
                </div>
                <div class="display-flex align-items-center justify-content-space-between width-100phantram">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                        <span>33</span>&nbsp;<span>coins</span> 
                    </div>
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram tyle-thaydoi-floor text-red">
                        <span>-</span><span>12</span><span>%</span>
                    </div>
                </div>
                <div class="display-flex align-items-center justify-content-space-between col-volume-at-trending-collections-page-home width-100phantram">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                        <span>14</span>&nbsp;<span>coins</span> 
                    </div>
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram tyle-thaydoi-volume text-green" >
                        <span>+</span><span>3</span><span>%</span>
                    </div>
                </div>
                <div class="col-selled-at-trending-collections-page-home display-flex flex-end col-margin-right-rank">
                    <div class="display-flex flex-end col-margin-right-rank width-100phantram">
                        <span>5.8</span><span>K</span>
                    </div>
                </div>
            </div> -->
            <!-- -------------------------------------------------------- -->

        </div>
        <a href="index.php?act=explore&explorepage=exploreCollections">
            <button class="btn-destroy set-all-btn-change-page-at-home-section display-flex align-items-center justify-content-center">
                <span>Xem tất cả</span>
                <i class='bx bx-right-arrow-alt'></i>
            </button>
        </a>
    </div>