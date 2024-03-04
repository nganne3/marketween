<div class="chinhhoa_grid_best">

    <?php
        $grs = best_grid_sales($pdoConnection);

        foreach($grs as $top){    
            if (isset($_SESSION['iduser']) && $top['UserID'] == $_SESSION['iduser']) {
                $hrefu = 'index.php?act=profile&profile_data=product';
            }else{
                $hrefu = 'index.php?act=your_profile&profile_id='.$top['UserID'].'&data_your_pro5=your_product_in_profile';
            }
            
            $anhbia = 'display:block;';
            
            if ($top['CoverImage'] === null || $top['CoverImage'] == '') {
                $anhbia = 'display:none;';
            };
            
            if ($top['total_sold'] === null ) {
                $top['total_sold'] = 0;
            };
            
            if ($top['total_volume']=== null) {
                $top['total_volume'] = 0;
            };
            
            $qttsold = formatFollowerCount($top['total_sold']);
            $qttvolume = formatFollowerCount($top['total_volume']);
            
            
            echo '
            
            <a href="'.$hrefu.'">
                <div class="item_duythai width_responsive_duythai2 ">
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
                                <div style="width:100%;">
                                    <span class="username_duythai">'.$top['Username'].'</span>  
                                    <div class="follow_duythai" style="display:flex;align-items:center; justify-content:space-between;">
                                        <div><span>'.$qttsold.'</span>&nbsp;<span>Doanh thu</span> </div>
                                        <div><span>'.$qttvolume.'</span>&nbsp;<span>Đã bán</span></div>
                                    </div>
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
