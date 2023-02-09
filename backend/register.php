<?php
session_start();
require_once '../database/config.php';
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';

if (isset($_POST['register'])) {
    $mail = new PHPMAILER(true);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $profile_image = 'profile.png';
    $password = md5($_POST['password']);

    $check_if_exist = mysqli_query($conn, "SELECT * FROM tbl_user WHERE email = '$email'");

    if (mysqli_num_rows($check_if_exist) > 0) {
        foreach ($check_if_exist as $get_info) {
            if ($get_info['verified'] == '' || $get_info['verified'] == null) {
                $delete = mysqli_query($conn, "DELETE FROM tbl_user WHERE email = '$email'");

                if ($delete) {
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
                        $mail->addAddress($email, $name);

                        //Set email format to HTML
                        $mail->isHTML(true);

                        $otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

                        $mail->Subject = 'Email verification';
                        $mail->Body = '<p>Your One-Time pin is: <b style="font-size: 30px;">' . $otp . '. </b>Please enter this code within 3 minutes</p><p>Incase you didn\'t request for an OTP, simply ignore this message.</p><p>Have a wonderful day!</p><p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                        $mail->send();

                        // insert in users table
                        $insert = mysqli_query($conn, "INSERT INTO tbl_user (name, email, mobile_no, gender, birthday, password, profile_image) VALUES ('$name', '$email', '$phoneNumber', '$gender', '$birthday', '$password', '$profile_image')");

                        if ($insert) {
                            $_SESSION['verify_email'] = $email;
                            $_SESSION['otp'] = $otp;
                            $_SESSION['time'] = $_SERVER['REQUEST_TIME'];
                            echo 'verification.php';
                        }
                        exit();
                    } catch (Exception $e) {
                        echo "Manuel practice: Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                echo 'email already used';
            }
        }
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
            $mail->addAddress($email, $name);

            //Set email format to HTML
            $mail->isHTML(true);

            $otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body = '<p>Your One-Time pin is: <b style="font-size: 30px;">' . $otp . '. </b>Please enter this code within 3 minutes</p><p>Incase you didn\'t request for an OTP, simply ignore this message.</p><p>Have a wonderful day!</p><p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

            $mail->send();

            // insert in users table
            $insert = mysqli_query($conn, "INSERT INTO tbl_user (name, email, mobile_no, gender, birthday, password, profile_image) VALUES ('$name', '$email', '$phoneNumber', '$gender', '$birthday', '$password', '$profile_image')");

            if ($insert) {
                $_SESSION['verify_email'] = $email;
                $_SESSION['otp'] = $otp;
                $_SESSION['time'] = $_SERVER['REQUEST_TIME'];
                echo 'verification.php';
            }
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
