<!-- ================================================START HOME================================= -->
<div id="home-page">
<!-- ====================================================START BANNER========================================================== -->
    <?php 
        
        include '../../App/View/home_banner.php';

    ?>
<!-- ====================================================START NEW COLLECTIONS============================================================ -->
    <?php 
        include '../../App/View/home_new_collection.php';
    ?>
<!-- ====================================================END NEW COLLECTIONS============================================================ -->

<!-- ====================================================START TRENDING COLLECTIONS============================================================ -->
    <?php 
        
        include '../../App/View/home_trending_collection.php';

    ?>
<!-- ====================================================END TRENDING COLLECTIONS============================================================ -->

<!-- ====================================================START TOP FOLLOW============================================================ -->
    <?php 
        
        include '../../App/View/home_top_follow.php';

    ?>
<!-- ====================================================END TOP FOLLOW============================================================ -->

<!-- ====================================================START FEATURED BUSINESS============================================================ -->
    <?php 
            
        include '../../App/View/home_top_sales.php';

    ?>
<!-- ====================================================END FEATURED BUSINESS============================================================ -->

<!-- ====================================================START GMAIL=========================================================== -->
    <div class="gamil-section-page-home margin-sections-at-home-page">

        <div class="display-flex align-items-center colmn-gap-px padding-left-right-30px padding-top-bot-48px">
            <div class="text-32px width-100phantram">
                <p>
                    Hãy để lại Gmail
                </p>
                <p>
                    Để nhận nhiều thông chi tiết
                </p>   
            </div>
            <div class="width-100phantram">
                <div class="max-width-520px">
                    <div class="display-flex align-items-center margin-bottom-10px" >
                        <input class="get-gmail-at-page-home" type="text" placeholder="Email của bạn">
                        <button class="btn-destroy btn-for-get-mail-at-page-home">Gửi</button>
                    </div>
                    <div class="text-white">
                        Khi bạn nhấn nút gửi, bạn sẽ nhận được email từ Markerween. Bạn luôn có quyền hủy đăng ký trong mỗi email bạn nhận được.
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ====================================================END GMAIL============================================================ -->

</div>
<!-- ================================================END HOME=================================== -->

<script src="<?php echo SITE_SCRIPT_PATH; ?>click_to_page.js"></script>
