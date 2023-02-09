<?php
session_start();
require_once '../database/config.php';

if (isset($_POST['checkout'])) {
    // FOR PICKUP
    if ($_POST['deliveryMethod'] == 'PICK UP') {
        // FOR CASH ON DELIVERY/PICKUP
        if ($_POST['paymentMethod'] == 'CASH ON DELIVERY/PICKUP') {
            $paymentMethod = $_POST['paymentMethod'];
            $userId = $_SESSION['margaux_user_id'];
            $fullName = $_POST['fullName'];
            $contactNumber = $_POST['contactNumber'];
            $deliveryMethod = $_POST['deliveryMethod'];
            $pickUpDateTime = date('Y-m-d h:i:s', strtotime($_POST['pickUpDate'] . ' ' . $_POST['pickUpTime']));
            $orderDateTime = date('Y-m-d H:i:s');
            $orderTotal = $_POST['orderTotal'];

            $insertOrder = mysqli_query($conn, "INSERT INTO tbl_order (userId, deliveryMethod, pickupDateTime, paymentMethod, orderTotal, orderDateTime, orderStatus) VALUES ('$userId', '$deliveryMethod', '$pickUpDateTime', '$paymentMethod', '$orderTotal', '$orderDateTime', 'PENDING')");

            if ($insertOrder) {
                $orderId = mysqli_insert_id($conn);

                $insertOrderAddress = mysqli_query($conn, "INSERT INTO tbl_order_address (orderId, billingFullname, billingContactNum) VALUES ('$orderId', '$fullName', '$contactNumber')");

                if ($insertOrderAddress) {
                    $getCartItem = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE userId = $userId");

                    foreach ($getCartItem as $item) {
                        $cartId = $item['cartId'];
                        $categoryId = $item['categoryId'];
                        $productId = $item['productId'];
                        $productPrice = $item['productPrice'];
                        $productQty = $item['productQty'];
                        $productTotal = $item['productTotal'];

                        $insertOrderItems = mysqli_query($conn, "INSERT INTO tbl_order_items (orderId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$orderId', '$categoryId', '$productId', '$productPrice', '$productQty', '$productTotal')");

                        if ($insertOrderItems) {
                            $deleteCartItem = mysqli_query($conn, "DELETE FROM tbl_cart WHERE cartId = $cartId");
                        }
                    }

                    if ($deleteCartItem) {
                        echo 'success';
                    }
                }
            }
            // FOR GCASH
        } else {
            $paymentMethod = $_POST['paymentMethod'];
            $userId = $_SESSION['margaux_user_id'];
            $fullName = $_POST['fullName'];
            $contactNumber = $_POST['contactNumber'];
            $deliveryMethod = $_POST['deliveryMethod'];
            $pickUpDate = $_POST['pickUpDate'];
            $pickUpDateTime = date('Y-m-d h:i:s', strtotime($_POST['pickUpDate'] . ' ' . $_POST['pickUpTime']));
            $proofOfPayment = $_FILES['proofOfPayment']['name'];
            $proofOfPaymentTmp = $_FILES['proofOfPayment']['tmp_name'];
            $referenceNum = $_POST['referenceNum'];
            $gcashNumber = $_POST['gcashNumber'];
            $orderDateTime = date('Y-m-d H:i:s');
            $orderTotal = $_POST['orderTotal'];

            $image_ext = explode('.', $proofOfPayment);
            $image_ext = strtolower(end($image_ext));

            $new_image_name = uniqid() . '.' . $image_ext;

            $insertOrder = mysqli_query($conn, "INSERT INTO tbl_order (userId, gcashNumber, deliveryMethod, paymentMethod, orderTotal, orderDateTime, orderStatus, paymentProof, referenceNum) VALUES ('$userId', '$gcashNumber', '$deliveryMethod', '$paymentMethod', '$orderTotal', '$orderDateTime', 'PENDING', '$new_image_name', '$referenceNum')");

            if ($insertOrder) {
                move_uploaded_file($proofOfPaymentTmp, '../admin/assets/images/gcashPaymentProof/' . $new_image_name);

                $orderId = mysqli_insert_id($conn);

                $insertOrderAddress = mysqli_query($conn, "INSERT INTO tbl_order_address (orderId, billingFullname, billingContactNum) VALUES ('$orderId', '$fullName', '$contactNumber')");

                if ($insertOrderAddress) {
                    $getCartItem = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE userId = $userId");

                    foreach ($getCartItem as $item) {
                        $cartId = $item['cartId'];
                        $categoryId = $item['categoryId'];
                        $productId = $item['productId'];
                        $productPrice = $item['productPrice'];
                        $productQty = $item['productQty'];
                        $productTotal = $item['productTotal'];

                        $insertOrderItems = mysqli_query($conn, "INSERT INTO tbl_order_items (orderId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$orderId', '$categoryId', '$productId', '$productPrice', '$productQty', '$productTotal')");

                        if ($insertOrderItems) {
                            $deleteCartItem = mysqli_query($conn, "DELETE FROM tbl_cart WHERE cartId = $cartId");
                        }
                    }

                    if ($deleteCartItem) {
                        echo 'success';
                    }
                }
            }
        }
        // FOR DELIVERY
    } else {
        // LALAMOVE COURIER
        if ($_POST['preferredCourier'] == 'LALAMOVE') {
            $deliveryMethod = $_POST['deliveryMethod'];
            $preferredCourier = $_POST['preferredCourier'];
            $userId = $_SESSION['margaux_user_id'];
            $fullName = $_POST['fullName'];
            $contactNumber = $_POST['contactNumber'];
            $provinceValue = $_POST['provinceValue'];
            $cityValue = $_POST['cityValue'];
            $barangayValue = $_POST['barangayValue'];
            $block = $_POST['block'];
            $paymentMethod = $_POST['paymentMethod'];
            $referenceNum = $_POST['referenceNum'];
            $gcashNumber = $_POST['gcashNumber'];
            $proofOfPayment = $_FILES['proofOfPayment']['name'];
            $proofOfPaymentTmp = $_FILES['proofOfPayment']['tmp_name'];
            $orderDateTime = date('Y-m-d H:i:s');
            $orderTotal = $_POST['orderTotal'];

            $image_ext = explode('.', $proofOfPayment);
            $image_ext = strtolower(end($image_ext));

            $new_image_name = uniqid() . '.' . $image_ext;

            $insertOrder = mysqli_query($conn, "INSERT INTO tbl_order (userId, gcashNumber, deliveryMethod, courier, paymentMethod, orderTotal, orderDateTime, orderStatus, paymentProof, referenceNum) VALUES ('$userId', '$gcashNumber', '$deliveryMethod', '$preferredCourier', '$paymentMethod', '$orderTotal', '$orderDateTime', 'PENDING', '$new_image_name', '$referenceNum')");

            if ($insertOrder) {
                move_uploaded_file($proofOfPaymentTmp, '../admin/assets/images/gcashPaymentProof/' . $new_image_name);

                $orderId = mysqli_insert_id($conn);

                $insertOrderAddress = mysqli_query($conn, "INSERT INTO tbl_order_address (orderId, billingFullname, billingContactNum, billingBlock, billingBarangay, billingCity, billingProvince) VALUES ('$orderId', '$fullName', '$contactNumber', '$block', '$barangayValue', '$cityValue', '$provinceValue')");

                if ($insertOrderAddress) {
                    $getCartItem = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE userId = $userId");

                    foreach ($getCartItem as $item) {
                        $cartId = $item['cartId'];
                        $categoryId = $item['categoryId'];
                        $productId = $item['productId'];
                        $productPrice = $item['productPrice'];
                        $productQty = $item['productQty'];
                        $productTotal = $item['productTotal'];

                        $insertOrderItems = mysqli_query($conn, "INSERT INTO tbl_order_items (orderId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$orderId', '$categoryId', '$productId', '$productPrice', '$productQty', '$productTotal')");

                        if ($insertOrderItems) {
                            $deleteCartItem = mysqli_query($conn, "DELETE FROM tbl_cart WHERE cartId = $cartId");
                        }
                    }

                    if ($deleteCartItem) {
                        echo 'success';
                    }
                }
            }
            // LBC EXPRESS COURIER
        } else {
            // LBC MODE PICKUP
            if ($_POST['lbcMode'] == 'PICK UP') {
                $deliveryMethod = $_POST['deliveryMethod'];
                $preferredCourier = $_POST['preferredCourier'];
                $lbcMode = $_POST['lbcMode'];
                $userId = $_SESSION['margaux_user_id'];
                $fullName = $_POST['fullName'];
                $contactNumber = $_POST['contactNumber'];
                $lbcBranch = $_POST['lbcBranch'];
                $provinceValue = $_POST['provinceValue'];
                $cityValue = $_POST['cityValue'];
                $barangayValue = $_POST['barangayValue'];
                $block = $_POST['block'];
                $paymentMethod = $_POST['paymentMethod'];
                $referenceNum = $_POST['referenceNum'];
                $gcashNumber = $_POST['gcashNumber'];
                $proofOfPayment = $_FILES['proofOfPayment']['name'];
                $proofOfPaymentTmp = $_FILES['proofOfPayment']['tmp_name'];
                $orderDateTime = date('Y-m-d H:i:s');
                $orderTotal = $_POST['orderTotal'];

                $image_ext = explode('.', $proofOfPayment);
                $image_ext = strtolower(end($image_ext));

                $new_image_name = uniqid() . '.' . $image_ext;

                $insertOrder = mysqli_query($conn, "INSERT INTO tbl_order (userId, gcashNumber, deliveryMethod, courier, lbcMode, paymentMethod, orderTotal, orderDateTime, orderStatus, paymentProof, referenceNum) VALUES ('$userId', '$gcashNumber', '$deliveryMethod', '$preferredCourier', '$lbcMode', '$paymentMethod', '$orderTotal', '$orderDateTime', 'PENDING', '$new_image_name', '$referenceNum')");

                if ($insertOrder) {
                    move_uploaded_file($proofOfPaymentTmp, '../admin/assets/images/gcashPaymentProof/' . $new_image_name);

                    $orderId = mysqli_insert_id($conn);

                    $insertOrderAddress = mysqli_query($conn, "INSERT INTO tbl_order_address (orderId, billingFullname, billingContactNum, billingBlock, billingBarangay, billingCity, billingProvince, nearestLBC) VALUES ('$orderId', '$fullName', '$contactNumber', '$block', '$barangayValue', '$cityValue', '$provinceValue', '$lbcBranch')");

                    if ($insertOrderAddress) {
                        $getCartItem = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE userId = $userId");

                        foreach ($getCartItem as $item) {
                            $cartId = $item['cartId'];
                            $categoryId = $item['categoryId'];
                            $productId = $item['productId'];
                            $productPrice = $item['productPrice'];
                            $productQty = $item['productQty'];
                            $productTotal = $item['productTotal'];

                            $insertOrderItems = mysqli_query($conn, "INSERT INTO tbl_order_items (orderId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$orderId', '$categoryId', '$productId', '$productPrice', '$productQty', '$productTotal')");

                            if ($insertOrderItems) {
                                $deleteCartItem = mysqli_query($conn, "DELETE FROM tbl_cart WHERE cartId = $cartId");
                            }
                        }

                        if ($deleteCartItem) {
                            echo 'success';
                        }
                    }
                }
                // LBC MODE DOOR-TO-DOOR
            } else {
                $deliveryMethod = $_POST['deliveryMethod'];
                $preferredCourier = $_POST['preferredCourier'];
                $lbcMode = $_POST['lbcMode'];
                $userId = $_SESSION['margaux_user_id'];
                $fullName = $_POST['fullName'];
                $contactNumber = $_POST['contactNumber'];
                $provinceValue = $_POST['provinceValue'];
                $cityValue = $_POST['cityValue'];
                $barangayValue = $_POST['barangayValue'];
                $block = $_POST['block'];
                $paymentMethod = $_POST['paymentMethod'];
                $referenceNum = $_POST['referenceNum'];
                $gcashNumber = $_POST['gcashNumber'];
                $proofOfPayment = $_FILES['proofOfPayment']['name'];
                $proofOfPaymentTmp = $_FILES['proofOfPayment']['tmp_name'];
                $orderDateTime = date('Y-m-d H:i:s');
                $orderTotal = $_POST['orderTotal'];

                $image_ext = explode('.', $proofOfPayment);
                $image_ext = strtolower(end($image_ext));

                $new_image_name = uniqid() . '.' . $image_ext;

                $insertOrder = mysqli_query($conn, "INSERT INTO tbl_order (userId, gcashNumber, deliveryMethod, courier, lbcMode, paymentMethod, orderTotal, orderDateTime, orderStatus, paymentProof, referenceNum) VALUES ('$userId', '$gcashNumber', '$deliveryMethod', '$preferredCourier', '$lbcMode', '$paymentMethod', '$orderTotal', '$orderDateTime', 'PENDING', '$new_image_name', '$referenceNum')");

                if ($insertOrder) {
                    move_uploaded_file($proofOfPaymentTmp, '../admin/assets/images/gcashPaymentProof/' . $new_image_name);

                    $orderId = mysqli_insert_id($conn);

                    $insertOrderAddress = mysqli_query($conn, "INSERT INTO tbl_order_address (orderId, billingFullname, billingContactNum, billingBlock, billingBarangay, billingCity, billingProvince) VALUES ('$orderId', '$fullName', '$contactNumber', '$block', '$barangayValue', '$cityValue', '$provinceValue')");

                    if ($insertOrderAddress) {
                        $getCartItem = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE userId = $userId");

                        foreach ($getCartItem as $item) {
                            $cartId = $item['cartId'];
                            $categoryId = $item['categoryId'];
                            $productId = $item['productId'];
                            $productPrice = $item['productPrice'];
                            $productQty = $item['productQty'];
                            $productTotal = $item['productTotal'];

                            $insertOrderItems = mysqli_query($conn, "INSERT INTO tbl_order_items (orderId, categoryId, productId, productPrice, productQty, productTotal) VALUES ('$orderId', '$categoryId', '$productId', '$productPrice', '$productQty', '$productTotal')");

                            if ($insertOrderItems) {
                                $deleteCartItem = mysqli_query($conn, "DELETE FROM tbl_cart WHERE cartId = $cartId");
                            }
                        }

                        if ($deleteCartItem) {
                            echo 'success';
                        }
                    }
                }
            }
        }
    }
}
