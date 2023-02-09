<?php
session_start();
require_once '../../database/config.php';

if(isset($_POST['verify'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $timestamp = $_SERVER['REQUEST_TIME'];
    $datas = json_decode($_SESSION['admin_update_profile_array'], true);

    if(($timestamp - $_SESSION['admin_time']) > 180) {
        unset($_SESSION['admin_otp']);
        echo 'expired';
    } else {
        if($_SESSION['admin_update_email'] == $email) {
            if($_SESSION['admin_otp'] == $otp) {
                $admin_id = $datas['admin_id'];
                $name = $datas['name'];
                $email = $datas['email'];
                $username = $datas['username'];
                $new_pass = $datas['new_pass'];
                $new_pass_hashed = md5($new_pass);
                
                if($new_pass == NULL || $new_pass == '') {
                    $update = mysqli_query($conn, "UPDATE tbl_admin SET name = '$name', email = '$email', username = '$username' WHERE adminId = $admin_id");

                    if($update) {
                        echo 'success';
                    }
                } else {
                    $update = mysqli_query($conn, "UPDATE tbl_user SET name = '$name', email = '$email', username = '$username' password = '$new_pass_hashed' WHERE adminId = $admin_id");

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