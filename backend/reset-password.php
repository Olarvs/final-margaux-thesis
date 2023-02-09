<?php
session_start();
require_once '../database/config.php';

if(isset($_POST['resetPassword'])) {
    $email = $_SESSION['change_pass_email'];
    $password = md5($_POST['password']);

    $update = mysqli_query($conn, "UPDATE tbl_user SET password = '$password' WHERE email = '$email'");

    if($update) {
        echo 'success';
    }
}