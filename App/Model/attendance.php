<?php 

function attendance_basic ($conn){
    $stmt = $conn -> prepare(
        "   SELECT * 
            FROM `attendance` 
        ");    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetch();
    $conn = null;
    return $best;
}

function check_att_user($conn, $userid){
    $stmt = $conn -> prepare(
        "   SELECT * 
            FROM `attendancelog` 
            WHERE `UserID` = :user 
            AND DATE(`CreatedAt`) = CURDATE()
        ");    
    $stmt->bindParam(":user", $userid);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();
    $conn = null;
    return $result;
}
