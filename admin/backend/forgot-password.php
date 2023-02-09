<?php
session_start();
require_once '../../database/config.php';
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../../vendor/autoload.php';

if (isset($_POST['requestReset'])) {
    $mail = new PHPMAILER(true);
    $email = $_POST['email'];

    $check = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email = '$email' AND isVerified = 1");

    if (mysqli_num_rows($check) > 0) {
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

            $_SESSION['admin_forgot_pass_email'] = $email;
            $_SESSION['admin_forgot_pass_otp'] = $otp;
            $_SESSION['admin_forgot_pass_time'] = $_SERVER['REQUEST_TIME'];
            echo 'success';
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'invalid email';
    }
}

if(isset($_POST['forgotPassVerification'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $timestamp = $_SERVER['REQUEST_TIME'];

    if(($timestamp - $_SESSION['admin_forgot_pass_time']) > 180) {
        unset($_SESSION['admin_forgot_pass_otp']);
        echo 'expired';
    } else {
        if($_SESSION['admin_forgot_pass_email'] == $email) {
            if($_SESSION['admin_forgot_pass_otp'] == $otp) {
                $_SESSION['admin_change_pass_email'] = $email;
                echo 'success';
            } else {
                echo 'invalid otp';
            }
        } else {
            echo 'invalid email';
        }
    }
}

if(isset($_POST['resetPassword'])) {
    $email = $_SESSION['admin_change_pass_email'];
    $password = md5($_POST['password']);

    $update = mysqli_query($conn, "UPDATE tbl_admin SET password = '$password' WHERE email = '$email'");

    if($update) {
        echo 'success';
    }
}