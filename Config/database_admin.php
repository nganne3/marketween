<?php 

function connectdata(){
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=marketween", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    } catch(PDOException $e){
    }
    return $conn;
} 

