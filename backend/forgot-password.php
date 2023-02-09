<?php
session_start();
require_once '../database/config.php';
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';

if (isset($_POST['forgotPassword'])) {
    $mail = new PHPMAILER(true);
    $email = $_POST['email'];

    $checkIfEmailExist = mysqli_query($conn, "SELECT * FROM tbl_user WHERE email = '$email' AND verified = 'VERIFIED'");

    if (mysqli_num_rows($checkIfEmailExist) < 1) {
        echo 'invalid email';
    } else {
        try {
            //Enable verbose debug output
            $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

            //Send using SMTP
            $mail->isSMTP();

            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';

            //Enable SMTP authentication
            $mail->SMTPAuth = true;

            //SMTP username
            $mail->Username = 'margauxcscorner@gmail.com';

            //SMTP password
            $mail->Password = 'uqapxrlzstgpgjkq';
            
            //old djfkzhifoquvycgz
            //new uqapxrlzstgpgjkq
            
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

            //Add a recipient
            $mail->addAddress($email);

            //Set email format to HTML
            $mail->isHTML(true);

            $otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Password Reset';
            $mail->Body = '<p>Your One-Time pin is: <b style="font-size: 30px;">' . $otp . '. </b>Please enter this code within 3 minutes</p><p>Incase you didn\'t request for an OTP, simply ignore this message.</p><p>Have a wonderful day!</p><p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

            $mail->send();

            $_SESSION['forgot_pass_email'] = $email;
            $_SESSION['forgot_pass_otp'] = $otp;
            $_SESSION['forgot_pass_time'] = $_SERVER['REQUEST_TIME'];
            echo 'success';
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
