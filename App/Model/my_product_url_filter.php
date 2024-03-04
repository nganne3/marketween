<?php 

session_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function filterProducts($trend, $minPrice, $maxPrice,
$priced, $unpriced, $images, $video, $sound, $price_desc, $price_asc, $conn){
    $userID = $_SESSION['iduser'];

    $query = "SELECT `products`.*, `prices`.`ListedPrice`, `users`.`Username`, `users`.`UserID`, `categories`.`Name` AS `namecate`
    FROM `products`
    JOIN `collections`
    ON `collections`.`CollectionID` = `products`.`CollectionID`
    JOIN `users`
    ON `users`.`UserID` = `collections`.`CreatorID`
    JOIN `categories`
    ON `categories`.`CategoryID` = `products`.`Category`
    LEFT JOIN `prices`
    ON `products`.`ProductID` = `prices`.`ProductID`
    AND `prices`.`CreatedAt` = (
        SELECT MAX(`CreatedAt`) 
        FROM `prices`
        WHERE `products`.`ProductID` = `prices`.`ProductID`
    )
    WHERE 1
    AND `users`.`UserID` = :userID
    ";

    if ($priced !== null && $priced !== '') {
        $query .= " AND `prices`.`ListedPrice` IS NOT NULL";
    }

    if ($unpriced !== null && $unpriced !== '') {
        $query .= " AND `prices`.`ListedPrice` IS NULL";
    }

    // -------------

    if ($minPrice !== null && $minPrice !== '') {
        $query .= " AND `prices`.`ListedPrice` >= :minPrice";
    }

    if ($maxPrice !== null && $maxPrice !== '')  {
        $query .= " AND `prices`.`ListedPrice` <= :maxPrice";
    }

    // -----------

    $conditions = [];
    $params = [];

    if ($images !== null && $images !== '') {
        $conditions[] = "`products`.`Category` = :images";
        $params[':images'] = $images;
    }

    if ($video !== null && $video !== '') {
        $conditions[] = "`products`.`Category` = :video";
        $params[':video'] = $video;
    }

    if ($sound !== null && $sound !== '') {
        $conditions[] = "`products`.`Category` = :sound";
        $params[':sound'] = $sound;
    }

    if (!empty($conditions)) {
        $query .= ' AND (' . implode(' OR ', $conditions) . ')';
    }

    // -------------

    $order_by = '';

    if ($trend !== null && $trend !== '') {
        $order_by = "`products`.`Views` DESC";
    }
    
    if ($price_desc !== null && $price_desc !== '') {
        $order_by = "`prices`.`ListedPrice` DESC";
    }
    
    if ($price_asc !== null && $price_asc !== '') {
        $order_by = "`prices`.`ListedPrice` ASC";
    }
    
    if ($order_by !== '') {
        $query .= " ORDER BY $order_by";
    }

    $stmt = $conn -> prepare($query);

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

    if ($minPrice !== null && $minPrice !== '') {
        $stmt->bindParam(':minPrice', $minPrice, PDO::PARAM_INT);
    }

    if ($maxPrice !== null && $maxPrice !== '') {
        $stmt->bindParam(':maxPrice', $maxPrice, PDO::PARAM_INT);
    }
    
    if ($video !== null && $video !== '') {
        $stmt->bindParam(':video', $video, PDO::PARAM_STR);
    }
    
    if ($sound !== null && $sound !== '') {
        $stmt->bindParam(':sound', $sound, PDO::PARAM_STR);
    } 

    if ($images !== null && $images !== '') {
        $stmt->bindParam(':images', $images, PDO::PARAM_STR);
    } 

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $products = $stmt->fetchAll();
    return $products;
}        

// ===========================CHECK URL==============================

