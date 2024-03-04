<?php

    session_start();
    ob_start();

    include "../../Config/database.php";
    include "../../Config/paths.php";
    include "../../App/Model/code_qr_show.php";

    if(isset($_SESSION['codeQR'])){ 
        unset($_SESSION['codeQR']); 
    }

    $idorder = '';
    $hoadon = '';
    if(isset($_SESSION['order'])){ 
        $idorder = $_SESSION['order'];
        $hoadon =  getOrdersAndDetails($idorder, $pdoConnection);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketween</title>

    <link rel="shortcut icon" href="../../Public/Images/Group 230 (1).png" type="image/x-icon">
    <!-- =========================FAVICON============================ -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- =========================BOX ICON============================ -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- =========================GOOGLE FONT============================ -->

    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>style.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>informationPayment.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>codeQR.css">
    <link rel="stylesheet" href="<?php echo SITE_CSS_PATH; ?>daulung.css">

    <!-- =========================CSS============================ -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- =========================JQUERY============================ -->

</head>
<body>
    
<div id="codeQR-page">

    <!-- =============================================START HEADER PAGE=============================================================== -->
    <div id="header-of-codeQR" class="display-flex align-items-center justify-content-space-between">

        <div class="central-header-QR display-flex align-items-center justify-content-space-between">   
            <a href="../../index.php" id="brand-marketween" class="display-flex align-items-center">
                <div id="logo-at-information-payment-page" class="overflow-hidden border-radius-50phantram margin-right-10px">
                    <img class="width-100-height-100" src="https://i.pinimg.com/originals/fb/54/84/fb54849f358f7825923f7d0517f3678f.png" alt="">
                </div>
                <div class="font-weight-600 font-size-18px">
                    Marketween
                </div>
            </a>
    
            <div class="back-page">
                <a href="../../index.php" class="display-flex align-items-center" style="color: rgb(0, 102, 255);">
                    <i class="bx bx-chevron-left"></i>
                    <span>Trở về trang chủ</span>
                </a>
            </div>
        </div>
    </div>
    <!-- =============================================END HEADER PAGE=============================================================== -->

    <div class="padding-le">
        <!-- =============================================START YOUR ORDER=============================================================== -->
        <div class="inf-order your-order">

            <div class="your-order-padding combo-border">

                <div class="font-size-36px margin-bottom-20px">
                    Hóa đơn của bạn
                </div>
    
                <div class="display-flex align-items-center justify-content-space-between margin-bottom-20px">
                    <div>
                        Mã hóa đơn
                    </div>
                    <div>
                       <?php
                       
                        echo $hoadon['0']['CodeO'];
                       
                       ?>
                    </div>
                </div>

                <!-- --------------------------------------------------------------- -->

                <div class="display-flex align-items-center justify-content-space-between margin-bottom-20px">
                    <div>
                        Tên khách hàng
                    </div>
                    <div>
                        <?php
                        
                        echo $hoadon['0']['NameUser'];
                        
                        ?>
                    </div>
                </div>

                <!-- --------------------------------------------------------------- -->

                <div class="display-flex justify-content-space-between margin-bottom-20px">
                    <div>
                        Tên sản phẩm
                    </div>
                    <div id="all_pr_name">

                    </div>
                </div>

                <!-- --------------------------------------------------------------- -->

                <div class="display-flex align-items-center justify-content-space-between margin-bottom-20px">
                    <div>
                        Địa chỉ email
                    </div>
                    <div>
                        <?php
                        
                        echo $hoadon['0']['Email'];
                        
                        ?>
                    </div>
                </div>

                <!-- --------------------------------------------------------------- -->

                <div class="display-flex align-items-center justify-content-space-between margin-bottom-20px">
                    <div>
                        Ngày giao dịch
                    </div>
                    <div>
                        <?php
                        
                        $timecreate = $hoadon['0']['timecreate'];
                        $formattedDate = date("d-m-Y", strtotime($timecreate));
                        $formattedTime = date("H:i:s", strtotime($timecreate));
                        echo 'Ngày ' . $formattedDate . ', lúc ' . $formattedTime;
        
                        ?>
                    </div>
                </div>

                <!-- --------------------------------------------------------------- -->
                
                <hr class="hr-qrcode">

                <div class="display-flex align-items-center justify-content-space-between">
                    <div>
                        Tổng thanh toán
                    </div>
                    <div class="display-flex align-items-center font-size-22px font-weight-600">
                        <div style="margin-right: 5px;">
                            <?php
                            
                            echo number_format($hoadon['0']['Total']*1000, 0, '', '.') . ' VND';
                            
                            ?>
                        </div>
                        <!-- <div>
                            VND
                        </div> -->
                    </div>
                </div>
            </div>

        </div>
        <!-- =============================================END YOUR ORDER================================================================= -->

        <!-- =============================================START QR & LIST PRODUCT=============================================================== -->
        <div class="qr-and-product display-flex justify-content-space-between">
            <div class="your-order-padding width-100phantram">
                <div class="margin-bottom-20px font-size-18px font-weight-600">
                    Danh sách sản phẩm
                </div>
                <div id="list-product-at-order">

                    <!-- <div class="pr-order display-flex align-items-center justify-content-space-between margin-bottom-20px">

                        <div class="display-flex align-items-center">
                            <div class="pr-order-img overflow-hidden border-radius-12px margin-right-10px">
                                <img class="width-100-height-100" src="https://i.pinimg.com/originals/43/ec/f7/43ecf763ebfdc4ce1db42441714dbeca.jpg" alt="">
                            </div>
                            <div>
                                <div class="font-size-18px font-weight-600">
                                    Sengaku #2020
                                </div>
                                <div class="color-text-xam">
                                    Bởi Johan
                                </div>
                            </div>
                        </div>
                        
                        <div class="display-flex align-items-center font-weight-600">
                            <p style="margin-right: 5px;">14.000</p>
                            <p>VND</p>
                        </div>

                    </div> -->
                    <!-- ---------------------------------- -->

                </div>
            </div>
            <div class="your-order-padding width-100phantram">
                <div class="margin-bottom-20px font-size-18px font-weight-600">
                    Mã QR thanh toán
                </div>
                <div class="display-flex align-items-center">
                    <div class="overflow-hidden QR-Image">
                        <img class="width-100-height-100" src="https://i.pinimg.com/originals/f7/b4/70/f7b47083c1734d337d37092cbe1d9228.png" alt="">
                    </div>
                    <div class="in4-of-qrcode">
                        <div class="margin-bottom-10px">
                            0921063009
                        </div>
                        <div class="margin-bottom-10px">
                            PHAM VAN TAN
                        </div>
                        <div class="margin-bottom-10px">
                            Ngân hàng Thương mại cổ phần Quân đội MB BANK
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- =============================================END QR & LIST PRODUCT=============================================================== -->

    </div>
</div>

<script src="<?php echo SITE_SCRIPT_PATH; ?>code_qr.js"></script>

</body>
</html>