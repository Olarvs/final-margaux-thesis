<?php
session_start();
require_once '../../database/config.php';

// Get Category
if (isset($_POST['getCategory'])) {
    $getCategoryId = $_POST['getCategoryId'];
    $get_category = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryId = $getCategoryId");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_category)) {
        $result_array['categoryId'] = $result['categoryId'];
        $result_array['categoryName'] = $result['categoryName'];
        $result_array['categoryThumbnail'] = $result['categoryThumbnail'];
    }

    echo json_encode($result_array);
}
// RESTORE CATEGORY
if (isset($_POST['restoreCategory'])) {
    $restoreCategoryId = $_POST['restoreCategoryId'];

    $checkIfCategoryExist = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryId = $restoreCategoryId");

    if (mysqli_num_rows($checkIfCategoryExist) > 0) {
        $restoreCategory = mysqli_query($conn, "UPDATE tbl_category SET isDeleted = 0 WHERE categoryId = $restoreCategoryId");

        if ($restoreCategory) {
            echo 'success';
        }
    } else {
        echo 'invalid';
    }
}


// DELETE CATEGORY
if (isset($_POST['deleteCategory'])) {
    $deleteCategoryId = $_POST['deleteCategoryId'];

    $checkIfCategoryExist = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryId = $deleteCategoryId");

    if (mysqli_num_rows($checkIfCategoryExist) > 0) {
        $deleteCategory = mysqli_query($conn, "UPDATE tbl_category SET isDeleted = 2 WHERE categoryId = $deleteCategoryId");

        if ($deleteCategory) {
            echo 'success';
        }
    } else {
        echo 'invalid';
    }
}
// RESTORE Product
if (isset($_POST['restoreProduct'])) {
    $restoreProductId = $_POST['restoreProductId'];

    $checkIfProductExist = mysqli_query($conn, "SELECT a.categoryId, a.productId, a.productName, a.productDesc, a.productThumbnail,b.isDeleted,b.categoryName FROM tbl_product a   LEFT JOIN tbl_category b ON a.categoryId = b.categoryId WHERE a.productId = $restoreProductId");
    if (mysqli_num_rows($checkIfProductExist) ==0 ){
        echo 'invalid';
    } else{
        foreach($checkIfProductExist as $product){
            if ($product['isDeleted'] == 0) {
                $restoreProduct = mysqli_query($conn, "UPDATE tbl_product SET isDeleted = 0 WHERE productId = $restoreProductId");

            if ($restoreProduct) {
                echo 'success';
                }
            }   else {
                    echo 'error';
            }
        }
    }
}

// DELETE Product
if (isset($_POST['deleteProduct'])) {
    $deleteProductId = $_POST['deleteProductId'];

    $checkIfProductExist = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $deleteProductId");

    if (mysqli_num_rows($checkIfProductExist) > 0) {
        $deleteProduct = mysqli_query($conn, "UPDATE tbl_product SET isDeleted = 2 WHERE productId = $deleteProductId");

        if ($deleteProduct) {
            echo 'success';
        }
    } else {
        echo 'invalid';
    }
}
// Array
// (
//     [deleteProductId] => 2
//     [deleteProduct] => true
// )
