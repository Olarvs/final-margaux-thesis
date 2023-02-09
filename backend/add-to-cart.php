<?php
session_start();
require_once '../database/config.php';

if (isset($_POST['addToCart'])) {
    if (!isset($_SESSION['margaux_user_id'])) {
        echo 'login first';
    } else {
        $userId = $_SESSION['margaux_user_id'];
        $qty = $_POST['qty'];
        $productPrice = $_POST['productPrice'];
        $productId = $_POST['productId'];
        $categoryId = $_POST['categoryId'];
        $productTotal = $_POST['productTotal'];

        $checkIfExist = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE productId = $productId AND userId = $userId");

        if (mysqli_num_rows($checkIfExist) > 0) {
            $fetch = mysqli_fetch_array($checkIfExist);
            $productPriceDB = $fetch['productPrice'];
            $productQtyDB = $fetch['productQty'];
            $productTotalDB = $fetch['productTotal'];
            $cartId = $fetch['cartId'];

            if ($productPrice == $productPriceDB) {
                $finalProductQty = floatval($qty) + floatval($productQtyDB);
                $finalProductTotal = floatval($productTotal) + floatval($productTotalDB);

                $updateCart = mysqli_query($conn, "UPDATE tbl_cart SET productQty = '$finalProductQty', productTotal = '$finalProductTotal' WHERE cartId = $cartId");

                if($updateCart) {
                    echo 'success';
                }
            } else {
                $addToCart = mysqli_query($conn, "INSERT INTO tbl_cart (userId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$userId', '$categoryId', '$productId', '$productPrice', '$qty', '$productTotal')");

                if ($addToCart) {
                    echo 'success';
                }
            }
        } else {
            $addToCart = mysqli_query($conn, "INSERT INTO tbl_cart (userId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$userId', '$categoryId', '$productId', '$productPrice', '$qty', '$productTotal')");

            if ($addToCart) {
                echo 'success';
            }
        }
    }
}

if (isset($_POST['updateToCart'])) {
    if (!isset($_SESSION['margaux_user_id'])) {
        echo 'login first';
    } else {
        $cartId = $_SESSION['cartId'];
        $userId = $_SESSION['margaux_user_id'];
        $qty = $_POST['qty'];
        $productPrice = $_POST['productPrice'];
        $productId = $_POST['productId'];
        $categoryId = $_POST['categoryId'];
        $productTotal = $_POST['productTotal'];

        $updateCart = mysqli_query($conn, "UPDATE tbl_cart SET productQty = '$qty', productPrice = '$productPrice', productId = '$productId', categoryId = '$categoryId', productTotal = '$productTotal' WHERE cartId = $cartId");

        if ($updateCart) {
            echo 'success';
        }
    }
}

if (isset($_POST['deleteItem'])) {
    $cartId = $_POST['cartId'];

    $removeItem = mysqli_query($conn, "DELETE FROM tbl_cart WHERE cartId = $cartId");

    if ($removeItem) {
        echo 'success';
    }
}
