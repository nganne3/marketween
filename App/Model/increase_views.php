<?php 

function updateViews($conn, $id) {

    if (!is_numeric($id) || $id <= 0) {
        echo "Invalid ID";
        return;
    }

    $sql = "UPDATE `collections` SET `Views` = views + 1 WHERE `CollectionID` = ?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$id]);
    // echo "Record updated successfully";
}

function updateViews_product($conn, $id) {

    if (!is_numeric($id) || $id <= 0) {
        echo "Invalid ID";
        return;
    }

    $sql = "UPDATE `products` SET `Views` = views + 1 WHERE `ProductID` = ?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$id]);
    // echo "Record updated successfully";
}


