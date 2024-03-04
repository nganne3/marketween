<div class="new-collections-page-home margin-sections-at-home-page">

        <div class="border-hr cachxuong-margin-bot">
            <h2 class="title-h2">Nhà kinh doanh nổi bật</h2>
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
                    Doanh thu
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

        <?php 

            $sales_g = best_bussiness($pdoConnection);

            if (is_array($sales_g) && !empty($sales_g)) {
                if ($sales_g >= 10) {
                    include "../../App/View/table_top_10_sales.php";
                }else{
                    include "../../App/View/top_sales_grid.php";
                }
            }else{
                echo "<div style'text-align:center;'> Chưa có biến động gì!</div>";
            }

        ?>

        <a href="index.php?act=explore&explorepage=exploreUsers&ft_best">
            <button class="btn-destroy set-all-btn-change-page-at-home-section display-flex align-items-center justify-content-center">
                <span>Xem tất cả</span>
                <i class='bx bx-right-arrow-alt'></i>
            </button>
        </a>

    </div>

<script src="<?php echo SITE_SCRIPT_PATH; ?>folow_ajax.js"></script>
