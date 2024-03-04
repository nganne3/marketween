<?php
    // Trong file delete_category.php
include_once 'm_categories.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['categoryId'])) {
        $categoryId = $_POST['categoryId'];
        categories_delete($categoryId);
        // Có thể trả về thông báo hoặc dữ liệu khác nếu cần
        echo 'success';
        exit;
    }
}

?>