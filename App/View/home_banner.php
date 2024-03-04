<div id="banner-page-home">

    <div class="position-relactive">

        <button class="btn_scr_bannerhome" id="btn-banner-scroll-left">
            <i class='bx bx-chevron-left'></i>
        </button>
        <button class="btn_scr_bannerhome" id="btn-banner-scroll-right">
            <i class='bx bx-chevron-right'></i>
        </button>

        <div class="parent_banner">
            <div class="banner-page-home-noituyen" style="scroll-behavior: smooth;">
                
                <?php

                include_once "../../App/Model/home.php";

                global $pdoConnection;

                $banner = show_all_banner($pdoConnection);

                foreach($banner as $bm){

                    if (isset($_SESSION['iduser'])) {
                        if ($bm['CreatorID'] == $_SESSION['iduser']) {
                            $href = 'index.php?act=my_collection&mycollection='.$bm['CollectionID'].'';
                        }else{
                            $href = 'index.php?act=your_collection&yourcollection='.$bm['CollectionID'].'';
                        }
                    }
                    else{
                        $href = 'index.php?act=your_collection&yourcollection='.$bm['CollectionID'].'';
                    }

                    echo '
                    <div class="transition-all-2s-linear check_screence w_banner_exam">
                        <div class="display-flex banner-central banner_colorthier">
                            <div id="img-banner-featured-of-collections">
                                <img class="img_cl_thier" id="img-banner" src="'.COLLECTION_PATH.''.$bm['FeaturedImage'].'" alt="">
                            </div>
                            <div id="content-of-banner">
                                <h1 class="nghichdao_text">
                                    '.$bm['Name'].'
                                </h1>
                                <div id="by-and-avt-at-banner" class="display-flex">
                                    <div class="by nghichdao_text">
                                        Bởi
                                    </div>
                                    <a id="owner-collections-at-banner__text__avt" class="display-flex">
                                        <div id="owner-collections-at-banner">
                                            <img id="avt-at-banner" src="'.USER_PATH.''.$bm['AvatarImage'].'" alt="">
                                        </div>
                                        <div class="nghichdao_text">
                                            '.$bm['Username'].'
                                        </div>
                                    </a>
                                </div>
                                <p id="description-at-banner" class="nghichdao_text">
                                    '.$bm['Description'].'
                                </p>
                                <a href="'.$href.'">
                                    <button id="explore-btn-at-banner">
                                        Khám Phá
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    ';
                }
                
                ?>


                <!-- --------------------------------------------- -->

            </div>
        </div>

    </div>

    <div id="time-banner" class="display-flex align-items-center justify-content-center">
        <button class="pause-or-continous" id="run-banner">
            <i class='bx bx-pause' id="runokaybn"></i>
        </button>
        <div class="display-flex align-items-center colmn-at-time-banner">
            <button class="btn-destroy">
                <div class="bar-time-at-banner" >
                    <div class="bar-time-at-banner-black" id="johandepzaivl">
                    </div>
                </div>
            </button>
            <button class="btn-destroy">
                <div class="bar-time-at-banner">
                    <div class="bar-time-at-banner-black">
                    </div>
                </div>
            </button>
            <button class="btn-destroy">
                <div class="bar-time-at-banner">
                    <div class="bar-time-at-banner-black">
                    </div>
                </div>
            </button>
        </div>
    </div>
</div>

<script src="<?php echo SITE_SCRIPT_PATH; ?>banner_home.js"></script>
