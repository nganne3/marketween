<?php 

function getOrdersAndDetails($id, $conn) {
    $stmt = $conn->prepare("SELECT `orders`.*, `orders`.`CreatedAt` AS `timecreate`, `orderdetails`.*  
                            FROM `orders` 
                            JOIN `orderdetails` 
                            ON `orders`.`OrderID` = `orderdetails`.`OrderID`
                            WHERE `orders`.`OrderID` = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
