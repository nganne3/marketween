<?php 

function home_n_collection($conn){
    $stmt = $conn -> prepare(
    "   SELECT `collections`.*, `users`.*
        FROM `collections`
        JOIN `users`
        ON `users`.`UserID` = `collections`.`CreatorID`
        WHERE `TimeCreated` >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
        LIMIT 10;
    ");
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

function show_all_banner($conn){
    $stmt = $conn -> prepare(
    "   SELECT `collections`.*, `users`.*
        FROM `collections`
        JOIN `users`
        ON `collections`.`CreatorID` = `users`.`UserID`
        ORDER BY 
        `collections`.`Volume` DESC, 
        `collections`.`Floor` DESC, 
        `collections`.`Views` DESC, 
        `collections`.`TimeCreated` DESC
        LIMIT 3;
    ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

// ===================CAP NHAT FOLLOW=====================

function update_followers($conn){
    // Đặt tất cả giá trị trong cột followers về 0
    $stmt = $conn -> prepare(
        "   UPDATE `users`
            SET `followers` = 0
        ");    
    $stmt->execute();

    // Lấy số lượng người theo dõi từ bảng follow
    $stmt = $conn -> prepare(
        "   SELECT `FollowingID`, COUNT(`FollowerID`) AS `follower_count`
            FROM `follow`
            GROUP BY `FollowingID`
        ");    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $followers = $stmt->fetchAll();

    // Cập nhật số lượng người theo dõi trong bảng users
    foreach ($followers as $follower) {
        $stmt = $conn -> prepare(
            "   UPDATE `users`
                SET `followers` = :follower_count
                WHERE `UserID` = :user_id
            ");    
        $stmt->bindParam(':follower_count', $follower['follower_count']);
        $stmt->bindParam(':user_id', $follower['FollowingID']);
        $stmt->execute();
    }

    $conn = null;
}

function update_following($conn){
    // Đặt tất cả giá trị trong cột following về 0
    $stmt = $conn -> prepare(
        "   UPDATE `users`
            SET `following` = 0
        ");    
    $stmt->execute();

    // Lấy số lượng người mà mỗi người dùng đang theo dõi từ bảng follow
    $stmt = $conn -> prepare(
        "   SELECT `FollowingID`, COUNT(`FollowerID`) AS `following_count`
            FROM `follow`
            GROUP BY `FollowingID`
        ");    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $following = $stmt->fetchAll();

    // Cập nhật số lượng người mà mỗi người dùng đang theo dõi trong bảng users
    foreach ($following as $follow) {
        $stmt = $conn -> prepare(
            "   UPDATE `users`
                SET `following` = :following_count
                WHERE `UserID` = :user_id
            ");    
        $stmt->bindParam(':following_count', $follow['following_count']);
        $stmt->bindParam(':user_id', $follow['FollowingID']);
        $stmt->execute();
    }

    $conn = null;
}

// ===================LAY SO LUONG FOLLOW=====================

function top_follow($conn, $my_id){
    $stmt = $conn -> prepare(
        "   SELECT `u`.*, 
            CASE 
                WHEN EXISTS (
                    SELECT 1 FROM `follow` 
                    WHERE `FollowerID` = :my_id AND `FollowingID` = `u`.`UserID`
                ) THEN 'true'
                ELSE 'false'
            END AS `is_following`
            FROM `users` u
            WHERE `u`.`Role` <> 'admin'
            ORDER BY `Followers` DESC 
            LIMIT 6;
        ");    
    $stmt->bindParam(':my_id', $my_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

function formatFollowerCount($count) {
    if ($count >= 1000000) {
        return number_format($count / 1000000, 1) . 'M';
    } else if ($count >= 1000) {
        return number_format($count / 1000, 1) . 'K';
    } else {
        return $count;
    }
}

function best_bussiness($conn){
    $stmt = $conn -> prepare(
        "   SELECT `u`.*, 
            SUM(c.Sold) AS total_sold, 
            SUM(c.Volume) AS total_volume
            FROM `users` u
            LEFT JOIN `collections` c ON `u`.`UserID` = `c`.`CreatorID`
            WHERE `u`.`Role` <> 'admin'
            GROUP BY `u`.`UserID`
            ORDER BY total_sold DESC, total_volume DESC
        ");    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

function best_grid_sales($conn){
    $stmt = $conn -> prepare(
        "   SELECT `u`.*, 
            SUM(c.Sold) AS total_sold, 
            SUM(c.Volume) AS total_volume
            FROM `users` u
            LEFT JOIN `collections` c ON `u`.`UserID` = `c`.`CreatorID`
            WHERE `u`.`Role` <> 'admin'
            GROUP BY `u`.`UserID`
            ORDER BY total_sold DESC, total_volume DESC
            LIMIT 6
        ");    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

function best_bussiness_6_to_10($conn){
    $stmt = $conn->prepare(
        "SELECT `u`.*, 
        SUM(c.Sold) AS total_sold,
        SUM(c.Volume) AS total_volume
        FROM `users` u
        LEFT JOIN `collections` c ON `u`.`UserID` = `c`.`CreatorID`
        WHERE `u`.`Role` <> 'admin'
        GROUP BY `u`.`UserID`
        ORDER BY total_sold DESC, total_volume DESC
        LIMIT 5, 5;
    ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

function best_bussiness_0_to_5($conn){
    $stmt = $conn->prepare(
        "SELECT `u`.*, 
        SUM(c.Sold) AS total_sold,
        SUM(c.Volume) AS total_volume
        FROM `users` u
        LEFT JOIN `collections` c ON `u`.`UserID` = `c`.`CreatorID`
        WHERE `u`.`Role` <> 'admin'
        GROUP BY `u`.`UserID`
        ORDER BY total_sold DESC, total_volume DESC
        LIMIT 0, 5;
    ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

