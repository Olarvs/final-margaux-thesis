<?php
session_start();
require_once '../../database/config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $passwordWoMd5 = $_POST['password'];
    $role = $_POST['role'];

    $checkIfExist = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password' AND role = '$role' AND isVerified = 1");

    if (mysqli_num_rows($checkIfExist) > 0) {
        foreach($checkIfExist as $row) {
            if($row['status'] == 0) {
                echo 'not activate';
            } else {
                $_SESSION['margaux_admin_id'] = $row['adminId'];
                $_SESSION['margaux_admin_username'] = $username;
                $_SESSION['margaux_role'] = $role;
                echo 'success';
            }
        }
    } else {
        echo 'invalid';
    }
}
