<?php
session_start();
require_once '../../database/config-pdo.php';
require_once '../../database/config.php';

$adminId = $_SESSION['margaux_admin_id'];

$getLowStockValue = mysqli_query($conn, "SELECT * FROM tbl_stock_settings");

$lowStock = 0;

foreach($getLowStockValue as $value) {
    $lowStock = $value['lowStock'];
}

$column = array('productId', 'productName', 'dateAdded', 'productStock');

$query = "SELECT tbl_category.*, tbl_product.*
FROM tbl_category
LEFT JOIN tbl_product
ON tbl_category.categoryId = tbl_product.categoryId
WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0";

if (isset($_POST['search']['value'])) {
    $query .= '
 AND (productName LIKE "%' . $_POST['search']['value'] . '%"
 OR productStock LIKE "%' . $_POST['search']['value'] . '%" )
 ';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY productStock DESC ';
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
    $status = '<label class="badge badge-success">IN STOCK</label>';
    if($row['productStock'] == 0) {
        $status = '<label class="badge badge-danger">OUT OF STOCK</label>';
    } else if($row['productStock'] <= $lowStock) {
        $status = '<label class="badge badge-warning">LOW STOCK</label>';
    }
    $date = '';
    if($row['dateAdded'] != NULL) {
        $date = date('M d, Y', strtotime($row['dateAdded']));
    }
    $sub_array = array();
    $sub_array[] = '#'.$row['productId'];
    $sub_array[] = $row['productName'];
    $sub_array[] = $date;
    $sub_array[] = intval($row['productStock']);
    $sub_array[] = $status;
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT tbl_category.*, tbl_product.*
    FROM tbl_category
    LEFT JOIN tbl_product
    ON tbl_category.categoryId = tbl_product.categoryId
    WHERE tbl_category.isDeleted = 0 AND tbl_product.isDeleted = 0";
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