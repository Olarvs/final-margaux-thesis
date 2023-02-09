<?php
session_start();
require_once '../../database/config.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../../vendor/autoload.php';

$currentDateTime = date('Y-m-d H:i:s');

// GET STATUS
if(isset($_POST['get_status'])) {
    $orderId = $_POST['orderId'];

    $getOrder = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $result_array = array();

    foreach($getOrder as $row) {
        $result_array['orderId'] = $row['orderId'];
        $result_array['orderStatus'] = $row['orderStatus'];
    }

    echo json_encode($result_array);
}

// GET ADDRESS
if(isset($_POST['getAddress'])) {
    $orderId = $_POST['orderId'];

    $getAddress = mysqli_query($conn, "SELECT tbl_order_address.billingBlock, refbrgy.brgyDesc, refcitymun.citymunDesc, refprovince.provDesc
    FROM tbl_order_address
    LEFT JOIN refbrgy
    ON tbl_order_address.billingBarangay = refbrgy.brgyCode
    LEFT JOIN refcitymun
    ON tbl_order_address.billingCity = refcitymun.citymunCode
    LEFT JOIN refprovince
    ON tbl_order_address.billingProvince = refprovince.provCode
    WHERE orderId = $orderId");

    $result = array();

    foreach($getAddress as $address) {
        $result['block'] = $address['billingBlock'];
        $result['barangay'] = $address['brgyDesc'];
        $result['city'] = $address['citymunDesc'];
        $result['province'] = $address['provDesc'];
    }

    echo json_encode($result);
}

// PICKUP
if(isset($_POST['updateOrderPickUpCop'])) {
    $mail = new PHPMAILER(true);
    $orderId = $_POST['updateOrderId'];
    $orderStatus = $_POST['updateStatus'];
    $reason = mysqli_real_escape_string($conn, $_POST['reason']) ?? null;

    $getCurrentStatus = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $fetchCurrentStatus = mysqli_fetch_array($getCurrentStatus);

    $currentStatus = $fetchCurrentStatus['orderStatus'];

    $invoice = '<table style="border-collapse: collapse; width: 100%;"><thead style="border-bottom: 1px solid black !important;"><tr><th style="border-bottom: 1px solid; border-top: 1px solid; padding: 5px 15px; padding-left: 5px; text-transform: uppercase;"colspan="2">ORDER SUMMARY</th></tr><tr style="border-bottom: 1px solid black !important;"><th style="border-bottom: 1px solid; text-align: left; padding: 5px 15px; padding-left: 5px; text-transform: uppercase;">Items</th><th style="border-bottom: 1px solid; text-align: right; padding: 5px 15px; padding-right: 5px; text-transform: uppercase;">Total Price</th></tr></thead><tbody>
    ';

    $get_items = mysqli_query($conn, "SELECT tbl_product.productName, tbl_category.categoryName, tbl_order_items.productQty, tbl_order_items.productTotal
    FROM tbl_order_items
    LEFT JOIN tbl_product
    ON tbl_order_items.productId = tbl_product.productId
    LEFT JOIN tbl_category
    ON tbl_order_items.categoryId = tbl_category.categoryId WHERE tbl_order_items.orderId = $orderId");

    foreach($get_items as $row) {

    $invoice .= '<tr><td style="border-bottom: 1px solid; text-align: left; padding: 5px 15px; padding-left: 5px;">'. $row['productName'] .' <br>'.$row['categoryName'].' <br>x'.$row['productQty'].'</td><td style="border-bottom: 1px solid; text-align: right; padding: 5px 15px; padding-right: 5px;">P'.$row['productTotal'].'</td></tr>';

    }

    $getTotal = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $fetch = mysqli_fetch_array($getTotal);

    $invoice .= '<tr><td style="text-align: right;" colspan="2">TOTAL: <strong style="padding-left: 20px;">P'.$fetch['orderTotal'].'</strong></td></tr></tbody></table>';

    $getNameEmail = mysqli_query($conn, "SELECT tbl_user.email, tbl_order_address.billingFullName
    FROM tbl_order
    LEFT JOIN tbl_user
    ON tbl_order.userId = tbl_user.user_id
    LEFT JOIN tbl_order_address
    ON tbl_order.orderId = tbl_order_address.orderId WHERE tbl_order.orderId = $orderId");

    $fetch = mysqli_fetch_array($getNameEmail);

    $name = $fetch['billingFullName'];
    $email = $fetch['email'];

    if($orderStatus == 'CONFIRMED') {
        $getItems = mysqli_query($conn, "SELECT * FROM tbl_order_items WHERE orderId = $orderId");

        foreach($getItems as $items) {
            $productId = $items['productId'];
            $productQty = $items['productQty'];

            $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

            foreach($getProduct as $product) {
                $productId = $product['productId'];
                if($product['productStock'] < $productQty) {
                    echo 'out of stock';
                    $updateProduct = false;
                    break;
                } else {
                    $updateProductStock = ((int)$product['productStock']) - ((int)$productQty);

                    $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$updateProductStock' WHERE productId = $productId");
                }
            }
        }

        if($updateProduct == true) {
            $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

            if($updateOrder) {
                try {
                    //Enable verbose debug output
                    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
    
                    //Send using SMTP
                    $mail->isSMTP();
    
                    //Set the SMTP server to send through
                    $mail->Host = 'smtp.gmail.com';
    
                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;
    
                    //SMTP username
                    $mail->Username = 'margauxcscorner@gmail.com';
    
                    //SMTP password
                    $mail->Password = 'uqapxrlzstgpgjkq';
                     //old djfkzhifoquvycgz
                     //new uqapxrlzstgpgjkq
    
                    //Enable TLS encryption;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->Port = 587;
    
                    //Recipients
                    $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');
    
                    //Add a recipient
                    $mail->addAddress($email, $name);
    
                    //Set email format to HTML
                    $mail->isHTML(true);
    
                    $mail->Subject = 'Order Confirmation';
                    $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                    <p>We\'re happy to let you know that your order has been confirmed!</p>
                    <p>Just wait for our next update about you order.</p>';
                    $mail->Body .= $invoice;
                    $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';
    
                    $mail->send();
    
                    echo 'success';
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } else if($orderStatus == 'READY TO PICK UP') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                <p>Your order is already packed and ready for pick up.</p>';
                $mail->Body .= $invoice;
                $mail->Body .= '<p><strong>Address: </strong>Brgy Sto Nino Purok 1 Cabanatuan City Near Purok 1 Sto Nino Basketball Court, Cabanatuan City, Philippines</p>
                <p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else if($orderStatus == 'COMPLETED') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Thank you, '.$name.'!</strong></p>
                <p>Hi there. Your recent order on Margaux Corner has been completed.</p>';

                $mail->Body .= $invoice;
                
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        if($currentStatus == 'PENDING') {
            $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', reason = '$reason' WHERE orderId = $orderId");

            if($updateOrder) {
                echo 'success';
            }
        } else {
            $getItems = mysqli_query($conn, "SELECT * FROM tbl_order_items WHERE orderId = $orderId");

            foreach($getItems as $items) {
                $productId = $items['productId'];
                $productQty = $items['productQty'];

                $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

                foreach($getProduct as $product) {
                    $productStock = $product['productStock'];

                    $updateProductStock = ((int)$productQty) + ((int)$productStock);

                    $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$updateProductStock' WHERE productId = $productId");
                }
            }

            if($updateProduct == true) {
                $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime', reason = '$reason' WHERE orderId = $orderId");

                if($updateOrder) {
                    try {
                        //Enable verbose debug output
                        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
        
                        //Send using SMTP
                        $mail->isSMTP();
        
                        //Set the SMTP server to send through
                        $mail->Host = 'smtp.gmail.com';
        
                        //Enable SMTP authentication
                        $mail->SMTPAuth = true;
        
                        //SMTP username
                        $mail->Username = 'margauxcscorner@gmail.com';
        
                        //SMTP password
                        $mail->Password = 'uqapxrlzstgpgjkq';
                         //old djfkzhifoquvycgz
                        //new uqapxrlzstgpgjkq
        
                        //Enable TLS encryption;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
                        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->Port = 587;
        
                        //Recipients
                        $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');
        
                        //Add a recipient
                        $mail->addAddress($email, $name);
        
                        //Set email format to HTML
                        $mail->isHTML(true);
        
                        $mail->Subject = 'Order Status';
                        $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                        <p>We\'re sorry but your order has been cancelled:</p>
                        <p><strong>Reason:</strong> '.$reason.'</p>
                        <p><strong>- Margaux Cacti & Succulents Corner</strong></p>';
        
                        $mail->send();
        
                        echo 'success';
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            }
        }
    }
}

// DELIVERY - LALAMOVE
if(isset($_POST['updateOrderDelivery'])) {
    $mail = new PHPMAILER(true);
    $orderId = $_POST['updateOrderIdDelivery'];
    $orderStatus = $_POST['updateStatusDelivery'];
    $shippingFee = number_format((float)$_POST['feeDelivery'], 2, '.', '') ?? null;
    $reason = mysqli_real_escape_string($conn, $_POST['reasonDelivery']) ?? null;

    $getCurrentStatus = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $fetchCurrentStatus = mysqli_fetch_array($getCurrentStatus);

    $currentStatus = $fetchCurrentStatus['orderStatus'];

    $invoice = '<table style="border-collapse: collapse; width: 100%;"><thead style="border-bottom: 1px solid black !important;"><tr><th style="border-bottom: 1px solid; border-top: 1px solid; padding: 5px 15px; padding-left: 5px; text-transform: uppercase;"colspan="2">ORDER SUMMARY</th></tr><tr style="border-bottom: 1px solid black !important;"><th style="border-bottom: 1px solid; text-align: left; padding: 5px 15px; padding-left: 5px; text-transform: uppercase;">Items</th><th style="border-bottom: 1px solid; text-align: right; padding: 5px 15px; padding-right: 5px; text-transform: uppercase;">Total Price</th></tr></thead><tbody>
    ';

    $get_items = mysqli_query($conn, "SELECT tbl_product.productName, tbl_category.categoryName, tbl_order_items.productQty, tbl_order_items.productTotal
    FROM tbl_order_items
    LEFT JOIN tbl_product
    ON tbl_order_items.productId = tbl_product.productId
    LEFT JOIN tbl_category
    ON tbl_order_items.categoryId = tbl_category.categoryId WHERE tbl_order_items.orderId = $orderId");

    foreach($get_items as $row) {

    $invoice .= '<tr><td style="border-bottom: 1px solid; text-align: left; padding: 5px 15px; padding-left: 5px;">'. $row['productName'] .' <br>'.$row['categoryName'].' <br>x'.$row['productQty'].'</td><td style="border-bottom: 1px solid; text-align: right; padding: 5px 15px; padding-right: 5px;">P'.$row['productTotal'].'</td></tr>';

    }

    $getTotal = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $fetch = mysqli_fetch_array($getTotal);

    $invoice .= '<tr><td style="text-align: right;" colspan="2">TOTAL: <strong style="padding-left: 20px;">P'.$fetch['orderTotal'].'</strong></td></tr></tbody></table>';

    $getNameEmail = mysqli_query($conn, "SELECT tbl_user.email, tbl_order_address.billingFullName
    FROM tbl_order
    LEFT JOIN tbl_user
    ON tbl_order.userId = tbl_user.user_id
    LEFT JOIN tbl_order_address
    ON tbl_order.orderId = tbl_order_address.orderId WHERE tbl_order.orderId = $orderId");

    $fetch = mysqli_fetch_array($getNameEmail);

    $name = $fetch['billingFullName'];
    $email = $fetch['email'];

    if($orderStatus == 'CONFIRMED') {
        $getItems = mysqli_query($conn, "SELECT * FROM tbl_order_items WHERE orderId = $orderId");

        foreach($getItems as $items) {
            $productId = $items['productId'];
            $productQty = $items['productQty'];

            $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

            foreach($getProduct as $product) {
                $productId = $product['productId'];
                if($product['productStock'] < $productQty) {
                    echo 'out of stock';
                    $updateProduct = false;
                    break;
                } else {
                    $updateProductStock = ((int)$product['productStock']) - ((int)$productQty);

                    $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$updateProductStock' WHERE productId = $productId");
                }
            }
        }

        if($updateProduct == true) {
            $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

            if($updateOrder) {
                try {
                    //Enable verbose debug output
                    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
    
                    //Send using SMTP
                    $mail->isSMTP();
    
                    //Set the SMTP server to send through
                    $mail->Host = 'smtp.gmail.com';
    
                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;
    
                    //SMTP username
                    $mail->Username = 'margauxcscorner@gmail.com';
    
                    //SMTP password
                    $mail->Password = 'uqapxrlzstgpgjkq';
                     //old djfkzhifoquvycgz
                    //new uqapxrlzstgpgjkq
    
                    //Enable TLS encryption;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->Port = 587;
    
                    //Recipients
                    $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');
    
                    //Add a recipient
                    $mail->addAddress($email, $name);
    
                    //Set email format to HTML
                    $mail->isHTML(true);
    
                    $mail->Subject = 'Order Confirmation';
                    $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                    <p>We\'re happy to let you know that your order has been confirmed!</p>
                    <p>Just wait for our next update about you order.</p>';
                    $mail->Body .= $invoice;
                    $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';
    
                    $mail->send();
    
                    echo 'success';
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } else if($orderStatus == 'PACKED (READY TO SHIP)') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                <p>Your order is already packed and ready to ship via lalamove courier.</p>';
                $mail->Body .= $invoice;
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else if($orderStatus == 'OUT FOR DELIVERY') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                <p>Your order has been sent to courier.</p>
                <p>Please prepare exact amount of P'.$shippingFee.' for shipping fee.</p>';
                $mail->Body .= $invoice;
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else if($orderStatus == 'COMPLETED') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Thank you, '.$name.'!</strong></p>
                <p>Hi there. Your recent order on Margaux Corner has been completed.</p>';

                $mail->Body .= $invoice;
                
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        if($currentStatus == 'PENDING') {
            $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime', reason = '$reason' WHERE orderId = $orderId");

            if($updateOrder) {
                echo 'success';
            }
        } else {
            $getItems = mysqli_query($conn, "SELECT * FROM tbl_order_items WHERE orderId = $orderId");

            foreach($getItems as $items) {
                $productId = $items['productId'];
                $productQty = $items['productQty'];

                $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

                foreach($getProduct as $product) {
                    $productStock = $product['productStock'];

                    $updateProductStock = ((int)$productQty) + ((int)$productStock);

                    $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$updateProductStock' WHERE productId = $productId");
                }
            }

            if($updateProduct == true) {
                $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime', reason = '$reason' WHERE orderId = $orderId");

                if($updateOrder) {
                    try {
                        //Enable verbose debug output
                        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
        
                        //Send using SMTP
                        $mail->isSMTP();
        
                        //Set the SMTP server to send through
                        $mail->Host = 'smtp.gmail.com';
        
                        //Enable SMTP authentication
                        $mail->SMTPAuth = true;
        
                        //SMTP username
                        $mail->Username = 'margauxcscorner@gmail.com';
        
                        //SMTP password
                        $mail->Password = 'uqapxrlzstgpgjkq';
                         //old djfkzhifoquvycgz
                        //new uqapxrlzstgpgjkq
        
                        //Enable TLS encryption;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
                        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->Port = 587;
        
                        //Recipients
                        $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');
        
                        //Add a recipient
                        $mail->addAddress($email, $name);
        
                        //Set email format to HTML
                        $mail->isHTML(true);
        
                        $mail->Subject = 'Order Status';
                        $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                        <p>We\'re sorry but your order has been cancelled:</p>
                        <p><strong>Reason:</strong> '.$reason.'</p>
                        <p><strong>- Margaux Cacti & Succulents Corner</strong></p>';
        
                        $mail->send();
        
                        echo 'success';
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            }
        }
    }
}

// DELIVERY - LBC
if(isset($_POST['updateOrderDeliveryLBC'])) {
    $mail = new PHPMAILER(true);
    $orderId = $_POST['updateOrderIdDeliveryLBC'];
    $orderStatus = $_POST['updateStatusDeliveryLBC'];
    $shippingFee = number_format((float)$_POST['feeDeliveryLBC'], 2, '.', '') ?? null;
    $reason = mysqli_real_escape_string($conn, $_POST['reasonDeliveryLBC']) ?? null;
    $tracking = $_POST['trackingDeliveryLBC'] ?? null;

    $getCurrentStatus = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $fetchCurrentStatus = mysqli_fetch_array($getCurrentStatus);

    $currentStatus = $fetchCurrentStatus['orderStatus'];

    $invoice = '<table style="border-collapse: collapse; width: 100%;"><thead style="border-bottom: 1px solid black !important;"><tr><th style="border-bottom: 1px solid; border-top: 1px solid; padding: 5px 15px; padding-left: 5px; text-transform: uppercase;"colspan="2">ORDER SUMMARY</th></tr><tr style="border-bottom: 1px solid black !important;"><th style="border-bottom: 1px solid; text-align: left; padding: 5px 15px; padding-left: 5px; text-transform: uppercase;">Items</th><th style="border-bottom: 1px solid; text-align: right; padding: 5px 15px; padding-right: 5px; text-transform: uppercase;">Total Price</th></tr></thead><tbody>
    ';

    $get_items = mysqli_query($conn, "SELECT tbl_product.productName, tbl_category.categoryName, tbl_order_items.productQty, tbl_order_items.productTotal
    FROM tbl_order_items
    LEFT JOIN tbl_product
    ON tbl_order_items.productId = tbl_product.productId
    LEFT JOIN tbl_category
    ON tbl_order_items.categoryId = tbl_category.categoryId WHERE tbl_order_items.orderId = $orderId");

    foreach($get_items as $row) {

    $invoice .= '<tr><td style="border-bottom: 1px solid; text-align: left; padding: 5px 15px; padding-left: 5px;">'. $row['productName'] .' <br>'.$row['categoryName'].' <br>x'.$row['productQty'].'</td><td style="border-bottom: 1px solid; text-align: right; padding: 5px 15px; padding-right: 5px;">P'.$row['productTotal'].'</td></tr>';

    }

    $getTotal = mysqli_query($conn, "SELECT * FROM tbl_order WHERE orderId = $orderId");

    $fetch = mysqli_fetch_array($getTotal);

    $invoice .= '<tr><td style="text-align: right;" colspan="2">TOTAL: <strong style="padding-left: 20px;">P'.$fetch['orderTotal'].'</strong></td></tr></tbody></table>';

    $getNameEmail = mysqli_query($conn, "SELECT tbl_user.email, tbl_order_address.billingFullName
    FROM tbl_order
    LEFT JOIN tbl_user
    ON tbl_order.userId = tbl_user.user_id
    LEFT JOIN tbl_order_address
    ON tbl_order.orderId = tbl_order_address.orderId WHERE tbl_order.orderId = $orderId");

    $fetch = mysqli_fetch_array($getNameEmail);

    $name = $fetch['billingFullName'];
    $email = $fetch['email'];

    if($orderStatus == 'CONFIRMED') {
        $getItems = mysqli_query($conn, "SELECT * FROM tbl_order_items WHERE orderId = $orderId");

        foreach($getItems as $items) {
            $productId = $items['productId'];
            $productQty = $items['productQty'];

            $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

            foreach($getProduct as $product) {
                $productId = $product['productId'];
                if($product['productStock'] < $productQty) {
                    echo 'out of stock';
                    $updateProduct = false;
                    break;
                } else {
                    $updateProductStock = ((int)$product['productStock']) - ((int)$productQty);

                    $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$updateProductStock' WHERE productId = $productId");
                }
            }
        }

        if($updateProduct == true) {
            $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

            if($updateOrder) {
                try {
                    //Enable verbose debug output
                    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
    
                    //Send using SMTP
                    $mail->isSMTP();
    
                    //Set the SMTP server to send through
                    $mail->Host = 'smtp.gmail.com';
    
                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;
    
                    //SMTP username
                    $mail->Username = 'margauxcscorner@gmail.com';
    
                    //SMTP password
                    $mail->Password = 'uqapxrlzstgpgjkq';
                     //old djfkzhifoquvycgz
                    //new uqapxrlzstgpgjkq
    
                    //Enable TLS encryption;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->Port = 587;
    
                    //Recipients
                    $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');
    
                    //Add a recipient
                    $mail->addAddress($email, $name);
    
                    //Set email format to HTML
                    $mail->isHTML(true);
    
                    $mail->Subject = 'Order Confirmation';
                    $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                    <p>We\'re happy to let you know that your order has been confirmed!</p>
                    <p>Just wait for our next update about you order.</p>';
                    $mail->Body .= $invoice;
                    $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';
    
                    $mail->send();
    
                    echo 'success';
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } else if($orderStatus == 'PACKED (READY TO SHIP)') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                <p>Your order is already packed and ready to ship via lbc express courier.</p>';
                $mail->Body .= $invoice;
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else if($orderStatus == 'OUT FOR DELIVERY') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq

                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                <p>Your order has been sent to courier.</p>
                <p>Please prepare exact amount of P'.$shippingFee.' for shipping fee.</p>
                <p>To track your order type this tracking number <strong>'.$tracking.'</strong> in https://www.lbcexpress.com/track/.</p>';
                $mail->Body .= $invoice;
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else if($orderStatus == 'COMPLETED') {
        $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime' WHERE orderId = $orderId");

        if($updateOrder) {
            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server to send through
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'margauxcscorner@gmail.com';

                //SMTP password
                $mail->Password = 'uqapxrlzstgpgjkq';
                 //old djfkzhifoquvycgz
                //new uqapxrlzstgpgjkq
                
                //Enable TLS encryption;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');

                //Add a recipient
                $mail->addAddress($email, $name);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Order Status';
                $mail->Body = '<p><strong>Thank you, '.$name.'!</strong></p>
                <p>Hi there. Your recent order on Margaux Corner has been completed.</p>';

                $mail->Body .= $invoice;
                
                $mail->Body .= '<p><strong>- Margaux Cacti & Succulents Corner</strong></p>';

                $mail->send();

                echo 'success';
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        if($currentStatus == 'PENDING') {
            $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime', reason = '$reason' WHERE orderId = $orderId");

            if($updateOrder) {
                echo 'success';
            }
        } else {
            $getItems = mysqli_query($conn, "SELECT * FROM tbl_order_items WHERE orderId = $orderId");

            foreach($getItems as $items) {
                $productId = $items['productId'];
                $productQty = $items['productQty'];

                $getProduct = mysqli_query($conn, "SELECT * FROM tbl_product WHERE productId = $productId");

                foreach($getProduct as $product) {
                    $productStock = $product['productStock'];

                    $updateProductStock = ((int)$productQty) + ((int)$productStock);

                    $updateProduct = mysqli_query($conn, "UPDATE tbl_product SET productStock = '$updateProductStock' WHERE productId = $productId");
                }
            }

            if($updateProduct == true) {
                $updateOrder = mysqli_query($conn, "UPDATE tbl_order SET orderStatus = '$orderStatus', orderDateTimeCompleted = '$currentDateTime', reason = '$reason' WHERE orderId = $orderId");

                if($updateOrder) {
                    try {
                        //Enable verbose debug output
                        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
        
                        //Send using SMTP
                        $mail->isSMTP();
        
                        //Set the SMTP server to send through
                        $mail->Host = 'smtp.gmail.com';
        
                        //Enable SMTP authentication
                        $mail->SMTPAuth = true;
        
                        //SMTP username
                        $mail->Username = 'margauxcscorner@gmail.com';
        
                        //SMTP password
                         $mail->Password = 'uqapxrlzstgpgjkq';
                          //old djfkzhifoquvycgz
                          //new uqapxrlzstgpgjkq
        
                        //Enable TLS encryption;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
                        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->Port = 587;
        
                        //Recipients
                        $mail->setFrom('margauxcscorner@gmail.com', 'Margaux Cacti & Succulents Corner');
        
                        //Add a recipient
                        $mail->addAddress($email, $name);
        
                        //Set email format to HTML
                        $mail->isHTML(true);
        
                        $mail->Subject = 'Order Status';
                        $mail->Body = '<p><strong>Hi, '.$name.'!</strong></p>
                        <p>We\'re sorry but your order has been cancelled:</p>
                        <p><strong>Reason:</strong> '.$reason.'</p>
                        <p><strong>- Margaux Cacti & Succulents Corner</strong></p>';
        
                        $mail->send();
        
                        echo 'success';
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            }
        }
    }
}