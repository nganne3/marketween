<!-- ===============================================SETTING PROFILE PAGE========================================== -->
<?php
    $clq1 = "";
    $clq2 = "";
    $laycainit = "";
    $text_black = "text-black";
    $text_not_yet_hover = "text-not-yet-hover";

    if (isset($_GET['page_sett'])) {
        $laycainit = $_GET['page_sett'];
        if ($laycainit == "set_profile") {
            $clq1 = $text_black;
            $clq2 = $text_not_yet_hover;
        }
        elseif($laycainit == "set_account"){
            $clq1 = $text_not_yet_hover;;
            $clq2 =  $text_black;
        }
    }
    else{
        $clq1 = $text_black;
        $clq2 = $text_not_yet_hover;
    }
?>

<div id="page_setting_my_account">

    <div class="padding_st_pg">

        <div class="title_page_h1">
            <h1>Cài đặt cấu hình</h1>
        </div>

        <div class="flex_stpage">
            <!-- ===========================START LEFT======================= -->
            <div class="bentrai_st_page">
                <div class="zancach">
                    <a href="index.php?act=settingprofile&usersett=<?php echo $login_ex; ?>&page_sett=set_profile" class="a_btn_change_php <?php echo $clq1; ?>" href="">Hồ sơ</a>
                </div>
                <div class="zancach">   
                    <a href="index.php?act=settingprofile&usersett=<?php echo $login_ex; ?>&page_sett=set_account" class="a_btn_change_php <?php echo $clq2; ?>" href="">Tài khoản</a>
                </div>
            </div>
            <!-- ===========================END LEFT======================= -->
            <!-- ===========================START RIGHT======================= -->
            <div class="benphai_st_page">   

            <?php
                if (isset($_GET['page_sett'])) {
                    $page = $_GET['page_sett'];
                    if ($page == 'set_profile' || $page == 'set_account') {
                        renderView($page);         
                    }
                    else {
                        renderView("set_profile");
                    }
                } else {           
                    $page = "";
                    renderView("set_profile");
                };
            ?>
            
            </div>
            <!-- ===========================END RIGHT======================= -->
        </div>

    </div>

</div>

<!-- ===============================================END SETTING PROFILE PAGE========================================== -->
