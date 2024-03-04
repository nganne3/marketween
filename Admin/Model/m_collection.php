<?php
    // thống kê số lượng bộ sưu tập
    function collection_Amount(){
        $conn = connectdata();
        $sql = "SELECT count(*) AS AmountCollection FROM collections";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // show tất cả bộ sưu tập
    function collection_getAll(){
        $conn = connectdata();
        $stmt = $conn->prepare("
        SELECT col.CollectionID, col.Name, col.Views, col.Volume, col.Sold, col.LogoImage, col.Floor, u.Username, u.AvatarImage
        FROM collections col 
        LEFT JOIN users u 
        ON col.CreatorID = u.UserID");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // lấy bộ sưu tập show ở phần insert
    function collection_get(){
        $conn = connectdata();
        $sql = "SELECT * FROM collections";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    // kiểm tra xem có collection nào đang tồn tại hay không
    function collection_checkName($Name){
        $conn = connectdata();
        $sql = "SELECT * FROM collections WHERE Name = :name";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $Name);
        $stmt->execute();
    
        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] !== '00000') {
            throw new Exception("SQL Error: " . $errorInfo[2]);
        }
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        $result = $stmt->fetch();
    
        return ($result !== false);
    }
    
    // add collection
    function collection_add($Name, $Username, $Description, $LogoImage, $FeturedImage, $BannerImage){
        try {
            $conn = connectdata();
    
            $userQuery = $conn->prepare("SELECT UserID FROM users WHERE Username = :Username");
            $userQuery->bindParam(":Username", $Username);
            $userQuery->execute();
            $userResult = $userQuery->fetch(PDO::FETCH_ASSOC);
    
            if (!$userResult) {
                throw new Exception("User with username '$Username' not found.");
            }
    
            $sql = "INSERT INTO collections (Name, CreatorID, Description, LogoImage, FeaturedImage, BannerImage) 
                    VALUES (:Name, :CreatorID, :Description, :LogoImage, :FeaturedImage, :BannerImage)";
    
            $stmt = $conn->prepare($sql);
    
            $stmt->bindParam(":Name", $Name);
            $stmt->bindParam(":CreatorID", $userResult['UserID']);
            $stmt->bindParam(":Description", $Description);
            $stmt->bindParam(":LogoImage", $LogoImage);
            $stmt->bindParam(":FeaturedImage", $FeturedImage); 
            $stmt->bindParam(":BannerImage", $BannerImage);
    
            $result = $stmt->execute();
    
            if ($result === false) {
                throw new Exception("Error executing SQL statement: " . $stmt->errorInfo()[2]);
            }
    
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    // xóa 1 collection
    function collection_delete($CollectionID) {
        try {
            $conn = connectdata();
            $conn->beginTransaction();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec('SET foreign_key_checks = 0');

            // Xóa tất cả sản phẩm thuộc bộ sưu tập
            $deleteProductsSQL = "DELETE FROM products WHERE CollectionID = :CollectionID";
            $deleteProductsStmt = $conn->prepare($deleteProductsSQL);
            $deleteProductsStmt->bindParam(":CollectionID", $CollectionID);
            $deleteProductsStmt->execute();
    
            // Xóa bộ sưu tập
            $deleteCollectionSQL = "DELETE FROM collections WHERE CollectionID = :CollectionID";
            $deleteCollectionStmt = $conn->prepare($deleteCollectionSQL);
            $deleteCollectionStmt->bindParam(":CollectionID", $CollectionID);
            $deleteCollectionStmt->execute();
    
            // Lấy ID của người tạo bộ sưu tập
            $getCreatorIDSQL = "SELECT CreatorID FROM collections WHERE CollectionID = :CollectionID";
            $getCreatorIDStmt = $conn->prepare($getCreatorIDSQL);
            $getCreatorIDStmt->bindParam(":CollectionID", $CollectionID);
            $getCreatorIDStmt->execute();
            $creatorID = $getCreatorIDStmt->fetchColumn();
    
            if ($creatorID) {
                // Kiểm tra xem người tạo có bộ sưu tập nào khác không
                $checkCollectionSQL = "SELECT COUNT(*) FROM collections WHERE CreatorID = :CreatorID";
                $checkCollectionStmt = $conn->prepare($checkCollectionSQL);
                $checkCollectionStmt->bindParam(":CreatorID", $creatorID);
                $checkCollectionStmt->execute();
                $collectionCount = $checkCollectionStmt->fetchColumn();
    
                if ($collectionCount === 0) {
                    // Nếu không có bộ sưu tập nào khác, xóa người tạo
                    $deleteUserSQL = "DELETE FROM users WHERE UserID = :UserID";
                    $deleteUserStmt = $conn->prepare($deleteUserSQL);
                    $deleteUserStmt->bindParam(":UserID", $creatorID);
                    $deleteUserStmt->execute();
                }
            }
            $conn->exec('SET foreign_key_checks = 1');

            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error deleting collection and related data: " . $e->getMessage();
            return false;
        }
    }
    
    
    
    
    
    
    

    // xuất 1 collection dựa trên id
    function getCollectionById($collectionId) {
        $conn = connectdata();
        $stmt = $conn->prepare("
            SELECT col.CollectionID, col.Name, col.Description, col.Views, col.Volume, col.Sold, col.LogoImage, col.BannerImage, col.FeaturedImage, col.Floor, u.Username, u.AvatarImage
            FROM collections col 
            LEFT JOIN users u 
            ON col.CreatorID = u.UserID
            WHERE col.CollectionID = :collectionId
        ");
        $stmt->bindParam(':collectionId', $collectionId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $collection = $stmt->fetch();
    
        return $collection;
    }
    // edit collection
    function editCollection($Name, $Description, $LogoImage, $FeaturedImage, $BannerImage, $CollectionID) {
        $conn = connectdata();
        $stmt = $conn->prepare("
            UPDATE collections 
            SET Name = :Name, Description = :Description, LogoImage = :LogoImage, BannerImage = :BannerImage, FeaturedImage = :FeaturedImage
            WHERE CollectionID = :CollectionID
        ");
    
        $stmt->bindParam(':Name', $Name, PDO::PARAM_STR);
        $stmt->bindParam(':Description', $Description, PDO::PARAM_STR);
        $stmt->bindParam(':LogoImage', $LogoImage, PDO::PARAM_STR);
        $stmt->bindParam(':FeaturedImage', $FeaturedImage, PDO::PARAM_STR);
        $stmt->bindParam(':BannerImage', $BannerImage, PDO::PARAM_STR);
        $stmt->bindParam(':CollectionID', $CollectionID, PDO::PARAM_INT);
    
        $stmt->execute();
    }
    
    
        

