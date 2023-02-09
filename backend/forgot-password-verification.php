<?php
session_start();
require_once '../database/config.php';

if(isset($_POST['verify'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $timestamp = $_SERVER['REQUEST_TIME'];

    if(($timestamp - $_SESSION['forgot_pass_time']) > 180) {
        unset($_SESSION['forgot_pass_otp']);
        echo 'expired';
    } else {
        if($_SESSION['forgot_pass_email'] == $email) {
            if($_SESSION['forgot_pass_otp'] == $otp) {
                $_SESSION['change_pass_email'] = $email;
                echo 'success';
            } else {
                echo 'invalid otp';
            }
        } else {
            echo 'invalid email';
        }
    }
}