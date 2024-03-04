<?php
    // thống kê số lượng sản phẩm
    function product_Amount(){
        $conn = connectdata();
        $sql = "SELECT count(*) AS AmountProduct FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // show tất cả sản phẩm
    function product_getAll() {
        try {
            $conn = connectdata();
            $stmt = $conn->prepare("
                SELECT 
                    p.*, 
                    p.Name AS NameProduct,  
                    col.Name AS NameCollection,
                    u.Username, 
                    u.AvatarImage,
                    pri.ListedPrice,
                    cate.Name AS NameCategory
                FROM 
                    products p 
                    INNER JOIN collections col ON p.CollectionID = col.CollectionID
                    INNER JOIN users u ON col.CreatorID = u.UserID 
                    INNER JOIN prices pri ON pri.ProductID = p.ProductID 
                    INNER JOIN categories cate ON cate.CategoryID = p.Category
                WHERE 
                    pri.CreatedAt = (
                        SELECT MAX(CreatedAt)
                        FROM prices
                        WHERE ProductID = p.ProductID
                    );
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        } catch (PDOException $e) {
            // Handle exception, log, or echo the error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    

    // kiểm tra có trùng tên hay không
    function product_checkName($Name){
        $conn = connectdata();
        $sql = "SELECT * FROM products WHERE Name='".$Name."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // thêm sản phẩm mới
    function addProduct($Name, $ListedPrice, $Description, $Category, $CollectionID, $ImageURL) {
        try {
            $conn = connectdata();
    
            // Kiểm tra tên sản phẩm
            $nameCheckStmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE Name = :Name");
            $nameCheckStmt->bindParam(":Name", $Name);
            $nameCheckStmt->execute();
            $nameCount = $nameCheckStmt->fetchColumn();
    
            if ($nameCount > 0) {
                return false;
            }
    
            // Kiểm tra định dạng ảnh và kích thước
            $allowedImageFormats = array("jpg", "jpeg", "png", "gif");
            $imageFileType = strtolower(pathinfo($ImageURL, PATHINFO_EXTENSION));
    
            if (!in_array($imageFileType, $allowedImageFormats) || $_FILES["ImageURL"]["error"] != 0) {
                return false;
            }
    
            // Kiểm tra giá
            if (!is_numeric($ListedPrice) || $ListedPrice < 0) {
                return false;
            }
    
            // Kiểm tra Bộ sưu tập và thể loại
            $collectionAndCategoryCheckStmt = $conn->prepare("SELECT COUNT(*) FROM collections WHERE CollectionID = :CollectionID AND EXISTS (SELECT 1 FROM categories WHERE CategoryID = :CategoryID)");
            $collectionAndCategoryCheckStmt->bindParam(":CollectionID", $CollectionID);
            $collectionAndCategoryCheckStmt->bindParam(":CategoryID", $Category);
            $collectionAndCategoryCheckStmt->execute();
            $collectionAndCategoryCount = $collectionAndCategoryCheckStmt->fetchColumn();
    
            if ($collectionAndCategoryCount == 0) {
                return false;
            }
    
            $conn->beginTransaction();
    
            // Thêm sản phẩm
            $sqlProduct = "INSERT INTO products (Name, Description, Category, CollectionID, ImageURL) VALUES (:Name, :Description, :Category, :CollectionID, :ImageURL)";
            $stmtProduct = $conn->prepare($sqlProduct);
            $stmtProduct->bindParam(":Name", $Name);
            $stmtProduct->bindParam(":Description", $Description);
            $stmtProduct->bindParam(":Category", $Category);
            $stmtProduct->bindParam(":CollectionID", $CollectionID);
            $stmtProduct->bindParam(":ImageURL", $ImageURL);
            $stmtProduct->execute();
    
            $lastProductId = $conn->lastInsertId();
    
            $sqlPrice = "INSERT INTO prices (ProductID, ListedPrice) VALUES (:ProductID, :ListedPrice)";
            $stmtPrice = $conn->prepare($sqlPrice);
            $stmtPrice->bindParam(":ProductID", $lastProductId);
            $stmtPrice->bindParam(":ListedPrice", $ListedPrice);
            $stmtPrice->execute();
    
            $conn->commit();
    
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    // lấy thông tin chi tiết của sản phẩm
    function getProductDetails($productID) {
        try {
            $conn = connectdata();
            $stmt = $conn->prepare("
                SELECT 
                    p.*, 
                    p.Name AS NameProduct,  
                    col.Name AS NameCollection,
                    u.Username, 
                    u.AvatarImage,
                    pri.ListedPrice,
                    cate.Name AS NameCategory
                FROM 
                    products p 
                    INNER JOIN collections col ON p.CollectionID = col.CollectionID
                    INNER JOIN users u ON col.CreatorID = u.UserID 
                    INNER JOIN prices pri ON pri.ProductID = p.ProductID 
                    INNER JOIN categories cate ON cate.CategoryID = p.Category
                WHERE p.ProductID = :productID
            ");
            $stmt->bindParam(":productID", $productID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // deit sản phẩm
    function edit_Product($ProductID, $Name, $ListedPrice, $Description, $Category, $CollectionID, $ImageURL)
    {
        try {
            $conn = connectdata();
            $conn->beginTransaction();

            $updateProductSQL = "UPDATE products 
                                SET `Name` = :Name, `Description` = :Description, 
                                `Category` = :Category, `CollectionID` = :CollectionID, `ImageURL` = :ImageURL 
                                WHERE `ProductID` = :ProductID";

            $updateProductStmt = $conn->prepare($updateProductSQL);
            $updateProductStmt->bindParam(":ProductID", $ProductID, PDO::PARAM_INT);
            $updateProductStmt->bindParam(":Name", $Name);
            $updateProductStmt->bindParam(":Description", $Description);
            $updateProductStmt->bindParam(":Category", $Category, PDO::PARAM_INT);
            $updateProductStmt->bindParam(":CollectionID", $CollectionID, PDO::PARAM_INT);
            $updateProductStmt->bindParam(":ImageURL", $ImageURL);

            $updateProductStmt->execute();

            $updatePriceSQL = "UPDATE prices 
                            SET `ListedPrice` = :ListedPrice 
                            WHERE `ProductID` = :ProductID";

            $updatePriceStmt = $conn->prepare($updatePriceSQL);
            $updatePriceStmt->bindParam(":ProductID", $ProductID, PDO::PARAM_INT);
            $updatePriceStmt->bindParam(":ListedPrice", $ListedPrice);

            $updatePriceStmt->execute();

            $conn->commit();

            return true;
        } catch (PDOException $e) {
            $conn->rollBack();

            error_log($e->getMessage());
            return false;
        }
    }

    // delete sản phẩm
    function delete_Product($ProductID)
    {
        try {
            $conn = connectdata();
            $conn->beginTransaction();

            $deletePriceSQL = "DELETE FROM prices WHERE `ProductID` = :ProductID";
            $deletePriceStmt = $conn->prepare($deletePriceSQL);
            $deletePriceStmt->bindParam(":ProductID", $ProductID, PDO::PARAM_INT);
            $deletePriceStmt->execute();

            $deleteOrderDetailsSQL = "DELETE FROM orderdetails WHERE `ProductID` = :ProductID";
            $deleteOrderDetailsStmt = $conn->prepare($deleteOrderDetailsSQL);
            $deleteOrderDetailsStmt->bindParam(":ProductID", $ProductID, PDO::PARAM_INT);
            $deleteOrderDetailsStmt->execute();

            $deleteCommentsSQL = "DELETE FROM comments WHERE `ProductID` = :ProductID";
            $deleteCommentsStmt = $conn->prepare($deleteCommentsSQL);
            $deleteCommentsStmt->bindParam(":ProductID", $ProductID, PDO::PARAM_INT);
            $deleteCommentsStmt->execute();

            $deleteProductSQL = "DELETE FROM products WHERE `ProductID` = :ProductID";
            $deleteProductStmt = $conn->prepare($deleteProductSQL);
            $deleteProductStmt->bindParam(":ProductID", $ProductID, PDO::PARAM_INT);
            $deleteProductStmt->execute();

            $conn->commit();

            return true;
        } catch (PDOException $e) {
            $conn->rollBack();

            error_log($e->getMessage());
            return false;
        }
    }




?>