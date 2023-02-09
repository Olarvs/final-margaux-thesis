<?php
session_start();
require_once '../database/config.php';

if(isset($_POST['get_shipping_fee'])) {
$province_id = $_POST['province_id'];
    
    $get_shipping_fee = mysqli_query($conn, "SELECT * FROM shipping WHERE provCode = $province_id");
    
    if (mysqli_num_rows($get_shipping_fee) != 0) {
        foreach($get_shipping_fee as $shipping) {
        echo  number_format(floatval($shipping['shippingFee']), 2, '.', '');
        }
        
    }
    
}


?>