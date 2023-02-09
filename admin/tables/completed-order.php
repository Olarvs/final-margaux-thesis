<?php
session_start();
require_once '../../database/config-pdo.php';
require_once '../../database/config.php';

$adminId = $_SESSION['margaux_admin_id'];

$column = array('orderId', 'billingFullName', 'email', 'deliveryMethod', 'paymentMethod', 'orderDateTimeCompleted', 'orderTotal');

$query = "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_user.email, tbl_order.deliveryMethod, tbl_order.paymentMethod, tbl_order.orderDateTimeCompleted, tbl_order.orderTotal
FROM tbl_order
LEFT JOIN tbl_user
ON tbl_order.userId = tbl_user.user_id
LEFT JOIN tbl_order_address
ON tbl_order.orderId = tbl_order_address.orderId
WHERE tbl_order.orderStatus = 'COMPLETED'";

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
    $query .= 'ORDER BY tbl_order.orderId DESC ';
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
    $sub_array[] = $row['deliveryMethod'];
    $sub_array[] = $row['paymentMethod'];
    $sub_array[] = date('F d, Y h:i A', strtotime($row['orderDateTimeCompleted']));
    $sub_array[] = $row['orderTotal'];
    $sub_array[] = '<div class="d-flex flex-row align-items-center gap-2"> <a href="view-order.php?id='.$row['orderId'].'" class="btn btn-primary" id="get_view" data-id="'.$row['orderId'].'">VIEW ORDER</a></div>';
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT tbl_order.orderId, tbl_order_address.billingFullName, tbl_user.email, tbl_order.deliveryMethod, tbl_order.paymentMethod, tbl_order.orderDateTimeCompleted, tbl_order.orderTotal
    FROM tbl_order
    LEFT JOIN tbl_user
    ON tbl_order.userId = tbl_user.user_id
    LEFT JOIN tbl_order_address
    ON tbl_order.orderId = tbl_order_address.orderId
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
);

echo json_encode($output);