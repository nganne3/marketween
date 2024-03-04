<?php
    // show tất cả danh mục
    function categories_getAll(){
        $conn = connectdata();
        $stmt = $conn->prepare("SELECT c.CategoryID, c.Name, c.Status, COUNT(p.ProductID) AS AmountProduct FROM categories c LEFT JOIN products p ON c.CategoryID = p.Category GROUP BY c.CategoryID, c.Name, c.Status");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // kiểm tra có trùng tên danh mục hay không
    function categories_checkName($nameCategory){
        $conn = connectdata();
        $sql = "SELECT * FROM categories WHERE Name='".$nameCategory."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // thêm danh mục mới
    function categories_add($nameCategory, $statusCategory){
        $conn = connectdata();
        $sql = "INSERT INTO categories (`Name`, `Status`) VALUES (:nameCategory, :statusCategory)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nameCategory", $nameCategory);
        $stmt->bindParam(":statusCategory", $statusCategory);
        return $stmt->execute();
    }

    // show 1 danh mục để edit
    function categories_getById($CategoryID){
        $conn = connectdata();
        $sql = "SELECT * FROM categories WHERE CategoryID = ".$CategoryID;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }
    
    // sửa 1 danh mục
    function categories_edit($nameCategory, $statusCategory, $CategoryID){
        $conn = connectdata();
        $sql = "UPDATE categories SET `Name`=:nameCategory, `Status`=:statusCategory WHERE CategoryID=:CategoryID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nameCategory", $nameCategory);
        $stmt->bindParam(":statusCategory", $statusCategory);
        $stmt->bindParam(":CategoryID", $CategoryID);
        return $stmt->execute();
    }

    // xóa 1 danh mục
    function categories_delete($CategoryID){
        try {
            $conn = connectdata();
            $conn->beginTransaction();
    
            $conn->exec('SET foreign_key_checks = 0');
    
            $deleteCategorySql = "DELETE FROM categories WHERE `CategoryID` = :CategoryID";
            $deleteCategoryStmt = $conn->prepare($deleteCategorySql);
            $deleteCategoryStmt->bindParam(":CategoryID", $CategoryID);
            $deleteCategoryStmt->execute();
    
            $conn->exec('SET foreign_key_checks = 1');
    
            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
    
    

    // lấy danh mục show ở phần insert
    function categories_get(){
        $conn = connectdata();
        $sql = "SELECT * FROM categories";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
?>