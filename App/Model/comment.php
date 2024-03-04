<?php 

session_start();
ob_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function enter_cmt($conn, $content, $user, $idsp){
    // $idpro = $_GET['products_detail_id'];
    try {
        $stmt = $conn->prepare("

        INSERT INTO `comments` (`UserID`, `ProductID`, `CreatedAt`, `Content`) 
        VALUES (:user, :idpro, NOW(), :content)");

        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':idpro', $idsp);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}

function edit_cmt($conn, $content_new, $cmtid){
    try {
        $stmt = $conn->prepare("
        UPDATE `comments` 
        SET `Content` = :content
        WHERE `CommentID` = :cmtid; 
        ");
        $stmt->bindParam(':content', $content_new);
        $stmt->bindParam(':cmtid', $cmtid);
        
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}

function remove_cmt($conn, $id_xoa){
    try {
        $stmt = $conn->prepare("
            DELETE FROM `comments` 
            WHERE `CommentID` = :idcmt
        ");
        $stmt->bindParam(':idcmt', $id_xoa);
        $stmt->execute();
        echo "Xóa dữ liệu okay!";
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['content_new']) && isset($_POST['cmtid'])) {
        $content_new = $_POST['content_new'] ?? '';
        $cmtid = $_POST['cmtid'] ?? '';
        edit_cmt($pdoConnection, $content_new, $cmtid);
        return;
    };

    if (isset($_POST['cmt_bixoa'])) {
        $id_xoa = $_POST['cmt_bixoa'] ?? '';
        remove_cmt($pdoConnection, $id_xoa);
        return;
    };

    $content = $_POST['content'] ?? '';
    $user = $_POST['user'] ?? '';
    $idsp = $_POST['spnaovay'];

    enter_cmt($pdoConnection, $content, $user, $idsp);

}


