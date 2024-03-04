<?php 

session_start();
ob_start();

include_once "../../Config/paths.php";
include_once "../../Config/database.php";
include_once "../../App/Model/category_show.php";
include_once "../../App/Model/showproducts.php";
include_once "../../App/Model/profile_user.php";

$file = $_GET['content_profile'] ?? '';
include SITE_VIEW_PATH . $file . '.php';
