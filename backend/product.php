<?php
session_start();
require_once '../database/config.php';

// Get product
if(isset($_POST['getProduct'])) {
    $getProductId = $_POST['getProductId'];

    $getProductInfo = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $getProductId");

    $resultArray = array();
    foreach($getProductInfo as $row) {
        $resultArray['productId'] = $row['productId'];
        $resultArray['categoryId'] = $row['categoryId'];
        $resultArray['productName'] = $row['productName'];
        $resultArray['productDesc'] = $row['productDesc'];
        $resultArray['productThumbnail'] = $row['productThumbnail'];
        $resultArray['productPrice'] = $row['productPrice'];
        $resultArray['productStock'] = $row['productStock'];
        $resultArray['productStatus'] = $row['productStatus'];
    }

    echo json_encode($resultArray);
}