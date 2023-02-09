<?php
session_start();
require_once '../database/config-pdo.php';

$userId = $_SESSION['margaux_user_id'];

$column = array('orderId', 'deliveryMethod', 'paymentMethod', 'orderDateTime', 'orderDateTimeCompleted', 'orderStatus', 'orderTotal');

$query = "SELECT * FROM tbl_order WHERE userId = $userId AND (orderStatus = 'COMPLETED' OR orderStatus = 'CANCELLED')";

if (isset($_POST['search']['value'])) {
    $query .= '
 AND (orderId LIKE "%' . $_POST['search']['value'] . '%"
 OR deliveryMethod LIKE "%' . $_POST['search']['value'] . '%"
 OR paymentMethod LIKE "%' . $_POST['search']['value'] . '%"
 OR orderDateTime LIKE "%' . $_POST['search']['value'] . '%"
 OR orderTotal LIKE "%' . $_POST['search']['value'] . '%"
 OR orderDateTimeCompleted LIKE "%' . $_POST['search']['value'] . '%" )
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
    $cancelBtn = '';

    if($row['paymentMethod'] != 'GCASH' && $row['orderStatus'] == 'PENDING') {
        $cancelBtn = '<button type="button" class="btn btn-danger" id="getCancel" data-id="'.$row['orderId'].'">CANCEL</button>';
    }

    $feedbackBtn = '';

    if($row['feedback'] == 0) {
        if($row['orderStatus'] == 'COMPLETED') {
            $feedbackBtn = '<button type="button" class="btn btn-success" id="getRate" data-id="'.$row['orderId'].'">GIVE FEEDBACK</button>';
        }
    }

    $sub_array = array();
    $sub_array[] = '#'.$row['orderId'];
    $sub_array[] = $row['deliveryMethod'];
    $sub_array[] = $row['paymentMethod'];
    $sub_array[] = date('M d, Y h:i A', strtotime($row['orderDateTime']));
    $sub_array[] = date('M d, Y h:i A', strtotime($row['orderDateTimeCompleted']));
    $sub_array[] = $row['orderStatus'];
    $sub_array[] = $row['orderTotal'];
    $sub_array[] = '<div class="d-flex flex-row align-items-center gap-2"> <a href="view-order.php?id='.$row['orderId'].'" type="button" class="btn btn-primary" id="getView">VIEW ORDER</a> '.$feedbackBtn.' </div>';
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    global $userId;
    $query = "SELECT * FROM tbl_order WHERE userId = $userId AND (orderStatus = 'COMPLETED' OR orderStatus = 'CANCELLED')";
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