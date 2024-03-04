<?php 

include_once "../../Config/local.php";

function connectdata($Server, $Userlocal, $Passlocal, $dataname){
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$Server;dbname=$dataname", $Userlocal, $Passlocal);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
} 

$databaseInfo = array(
    'server' => $Server,
    'username' => $Userlocal,
    'password' => $Passlocal,
    'database' => $dataname,
);

define('CONNECTDATABASE', $databaseInfo);
global $pdoConnection;
$pdoConnection = connectdata(CONNECTDATABASE['server'], CONNECTDATABASE['username'], CONNECTDATABASE['password'], CONNECTDATABASE['database']);



