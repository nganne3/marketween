<?php
    // thống kê số lượng người dùng
    function user_Amount(){
        $conn = connectdata();
        $sql = "SELECT count(*) AS AmountUser FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // show tất cả người dùng
    function user_getAll(){
        $conn = connectdata();
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // show top 5 người dùng có doanh thu cao nhất
    function user_getUserMaxVolume($limit){
        $conn = connectdata();
        $stmt = $conn->prepare("
        SELECT u.UserID, u.Username, u.AvatarImage, SUM(col.Volume) AS Volume 
        FROM users u 
        JOIN collections col 
        ON u.UserID = col.CreatorID 
        GROUP BY u.UserID, u.Username 
        ORDER BY `Volume` 
        DESC 
        LIMIT $limit; 
        ");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // show top 5 người dùng có Coins cao nhất
    function user_getUserMaxCoins($limit){
        $conn = connectdata();
        $stmt = $conn->prepare("SELECT * FROM users ORDER BY Coins DESC LIMIT $limit");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // show top 5 người dùng có lượt bán sản phẩm cao nhất
    function user_getUserMaxSold($limit){
        $conn = connectdata();
        $stmt = $conn->prepare("
        SELECT u.UserID, u.Username, u.AvatarImage, SUM(col.Sold) AS AmountProduct 
        FROM users u 
        JOIN collections col 
        ON u.UserID = col.CreatorID 
        GROUP BY u.UserID, u.Username 
        ORDER BY `AmountProduct` 
        DESC 
        LIMIT $limit;  
        ");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // show top 5 người dùng được follow nhiều nhất
    function user_getUserMaxFollowers($limit){
        $conn = connectdata();
        $stmt = $conn->prepare("SELECT * FROM users ORDER BY Followers DESC LIMIT $limit");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // kiểm tra có trùng email hay không
    function user_checkEmail($Email){
        $conn = connectdata();
        $sql = "SELECT * FROM users WHERE Email='".$Email."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // thêm người dùng mới
    function user_add($Username, $Email, $Role, $Coins, $Password, $Bio, $newFileName, $newFileName2){
        $conn = connectdata();
        $sql = "INSERT INTO users (`Username`, `Email`, `Role`, `Coins`, `Password`, `Bio`, `AvatarImage`, `CoverImage`) VALUES (:Username, :Email, :Role, :Coins, :Password, :Bio, :newFileName, :newFileName2)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":Username", $Username);
        $stmt->bindParam(":Email", $Email);
        $stmt->bindParam(":Role", $Role);
        $stmt->bindParam(":Coins", $Coins);
        $stmt->bindParam(":Password", $Password);
        $stmt->bindParam(":Bio", $Bio);
        $stmt->bindParam(":newFileName", $newFileName);
        $stmt->bindParam(":newFileName2", $newFileName2);
        return $stmt->execute();
    }

    // show 1 người dùng để edit
    function user_getById($UserID) {
        try {
            $conn = connectdata();
            $sql = "SELECT * FROM users WHERE UserID = :UserID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);
            $stmt->execute();
    
            $errorInfo = $stmt->errorInfo();
            if ($errorInfo[0] !== '00000') {
                throw new Exception("SQL Error: " . $errorInfo[2]);
            }
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    // sửa 1 người dùng
    function user_edit($Username, $Email, $Role, $Coins, $Password, $Bio, $newFileName, $newFileName2, $UserID){
        $conn = connectdata();
        $sql = "UPDATE users SET `Username`=:Username, `Email`=:Email, `Role`=:Role, `Coins`=:Coins, `Password`=:Password, `Bio`=:Bio, `AvatarImage`=:newFileName, `CoverImage`=:newFileName2 WHERE UserID=:UserID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":Username", $Username);
        $stmt->bindParam(":Email", $Email);
        $stmt->bindParam(":Role", $Role);
        $stmt->bindParam(":Coins", $Coins);
        $stmt->bindParam(":Password", $Password);
        $stmt->bindParam(":Bio", $Bio);
        $stmt->bindParam(":newFileName", $newFileName);
        $stmt->bindParam(":newFileName2", $newFileName2);
        $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    // xóa 1 người dùng
    function user_delete($UserID) {
        try {
            $conn = connectdata();
            $conn->beginTransaction();
    
            $conn->exec('SET foreign_key_checks = 0');
    
            $deleteAttendanceLogSQL = "DELETE FROM attendancelog WHERE `UserID` = :UserID";
            $deleteAttendanceLogStmt = $conn->prepare($deleteAttendanceLogSQL);
            $deleteAttendanceLogStmt->bindParam(":UserID", $UserID);
            $deleteAttendanceLogStmt->execute();
    
    
            $deleteUserSQL = "DELETE FROM users WHERE `UserID` = :UserID";
            $deleteUserStmt = $conn->prepare($deleteUserSQL);
            $deleteUserStmt->bindParam(":UserID", $UserID);
            $deleteUserStmt->execute();
    
            $conn->exec('SET foreign_key_checks = 1');
    
            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
    
    
    
    
    
    