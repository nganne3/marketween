<?php
// show bảng điều khiển điểm danh
function attendance_control(){
    $conn = connectdata();
    $sql = "SELECT Title, Description, Status, Coins, PeriodicTime FROM attendance";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetch();
}

// show nhật ký điểm danh
    function attendance_getAll(){
        $conn = connectdata();
        $stmt = $conn->prepare("SELECT al.CreatedAt, a.Title, a.Coins, u.AvatarImage, u.Username, u.UserID FROM attendancelog al INNER JOIN users u ON al.UserID = u.UserID INNER JOIN attendance a ON al.ATDID = a.ATTID");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // add thông tin điểm danh
    function addNewAttendance($title, $description, $periodicTime, $amountCoins, $status) {
        try {
            $conn = connectdata();
            $conn->beginTransaction();
    
            $insertAttendanceSQL = "
                INSERT INTO attendance (Title, Description, PeriodicTime, Coins, Status)
                VALUES (:title, :description, :periodicTime, :amountCoins, :status)
            ";
            $insertAttendanceStmt = $conn->prepare($insertAttendanceSQL);
            $insertAttendanceStmt->bindParam(":title", $title);
            $insertAttendanceStmt->bindParam(":description", $description);
            $insertAttendanceStmt->bindParam(":periodicTime", $periodicTime);
            $insertAttendanceStmt->bindParam(":amountCoins", $amountCoins);
            $insertAttendanceStmt->bindParam(":status", $status);
            $insertAttendanceStmt->execute();
    
            $attId = $conn->lastInsertId();
    
            $conn->commit();
    
            return $attId;
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error inserting attendance: " . $e->getMessage();
            return false;
        }
    }

    // Lấy thông tin mới nhất dựa trên Attid
    function attendance_getlastnew(){
        $conn = connectdata();
        $sql = "SELECT Title, Description, Status, Coins, PeriodicTime FROM attendance ORDER BY attid DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }
    
    

    
    

    
    
    
    
    