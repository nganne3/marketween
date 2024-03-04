<div class="new-collections-page-home margin-sections-at-home-page">
        <div class="border-hr cachxuong-margin-bot">
            <h2 class="title-h2">Được theo dõi nhiều nhất</h2>
        </div>

        <div class="display-flex align-items-center flex-wrap-wrap user-top-fl-all-col-gap btn-view-all-margin-bottom" >
            <?php

            update_followers($pdoConnection);
            update_following($pdoConnection);

            if (isset($_SESSION['iduser'])) {
                $idcheckfl = $_SESSION['iduser'];
            }else{
                $idcheckfl = "0";
            }

            $toptop = top_follow($pdoConnection,  $idcheckfl);


            foreach($toptop as $top){    
                if (isset($_SESSION['iduser']) && $top['UserID'] == $_SESSION['iduser']) {
                    $hrefu = 'index.php?act=profile&profile_data=product';
                    $bofl = 'display:none';
                }else{
                    $hrefu = 'index.php?act=your_profile&profile_id='.$top['UserID'].'&data_your_pro5=your_product_in_profile';
                    $bofl = 'display:block';
                }

                // var_dump($top['is_following']);
            
                $anhbia = 'display:block;';

                if ($top['CoverImage'] === null || $top['CoverImage'] == '') {
                    $anhbia = 'display:none;';
                };

                if ($top['is_following'] === 'true') {
                    $is_follow = "Hủy theo dõi";
                }else{
                    $is_follow = "Theo dõi";
                }

                $qttfl = formatFollowerCount($top['Followers']);
                echo '
                <a href="'.$hrefu.'">
                    <div class="item_duythai width_responsive_duythai2">
                        <div class="ke-an-danh-border-that-su">
                            <div class="maintain-double-img-duythai">
                                <div class="item-img_duythai">
                                    <img style="'.$anhbia.'" src="'.USER_PATH.''.$top['CoverImage'].'" alt="">
        
                                    <div style="width:100%; height: 100%; background-color: grey; border-radius:10px;">
                                    
                                    </div>
                                </div>
                                <div class="item-author_duythai">
                                    <img src="'.USER_PATH.''.$top['AvatarImage'].'" alt=""> 
                                </div>
                            </div>
        
                            <div class="item-details_duythai">
                                <div class="display-flex align-items-center justify-content-space-between name-and-follow-btn" >   
                                    <div>
                                        <span class="username_duythai">'.$top['Username'].'</span>  
                                        <div class="follow_duythai"><span>'.$qttfl.'</span>&nbsp;<span>Lượt theo dõi</span></div>
                                    </div>
                                    <div class="follow-wrapper_duythai" style="'.$bofl.'">
                                        <button class="btn-destroy follow-duythai display-flex align-items-center folow_ajax">
                                            <span>'.$is_follow.'</span>
                                            <input type="hidden" value="'.$idcheckfl.'">
                                            <input type="hidden" value="'.$top['UserID'].'">
                                            <input type="hidden" value="'.$top['is_following'].'">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                ';
            }
            
            ?>
            

        </div>

        <a >
            <button class="btn-destroy set-all-btn-change-page-at-home-section display-flex align-items-center justify-content-center">
                <span>Xem tất cả</span>
                <i class='bx bx-right-arrow-alt'></i>
            </button>
        </a>

    </div>