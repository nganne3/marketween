<?php 

function get_user_info($conn, $iduser){
    $stmt = $conn -> prepare("
        SELECT `users`.*, 
        (SELECT COUNT(FollowerID) FROM `follow` WHERE `FollowingID` = :id) AS `followers`,
        (SELECT COUNT(FollowingID) FROM `follow` WHERE `FollowerID` = :id) AS `following`
        FROM `users`
        WHERE `UserID` = :id
    ");
    $stmt->bindParam(":id", $iduser);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetch();
    $conn = null;
    return $best;
}

function get_collection_user($conn, $iduser, $time_period){

    if (is_null($time_period) || $time_period == '') {
        $time_period = 'daily';
    }
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
        AVG(orderdetails.Price) AS avg_revenue,
        MIN(prices.ListedPrice) AS floor
    FROM
        collections
    LEFT JOIN products ON products.CollectionID = collections.CollectionID
    LEFT JOIN orderdetails ON orderdetails.ProductID = products.ProductID
    LEFT JOIN prices ON prices.ProductID = products.ProductID
    WHERE
        collections.CreatorID = :creatorId
    GROUP BY
        time_period, collections.CollectionID
    ORDER BY
        time_period;
    ");
    $stmt->bindParam(":creatorId", $iduser);
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


function get_your_is_products($conn, $is_user){
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
            WHERE `users`.`UserID` = :id
        ");
    $stmt->bindParam(':id', $is_user);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}
