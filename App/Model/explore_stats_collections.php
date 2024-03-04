<?php 

include "../../Config/database.php";
include "../../Config/paths.php";

function stats_collections($conn, $time_period){

    if (is_null($time_period) || $time_period == '') {
        $time_period = 'daily';
    };

    $date_format = '%Y-%m';
    if ($time_period == 'daily') {
        $date_format = '%Y-%m-%d';
    } elseif ($time_period == 'hourly') {
        $date_format = '%Y-%m-%d %H';
    } elseif ($time_period == 'weekly') {
        $date_format = '%Y-%u';
    } elseif ($time_period == '30days') {
        $date_format = '%Y-%m-%d';
    }

    $stmt = $conn -> prepare(" 
    SELECT 
        DATE_FORMAT(prices.CreatedAt, '".$date_format."') AS time_period,
        collections.CollectionID,
        collections.Description,
        collections.Name,
        collections.LogoImage,
        collections.Sold,
        collections.Volume,
        collections.Floor,
        collections.CreatorID,
        AVG(orderdetails.Price) AS avg_revenue,
        (SELECT MIN(ListedPrice) FROM prices WHERE CreatedAt = (SELECT MAX(CreatedAt) FROM prices)) AS floor
    FROM
        collections
     JOIN products ON products.CollectionID = collections.CollectionID
     JOIN orderdetails ON orderdetails.ProductID = products.ProductID
     JOIN prices ON prices.ProductID = products.ProductID
    GROUP BY
        time_period, collections.CollectionID
    ");
    $stmt->execute();
    $allRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $prevRow = null;
    foreach($allRows as &$row) {
        $row['avg_revenue'] = is_null($row['avg_revenue']) ? 0 : $row['avg_revenue'];
        $row['floor'] = is_null($row['floor']) ? 0 : $row['floor'];
        if ($prevRow) {
            if ($prevRow['avg_revenue'] != 0) {
                $changeRate = (($row['avg_revenue'] - $prevRow['avg_revenue']) / $prevRow['avg_revenue']) * 100;
                $row['revenueChangeRate'] = number_format($changeRate, 2);
            } else {
                $row['revenueChangeRate'] = 0;
            }
            if ($prevRow['floor'] != 0) {
                $changeRate = (($row['floor'] - $prevRow['floor']) / $prevRow['floor']) * 100;
                $row['floorChangeRate'] = number_format($changeRate, 2);
            } else {
                $row['floorChangeRate'] = 0;
            }
        } else {
            $row['revenueChangeRate'] = 0;
            $row['floorChangeRate'] = 0;
        }
        $prevRow = $row;
    }
    $conn = null;
    return $allRows;    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $time_period = 'daily'; 
    
    if (!empty($_POST['hourly'])) {
        $time_period = 'hourly';
    } else if (!empty($_POST['daily'])) {
        $time_period = 'daily';
    } else if (!empty($_POST['weekly'])) {
        $time_period = 'weekly';
    } else if (!empty($_POST['day30'])) {
        $time_period = '30days';
    }

    $incoll = stats_collections($pdoConnection, $time_period);
}

$yan = '';
$stt = '1';
$tangtruongfloor = '+';
$tangtruongvolu = '+';
$color_floor = 'text-green';
$color_volu = 'text-green';

$html = '';

foreach($incoll as $onii_chan_nee){
    // var_dump($onii_chan_nee);
    extract($onii_chan_nee, EXTR_PREFIX_ALL, 'this');
    if ($this_Sold >= 1000 ) {
       $yan = 'K';
    }
    elseif($this_Sold >= 1000000) {
        $yan = 'M';
    }

    if ($this_Sold >= 1000 ) {
        $yan = 'K';
    };
    if($this_Sold >= 1000000) {
        $yan = 'M';
    };

    if ($this_floorChangeRate < 0) {
        $tangtruongfloor = '';
        $color_floor = 'text-red';
    };
    if($this_floorChangeRate == 0){
        $tangtruongfloor = '';
        $color_floor = '';
    };
    if ($this_floorChangeRate > 0) {
        $color_floor = 'text-green';
        $tangtruongfloor = '+';
    };

    if ($this_revenueChangeRate < 0) {
        $tangtruongvolu = '';
        $color_volu = 'text-red';
    };
    if($this_revenueChangeRate == 0){
        $tangtruongvolu = '';
        $color_volu = '';
    };
    if($this_revenueChangeRate > 0){
        $tangtruongvolu = '+';
        $color_volu = 'text-green';
    };

    if (isset($_SESSION['iduser'])) {
        if ($this_CreatorID == $_SESSION['iduser']) {
            $href = 'index.php?act=my_collection&mycollection='.$this_CollectionID.'';
        }else{
            $href = 'index.php?act=your_collection&yourcollection='.$this_CollectionID.'';
        }
    }
    else{
        $href = 'index.php?act=your_collection&yourcollection='.$this_CollectionID.'';
    }

    $html .= '
    
    <a href="'.$href.'" class="display-flex align-items-center justify-content-space-between bangxephang-at-trending-collections-page-home row-rank-collections margin-top-bot-0px huydisplay_flex_responsive_duythai bodermoi_responsive_duythai huyhover_responsive_duythai thucdong">
        <div class="display-flex align-items-center justify-content-space-between col-rank-at-trending-collections-page-home col-margin-right-rank">
            <div class="display-flex justify-content-center dauthang-rank an_responsive_duythai">
                '.$stt .'
            </div>
        </div>
        <div class="display-flex align-items-center col-margin-right-rank width-100phantram  display_flexmoi_responsive_duythai">
            <div class="display-flex col-margin-right-rank width-100phantram align-items-center display_flexmoi_responsive_duythai">
                <div class="img-avt-collections-at-rank-table">
                    <img class="img-avt-collections-at-rank-table-main" src="'. COLLECTION_PATH .''.$this_LogoImage.'" alt="">
                </div>
                <div class="font-weight-500 font_sizemoi_responsive_duythai">
                    '.$this_Name.'
                </div>
                <div class="i_responsive_duythai">
                    <i class="bx bx-right-arrow-alt i_responsive_duythai14"></i>
                </div>
            </div>
        </div>
        <div class="display-flex align-items-center justify-content-space-between width-100phantram anchinh_responsive_duythai display_flexmoi_responsive_duythai font_size_responsive_duythai">
            <div class="display-flex flex-end col-margin-right-rank width-100phantram huydisplay_flex_responsive_duythai font-weight_responsive_duythai">
                Doanh Thu
            </div>
            <div class="display-flex flex-end col-margin-right-rank width-100phantram huydisplay_flex_responsive_duythai right_responsive_duythaii font-weight_responsive_duythai">
                Giá sàn
            </div>
        </div>
        <div class="display-flex align-items-center justify-content-space-between width-100phantram huydisplay_flex_responsive_duythai">
            <div class="display-flex flex-end col-margin-right-rank width-100phantram huydisplay_flex_responsive_duythai">
                <span class="coins_responsive_duythai">'.$this_Floor.'</span>&nbsp;<span class="coins_responsive_duythai14">Coins</span> 
            </div>
            <div class="display-flex flex-end col-margin-right-rank width-100phantram '.$color_floor.' tyle-thaydoi-floor huydisplay_flex_responsive_duythai red_responsive_duythai">
                <span>'.$tangtruongfloor.'</span><span>'.$this_floorChangeRate.'</span><span>%</span>
            </div>
        </div>
        <div class="display-flex align-items-center justify-content-space-between col-volume-at-trending-collections-page-home width-100phantram huydisplay_flex_responsive_duythai margin_responsive_duythai ">
            <div class="display-flex flex-end col-margin-right-rank width-100phantram margin-top_responsive_duythai">
                <span class="coins_responsive_duythai">'.$this_Volume.'</span>&nbsp;<span class="coins_responsive_duythai14">Coins</span> 
            </div>
            <div class="display-flex flex-end col-margin-right-rank width-100phantram tyle-thaydoi-volume '.$color_volu.' left_responsive_duythai red_responsive_duythai" >
                <span>'.$tangtruongvolu.'</span><span>'.$this_revenueChangeRate.'</span><span>%</span>
            </div>
        </div>
        <div class="col-selled-at-trending-collections-page-home display-flex flex-end col-margin-right-rank huydisplay_flex_responsive_duythai">
            <div class="display-flex flex-end col-margin-right-rank width-100phantram an_responsive_duythai">
                <span>'.$this_Sold.'</span><span>'.$yan.'</span>
            </div>
        </div>
    </a>

    ';
    $stt++;
}

echo $html;


