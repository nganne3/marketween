<?php 

session_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function set_link_driver($conn, $driver, $idpro){
    try {
        $stmt = $conn->prepare("UPDATE `products` SET `FileURL` = :driver WHERE `ProductID` = :idpro");

        $stmt->bindParam(':driver', $driver);
        $stmt->bindParam(':idpro', $idpro);

        $stmt->execute();

        echo "Cập nhật dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
    
}

function set_a_prices($conn, $price, $idpro){
    try {
        $stmt = $conn->prepare("INSERT INTO `prices` (`ListedPrice`, `ProductID`, `CreatedAt`) VALUES (:price, :idpro, NOW())");
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':idpro', $idpro);
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}

function huy_niemyet($conn, $idsp){
    try {
        $stmt = $conn->prepare("
        UPDATE `prices` 
        SET `ListedPrice` = :vl
        WHERE `ProductID` = :idpro 
        AND `PriceID` = 
            (SELECT MAX(`PriceID`) 
            FROM `prices`
            WHERE `ProductID` = :idpro);
        ");

        $zero = 0;
        $stmt->bindParam(':vl', $zero);
        $stmt->bindParam(':idpro', $idsp);

        $stmt->execute();

        echo "Cập nhật dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['id_huyban']) {
        huy_niemyet($pdoConnection, $_POST['id_huyban']);
        return;
    }

    $price = $_POST['input1'] ?? '';
    $driver = $_POST['input2'] ?? '';
    $idpro = $_POST['idpr'] ?? '';

    set_link_driver($pdoConnection, $driver, $idpro);
    set_a_prices($pdoConnection, $price, $idpro);
}