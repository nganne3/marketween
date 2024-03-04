<?php
    // thống kê số lượng bình luận
    function comment_Amount(){
        $conn = connectdata();
        $sql = "SELECT count(*) AS AmountComment FROM comments";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    // show tất cả bình luận
    function comment_getAll(){
        $conn = connectdata();
        $stmt = $conn->prepare("SELECT com.*, com.Status, u.Username, u.AvatarImage, p.Name, p.ImageURL FROM comments com INNER JOIN users u ON com.UserID = u.UserID INNER JOIN products p ON p.ProductID = com.ProductID");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->FetchAll();
        return $kq;
    }

    // xóa 1 cmt
    function delete_comment($CommentID) {
        try {
            $conn = connectdata();
            $conn->beginTransaction();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $deleteCommentSQL = "DELETE FROM comments WHERE CommentID = :CommentID";
            $deleteCommentStmt = $conn->prepare($deleteCommentSQL);
            $deleteCommentStmt->bindParam(":CommentID", $CommentID, PDO::PARAM_INT);
            $deleteCommentStmt->execute();
    
            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error deleting comment: " . $e->getMessage();
            return false;
        }
    }
    
    // Thay đổi trạng thái
    function comment_toggleStatus($commentID, $newStatus) {

        try {
            $conn = connectdata();
            $conn->beginTransaction();
    
            $updateStatusSQL = "UPDATE comments SET Status = :newStatus WHERE CommentID = :commentID";
            $updateStatusStmt = $conn->prepare($updateStatusSQL);
            $updateStatusStmt->bindParam(":commentID", $commentID);
            $updateStatusStmt->bindParam(":newStatus", $newStatus);
            $updateStatusStmt->execute();
    
            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error updating comment status: " . $e->getMessage();
            return false;
        }
    }
    
?>