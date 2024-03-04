<?php 

function get_your_info($conn, $is_your_collection){
    $stmt = $conn -> prepare(
        "   SELECT `collections`.*, `users`.*, COUNT(`products`.`ProductID`) as `TotalProducts`
            FROM `collections` 
            JOIN `users`
            ON `users`.UserID = `collections`.`CreatorID`
            LEFT JOIN `products`
            ON `products`.`CollectionID` = `collections`.`CollectionID`
            WHERE `collections`.`CollectionID` = :id
            GROUP BY `collections`.`CollectionID`
        ");
    $stmt->bindParam(':id', $is_your_collection);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetch();
    $conn = null;
    return $best;
}

function get_your_is_products($conn, $is_your_collection){
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
            WHERE `collections`.`CollectionID` = :id
        ");
    $stmt->bindParam(':id', $is_your_collection);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}

