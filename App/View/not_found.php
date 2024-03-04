<?php

session_start();
ob_start();

if(isset($_SESSION['not_found'])) { 
    unset($_SESSION['not_found']); 
}

include "../../Config/database.php";
include "../../Config/paths.php";

if (isset($_GET['backhome'])){
    header('location: ../../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link rel="shortcut icon" href="../../Public/Images/Group 230 (1).png" type="image/x-icon">
    <!-- =========================FAVICON============================ -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- =========================BOX ICON============================ -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>page_not_found.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>
    
    <div class="flex-container">
    <div class="text-center">
        <h1>
        <span class="fade-in" id="digit1">4</span>
        <span class="fade-in" id="digit2">0</span>
        <span class="fade-in" id="digit3">4</span>
        </h1>
        <h3 class="fadeIn">KHÔNG TÌM THẤY TRANG</h3>
        <a href="not_found.php?backhome"><button type="button" name="button">Trở Lại Trang Chủ</button></a>
    </div>
    </div>

</body>
</html>