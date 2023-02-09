<?php
session_start();
require_once '../../database/config-pdo.php';

$adminId = $_SESSION['margaux_admin_id'];

$column = array('orderId', 'billingFullName', 'billingContactNum', 'referenceNum', 'email', 'orderId', 'orderDateTime', 'orderTotal', 'orderStatus');

$query = "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_order_address.billingContactNum, tbl_order.paymentProof, tbl_order.referenceNum, tbl_user.email,tbl_order.pickupDateTime, tbl_order.orderDateTime, tbl_order.orderTotal, tbl_order.orderStatus, tbl_order.gcashNumber
FROM tbl_order
LEFT JOIN tbl_order_address
ON tbl_order.orderId = tbl_order_address.orderId
LEFT JOIN tbl_user
ON tbl_order.userId = tbl_user.user_id
WHERE tbl_order.deliveryMethod = 'DELIVERY' AND tbl_order.courier = 'LALAMOVE' AND tbl_order.paymentMethod = 'GCASH' AND (tbl_order.orderStatus != 'COMPLETED' AND tbl_order.orderStatus != 'CANCELLED')";

$searchByStatus = $_POST['searchByStatus'];

if($searchByStatus != '') {
    $query .= 'AND tbl_order.orderStatus LIKE "%' . $searchByStatus . '%"';
}

if (isset($_POST['search']['value'])) {
    $query .= '
 AND (tbl_order_address.billingFullName LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_order_address.billingContactNum LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_user.email LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_order.referenceNum LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_order.pickupDateTime LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_order.orderDateTime LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_order.orderTotal LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_order.orderStatus LIKE "%' . $_POST['search']['value'] . '%" )
 ';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY orderDateTime DESC ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = '#'.$row['orderId'];
    $sub_array[] = $row['billingFullName'];
    $sub_array[] = $row['email'];
    $sub_array[] = '+63'.$row['billingContactNum'];
    $sub_array[] = '<div class="d-flex flex-column gap-2 justify-content-center text-center"><a href="javascript:void(0)" id="viewProofOfPayment" data-id="./assets/images/gcashPaymentProof/'.$row['paymentProof'].'">VIEW IMAGE</a><p>Ref Num: '.$row['referenceNum'].'</p><p>Gcash Num: +63'.$row['gcashNumber'].'</p></div>';
    $sub_array[] = '<div class="d-flex flex-column gap-2 justify-content-center text-center"><a href="javascript:void(0)" id="viewAddress" data-id="'.$row['orderId'].'">VIEW ADDRESS</a></div>';
    $sub_array[] = date('M d, Y h:i A', strtotime($row['orderDateTime']));
    $sub_array[] = $row['orderTotal'];
    $sub_array[] = $row['orderStatus'];
    $sub_array[] = '<div class="d-flex flex-row align-items-center gap-2"> <button type="button" class="btn btn-primary" id="get_view" data-id="'.$row['orderId'].'">VIEW ORDER</button> <button type="button" class="btn btn-success" id="get_update" data-id="'.$row['orderId'].'">UPDATE</button> </div>';
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_order_address.billingContactNum, tbl_order.paymentProof, tbl_order.referenceNum, tbl_user.email,tbl_order.pickupDateTime, tbl_order.orderDateTime, tbl_order.orderTotal, tbl_order.orderStatus, tbl_order.gcashNumber
    FROM tbl_order
    LEFT JOIN tbl_order_address
    ON tbl_order.orderId = tbl_order_address.orderId
    LEFT JOIN tbl_user
    ON tbl_order.userId = tbl_user.user_id
    WHERE tbl_order.deliveryMethod = 'DELIVERY' AND tbl_order.courier = 'LALAMOVE' AND tbl_order.paymentMethod = 'GCASH' AND (tbl_order.orderStatus != 'COMPLETED' AND tbl_order.orderStatus != 'CANCELLED')";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data,
);

echo json_encode($output);