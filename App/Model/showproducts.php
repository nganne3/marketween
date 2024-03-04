<?php 

function showAllProducts($conn){
    $stmt = $conn -> prepare(
    "   SELECT `products`.*,
        `prices`.`ListedPrice`,
        `users`.`Username`, `users`.`UserID`,
        `categories`.`Name` AS `namecate`,
        `collections`.`Name` AS `name_collections`, `collections`.`CreatorID`
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

function showAllProducts_user($conn, $idlgn){
    
    $stmt = $conn -> prepare(
    "   SELECT `products`.*,
        `prices`.`ListedPrice`,
        `users`.`Username`, `users`.`UserID`,
        `categories`.`Name` AS `namecate`,
        `collections`.`Name` AS `name_collections`, `collections`.`CreatorID`
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
        WHERE `users`.`UserID` = :userID
    ");
    $stmt->execute([':userID' => $idlgn]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    $conn = null;
    return $best;
}



