<?php
session_start();
require_once '../database/config.php';

$currentDateTime = date('Y-m-d H:i:s');

$userId = $_SESSION['margaux_user_id'];

if (isset($_POST['feedback'])) {
    $orderId = $_POST['orderId'];
    $rate = $_POST['rate'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']) ?? null;

    $insertFeedback = mysqli_query($conn, "INSERT INTO tbl_feedback (userId, rate, comment, date) VALUES ('$userId', '$rate', '$comment', '$currentDateTime')");

    if ($insertFeedback) {
        $update = mysqli_query($conn, "UPDATE tbl_order SET feedback = '1' WHERE orderId = $orderId");

        if ($update) {
            echo 'success';
        }
    }
}
