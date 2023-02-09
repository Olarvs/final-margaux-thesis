<?php
session_start();
require_once '../database/config.php';

            // form.append('categoryId', $('#categoryId').text());
            // form.append('productPrice', $('#productPrice').text());
            // form.append('productTotal', $('#productTotal').text());
            // form.append('updateToCart', true);
$userId = $_SESSION['margaux_user_id'];
$updateAction  = $_POST['UpdateAction'];
$productId = $_POST['productId'];
$categoryId = $_POST['productPrice'];
$productTotal = $_POST['productTotal'];
$updateToCart = $_POST['updateToCart'];

try{
    
    $checkIfExist = mysqli_query($conn, "SELECT * FROM `tbl_cart` WHERE `userId` = $userId AND `productId` = $productId");
   
    
   if (mysqli_num_rows($checkIfExist) > 0) {
    $fetch = mysqli_fetch_array($checkIfExist);
    $productPriceDB = $fetch['productPrice'];
    $productQtyDB = $fetch['productQty'];
    $productTotalDB = $fetch['productTotal'];
    $cartId = $fetch['cartId'];
       
       
        if($updateToCart == 'Increment'){
        //Current data when incremented the quantity
    $currentQuantity = floatval($productQtyDB) + 1;
    $currentProductTotal = floatval($productTotalDB) + floatval($productPriceDB); 
    
    try{
             $updateCart = mysqli_query($conn, "UPDATE tbl_cart SET productQty = '$currentQuantity', productTotal = '$currentProductTotal' WHERE cartId = $cartId");
             
    
       exit(json_encode(array("statusCode"=>'success', "action"=>'Increment')));
    }catch(Exception $e){
            exit(json_encode(array("statusCode"=>$e->getMessage(),"errorPosition" => "updateCartIncrement")));
    }
       
        // exit(json_encode(array("statusCode"=>'success', "action"=>'Increment',"row" =>$fetchResponse)));
    }
    
    if($updateToCart == 'Decrement'){
        //Current data when incremented the quantity
    $currentQuantity = floatval($productQtyDB) - 1;
    $currentProductTotal = floatval($productTotalDB) - floatval($productPriceDB); 
    
    try{
             $updateCart = mysqli_query($conn, "UPDATE tbl_cart SET productQty = '$currentQuantity', productTotal = '$currentProductTotal' WHERE cartId = $cartId");
             
       exit(json_encode(array("statusCode"=>'success', "action"=>'Decrement')));
    }catch(Exception $e){
            exit(json_encode(array("statusCode"=>$e->getMessage(),"errorPosition" => "updateCartDecrement")));
    }
       
        // exit(json_encode(array("statusCode"=>'success', "action"=>'Increment',"row" =>$fetchResponse)));
    }
    
   }
   

}catch(Exception $e){
    exit(json_encode(array("statusCode"=>$e->getMessage(),"errorPosition" => "checkIfExist", "UserID" => $userId, "ProductId" => $productId)));
}


?>