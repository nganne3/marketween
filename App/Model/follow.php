<?php 

session_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function set_flow($conn, $ed, $ing){
    try {
        $stmt = $conn->prepare(
            "   INSERT INTO `follow` (`FollowerID`, `FollowingID`) 
                VALUES (:id_ed, :id_ing)
            ");
        $stmt->bindParam(':id_ed', $ed);
        $stmt->bindParam(':id_ing', $ing);
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}

function unset_flow($conn, $ed, $ing){
    try {
        $stmt = $conn->prepare(
            "   DELETE FROM `follow` 
                WHERE `FollowerID` = :id_ed AND `FollowingID` = :id_ing
            ");
        $stmt->bindParam(':id_ed', $ed);
        $stmt->bindParam(':id_ing', $ing);
        $stmt->execute();
        echo "Xóa dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['flwer_huy']) && isset($_POST['flwing_huy'])) {

        $ed = $_POST['flwer_huy'] ?? '';
        $ing = $_POST['flwing_huy'] ?? '';
        
        unset_flow($pdoConnection, $ed, $ing);
        return;
    }

    if (isset($_POST['flwer']) && isset($_POST['flwing'])) {
        $ed = $_POST['flwer'] ?? '';
        $ing = $_POST['flwing'] ?? '';
        set_flow($pdoConnection, $ed, $ing);
        return;
    }
}