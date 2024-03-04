<?php 

session_start();
ob_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function authenticateUser($email, $password, $conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `Email` = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            if (password_verify($password, $user["Password"])) {
                return $user;
            } else {
                if (!password_needs_rehash($user["Password"], PASSWORD_DEFAULT)) {
                    return null;
                } else {
                    $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $stmtUpdate = $conn->prepare("UPDATE `users` SET `Password` = :newPassword WHERE `UserID` = :userId");
                    $stmtUpdate->bindParam(":newPassword", $newHashedPassword);
                    $stmtUpdate->bindParam(":userId", $user["UserID"]);
                    $stmtUpdate->execute();
                    
                    $user["Password"] = $newHashedPassword;
                    return $user;
                }
            }
        } else {
            return null;
        }
    } catch (PDOException $e) {
        return null;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (!isset($_SESSION["username"])) {
            $_SESSION["username"] = null;
        }
        if (!isset($_SESSION["iduser"])) {
            $_SESSION["iduser"] = null;
        }

        $user = authenticateUser($email, $password, $pdoConnection);

        if ($user) {
            $_SESSION["username"] = $user["Username"];
            if ($_SESSION['iduser']) {
                unset($_SESSION['iduser']);
            }
            $_SESSION["Coins"] = $user["Coins"];
            $_SESSION["iduser"] = $user["UserID"];
            $_SESSION["avatarus"] = $user["AvatarImage"];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION["Role"] = $user["Role"];
            $response["success"] = true;
            $response["message"] = "Đăng nhập thành công!";

        } else {
            $response["success"] = false;
            $response["message"] = "Email hoặc mật khẩu không đúng.";
        }
        // var_dump($user);
        // ob_end_clean();
        echo json_encode($response);
        exit();
    }
}




