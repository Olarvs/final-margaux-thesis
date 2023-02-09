<?php
session_start();
require_once '../../database/config.php';

if (isset($_POST['updateStockSett'])) {
    $stockId = $_POST['stockId'];
    $lowStockQty = $_POST['lowStockQty'];

    $update = mysqli_query($conn, "UPDATE tbl_stock_settings SET lowStock = '$lowStockQty' WHERE id = $stockId");

    if ($update) {
        echo 'success';
    }
}

if (isset($_POST['getProductStock'])) {
    $productId = $_POST['productId'];

    $getProductDB = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

    $resultArray = array();

    while ($row = mysqli_fetch_assoc($getProductDB)) {
        $resultArray['productId'] = $row['productId'];
        $resultArray['productName'] = $row['productName'];
    }
    echo json_encode($resultArray);
    // print_r($_POST);
}

if (isset($_POST['getEditProductStock'])) {
    $productId = $_POST['productId'];

    $getProductDB = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

    $resultArray = array();

    while ($row = mysqli_fetch_assoc($getProductDB)) {
        $resultArray['productId'] = $row['productId'];
        $resultArray['productName'] = $row['productName'];
        $resultArray['productStock'] = $row['productStock'];
    }
    echo json_encode($resultArray);
    // print_r($_POST);
}

if (isset($_POST['addStock'])) {
    $productId = $_POST['productId'];
    $productStock = $_POST['productStock'];

    $getCurrentStock = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

    foreach ($getCurrentStock as $currentStock) {
        $current = $currentStock['productStock'];
        $addStock = $productStock + $current;

        $update = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$addStock' WHERE productId = $productId");

        if ($update) {
            echo 'success';
        }
    }
    // print_r($_POST);
}

if (isset($_POST['editStock'])) {
    $productId = $_POST['editProductId'];
    $productStock = $_POST['editProductStock'];

    $update = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$productStock' WHERE productId = $productId");

    if ($update) {
        echo 'success';
    }
    // print_r($_POST);
}
