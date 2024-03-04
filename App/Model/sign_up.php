<?php 

session_start();
ob_start();

include "../../Config/database.php";
include "../../Config/paths.php";
include "../../Config/value_default.php";

function checkDatabase($value, $column, $conn) {
    $validColumns = ['Username', 'Email'];

    if (!in_array($column, $validColumns)) {
        echo json_encode(['error' => 'Invalid column name']);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE " . $column . " = ?");
    $stmt->execute([$value]);
    $exists = $stmt->rowCount() > 0;

    echo json_encode(['exists' => $exists]);
    exit();
}


function insertAccount($usernamex, $passwordx, $emailx, $conn) {
    try {
        $hashedPassword = password_hash($passwordx, PASSWORD_DEFAULT);
        $stmt = $conn->prepare(
            "INSERT INTO `users` 
            (`Username`, `Password`, `Email`, `AvatarImage`) 
            VALUES (:name, :password, :email, :avt)"
        );
        $stmt->bindParam(":name", $usernamex);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":email", $emailx);
        $avtValue = rand(1, 20) . '.jpg';
        $stmt->bindParam(":avt", $avtValue);

        $success = $stmt->execute();
        if ($success) {
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE `Username` = :username");
            $stmt->bindParam(":username", $usernamex);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['iduser'] = $user['UserID'];
            $_SESSION['Coins'] = $user['Coins'];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION["avatarus"] = $user["AvatarImage"];
            $_SESSION["Role"] = $user["Role"];
            return json_encode(["success" => true]);
        } else {
            return json_encode(["error" => "Lỗi khi thêm mới tài khoản."]);
        }
    } catch (PDOException $e) {
        return json_encode(["error" => "Lỗi khi thêm mới tài khoản: " . $e->getMessage()]);
    } finally {
        $stmt = null;
    }
}


$value = '';
$column = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['value'], $_POST['column'])) {
    $value = $_POST['value'];
    $column = $_POST['column'];
    $exists = checkDatabase($value, $column, $pdoConnection);
    echo json_encode($exists);
}

$usernamex = '';
$passwordx = '';
$emailx = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user"], $_POST["pass"], $_POST["email"])) {
    $result = insertAccount($_POST["user"], $_POST["pass"], $_POST["email"], $pdoConnection);
    echo $result;
} else {
    echo json_encode(["error" => "Lỗi: Dữ liệu không hợp lệ."]);
}