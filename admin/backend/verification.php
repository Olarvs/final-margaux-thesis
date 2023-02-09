<?php
session_start();
require_once '../../database/config.php';

if(isset($_POST['verify'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $timestamp = $_SERVER['REQUEST_TIME'];

    if(($timestamp - $_SESSION['time_admin']) > 180) {
        unset($_SESSION['otp_admin']);
        echo 'expired';
    } else {
        if($_SESSION['verify_email_admin'] == $email) {
            if($_SESSION['otp_admin'] == $otp) {
                $update = mysqli_query($conn, "UPDATE tbl_admin SET isVerified = 1 WHERE email = '$email'");

                if($update) {
                    echo 'success';
                }
            } else {
                echo 'invalid otp';
            }
        } else {
            echo 'invalid email';
        }
    }
}