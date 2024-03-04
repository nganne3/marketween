<?php 

function get_product_info($conn, $my_pro_id){
    $stmt = $conn -> prepare(
        "   SELECT `products`.*,
            `prices`.`ListedPrice`, `prices`.`CreatedAt` AS `last_price`,
            `users`.`Username`, `users`.`UserID`, `users`.`AvatarImage`,
            `categories`.`Name` AS `namecate`,
            `collections`.`Name` AS `name_bosuutap`, `collections`.`LogoImage`, `collections`.`CollectionID`
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
            WHERE `products`.`ProductID` = :id 
            -- AND `prices`.`ListedPrice` <> 0;
        ");
        $stmt->bindParam(':id', $my_pro_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $best = $stmt->fetch();
        $conn = null;
        return $best;
}

function get_comment($conn, $my_pro_id){

    if (!isset($_SESSION['limit'])) {
        $_SESSION['limit'] = 5;
    } else {
        $_SESSION['limit'] += 5;
    }

    $stmt = $conn -> prepare(
        "   SELECT `comments`.*, `users`.`Username`, `users`.`AvatarImage`
            FROM `comments` 
            JOIN `products`
            ON `comments`.`ProductID` = `products`.`ProductID`
            JOIN `users`
            ON `comments`.`UserID` = `users`.`UserID`
            WHERE `comments`.`ProductID` = :ys 
            LIMIT :limit
        ");

    $stmt->bindParam(':ys', $my_pro_id);
    $stmt->bindParam(':limit', $_SESSION['limit'], PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}


function related_product($conn, $collection, $breakid){

    $stmt = $conn -> prepare(
        "   SELECT `products`.*,
            `prices`.`ListedPrice`, `prices`.`CreatedAt` AS `last_price`,
            `users`.`Username`, `users`.`UserID`, `users`.`AvatarImage`,
            `categories`.`Name` AS `namecate`,
            `collections`.`Name` AS `name_bosuutap`, `collections`.`LogoImage`, `collections`.`CollectionID`
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
            WHERE `products`.`ProductID` != :id 
            AND `products`.`CollectionID` = :cll;
        ");
    $stmt->bindParam(':id', $breakid);
    $stmt->bindParam(':cll', $collection);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}





