<?php
session_start();
require_once '../../database/config.php';
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../../vendor/autoload.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $profile_image = 'profile.png';
    $role = $_POST['role'];

    $checkIfEmailExist = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email = '$email'");

    if (mysqli_num_rows($checkIfEmailExist) > 0) {
        foreach ($checkIfEmailExist as $fetchInfo) {
            if ($fetchInfo['isVerified'] == 0) {
                $adminId = $fetchInfo['adminId'];
                $delete = mysqli_query($conn, "DELETE FROM tbl_admin WHERE adminId = $adminId");

                if ($delete) {
                    $checkIfUserNameExist = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email != '$email' AND username = '$username' AND isVerified = 1");

                    if (mysqli_num_rows($checkIfUserNameExist) > 0) {
                        echo 'username exist';
                    } else {
                        try {
                            $mail = new PHPMAILER();
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
                            $insert = mysqli_query($conn, "INSERT INTO tbl_admin (name, username, email, password, profile_image, role) VALUES ('$name', '$username', '$email', '$password', '$profile_image', '$role')");

                            if ($insert) {
                                $_SESSION['verify_email_admin'] = $email;
                                $_SESSION['otp_admin'] = $otp;
                                $_SESSION['time_admin'] = $_SERVER['REQUEST_TIME'];
                                echo 'verification.php';
                            }
                            exit();
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }
            } else {
                echo 'email exist';
            }
        }
    } else {
        $checkIfUserNameExist = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email != '$email' AND username = '$username' AND isVerified = 1");

        if (mysqli_num_rows($checkIfUserNameExist) > 0) {
            echo 'username exist';
        } else {
            try {
                $mail = new PHPMAILER();
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
                $insert = mysqli_query($conn, "INSERT INTO tbl_admin (name, username, email, password, profile_image, role) VALUES ('$name', '$username', '$email', '$password', '$profile_image', '$role')");

                if ($insert) {
                    $_SESSION['verify_email_admin'] = $email;
                    $_SESSION['otp_admin'] = $otp;
                    $_SESSION['time_admin'] = $_SERVER['REQUEST_TIME'];
                    echo 'verification.php';
                }
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
