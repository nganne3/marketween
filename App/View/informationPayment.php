<?php

session_start();
ob_start();

if(isset($_SESSION['informationPayment'])) { 
    unset($_SESSION['informationPayment']); 
}

include "../../Config/database.php";
include "../../Config/paths.php";

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
    <!-- =========================CSS============================ -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- =========================JQUERY============================ -->

</head>

<body class="overflow-hidden">

    <div id="informationPayment-page">
        <div class="display-flex justify-content-space-between">
            <!-- ======================START INFORMATION WRITING PART========================== -->
            <div class="width-50phantram display-flex justify-content-center ">
                <div class="width-of-input-form-payment-information">
                    <!-- ==============================START LOGO=============================== -->
                    <div id="brand-marketween" class="display-flex align-items-center margin-bottom-146px margin-top-54px">
                        <div id="logo-at-information-payment-page" class="overflow-hidden border-radius-50phantram margin-right-10px">
                            <img class="width-100-height-100" src="https://i.pinimg.com/originals/fb/54/84/fb54849f358f7825923f7d0517f3678f.png" alt="">
                        </div>
                        <div class="font-weight-600 font-size-18px">
                            Marketween
                        </div>
                    </div>
                    <!-- ==============================END LOGO=============================== -->
                    <div>
                        <h1 class="font-size-36px margin-bottom-15px">
                            Thông tin thanh toán
                        </h1>
                        <div class="margin-bottom-48px">
                            Hãy cung cấp thông tin chúng tôi để có thể thực hiện thanh toán cũng như nhận sản phẩm
                        </div>

                        <div id="box_maintain_email" class="display-flex align-items-center jus border-xam border-radius-12px ">
                            <input id="check_email_pm_ne" class="input-destroy input-email-1n4-pay border-radius-12px width-100phantram" type="text" placeholder="Email nhận sản phẩm">
                            <div style="position: absolute; right: 10px; z-index:10;" class="display-flex align-items-center">
                                <span style="font-size: 12px; font-weight:400; margin-right:5px;" id="error_gmail_ip"></span>
                                <i id="err_gmailip" class='bx bxs-error-circle'></i>
                            </div>
                        </div>
                        
                        <br>

                        <div id="box_maintain_name" class="display-flex align-items-center border-xam border-radius-12px">
                            <input id="check_name_pm_ne" class="input-destroy input-email-1n4-pay border-radius-12px width-100phantram" type="text" placeholder="Họ và tên">
                            <div style="position: absolute; right: 10px; z-index:10;" class="display-flex align-items-center">
                                <span style="font-size: 12px; font-weight:400; margin-right:5px;" id="error_name_ip"></span>
                                <i id="err_nameip" class='bx bxs-error-circle'></i>
                            </div>
                        </div>
                        <br>

                        <div class="display-flex align-items-center justify-content-center margin-bottom-10px">
                            <button id="conf_payment_not_with_login" class="btn-destroy border-radius-12px width-100phantram padding-17px background-color-brand text-white button-disabled">Xác nhận</button>
                        </div>

                        <?php  
                            if(isset($_SERVER['HTTP_REFERER'])) {
                                echo '
                                    <a href="' . $_SERVER['HTTP_REFERER'] . '" class="display-flex align-items-center justify-content-center ">
                                    <button class="btn-destroy border-radius-12px width-100phantram padding-17px" style="border: 1px solid #c0b1b1;">Trở lại trang trước</button>
                                    </a>
                                ';
                            } else {
                                echo '
                                    <a href="javascript:history.back()" class="display-flex align-items-center justify-content-center ">
                                    <button class="btn-destroy border-radius-12px width-100phantram padding-17px" style="border: 1px solid #c0b1b1;">Trở lại trang trước</button>
                                    </a>
                                ';
                            }                    
                        ?>
                    </div>
                </div>
            </div>
            <!-- ======================END INFORMATION WRITING PART========================== -->

            <!-- ======================START SLIDE========================== -->
            <div class="width-50phantram height-max-content" >
                <div class="position-relactive width-100-height-100 ">
                    <div class="width-100-height-100 overflow-hidden">
                        <img class="width-100-height-100" src="https://i.pinimg.com/originals/55/d7/7f/55d77fd9bbe2ea76abe0080c6a31a0e2.png" alt="">
                    </div>
                    <div class="position-absolute width-100-height-100" style="background-color: rgba(0, 0, 0, 0.463); top: 0;">

                    </div>
                    <div class="position-absolute text-white infor-slide">
                        <div class="font-size-36px font-weight-600">
                            Joe Mark Count Universer
                        </div>
                        <div>
                            <span> Từ bộ sưu tập </span>&nbsp;<span>Mao Kai</span>
                        </div>
                        <div class="display-flex align-items-center margin-top-20px" style="column-gap: 10px;">
                            <div class="hinhtron-slide"></div>
                            <div class="hinhtron-slide"></div>
                            <div class="hinhtron-slide"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======================START SLIDE========================== -->
        </div>
    </div>

<script src="<?php echo SITE_SCRIPT_PATH; ?>page_informationpayment.js"></script>

</body>

</html>