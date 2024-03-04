<?php 

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
            ORDER BY total_sold DESC, total_volume DESC;
        ");    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}