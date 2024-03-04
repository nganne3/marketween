<?php 

session_start();
ob_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function uploadFile($fileInput, $targetDirectory) {
    if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] == 0) {
        $extension = pathinfo($_FILES[$fileInput]['name'], PATHINFO_EXTENSION);

        do {
            $uniqueName = uniqid() . '.' . $extension;
            $targetPath = $targetDirectory . '/' . $uniqueName;
        } while (file_exists($targetPath));

        if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetPath)) {
            return $uniqueName;
        }
    }
    return false;
}


// ======================THONG BAO

function get_followers($conn){
    if (!isset($_SESSION['iduser'])) {
        return [];
    }

    $user_id = $_SESSION['iduser'];
    $stmt = $conn -> prepare(
        "   SELECT `FollowerID`
            FROM `follow`
            WHERE `FollowingID` = :user_id
        ");    
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $followers = $stmt->fetchAll();
    return $followers;
}

function create_notification($conn, $follower_id, $pr){
    if (!isset($_SESSION['iduser'])) {
        return;
    }
    $flwing = $_SESSION['iduser'];
    try {
        $stmt = $conn -> prepare(
            "   INSERT INTO `follownotifications` (`FollowerID`, `FollowingID`, `CollectionID`, `ProductID`, `Title`, `CreatedAt`)
                VALUES (:user_nhannoti, :noticuauser, NULL, :idpr, 'Đã thêm một sản phẩm mới', NOW())
            ");    
        $stmt->bindParam(':user_nhannoti', $follower_id);
        $stmt->bindParam(':noticuauser', $flwing);
        $stmt->bindParam(':idpr', $pr);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}


function add_products($conn, $img, $driver, $name, $des, $collection, $category){
    $sql = "INSERT INTO `products` (`ImageURL`, `FileURL`, `Name`, `Description`, `CollectionID`, `Category`, `CreatedAt`) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$img, $driver, $name, $des, $collection, $category]);
    if ($result) {

        $lastId = $conn->lastInsertId();

        $followers = get_followers($conn);

        foreach ($followers as $follower) {
            create_notification($conn, $follower['FollowerID'], $lastId);
        }

        return ['success' => true, 'id' => $lastId];
    } else {
        return ['success' => false];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $img = uploadFile('file', IMAGE_PATH);
    if (!$img) {
        echo json_encode(['success' => false, 'message' => 'File upload failed']);
        return;
    }

    $driver = !empty($_POST['drive_link']) ? $_POST['drive_link'] : null;
    $name = $_POST['text1'] ?? '';
    $des = !empty($_POST['text2']) ? $_POST['text2'] : null;
    $collection = $_POST['select1'] ?? '';
    $category = $_POST['select2'] ?? '';

    $result = add_products($pdoConnection, $img, $driver, $name, $des, $collection, $category);

    if (!$result['success']) {
        echo json_encode(['success' => false, 'message' => 'SQL query failed']);
        return;
    }

    echo json_encode($result);
}
