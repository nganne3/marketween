<?php 

function get_sold($conn, $collectionId) {
    $stmt = $conn->prepare("
        SELECT COUNT(*) AS Sold
        FROM `orderdetails`
        INNER JOIN `products` ON `orderdetails`.`ProductID` = `products`.`ProductID`
        WHERE `products`.`CollectionID` = :collectionId
    ");
    $stmt->bindParam(":collectionId", $collectionId);
    $stmt->execute();
    $sold = $stmt->fetch(PDO::FETCH_ASSOC)['Sold'];
    return $sold !== false ? $sold : 0;
}

function get_floor($conn, $collectionId) {
    $stmt = $conn->prepare("
        SELECT MIN(prices.ListedPrice) AS `Floor`
        FROM `prices`
        INNER JOIN `products` ON `prices`.`ProductID` = `products`.`ProductID`
        WHERE `products`.`CollectionID` = :collectionId AND `prices`.`CreatedAt` = (
            SELECT MAX(`prices`.`CreatedAt`)
            FROM `prices`
            INNER JOIN `products` ON `prices`.`ProductID` = `products`.`ProductID`
            WHERE `products`.`CollectionID` = :collectionId
        )
    ");
    $stmt->bindParam(":collectionId", $collectionId);
    $stmt->execute();
    $floor = $stmt->fetch(PDO::FETCH_ASSOC)['Floor'];
    return $floor !== false ? $floor : 0;
}

function get_volume($conn, $collectionId) {
    $stmt = $conn->prepare("
        SELECT SUM(orderdetails.Price) AS Volume
        FROM `orderdetails`
        INNER JOIN `products` ON `orderdetails`.`ProductID` = `products`.`ProductID`
        WHERE products.CollectionID = :collectionId
    ");
    $stmt->bindParam(":collectionId", $collectionId);
    $stmt->execute();
    $volume = $stmt->fetch(PDO::FETCH_ASSOC)['Volume'];
    return $volume !== false ? $volume : 0;
}

function update_collection($conn, $collectionId, $sold, $floor, $volume) {
    // If there's no data, set the values to 0
    $sold = $sold !== null ? $sold : 0;
    $floor = $floor !== null ? $floor : 0;
    $volume = $volume !== null ? $volume : 0;

    $stmt = $conn->prepare("
        UPDATE `collections`
        SET Sold = :sold, Floor = :floor, Volume = :volume
        WHERE CollectionID = :collectionId
    ");
    $stmt->bindParam(":sold", $sold);
    $stmt->bindParam(":floor", $floor);
    $stmt->bindParam(":volume", $volume);
    $stmt->bindParam(":collectionId", $collectionId);
    $result = $stmt->execute();
    if (!$result) {
        throw new Exception('Failed to update collection: ' . implode(', ', $stmt->errorInfo()));
    }
}


function get_views($conn, $collectionId) {
    $stmt = $conn->prepare("
        SELECT SUM(Views) AS Views
        FROM `products`
        WHERE `CollectionID` = :collectionId
    ");
    $stmt->bindParam(":collectionId", $collectionId);
    $stmt->execute();
    $views = $stmt->fetch(PDO::FETCH_ASSOC)['Views'];
    return $views !== false ? $views : 0;
}

function update_views($conn, $collectionId, $views) {
    // If there's no data, set the values to 0
    $views = $views !== null ? $views : 0;

    $stmt = $conn->prepare("
        UPDATE `collections`
        SET `Views` = `Views` + :views
        WHERE `CollectionID` = :collectionId
    ");
    $stmt->bindParam(":views", $views);
    $stmt->bindParam(":collectionId", $collectionId);
    $result = $stmt->execute();
    if (!$result) {
        throw new Exception('Failed to update collection views: ' . implode(', ', $stmt->errorInfo()));
    }
}

function auto_into_collections($conn) {
    // Get all collections
    $stmt = $conn->prepare("SELECT `CollectionID` FROM `collections`");
    $stmt->execute();
    $collections = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($collections as $collection) {
        $sold = get_sold($conn, $collection['CollectionID']);
        $floor = get_floor($conn, $collection['CollectionID']);
        $volume = get_volume($conn, $collection['CollectionID']);
        $views = get_views($conn, $collection['CollectionID']);
        update_collection($conn, $collection['CollectionID'], $sold, $floor, $volume);
        update_views($conn, $collection['CollectionID'], $views);
    }
}

