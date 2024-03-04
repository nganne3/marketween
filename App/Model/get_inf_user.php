<?php 

function getUserInfoFromDatabase($conn, $id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `UserID` = :user_id");
        $stmt->bindParam(":user_id", $id);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userInfo;
    } catch (PDOException $e) {
        return null;
    }
} 

