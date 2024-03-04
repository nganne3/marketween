<div class="new-collections-page-home margin-sections-at-home-page">

    <div class="border-hr cachxuong-margin-bot">
        <h2 class="title-h2">Bộ sưu tập mới</h2>
    </div>

    <div class="container-new-collections-demo flex-wrap-wrap">

        <?php
        
        include_once "../../App/Model/home.php";

        $all_coll = home_n_collection($pdoConnection);
        
        if (is_array($all_coll) && !empty($all_coll)) {
            foreach($all_coll as $m){
                if ($m['Floor'] === null || $m['Floor'] == 0) {
                    $anhayhien = 'none';
                }else{
                    $anhayhien = 'block';
                };
    
                if (isset($_SESSION['iduser'])) {
                    $khaycoin = 'coins';
                    $k = '';
                }else{
                    $khaycoin = '₫';
                    $k = 'K';
                };
    
                $originalDate = $m['TimeCreated'];
                $date = date_create_from_format('Y-m-d H:i:s', $originalDate);
                $formattedDate = date_format($date, 'd-m-Y');
    
                if (isset($_SESSION['iduser'])) {
                    if ($m['CreatorID'] == $_SESSION['iduser']) {
                        $href = 'index.php?act=my_collection&mycollection='.$m['CollectionID'].'';
                    }else{
                        $href = 'index.php?act=your_collection&yourcollection='.$m['CollectionID'].'';
                    }
                }
                else{
                    $href = 'index.php?act=your_collection&yourcollection='.$m['CollectionID'].'';
                }
    
                echo '
                
                <div class="new-collections-vantan">
                    <div data-href="'.$href.'" class="central-of-new-collections-vantan click_to_page_that">
                        <div class="new-collections-vantan-form-img">
                            <img class="new-collections-demo-img" src="'.COLLECTION_PATH.''.$m['FeaturedImage'].'" alt="">
                        </div>
                        <div class="by-owner-and-name-at-new-collection">
                            <div class="by-owner-at-new-collection"><a href="">Bởi '.$m['Username'].'</a></div>
                            <div class="name-at-new-collection"><span>'.$m['Name'].'</span></div>
                        </div>
                        <div class="start-time-and-price-at-new-collection display-flex align-items-center justify-content-space-between">
                            <div>
                                <div class="color-text-xam">Bắt đầu</div>
                                <div>'.$formattedDate.'</div>
                            </div>
                            <div>
                                <div style="display: '.$anhayhien.'; class="color-text-xam">Giá sàn</div>
                                <div style="display: '.$anhayhien.';><span style="display: '.$anhayhien.';">'.$m['Floor'].''.$k.' '.$khaycoin.'</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                ';
    
            }
        }else{
            echo '<div style="font-weight: 500;"> Chưa có bộ sưu tập nào</div>';
        }
     
        ?>

    </div>

    <a href="index.php?act=explore&explorepage=exploreCollections">
        <button class="btn-destroy set-all-btn-change-page-at-home-section display-flex align-items-center justify-content-center">
            <span>Xem tất cả</span>
            <i class='bx bx-right-arrow-alt'></i>
        </button>
    </a>

</div>

