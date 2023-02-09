<?php
session_start();
require_once '../database/config.php';

if(isset($_POST['verify'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $timestamp = $_SERVER['REQUEST_TIME'];
    $datas = json_decode($_SESSION['update_profile_array'], true);

    if(($timestamp - $_SESSION['time']) > 180) {
        unset($_SESSION['otp']);
        echo 'expired';
    } else {
        if($_SESSION['update_email'] == $email) {
            if($_SESSION['otp'] == $otp) {
                $user_id = $datas['user_id'];
                $name = $datas['name'];
                $birthday = $datas['birthday'];
                $gender = $datas['gender'];
                $provinceValue = $datas['provinceValue'];
                $cityValue = $datas['cityValue'];
                $barangayValue = $datas['barangayValue'];
                $block = $datas['block'];
                $email = $datas['email'];
                $phoneNumber = $datas['phoneNumber'];
                $new_pass = $datas['new_pass'];
                $new_pass_hashed = md5($new_pass);
                
                if($new_pass == NULL || $new_pass == '') {
                    $update = mysqli_query($conn, "UPDATE tbl_user SET name = '$name', email = '$email', mobile_no = '$phoneNumber', gender = '$gender', birthday = '$birthday', block = '$block', barangay = '$barangayValue', city = '$cityValue', province = '$provinceValue' WHERE user_id = $user_id");

                    if($update) {
                        echo 'success';
                    }
                } else {
                    $update = mysqli_query($conn, "UPDATE tbl_user SET name = '$name', email = '$email', mobile_no = '$phoneNumber', gender = '$gender', birthday = '$birthday', block = '$block', barangay = '$barangayValue', city = '$cityValue', province = '$provinceValue', password = '$new_pass_hashed' WHERE user_id = $user_id");

                    if($update) {
                        echo 'success';
                    }
                }
            } else {
                echo 'invalid otp';
            }
        } else {
            echo 'invalid email';
        }
    }
}