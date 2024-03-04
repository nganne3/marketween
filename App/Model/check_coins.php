<?php 

session_start();
ob_start();

include "../../Config/database.php";
include "../../Config/paths.php";

function checkcoins($Total, $idlogin, $conn){

    $stmt = $conn->prepare("SELECT `Coins` FROM `users` WHERE `UserID` = :userId");
    $stmt->bindParam(':userId', $idlogin);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['Coins'] < $Total) {
        echo "disabled_btn";
        return;
    }
    $conn = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $Total = '';
    if (isset($_POST['total'])) {
        $Total = $_POST['total'];
    };

    $idlogin = '';
    if (isset($_POST['login']) && $_POST['login'] !== 'marketween') {
        $idlogin = $_POST['login'];
        checkcoins($Total, $idlogin, $pdoConnection);
    };
}