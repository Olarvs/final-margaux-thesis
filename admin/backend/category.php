<?php
session_start();
require_once '../../database/config.php';

if (isset($_POST['addCategory'])) {
    $addCategoryName = $_POST['addCategoryName'];
    $image = $_FILES['addCategoryThumbnail']['name'];
    $imageTmp = $_FILES['addCategoryThumbnail']['tmp_name'];

    $checkIfCategoryExist = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryName = '$addCategoryName'");

    if (mysqli_num_rows($checkIfCategoryExist) > 0) {
        echo 'exist';
    } else {
        $imageExt = explode('.', $image);
        $imageExt = strtolower(end($imageExt));

        $newImageName = uniqid() . '.' . $imageExt;

        $insertCategory = mysqli_query($conn, "INSERT INTO tbl_category (categoryName, categoryThumbnail) VALUES ('$addCategoryName', '$newImageName')");

        if ($insertCategory) {
            move_uploaded_file($imageTmp, '../assets/images/categoryImages/' . $newImageName);

            echo 'success';
        }

    }
}

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

// Edit Category
if (isset($_POST['editCategory'])) {
    $editCategoryId = $_POST['editCategoryId'];
    $editOldImage = $_POST['editOldImage'];
    $editCategoryName = $_POST['editCategoryName'];
    $editCategoryThumbnail = $_FILES['editCategoryThumbnail']['name'];
    $editCategoryThumbnailTmp = $_FILES['editCategoryThumbnail']['tmp_name'];
    $editCategoryThumbnailError = $_FILES['editCategoryThumbnail']['error'];

    if ($editCategoryThumbnailError == 4) {
        $checkIfCategoryExist = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryName = '$editCategoryName' AND categoryId != $editCategoryId");

        if (mysqli_num_rows($checkIfCategoryExist) > 0) {
            echo 'exist';
        } else {
            $updateCategory = mysqli_query($conn, "UPDATE tbl_category SET categoryName = '$editCategoryName' WHERE categoryId = $editCategoryId");

            if ($updateCategory) {
                echo 'success';
            }
        }
    } else {
        $checkIfCategoryExist = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryName = '$editCategoryName' AND categoryId != $editCategoryId");

        if (mysqli_num_rows($checkIfCategoryExist) > 0) {
            echo 'exist';
        } else {
            $imageExt = explode('.', $editCategoryThumbnail);
            $imageExt = strtolower(end($imageExt));

            $newImageName = uniqid() . '.' . $imageExt;

            $updateCategory = mysqli_query($conn, "UPDATE tbl_category SET categoryName = '$editCategoryName', categoryThumbnail = '$newImageName' WHERE categoryId = $editCategoryId");

            if ($updateCategory) {
                move_uploaded_file($editCategoryThumbnailTmp, '../assets/images/categoryImages/' . $newImageName);

                if (file_exists('../assets/images/categoryImages/' . $editOldImage)) {
                    unlink('../assets/images/categoryImages/' . $editOldImage);
                }

                echo 'success';
            }
        }
    }
}

// DELETE CATEGORY
if (isset($_POST['deleteCategory'])) {
    $deleteCategoryId = $_POST['deleteCategoryId'];

    $checkIfCategoryExist = mysqli_query($conn, "SELECT * FROM tbl_category WHERE categoryId = $deleteCategoryId");

    if (mysqli_num_rows($checkIfCategoryExist) > 0) {
        $archiveCategory = mysqli_query($conn, "UPDATE tbl_category SET isDeleted = 1 WHERE categoryId = $deleteCategoryId");

        if ($archiveCategory) {
            echo 'success';
        }
    } else {
        echo 'invalid';
    }
}

// Array
// (
//     [deleteCategoryId] => 2
//     [deleteCategory] => true
// )
