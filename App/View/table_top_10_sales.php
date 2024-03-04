<div class="display-flex align-items-center colmn-gap-px margin-bottom-30px">
    <div style="max-width:650px;">
        
        <div class="border-hr margin-bottom-10px">
            <div class="display-flex align-items-center width-100phantram justify-content-space-between padding-right-left-for-rank-nhakinhdoanh">
                <div class="display-flex align-items-center min-width-32px margin-right-at-rank-nhakinhdoanh">
                    <div class="min-width-32px cangiua-dau-thang">
                        #
                    </div>
                </div>
                <div class="display-flex align-items-center width-100phantram ">
                    <div>
                        NHÀ KINH DOANH
                    </div>
                </div>
                <div class="display-flex align-items-center volume-at-nhakinhdoanhxuatsac">
                    <div class="flex-end">
                        DOANH THU
                    </div>
                </div>
                <div class="display-flex align-items-center daban-at-nhakinhdoanhxuatsac">
                    <div class="flex-end">
                        ĐÃ BÁN
                    </div>
                </div>
            </div>
        </div>

        <?php
        
        $zero_five = best_bussiness_0_to_5($pdoConnection);
        $ss = 1;
        foreach($zero_five as $hh){
            
            if (isset($_SESSION['iduser'])) {
                $jji = 'coins';
                $nj = '';

                if ($hh['UserID'] == $_SESSION['iduser']) {
                    $hrefu = 'index.php?act=profile&profile_data=product';
                }else{
                    $hrefu = 'index.php?act=your_profile&profile_id='.$hh['UserID'].'&data_your_pro5=your_product_in_profile';
                }
            }
            else{
                $nj = 'K';
                $jji = 'VND';
            };

            $daban = formatFollowerCount($hh['total_sold']);
            if ($daban == null) {
                $daban = 0;
            }
            $doanhthucuanh = formatFollowerCount($hh['total_volume']);

            if ($hh['total_volume'] > 999 || $hh['total_volume'] == 0) {
                $nj = '';
            };
            if ($doanhthucuanh == 0) {
                $doanhthucuanh = "0";
                $jji = '';
            };

            echo '
            <div data-href="'.$hrefu.'" class="phinhto-nhakinhdoanh-rank click_to_page_that">
                <div class="display-flex align-items-center width-100phantram justify-content-space-between padding-right-left-for-rank-nhakinhdoanh">
                    <div class="display-flex align-items-center min-width-32px margin-right-at-rank-nhakinhdoanh">
                        <div class="min-width-32px cangiua-dau-thang">
                           '.$ss.'
                        </div>
                    </div>
                    <div class="display-flex align-items-center width-100phantram ">
                        <div class="display-flex align-items-center">
                            <div class="overflow-hidden avt-nhakinhdoanh-rank">
                                <img class="width-100-height-100" src="'.USER_PATH.''.$hh['AvatarImage'].'" alt="">
                            </div>
                            <div class="name-nhakinhdoanh-rank">
                                '.$hh['Username'].'
                            </div>
                        </div>
                    </div>
                    <div class="display-flex align-items-center volume-at-nhakinhdoanhxuatsac">
                        <div class="flex-end">
                            <span>'.$doanhthucuanh.'</span><span>'.$nj.'</span>&nbsp;<span>'.$jji.'</span>
                        </div>
                    </div>
                    <div class="display-flex align-items-center daban-at-nhakinhdoanhxuatsac">
                        <div class="flex-end">
                            <span>'.$daban.'</span>
                        </div>
                    </div>
                </div>
            </div>        
            ';
            $ss++;
        }
        
        ?>


        <!-- -------------------------------------------------------- -->

    </div>

    <div style="max-width:650px;">
        <div class="border-hr margin-bottom-10px">
            <div class="display-flex align-items-center width-100phantram justify-content-space-between padding-right-left-for-rank-nhakinhdoanh">
                <div class="display-flex align-items-center min-width-32px margin-right-at-rank-nhakinhdoanh">
                    <div class="min-width-32px cangiua-dau-thang">
                        #
                    </div>
                </div>
                <div class="display-flex align-items-center width-100phantram ">
                    <div>
                        NHÀ KINH DOANH
                    </div>
                </div>
                <div class="display-flex align-items-center volume-at-nhakinhdoanhxuatsac">
                    <div class="flex-end">
                        DOANH THU
                    </div>
                </div>
                <div class="display-flex align-items-center daban-at-nhakinhdoanhxuatsac">
                    <div class="flex-end">
                        ĐÃ BÁN
                    </div>
                </div>
            </div>
        </div>


        <?php
        
        $sixten = best_bussiness_6_to_10($pdoConnection);
        $vs = 6;
        foreach($sixten as $hh){
            
            
            if (isset($_SESSION['iduser'])) {
                $jji = 'coins';
                $nj = '';

                if ($hh['UserID'] == $_SESSION['iduser']) {
                    $hrefu = 'index.php?act=profile&profile_data=product';
                }else{
                    $hrefu = 'index.php?act=your_profile&profile_id='.$hh['UserID'].'&data_your_pro5=your_product_in_profile';
                }

            }
            else{
                $nj = 'K';
                $jji = 'VND';
            };

            $daban = formatFollowerCount($hh['total_sold']);

            if ($daban == null) {
                $daban = 0;
            }

            $doanhthucuanh = formatFollowerCount($hh['total_volume']);

            if ($hh['total_volume'] > 999 || $hh['total_volume'] == 0) {
                $nj = '';
            };
            if ($doanhthucuanh == 0) {
                $doanhthucuanh = "0";
                $jji = '';
            };

            echo '
            <div data-href="'.$hrefu.'" class="phinhto-nhakinhdoanh-rank click_to_page_that">
                <div class="display-flex align-items-center width-100phantram justify-content-space-between padding-right-left-for-rank-nhakinhdoanh">
                    <div class="display-flex align-items-center min-width-32px margin-right-at-rank-nhakinhdoanh">
                        <div class="min-width-32px cangiua-dau-thang">
                            '.$vs.'
                        </div>
                    </div>
                    <div class="display-flex align-items-center width-100phantram ">
                        <div class="display-flex align-items-center">
                            <div class="overflow-hidden avt-nhakinhdoanh-rank">
                                <img class="width-100-height-100" src="'.USER_PATH.''.$hh['AvatarImage'].'" alt="">
                            </div>
                            <div class="name-nhakinhdoanh-rank">
                                '.$hh['Username'].'
                            </div>
                        </div>
                    </div>
                    <div class="display-flex align-items-center volume-at-nhakinhdoanhxuatsac">
                        <div class="flex-end">
                            <span>'.$doanhthucuanh.'</span><span>'.$nj.'</span>&nbsp;<span>'.$jji.'</span>
                        </div>
                    </div>
                    <div class="display-flex align-items-center daban-at-nhakinhdoanhxuatsac">
                        <div class="flex-end">
                            <span>'.$daban.'</span>
                        </div>
                    </div>
                </div>
            </div>
            ';
            $vs++;
        }
        
        ?>





        <!-- -------------------------------------------------------- -->



    </div>
</div>