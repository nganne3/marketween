<?php 

    if (!empty($_GET['mycollection'])) {
        $is_yourman = $_GET['mycollection'];
        $is_your_info = get_your_info($pdoConnection, $is_yourman);

        if (empty($is_your_info['UserID'])) {
            $_SESSION['not_found'] = true;
            header('location: ../../index.php');
        } elseif (empty($is_your_info['CollectionID'])){
            $_SESSION['not_found'] = true;
            header('location: ../../index.php');
        }
    }
    else{
        $_SESSION['not_found'] = true;
        header('location: ../../index.php');
    }

    if ($is_your_info['BannerImage'] === null) {
        $dis_this =  'none';
    }
    else{
        $dis_this =  'inline-block';
    }

?> 

<!-- =================================START PROFILE================================== -->

<div id="profile_page_user">

    <div class="padding_pf_us">

        <div class="box_img_avt_cover_pfofile">

            <div class="img_cover_profile">
                <img style="display:<?php echo $dis_this; ?>" src="<?php echo COLLECTION_PATH . $is_your_info['BannerImage']; ?>" alt="">
            </div>

            <div class="img_avt_profile">
                <img src="<?php  echo COLLECTION_PATH . $is_your_info['LogoImage']; ?>" alt="">
            </div>
        </div>

        <div class="box_info_user_111">

            <div class="des_name_follo_creator">

                <div class="named_user_55">
                    <?php  echo $is_your_info['Name']; ?>
                </div>

                <div class="creator_coll_details">
                    <div class="cl_rgb">
                        Người tạo
                    </div>
                    <a class="creator_id" href=""><?php  echo $is_your_info['Username']; ?></a>
                </div>
                
                <div class="des_coll_and_profile cl_rgb">
                    <?php  echo $is_your_info['Description']; ?>
                </div>  
            </div>

            <div class="stats_right_box">
                <div class="pad_box_stats">
                    <div class="t_font_number">
                        <div class="cl_rgb">Giá sàn</div>
                        <div>
                            <?php  echo $is_your_info['Floor']; ?> &nbsp; <span>coins</span>
                        </div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Doanh thu</div>
                        <div>
                            <?php  echo $is_your_info['Volume']; ?> &nbsp; <span>coins</span>
                        </div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Tổng sản phẩm</div>
                        <div>
                            <?php  echo $is_your_info['TotalProducts']; ?>
                        </div>
                    </div>

                    <div class="t_font_number">
                        <div class="cl_rgb">Đã bán</div>
                        <div>
                            <?php  echo $is_your_info['Sold']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const bo_margin = document.getElementsByClassName('t_font_number');
                const margin_last = bo_margin[bo_margin.length - 1];
                margin_last.style.marginBottom = '0px';
            </script>

        </div>

 <!-- ==============================CONTAINER PROFILE DETAIL======================================= -->

        <div id="maintain_content_profile" style="margin-top: 30px;">
            <?php 
                renderView('my_product_in_collection');   
            ?>
        </div>
 <!-- ==============================END CONTAINER PROFILE DETAIL======================================= -->

    </div>

</div>


<script>
    let divs = document.querySelectorAll('.un_or_priced_btn');

    if(divs) {
        divs.forEach((div) => {
            div.addEventListener('click', function() {
                divs.forEach((div) => {
                    div.classList.remove('padding-den-nen');
                    div.classList.add('padding-xamn-nen');
                });

                this.classList.remove('padding-xamn-nen');
                this.classList.add('padding-den-nen');
            });
        });
    }

    let allDiv = document.querySelector('div.ctgr-btn_all');
    let soundDiv = document.querySelector('div.ctgr-btn_1');
    let videoDiv = document.querySelector('div.ctgr-btn_2');
    let imageDiv = document.querySelector('div.ctgr-btn_3');

    let otherDivs = [soundDiv, videoDiv, imageDiv];

    if(allDiv) {
        allDiv.addEventListener('click', function() {
            this.classList.remove('padding-xamn-nen');
            this.classList.add('padding-den-nen');

            otherDivs.forEach((e) => {
                if(e) {
                    e.classList.remove('padding-den-nen');
                    e.classList.add('padding-xamn-nen');
                }
            });
        });
    }

    otherDivs.forEach((e) => {
        if(e) {
            e.addEventListener('click', function() {
                this.classList.remove('padding-xamn-nen');
                this.classList.add('padding-den-nen');

                if(allDiv) {
                    allDiv.classList.remove('padding-den-nen');
                    allDiv.classList.add('padding-xamn-nen');
                }
            });
        }
    });

    const checkselectexplore = document.querySelector('.dropdown-select-box145');
    if (checkselectexplore) {
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
    }
</script>


<script src="<?php echo SITE_SCRIPT_PATH; ?>my_product_url_filter.js"></script>

<!-- =================================END PROFILE================================== -->
