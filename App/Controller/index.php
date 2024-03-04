<?php 
    session_start();
    ob_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../../Config/database.php";
    include "../../Config/paths.php";
    include "../../App/Model/auto_into_data.php";
    include "../../App/Model/increase_views.php";
    include "../../App/Model/notification.php";

    auto_into_collections($pdoConnection);

    $role_marketween = $_SESSION["Role"] ?? '';
    $role_marketween = ($role_marketween === 'admin') ? "Quản trị" : "Khách hàng";    

    if (isset($_SESSION['iduser'])) {  
        $none_hien = 'flex';
        if ($role_marketween === 'Khách hàng') {
            $none_flex = 'flex';
        }
        else{
            $none_flex = 'none';
        }
    }
    else{
        $none_hien = 'none';
        $none_flex = 'none';
    }

    $yet_lg = isset($_SESSION['iduser']) ? 'none' : 'flex';

    // =====================DIEM DANH====================
    include "../../App/Model/attendance.php";
    // =====================DIEM DANH====================

    include "../../App/View/header.php";

    if (isset($_GET['yourcollection'])) {      
        updateViews($pdoConnection, $_GET['yourcollection']);
    };

    if (isset($_GET['pro_dt_id_khach'])) {
        updateViews_product($pdoConnection, $_GET['pro_dt_id_khach']);
    };

    if (isset($_GET['act'])){
        $choose = $_GET['act'];
        switch($choose)
        {   

            case 'profile':
                
                if (isset($_SESSION['iduser'])) {  
                    include_once "../../App/Model/profile_user.php";
                    include_once "../../App/Model/category_show.php";
                    include_once "../../App/Model/showproducts.php";
                    include_once "../../App/View/profile.php";
                }
                else{
                    $_SESSION['not_found'] = true;
                    header('location: ../../index.php');
                }
                
                break;

            case 'your_profile':

                include_once "../../App/Model/your_profile.php";
                include_once "../../App/Model/category_show.php";
                include_once "../../App/Model/showexplore.php";
                include_once "../../App/View/your_profile.php";

                break;

            case 'product_detail':

                include_once "../../App/Model/my_detail_product.php";
                include_once "../../App/View/my_product_detail.php";
                break;
            
            case 'your_product_detail':

                include_once "../../App/Model/your_detail_product.php";
                include_once "../../App/View/your_product_detail.php";
                
                break;

            case 'your_collection':
                
                include_once "../../App/Model/your_collection.php";
                include_once "../../App/Model/showexplore.php";
                include_once "../../App/Model/category_show.php";
                include_once "../../App/View/your_collection.php";
                break;

            case 'my_collection':
            
                include_once "../../App/Model/my_collection.php";
                include_once "../../App/Model/showexplore.php";
                include_once "../../App/Model/category_show.php";
                include_once "../../App/View/my_collection.php";
                break;

            case 'newCollections':
                
                include_once "../../App/View/newCollections.php";
                break;

            case 'explore':

                include_once "../../App/Model/category_show.php";
                include_once "../../App/Model/showexplore.php";
                include_once "../../App/Model/showproducts.php";
                include_once "../../App/Model/show_collection.php";
                include_once "../../App/Model/buyer_exprole.php";
                include_once "../../App/View/explore.php";
                break;
            
            case 'createProduct':
                
                include_once "../../App/Model/category_show.php";
                include_once "../../App/Model/show_collection.php";
                include_once "../../App/View/CreateProduct.php";
                break;
            
            case 'createCollection':
                
                include_once "../../App/View/CreateCollection.php";
                break;
            
            case 'login':
    
                $_SESSION['login'] = $choose;
                header('location: ../../index.php');
                break; 

            case 'settingprofile':
                
                include_once "../../App/Model/showexplore.php";
                include_once "../../App/View/settingProfile.php";
                break;

            case 'admin':

                if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'admin') {
                    $_SESSION['admin'] = $choose;
                    header('location: ../../index.php');
                }
                else{
                    include "../../App/View/home.php";
                    break;
                }

            case 'logout':
            
                if (isset($_SESSION['iduser'])){
                    unset($_SESSION['iduser']);
                    unset($_SESSION['Coins']);
                    unset($_SESSION['Username']);
                    unset($_SESSION["avatarus"]);
                    unset($_SESSION["Role"]);   
                    header('location: ../../index.php');  
                }

                break;   

            case 'informationPayment':
                $_SESSION['informationPayment'] = $choose;
                header('location: ../../index.php');
                break;

            case 'home':
                
                include "../../App/View/home.php";
                // include "../../App/Model/home.php";
                break;

            default:
                $_SESSION['not_found'] = true;
                header('location: ../../index.php');
                break;
        }
    }
    else{
        include "../../App/View/home.php";
        // include "../../App/Model/home.php";
    }
    include "../../App/View/footer.php";