$html = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $priced = isset($_POST['priced']) ? $_POST['priced'] : null;
    $unpriced = isset($_POST['unpriced']) ? $_POST['unpriced'] : null;

    $sound = isset($_POST['sound']) ? $_POST['sound'] : null;
    $video = isset($_POST['video']) ? $_POST['video'] : null;
    $images =isset($_POST['images']) ? $_POST['images'] : null;

    $trend = isset($_POST['trend']) ? $_POST['trend'] : null;
    $price_asc = isset($_POST['price_asc']) ? $_POST['price_asc'] : null;
    $price_desc = isset($_POST['price_desc']) ? $_POST['price_desc'] : null;

    $minPrice = isset($_POST['minPrice']) ? $_POST['minPrice'] : null;
    $maxPrice = isset($_POST['maxPrice']) ? $_POST['maxPrice'] : null;

    filterProducts($trend, $minPrice, $maxPrice,
    $priced, $unpriced, $images, $video, $sound, 
    $price_desc, $price_asc, $pdoConnection);
}

$filterProducts = filterProducts($trend, $minPrice, $maxPrice, $priced, $unpriced, $images, $video, $sound, $price_desc, $price_asc, $pdoConnection);

if(isset($_SESSION['iduser'])) {
    $login_ex = $_SESSION['iduser'];
} else {
    $login_ex = 'marketween';
}

$set_a_price = "";
$not_a_price = "";

if (is_array($filterProducts) && !empty($filterProducts)) {
    foreach($filterProducts as $my){
        extract($my, EXTR_PREFIX_ALL, 'mypro');

        if ($mypro_ListedPrice == 0 || $mypro_ListedPrice == null) {
            $set_a_price = "<span>Chưa mở bán</span>";
            $not_a_price = "";
        }
        else{
            $set_a_price = "<span>Giá:</span> &nbsp; 
                        <span johan='cc' class='result_format'> $mypro_ListedPrice </span> 
                        <span class='vo_K_curn'></span>&nbsp;
                        <span class='who_curn'>Coins</span>";
            $not_a_price = 
            '
                <div class="display-flex justify-content-center box-add-to-cart-this-pro">

                    <div class="display-flex align-items-center ">

                        <input class="idpro_ex" type="hidden" value="'. $mypro_ProductID .'">
                        <input class="name_ex" type="hidden" value="'. $mypro_Name .'">
                        <input class="username_ex" type="hidden" value="'. $mypro_Username .'">
                        <input class="category_ex" type="hidden" value="'. $mypro_namecate .'">
                        <input class="price_ex" type="hidden" value="'. $mypro_ListedPrice .'">
                        <input class="img_ex" type="hidden" value="'. IMAGE_PATH .''. $mypro_ImageURL .'">
                        <input class="login_ex" type="hidden" value="'. $login_ex .'">

                        <div class="btn-buy-now-this-pro">
                            Đặt bán
                        </div>
                        <div class="btn-add-cart products_at_expro">
                            <i class="bx bx-plus"></i>
                        </div>

                    </div>
                </div>
            ';
        }

        $html .= '    
            <div class="items-pr-tang-thuong-154" data-id="'. $mypro_ProductID .'">
                <div class="items-pr-154">
                    <div class="items-pr-154-t1">
                        <a class="items-pr-154-t2" href="index.php?act=product_detail&products_detail_id='. $mypro_ProductID .'">
                            <div class="items-pr-154-t2-img">
                                <img src="'. IMAGE_PATH .''. $mypro_ImageURL .'" alt="">
                                '. $not_a_price .'
                            </div>
                            <div class="items-pr-154-t2-text">
                                <div class="items-pr-154-t2-text-name">
                                    '. $mypro_Name .'
                                </div>
                                <div class="display-flex align-items-center items-pr-154-t2-text-price">
                                    '. $set_a_price .'
                                </div>
                            </div>
                        </a>
                    </div>
                </div>                
            </div>         
        ';
    };
    
    echo $html;
}else{
    echo '<div style="text-align:center; padding: 50px 0; color:grey; width:100%;">Chưa có sản phẩm nào!</div>';
}








