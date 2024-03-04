<?php

session_start();

if (isset($_SESSION['not_found']) && $_SESSION['not_found'] == true) {
    header('location: App/View/not_found.php');
}
elseif (isset($_SESSION['informationPayment']) && $_SESSION['informationPayment'] == "informationPayment") {
    header('location: App/View/informationPayment.php');
}
elseif(isset($_SESSION['login']) && $_SESSION['login'] == "login"){
    header('location: App/View/login.php');
}
elseif(isset($_SESSION['codeQR']) && $_SESSION['codeQR'] == true){
    header('location: App/View/codeQR.php');
}
elseif(isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin'){
    unset($_SESSION['admin']);
    header('location: Admin/index.php');
}
else{
    header('location: App/Controller/index.php');
}