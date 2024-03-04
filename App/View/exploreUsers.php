<!-- ========================================================================== -->
<div class="search-and-select-154">
    <div class="search-154 search_reponsive2_duythai">
        <i class='bx bx-search' ></i>
        <input type="text" placeholder="Tìm kiếm tên sản phẩm">
    </div>
    <div class="dropdown-select-box145">
        <div class="dropdown-select-box145-display-flex">
            <div id="catch_ching_ft" class="dropdown-select-box145-display-flex-text">
                Được theo dõi nhiều nhất
            </div>
            <i class='bx bx-chevron-down'></i>
        </div>
        <div id="myDropdownexplore" class="dropdown-select-box145-content">
            <a id="top_follow_user" href="index.php?act=explore&explorepage=exploreUsers">Được theo dõi nhiều nhất</a>
            <a id="top_sales" href="index.php?act=explore&explorepage=exploreUsers&ft_best">Nhà kinh doanh nổi bật</a>
        </div>             
    </div>
    <script> 

        const checkselectexplore = document.querySelector('.dropdown-select-box145');
        checkselectexplore.addEventListener('click', ()=>{

            const downex = document.getElementById('myDropdownexplore');

            let vanva = getComputedStyle(downex);

            if (vanva.display == "none") {
                downex.style.display = "block";
            }
            else{
                downex.style.display = "none";
            }
        })

        $(document).ready(function() {
            $('#top_follow_user, #top_sales').on('click', function() {
                const content = $(this).text();
                $('#catch_ching_ft').text(content);
                // if ($('#catch_ching_ft').text() === $('#top_follow_user').text()) {
                //     location.reload();
                // }
            });
        });

    </script>
</div>
<!-- ========================================================================== -->
<div class="contaiuser-explore">

    <?php 

    global $pdoConnection;

    if (isset($_GET['explorepage']) && $_GET['explorepage'] === 'exploreUsers' && isset($_GET['ft_best'])) {

        $bestsl = best_bussiness($pdoConnection);

        foreach($bestsl as $top){    
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
                                <div style="width:100%;">
                                    <span class="username_duythai">'.$top['Username'].'</span>  
                                    <div class="follow_duythai" style="display:flex;align-items:center; justify-content:space-between;">
                                        <div><span>'.$qttvolume.' coins</span>&nbsp;<span>Doanh thu</span> </div>
                                        <div><span>'.$qttsold.'</span>&nbsp;<span>Đã bán</span></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </a>
            ';
        }
    }else{
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
        }
    ?>
</div>

<script src="<?php echo SITE_SCRIPT_PATH; ?>folow_ajax.js"></script>
