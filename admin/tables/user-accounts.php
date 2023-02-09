<?php
session_start();
require_once '../../database/config-pdo.php';

$adminId = $_SESSION['margaux_admin_id'];

$column = array('profile_image', 'user_id', 'name', 'email', 'mobile_no', 'gender');

$query = "SELECT * FROM tbl_user WHERE verified = 'VERIFIED'";

if (isset($_POST['search']['value'])) {
    $query .= '
 AND (name LIKE "%' . $_POST['search']['value'] . '%"
 OR gender LIKE "%' . $_POST['search']['value'] . '%"
 OR email LIKE "%' . $_POST['search']['value'] . '%"
 OR mobile_no LIKE "%' . $_POST['search']['value'] . '%" )
 ';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY user_id DESC ';
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
    $sub_array[] = '<img style="width: 70px; height: 70px; object-fit: cover;" src="../assets/images/profile_image/'.$row['profile_image'].'" alt="">';
    $sub_array[] = '#'.$row['user_id'];
    $sub_array[] = $row['name'];
    $sub_array[] = $row['email'];
    $sub_array[] = '+63'.$row['mobile_no'];
    $sub_array[] = $row['gender'];
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT * FROM tbl_user WHERE verified = 'VERIFIED'";
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