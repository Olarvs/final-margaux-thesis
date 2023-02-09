<?php
session_start();
require_once '../database/config.php';

$userId = $_SESSION['margaux_user_id'];

if(isset($_POST['cancel'])) {
    $orderId = $_POST['orderId'];

    $check = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId AND userId = $userId");

    if(mysqli_num_rows($check) == 1) {
        $delete = mysqli_query($conn, "DELETE FROM tbl_order WHERE orderId = $orderId");

        if($delete) {
            echo 'success';
        }
    } else {
        echo 'invalid';
    }
}