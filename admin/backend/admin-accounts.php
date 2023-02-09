<?php
session_start();
require_once '../../database/config.php';

if(isset($_POST['enable'])) {
    $adminId = $_POST['adminId'];

    $enable = mysqli_query($conn, "UPDATE tbl_admin SET status = 1 WHERE adminId = $adminId");

    if($enable) {
        echo 'success';
    }
}

if(isset($_POST['disable'])) {
    $adminId = $_POST['adminId'];

    $enable = mysqli_query($conn, "UPDATE tbl_admin SET status = 0 WHERE adminId = $adminId");

    if($enable) {
        echo 'success';
    }
}

if(isset($_POST['getAccount'])) {
    $adminId = $_POST['adminId'];

    $getInfo = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE adminId = $adminId");

    $resultArray = array();
    foreach($getInfo as $row) {
        $resultArray['adminId'] = $row['adminId'];
        $resultArray['name'] = $row['name'];
        $resultArray['username'] = $row['username'];
        $resultArray['email'] = $row['email'];
        $resultArray['password'] = $row['password'];
        $resultArray['role'] = $row['role'];
    }

    echo json_encode($resultArray);
}

if(isset($_POST['updateAccount'])) {
    $adminId = $_POST['adminId'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $checkEmail = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email = '$email' AND adminId != $adminId");

    if(mysqli_num_rows($checkEmail) > 0) {
        echo 'email exist';
    } else {
        $checkUsername = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE adminId != $adminId AND username = '$username'");

        if(mysqli_num_rows($checkUsername) > 0) {
            echo 'username exist';
        } else {
            $update = mysqli_query($conn, "UPDATE tbl_admin SET name = '$name', username = '$username', email = '$email', role = '$role', password = '$password' WHERE adminId = $adminId");

            if($update) {
                echo 'success';
            }
        }
    }
}