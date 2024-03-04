<?php 

    session_start();
    ob_start();

    include_once "../../Config/database.php";
    include "../../Config/paths.php";
    include "../../App/Model/submit_gmail.php";

    function cap_nhat_coins($conn, $user){
        try {
            $stmt = $conn->prepare("SELECT `Coins` FROM `users` WHERE `UserID` = :user");
            $stmt->bindParam(':user', $user);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $coins = $result['Coins'];
            if (isset($_SESSION['Coins'])) {
                $_SESSION['Coins'] = $coins;
            };
            echo "Đã cập nhật coins";
        } catch (PDOException $e) {
            die("Kết nối hoặc truy vấn thất bại: " . $e->getMessage());
        }
        
    }

    // ==========TRU VAO COINS
    function truCoisn($Total, $idlogin, $conn){
        $stmt = $conn->prepare("SELECT `Coins` FROM `users` WHERE `UserID` = :userId");
        $stmt->bindParam(':userId', $idlogin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result['Coins'] < $Total) {
            echo "Bạn không đủ số tiền trong tài khoản.";
            return;
        }
    
        $stmt = $conn->prepare("UPDATE users 
                                SET Coins = Coins - :total 
                                WHERE UserID = :userId 
                                ");
        $stmt->bindParam(':total', $Total);
        $stmt->bindParam(':userId', $idlogin);
        $stmt->execute();
    
        cap_nhat_coins($conn, $idlogin);
        $conn = null;
    }

    // =========GET EMAIL
    function getEmailById($id, $conn) {
        $sql = "SELECT `Email` FROM `users` WHERE `UserID` = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['Email'];
    }
    
    // =========ADD ORDER
    function createAnOrder($CodeO, $Total, $idlogin, $Email, $name_user, $conn){
        $stmt = $conn->prepare("INSERT INTO `orders` (`CodeO`, `Total`, `UserID`, `Email`, `CreatedAt`, `NameUser`) 
                                VALUES (:code, :total, :userId, :email, NOW(), :nameuser)");
        $stmt->bindParam(':code', $CodeO);
        $stmt->bindParam(':total', $Total);
        $stmt->bindParam(':userId', $idlogin);
        $stmt->bindParam(':email', $Email);
        $stmt->bindParam(':nameuser', $name_user);
        $stmt->execute();     
        return $conn->lastInsertId();

    }

    // ==========RANDOM CODE
    function generateUniqueCode($conn) {
        $codeExists = true;
        $code = '';
        
        while ($codeExists) {
            $randomNumber = str_pad(rand(0, 999), 4, '0', STR_PAD_LEFT);
            $code = 'marketween' . date('Ymd') . $randomNumber;
            $stmt = $conn->prepare("SELECT `CodeO` FROM `orders` WHERE `CodeO` = :code");
            $stmt->bindParam(':code', $code);
            $stmt->execute();
        
            $existingCode = $stmt->fetch(PDO::FETCH_ASSOC);
            $codeExists = !empty($existingCode);
        }
        
        return $code; 
    }

    // ==========ADD ORDER DETAILS
    function OrderDetail($orderId, $cart, $conn) {
        foreach ($cart as $item) {
            $sql = "INSERT INTO `orderdetails` (`ProductID`, `CreatedAt`, `Price`, `OrderID`) 
                    VALUES (:productid, NOW(), :price, :OrderID)";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':productid', $item['id']);
            $stmt->bindParam(':price', $item['price']);
            $stmt->bindParam(':OrderID', $orderId);
            $stmt->execute();
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $Total = '';
        if (isset($_POST['total'])) {
            $Total = $_POST['total'];
        };

        $idlogin = '';
        $Email = '';
        if (isset($_POST['login']) && $_POST['login'] !== 'marketween') {
            $idlogin = $_POST['login'];
            $Email = getEmailById($idlogin, $pdoConnection);
            truCoisn($Total, $idlogin, $pdoConnection);
        }
        else{
            if (isset($_POST['email'])) {
                $Email = $_POST['email'];
            };
            $idlogin = NULL;
        }

        $cart = '';
        if (isset($_POST['cart'])) {
            $cart = $_POST['cart'];
        };

        $name_user = '';
        if (isset($_POST['user'])) {
            $name_user = $_POST['user'];
        }else{
            $name_user = null;
        }

        $CodeO = generateUniqueCode($pdoConnection);

        $orderId = createAnOrder($CodeO, $Total, $idlogin, $Email, $name_user, $pdoConnection);

        OrderDetail($orderId, $cart, $pdoConnection);

        if ($name_user !== null) {
            $_SESSION['codeQR'] = true;
            $_SESSION['order'] = $orderId;
        }
    }

    // ==========GET LINK FILE
    function getlinkfile($orderId, $conn) {
        $stmt = $conn->prepare("SELECT `products`.* 
                                FROM `products`
                                JOIN `orderdetails`
                                ON `products`.`ProductID` = `orderdetails`.`ProductID` 
                                WHERE `orderdetails`.`OrderID` = :idorder
                                ");
        $stmt->bindParam(':idorder', $orderId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $result;
    }

    $linkfile_pr = getlinkfile($orderId, $pdoConnection);

    $html_Mail = "";

    foreach($linkfile_pr as $p) {
        extract($p);
        $inmota = "";
        if ($Description == null || $Description == "") {
           $inmota = 'display: none;';
        }

        $html_Mail .= '
        <table class="products_chinhxac" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;">                                                                               
        <tr style="border-collapse:collapse">
            <td align="center" class="es-m-txt-c" style="padding:0;Margin:0;">
                <h3 class="b_title" style="Margin:0;line-height:23px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:19px;font-style:normal;font-weight:normal;color:#333333">
                    <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-align:left;text-decoration:none;color:#000027;font-size:19px">
                    '. $Name .'
                    </a> 
                </h3>
            </td>
        </tr>
    
        <tr style="border-collapse:collapse;height: 60px; overflow: hidden; '.$inmota.'">
            <td align="center" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px">
                <p class="b_description" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">
                    '. $Description .'
                </p>
            </td>
        </tr> 
    
        <tr style="border-collapse:collapse">
            <td align="center" class="es-m-p0l es-m-txt-c" style="padding:0;Margin:0;10px;">
                <a href="'. $FileURL .'" class="es-button link_btn" target="_blank" >
                    Lấy link
                </a>
            </td>
        </tr>
    </table>
    <br>
    ';
    }
    
 $body = '
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="vi" style="height:100%;padding:0;Margin:0">
    <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Marketween</title>
    <style 
    type="text/css">#outlook 
    a { padding:0;}.ExternalClass { width:100%;} 
    .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div { line-height:100%;} 
    .es-button { mso-style-priority:100!important; text-decoration:none!important;}
    a[x-apple-data-detectors] { color:inherit!important; text-decoration:none!important; font-size:inherit!important; font-family:inherit!important; font-weight:inherit!important; line-height:inherit!important;} .es-desk-hidden { display:none; float:left; overflow:hidden; width:0; max-height:0; line-height:0; mso-hide:all;} 
    @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120%!important } h1 { font-size:30px!important; text-align:center } h2 { font-size:26px!important; text-align:center } h3 { font-size:20px!important; text-align:center } h1 a { text-align:center }
    .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:28px!important } h2 a { text-align:center } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:22px!important } h3 a { text-align:center } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:19px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important }
    .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important }
    .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-menu td a { font-size:16px!important } a.es-button, button.es-button { font-size:20px!important; display:block!important; padding-left:0px!important; padding-right:0px!important }
    .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important }
    .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } } 
    
    table.products_chinhxac {
        border: 1px solid black;
        border-radius: 10px;
        padding: 20px;
        height: max-content;
        width: 100%;
    }
    
    a.link_btn{
        text-decoration:none;
        -webkit-text-size-adjust:none;
        -ms-text-size-adjust:none;
        color:#FFFFFF;
        font-size:14px;
        padding:10px 20px 10px 20px;
        display:inline-block;
        background:#5e17eb; 
        border-radius:8px; 
        font-family:arial, "helvetica neue", helvetica, sans-serif;
        font-weight:normal;
        font-style:normal;
        line-height:17px;
        width:auto;
        text-align:center;
        color: white;
    }

    .im {
        color: black;
    }

    </style>
    </head>
    
    <body style="height:100%;width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
    
    <div dir="ltr" class="es-wrapper-color" lang="vi" style="background-color:#E9E8E6">
    <!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" src="https://ectpqwp.stripocdn.email/content/guids/CABINET_84e304ebb2973a40c374216a94f14039/images/72731514372290749.png" color="#e9e8e6" origin="0.5, 0" position="0.5, 0"></v:fill> </v:background><![endif]-->
    <table class="es-wrapper" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-image:url(https://ectpqwp.stripocdn.email/content/guids/CABINET_84e304ebb2973a40c374216a94f14039/images/72731514372290749.png);background-repeat:repeat;background-position:center top;background-color:#E9E8E6" width="100%" cellspacing="0" cellpadding="0" background="https://ectpqwp.stripocdn.email/content/guids/CABINET_84e304ebb2973a40c374216a94f14039/images/72731514372290749.png" role="none">
        <tr style="border-collapse:collapse">
            <td valign="top" style="padding:0;Margin:0">
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" role="none">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:15px">
                                        <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table> 
    
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" role="none">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:0;Margin:0">
                                        <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td style="padding:0;Margin:0;position:relative" align="center">
                                                                <a target="_blank" href="https://viewstripo.email" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#93C47D;font-size:14px">
                                                                    <img class="adapt-img" src="https://ectpqwp.stripocdn.email/content/guids/bannerImgGuid/images/image17011391248878148.png" alt="Emy blog" title="Emy blog" width="600" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="300">
                                                                </a> 
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table> 
    
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0">
                                            <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                                                <tr style="border-collapse:collapse">
                                                    <td align="left" style="Margin:0;padding-top:40px;padding-bottom:40px;padding-left:40px;padding-right:40px">
                                                        <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                            <tr style="border-collapse:collapse">
                                                                <td align="left" style="padding:0;Margin:0;width:520px">
                                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                        <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0">
                                            <h1 style="Margin:0;line-height:42px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:28px;font-style:normal;font-weight:normal;color:#333333">Cảm ơn bạn đã thanh toán</h1> 
                                        </td>
                                    </tr>
                                    <tr style="border-collapse:collapse">
                                                <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:15px;font-size:0">
                                                    <table width="70%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse"><td style="padding:0;Margin:0;border-bottom:1px solid #cccccc;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr> 
                                        <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0">
                                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Bên dưới là link driver lưu giữ tất cả tệp sản phẩm bạn đã mua. Chúc bạn có những giây phút vui vẻ tại Marketween.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table> 
    
                <!-- =====================QUAN TRONG===================== -->
    
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
    
                            <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                               
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;"> <!--[if mso]><table dir="rtl" style="width:560px" cellpadding="0" cellspacing="0"><tr><td dir="ltr" style="width:270px" valign="top">
    
                                        <table cellpadding="0" cellspacing="0" class="es-left" align="left" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="padding:0;Margin:0;">
                                                    <!-- ----------------data------------------- -->
                
                                                <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                                                   
                                                    <tr style="border-collapse:collapse">
                                                        <td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px"> <!--[if mso]><table dir="rtl" style="width:560px" cellpadding="0" cellspacing="0"><tr><td dir="ltr" style="width:270px" valign="top"><![endif]-->     
                
                                                            <table cellpadding="0" cellspacing="0" class="es-left" align="left" role="none" style="border-spacing:0px;float:left; width:100%;">
                                                                <tr style="border-collapse:collapse">
                                                                    <td align="left" style="padding:0;Margin:0;width:100%; min-height: 300px; overflow-y:auto;">
                                                                        <!-- ----------------data------------------- -->
                
                                                                        '.$html_Mail.'
                
                                                                       <!-- ----------------data------------------- -->
                
                                                                    </td>
                                                                </tr>
                                                            </table> 
                
                                                        </td>
                                                    </tr> 
                                                </table>
    
                                                   <!-- ----------------data------------------- -->
    
                                                </td>
                                            </tr>
                                        </table> 
    
                                    </td>
                                </tr> 
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px">
    
                                        <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:0;Margin:0;padding-bottom:10px;padding-left:20px;padding-right:20px;font-size:0">
                                                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px">
                                                                        </td> 
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
    
                                    </td>
                                </tr>
                            </table>
    
                        </td>
                    </tr>
                </table>
                
                <!-- =====================QUAN TRONG===================== -->
    
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                        <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#ffffff;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" role="none">
                            <tr style="border-collapse:collapse">
                                        <td align="left" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px">
                                            <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr style="border-collapse:collapse">
                                                    <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                    <td align="center" style="padding:0;Margin:0;padding-bottom:10px;padding-left:20px;padding-right:20px;font-size:0">
                                                        <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                            <tr style="border-collapse:collapse">
                                        <td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px">
                                        </td> 
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table> 
    
                <table cellpadding="0" cellspacing="0" class="es-footer" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
    <tr style="border-collapse:collapse">
    <td align="center" style="padding:0;Margin:0"><table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
    <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0">
                            <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                    <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                        <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-top:5px solid #5e17eb" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                            <tr style="border-collapse:collapse">
                                                <td align="center" style="padding:0;Margin:0;font-size:0">
                                                    <img class="adapt-img" src="https://ectpqwp.stripocdn.email/content/guids/CABINET_84e304ebb2973a40c374216a94f14039/images/8411514376477261.png" alt width="600" height="40" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                                </td> 
                                            </tr>
                                                <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0;padding-top:5px;font-size:0">
                            <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                    <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                                        <img title="Twitter" src="https://ectpqwp.stripocdn.email/content/assets/img/social-icons/logo-black/twitter-logo-black.png" alt="Tw" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                    </td>
                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                            <img title="Facebook" src="https://ectpqwp.stripocdn.email/content/assets/img/social-icons/logo-black/facebook-logo-black.png" alt="Fb" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                        </td>
                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                            <img title="Pinterest" src="https://ectpqwp.stripocdn.email/content/assets/img/social-icons/logo-black/pinterest-logo-black.png" alt="P" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                        </td>
                        <td valign="top" align="center" style="padding:0;Margin:0">
                            <img title="Google+" src="https://ectpqwp.stripocdn.email/content/assets/img/social-icons/logo-black/google-plus-logo-black.png" alt="G+" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr> 
    <tr style="border-collapse:collapse">
    <td align="left" style="padding:0;Margin:0">
        <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
            <tr style="border-collapse:collapse">
                <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0;padding-top:10px">
                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">
                                You are receiving this email because you have visited our site or asked us about regular newsletter. If you wish to unsubscribe from our newsletter, click 
                                <a target="_blank" class="view" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:14px">here</a> 
                            .</p>
                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px">Vector graphics designed by 
                            <a target="_blank" href="https://www.freepik.com/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:16px">Freepik</a>.
                        </p>
                        <p style=Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neu", helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">© Emy Blog 2017
                        </p>
                        </td>
                    </tr>
                            </table>
                        </td>
                    </tr>
                        </table>
                        </td>
                        </tr>
                        </table>
                        </td>
                        </tr>
    
                </table>
                
                <!-- ====LOGO -->
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse"></tr> 
                    <tr style="border-collapse:collapse">
                    <td align="center" style="padding:0;Margin:0">
                        <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center" role="none">
                            <tr style="border-collapse:collapse">
                                <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px">
                                    <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                        <td class="es-infoblock made_with" align="center" style="padding:0;Margin:0;line-height:14px;font-size:0;color:#999999">
                                                            <a target="_blank" href="https://viewstripo.email/?utm_source=templates&utm_medium=email&utm_campaign=publications_and_blog+&utm_content=trigger_newsletter" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#999999;font-size:12px">
                                                                <img src="https://ectpqwp.stripocdn.email/content/guids/CABINET_9df86e5b6c53dd0319931e2447ed854b/images/64951510234941531.png" alt width="125" height="56" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                                            </a>       
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                </table>
    
            </td>
        </tr>
    </table>
    </div>
    
    </body>
    </html>
';

    $khohieuqua = sendEmail($Email, "Mua hàng thành công", $body, $my_email, $my_bussiness, $host_mail, $code_word, $my_pass_mail);
    // ---------------------------------------------------------