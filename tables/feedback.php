<?php
// session_start();
require_once '../database/config-pdo.php';

$column = array('tbl_feedback.rate', 'tbl_user.name', 'tbl_feedback.comment', 'tbl_feedback.date');

$query = "SELECT tbl_user.*, tbl_feedback.* FROM tbl_feedback LEFT JOIN tbl_user ON tbl_feedback.userId = tbl_user.user_id";

$searchByStatus = $_POST['searchByStatus'];

if ($searchByStatus != '') {
    $query .= ' WHERE tbl_feedback.rate = "' . $searchByStatus . '" ';
} else {
    if (isset($_POST['search']['value'])) {
        $query .= '
 WHERE (tbl_feedback.rate LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_user.name LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_user.email LIKE "%' . $_POST['search']['value'] . '%"
 OR tbl_feedback.comment LIKE "%' . $_POST['search']['value'] . '%" )
 ';
    }
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
    $sub_array[] = $row['rate'];
    $sub_array[] = $row['name'] . '<br>' . $row['email'];
    $sub_array[] = $row['comment'];
    $sub_array[] = date('F d, Y h:i A', strtotime($row['date']));
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT tbl_user.*, tbl_feedback.* FROM tbl_feedback LEFT JOIN tbl_user ON tbl_feedback.userId = tbl_user.user_id";
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
