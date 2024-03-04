<?php 

session_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function cap_nhat_coins($conn, $user){
    try {
        $stmt = $conn->prepare("SELECT `Coins` FROM `users` WHERE `UserID` = :user");
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $coins = $result['Coins'];
        if (isset($_SESSION['Coins'])) {
            $_SESSION['Coins'] = $coins;
        };
        echo "Đã cập nhật coins";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
    
}

function att_done($conn, $user){
    try {
        $att = '1';
        $stmt = $conn->prepare("
        INSERT INTO `attendancelog` (`UserID`, `CreatedAt`, `ATDID`) 
        VALUES (:user, NOW(), :attid)");
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':attid', $att);
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}


function set_coins($conn, $user, $coins){
    try {
        $stmt = $conn->prepare("
        UPDATE `users` 
        SET `Coins` = `Coins` + :coins 
        WHERE `UserID` = :user");
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':coins', $coins);
        $stmt->execute();
        cap_nhat_coins($conn, $user);
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['iduser'])) {
        $user = $_SESSION['iduser'];
    }
    else{
        $user = '';
    }
    $coins = $_POST['coins'] ?? '';


    att_done($pdoConnection, $user);
    set_coins($pdoConnection, $user, $coins);


}