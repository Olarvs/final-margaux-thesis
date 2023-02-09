<?php
session_start();
require_once '../../database/config-pdo.php';
require_once '../../database/config.php';

$adminId = $_SESSION['margaux_admin_id'];

$column = array('name', 'sale');

$query = "SELECT tbl_product.productName, COUNT(tbl_product.productName) as sale FROM tbl_order LEFT JOIN tbl_order_items ON tbl_order.orderId = tbl_order_items.orderId LEFT JOIN tbl_product ON tbl_order_items.productId = tbl_product.productId LEFT JOIN tbl_category ON tbl_category.categoryId = tbl_product.categoryId WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 AND tbl_order.orderStatus = 'COMPLETED'";

if (isset($_POST['search']['value'])) {
    $query .= 'AND (tbl_product.productName LIKE "%' . $_POST['search']['value'] . '%" OR sale LIKE "%' . $_POST['search']['value'] . '%")
 ';
}

$query .= 'GROUP BY tbl_product.productName';

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
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
    $sub_array[] = $row['name'];
    $sub_array[] = $row['sale'];
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT tbl_product.productName, COUNT(tbl_product.productName) as sale
    FROM tbl_order
    LEFT JOIN tbl_order_items
    ON tbl_order.orderId = tbl_order_items.orderId
    LEFT JOIN tbl_product
    ON tbl_order_items.productId = tbl_product.productId
    LEFT JOIN tbl_category
    ON tbl_category.categoryId = tbl_product.categoryId
    WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0 AND tbl_order.orderStatus = 'COMPLETED'
    GROUP BY tbl_product.productName";
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