<?php
session_start();
require_once '../database/config.php';

if(isset($_POST['verify'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $timestamp = $_SERVER['REQUEST_TIME'];

    if(($timestamp - $_SESSION['time']) > 180) {
        unset($_SESSION['otp']);
        echo 'expired';
    } else {
        if($_SESSION['verify_email'] == $email) {
            if($_SESSION['otp'] == $otp) {
                $update = mysqli_query($conn, "UPDATE tbl_user SET verified = 'VERIFIED' WHERE email = '$email'");

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