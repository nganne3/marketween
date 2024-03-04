<?php 

function show_all_collec($conn){
    $stmt = $conn -> prepare(
    "   SELECT `products`.*, `prices`.`ListedPrice`, `users`.`Username`, `users`.`UserID`, `categories`.`Name` AS `namecate`
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
    ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

function show_tatca_collec($conn, $iduser){

    $stmt = $conn -> prepare(" SELECT * FROM `collections` WHERE `CreatorID` = :id ");
    $stmt->bindParam(":id", $iduser);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}


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
    LIMIT 5;
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
