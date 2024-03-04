<?php 

session_start();
ob_start();

include "../../Config/database.php";
include "../../Config/paths.php";

// ==================CHUYEN ANH

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

// =================THONG BAO

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

function create_notification($conn, $follower_id, $collectionid){
    if (!isset($_SESSION['iduser'])) {
        return;
    }

    $flwing = $_SESSION['iduser'];
    try {
        $stmt = $conn -> prepare(
            "   INSERT INTO `follownotifications` (`FollowerID`, `FollowingID`, `CollectionID`, `ProductID`, `Title`, `CreatedAt`)
                VALUES (:user_nhannoti, :noticuauser, :idbosuutap, NULL, 'Đã thêm một bộ sưu tập', NOW())
            ");    
        $stmt->bindParam(':user_nhannoti', $follower_id);
        $stmt->bindParam(':noticuauser', $flwing);
        $stmt->bindParam(':idbosuutap', $collectionid);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}

function add_collection($conn, $input1, $input2, $image1, $image2, $image3, $iduser){
    try {
        $sql = "INSERT INTO `collections` (`Name`, `Description`, `LogoImage`, `BannerImage`, `FeaturedImage`, `CreatorID`, `TimeCreated`) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$input1, $input2, $image1, $image2, $image3, $iduser]);
        
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
    } catch (PDOException $e) {
        die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image1 = uploadFile('image1', COLLECTION_PATH);
    $image2 = uploadFile('image2', COLLECTION_PATH);
    $image3 = uploadFile('image3', COLLECTION_PATH);

    $input1 = $_POST['input1'] ?? '';
    $input2 = $_POST['input2'] ?? '';

    $iduser = $_SESSION['iduser'] ?? '';

    $result = add_collection($pdoConnection, $input1, $input2, $image1, $image2, $image3, $iduser);

    echo json_encode($result);
}


