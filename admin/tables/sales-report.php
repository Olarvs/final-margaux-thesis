<?php
session_start();
require_once '../../database/config-pdo.php';

$adminId = $_SESSION['margaux_admin_id'];

$column = array('orderId', 'billingFullName', 'email', 'deliveryMethod', 'paymentMethod', 'orderTotal', 'orderDateTimeCompleted');

$query = "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_user.email, tbl_order.deliveryMethod, tbl_order.paymentMethod, tbl_order.orderDateTimeCompleted, tbl_order.orderTotal
FROM tbl_order
LEFT JOIN tbl_order_address
ON tbl_order.orderId = tbl_order_address.orderId
LEFT JOIN tbl_user
ON tbl_order.userId = tbl_user.user_id
WHERE tbl_order.orderStatus = 'COMPLETED'";

if($_POST["isDateSearch"] == "yes")
{
 $query .= 'AND date(tbl_order.orderDateTimeCompleted) BETWEEN "'.$_POST["startDate"].'" AND "'.$_POST["endDate"].'" ';
}

if (isset($_POST['search']['value'])) {
    $query .= '
 AND (tbl_order.orderId LIKE "%' . $_POST['search']['value'] . '%" 
 OR tbl_order_address.billingFullName LIKE "%' . $_POST['search']['value'] . '%" 
 OR tbl_user.email LIKE "%' . $_POST['search']['value'] . '%" 
 OR tbl_order.deliveryMethod LIKE "%' . $_POST['search']['value'] . '%" 
 OR tbl_order.paymentMethod LIKE "%' . $_POST['search']['value'] . '%" 
 OR tbl_order.orderDateTimeCompleted LIKE "%' . $_POST['search']['value'] . '%" 
 OR tbl_order.orderTotal LIKE "%' . $_POST['search']['value'] . '%" )
 ';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY orderDateTimeCompleted DESC ';
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

$orderTotals = 0;

foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = '#'.$row['orderId'];
    $sub_array[] = $row['billingFullName'];
    $sub_array[] = $row['email'];
    $sub_array[] = $row['deliveryMethod'];
    $sub_array[] = $row['paymentMethod'];
    $sub_array[] = date('M d, Y h:i A', strtotime($row['orderDateTimeCompleted']));
    $sub_array[] = '&#8369; '.$row['orderTotal'];
    $orderTotals = $orderTotals + floatval($row['orderTotal']);
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_user.email, tbl_order.deliveryMethod, tbl_order.paymentMethod, tbl_order.orderDateTimeCompleted, tbl_order.orderTotal
    FROM tbl_order
    LEFT JOIN tbl_order_address
    ON tbl_order.orderId = tbl_order_address.orderId
    LEFT JOIN tbl_user
    ON tbl_order.userId = tbl_user.user_id
    WHERE tbl_order.orderStatus = 'COMPLETED'";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data,
    'total' => '&#8369; '.number_format($orderTotals, 2)
);

echo json_encode($output);
