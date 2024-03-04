<?php 

function notifcations($conn){
    if (!isset($_SESSION['iduser'])) {
       return;
    };
    $id = $_SESSION['iduser'];
    try {
        $stmt = $conn->prepare(
            "   SELECT `follownotifications`.*, 
                `users`.`UserID`, `users`.`Username`, 
                `collections`.`FeaturedImage`, `collections`.`CollectionID`,
                `products`.`ProductID`, `products`.`ImageURL`
                FROM `follownotifications` 
                JOIN `users`
                ON `users`.`UserID` = `follownotifications`.`FollowingID`
                LEFT JOIN `collections`
                ON `collections`.`CollectionID` = `follownotifications`.`CollectionID`
                LEFT JOIN `products`
                ON `products`.`ProductID` = `follownotifications`.`ProductID`
                WHERE `FollowerID` = :id
            ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $userInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($userInfo) {
            foreach ($userInfo as &$row) {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['CreatedAt']);
                if ($date !== false) {
                    $row['CreatedAt'] = $date->format('H:i \n\g\à\y d/m/Y');
                }
            }
            return $userInfo;
        }
               
        return $userInfo;

    } catch (PDOException $e) {
        return null;
    }
}
