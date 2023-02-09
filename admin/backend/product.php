<?php
session_start();
require_once '../../database/config.php';

if (isset($_POST['addProduct'])) {
    $currentDate = date('Y-m-d');
    $addCategoryId = $_POST['addCategoryId'];
    $addProductName = $_POST['addProductName'];
    $addProductDescription = mysqli_real_escape_string($conn, $_POST['addProductDescription']) ?? null;
    $addProductPrice = $_POST['addProductPrice'];
    $addProductStock = $_POST['addProductStock'];
    $addProductStatus = $_POST['addProductStatus'];
    $addProductThumbnail = $_FILES['addProductThumbnail']['name'];
    $addProductThumbnailTmp = $_FILES['addProductThumbnail']['tmp_name'];
    $addProductThumbnailError = $_FILES['addProductThumbnail']['error'];

    if ($addProductThumbnailError == 4) {
        $checkIfProductExist = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productName = '$addProductName' AND categoryId = $addCategoryId");

        if (mysqli_num_rows($checkIfProductExist) > 0) {
            echo 'exist';
        } else {
            $insertProduct = mysqli_query($conn, "INSERT INTO tbl_product (categoryId, productName, productDesc, productThumbnail, productPrice, productStock, productStatus, dateAdded) VALUES ('$addCategoryId', '$addProductName', NULLIF('$addProductDescription', ''), 'no_image_available-product.png', '$addProductPrice', '$addProductStock', '$addProductStatus', '$currentDate')");

            if ($insertProduct) {
                echo 'success';
            }
        }
    } else {
        $imageExt = explode('.', $addProductThumbnail);
        $imageExt = strtolower(end($imageExt));

        $newImageName = uniqid() . '.' . $imageExt;

        $insertProduct = mysqli_query($conn, "INSERT INTO tbl_product (categoryId, productName, productDesc, productThumbnail, productPrice, productStock, productStatus, dateAdded) VALUES ('$addCategoryId', '$addProductName', NULLIF('$addProductDescription', ''), '$newImageName', '$addProductPrice', '$addProductStock', '$addProductStatus', '$currentDate')");

        if ($insertProduct) {
            move_uploaded_file($addProductThumbnailTmp, '../assets/images/productImages/' . $newImageName);

            echo 'success';
        }
    }
}

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

// Edit Category
if (isset($_POST['editProduct'])) {
    $editProductId = $_POST['editProductId'];
    $editCategoryId = $_POST['editCategoryId'];
    $editProductName = $_POST['editProductName'];
    $editProductDescription = mysqli_real_escape_string($conn, $_POST['editProductDescription']) ?? null;
    $editProductPrice = $_POST['editProductPrice'];
    $editProductStatus = $_POST['editProductStatus'];
    $editOldProductThumbnail = $_POST['editOldProductThumbnail'];
    $editProductThumbnail = $_FILES['editProductThumbnail']['name'];
    $editProductThumbnailError = $_FILES['editProductThumbnail']['error'];
    $editProductThumbnailTmp = $_FILES['editProductThumbnail']['tmp_name'];


    if ($editProductThumbnailError == 4) {
        $checkIfProductExist = mysqli_query($conn, "SELECT * FROM tbl_product WHERE categoryId = $editCategoryId AND productName = '$editProductName' AND productId != $editProductId");

        if (mysqli_num_rows($checkIfProductExist) > 0) {
            echo 'exist';
        } else {
            $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productName = '$editProductName', productDesc = NULLIF('$editProductDescription', ''), productPrice = '$editProductPrice', productStatus = '$editProductStatus' WHERE productId = $editProductId");

            if ($updateProduct) {
                echo 'success';
            }
        }
    } else {
        $checkIfProductExist = mysqli_query($conn, "SELECT * FROM tbl_product WHERE categoryId = $editCategoryId AND productName = '$editProductName' AND productId != $editProductId");

        if (mysqli_num_rows($checkIfProductExist) > 0) {
            echo 'exist';
        } else {
            $imageExt = explode('.', $editProductThumbnail);
            $imageExt = strtolower(end($imageExt));

            $newImageName = uniqid() . '.' . $imageExt;

            $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productName = '$editProductName', productDesc = NULLIF('$editProductDescription', ''), productPrice = '$editProductPrice', productStatus = '$editProductStatus', productThumbnail = '$newImageName' WHERE productId = $editProductId");

            if ($updateProduct) {
                move_uploaded_file($editProductThumbnailTmp, '../assets/images/productImages/' . $newImageName);

                if($editOldProductThumbnail != 'no_image_available-product.png') {
                    if (file_exists('../assets/images/productImages/' . $editOldProductThumbnail)) {
                        unlink('../assets/images/productImages/' . $editOldProductThumbnail);
                    }
                }

                echo 'success';
            }
        }
    }
}

if (isset($_POST['deleteProduct'])) {
    $deleteProductId = $_POST['deleteProductId'];

    $checkIfProductExist = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $deleteProductId");

    if (mysqli_num_rows($checkIfProductExist) > 0) {
        $archiveProduct = mysqli_query($conn, "UPDATE tbl_product SET isDeleted = 1 WHERE productId = $deleteProductId");

        if ($archiveProduct) {
            echo 'success';
        }
    } else {
        echo 'invalid';
    }
}

// Array
// (
//     [addCategoryId] => 2
//     [addProductName] => Cutie
//     [addProductDescription] => Sheeesh
//     [addProductPrice] => 200
//     [addProductStock] => 20
//     [addProductStatus] => Available
//     [addProduct] => true
// )
// Array
// (
//     [addProductThumbnail] => Array
//         (
//             [name] =>
//             [full_path] =>
//             [type] =>
//             [tmp_name] =>
//             [error] => 4
//             [size] => 0
//         )

// )
