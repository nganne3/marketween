<?php

function cate_show($conn){
    $stmt = $conn -> prepare("SELECT * FROM categories WHERE `Status` = :status ;");
    $status = 'show';
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $best = $stmt->fetchAll();
    return $best;
}


