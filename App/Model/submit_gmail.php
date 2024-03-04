<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($Email, $subject, $body, $my_email, $my_bussiness, $host_mail, $code_word, $my_pass_mail ) {
    require '../../PHPMailer-master/src/Exception.php';
    require '../../PHPMailer-master/src/PHPMailer.php';
    require '../../PHPMailer-master/src/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0; //0,1,2: chế độ debug. khi chạy ngon thì chỉnh lại 0 nhé
        $mail->isSMTP();  
        $mail->CharSet  = $code_word;
        $mail->Host = $host_mail;  //SMTP servers
        $mail->SMTPAuth = true; // Enable authentication
        $mail->Username = $my_email; // SMTP username
        $mail->Password = $my_pass_mail;   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // port to connect to 465/587             
        $mail->setFrom($my_email, $my_bussiness); 
        $mail->addAddress($Email, 'User'); //mail và tên người nhận  
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->smtpConnect( array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        ));
        $mail->send();
        echo 'Đã gửi mail xong';
    } catch (Exception $e) {
        echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;
    }
}
