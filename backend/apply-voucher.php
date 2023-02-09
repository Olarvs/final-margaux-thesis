<?php
session_start();
require_once '../database/config.php';

try{
    $voucherCode = $_POST['voucherCode'];


try{
    
    $checkIfExist = mysqli_query($conn, "SELECT * FROM `tbl_voucher` WHERE status = 'active' AND voucher_code = '$voucherCode'");
    
    
   if (mysqli_num_rows($checkIfExist) > 0 ) {
    $fetch = mysqli_fetch_array($checkIfExist);
    $voucherId = $fetch['id'];
    $description = $fetch['description'];
    $minimum_value = $fetch['minimum_value'];
    $discount = $fetch['discount'];
    $status = $fetch['status'];
    $date_added = $fetch['added_at'];
    
    //convert to two decimal places
    $discount = round(floatval($discount),2);
    
    //make it unavaiable once it was use
    // $updateVoucherStatus = mysqli_query($conn, "UPDATE tbl_voucher SET status = 'inactive' WHERE id = $voucherId");
     
     exit(json_encode(array("statusCode" => 'success', "isExist" => true, "description" => $description, "minimum_value" => $minimum_value, "discount" => $discount, "status" => $status, "date_added" => $date_added)));
   }else{
      exit(json_encode(array("statusCode" => 'success', "isExist" => false)));
   }
   

}catch(Exception $e){
    exit(json_encode(array("statusCode"=>$e->getMessage(),"errorPosition" => "checkIfExist")));
}

}catch(Exception $e){
    exit(json_encode(array("statusCode"=>$e->getMessage(),"errorPosition" => "receivingPostRequest")));
}
?>