<?php
session_start();
require_once '../../database/config-pdo.php';

$adminId = $_SESSION['margaux_admin_id'];

$column = array('profile_image', 'adminId', 'name', 'username', 'email', 'role');

$query = "SELECT * FROM tbl_admin WHERE isVerified = 1 AND status = 1 ";

if (isset($_POST['search']['value'])) {
    $query .= '
 AND (name LIKE "%' . $_POST['search']['value'] . '%"
 OR username LIKE "%' . $_POST['search']['value'] . '%"
 OR email LIKE "%' . $_POST['search']['value'] . '%"
 OR role LIKE "%' . $_POST['search']['value'] . '%" )
 ';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY adminId DESC ';
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
    $button = '';
    $update = '';
    if ($row['adminId'] != $adminId) {
        $button = '<button type="button" class="btn btn-danger" id="getDisable" data-id="'.$row['adminId'].'">Disable</button>';
        $update = '<button type="button" class="btn btn-success" id="getUpdate" data-id="' . $row['adminId'] . '">Update</button>';
    }
    $sub_array = array();
    $sub_array[] = '<img style="width: 70px; height: 70px; object-fit: cover;" src="./assets/images/profileImage/' . $row['profile_image'] . '" alt="">';
    $sub_array[] = '#'.$row['adminId'];
    $sub_array[] = $row['name'];
    $sub_array[] = $row['username'];
    $sub_array[] = $row['email'];
    $sub_array[] = $row['role'];
    $sub_array[] = '<div class="d-flex flex-row align-items-center gap-2"> ' . $button . ' ' .$update. ' </div>';
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT * FROM tbl_admin WHERE isVerified = 1 AND status = 1";
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
