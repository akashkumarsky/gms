<?php
include 'db.php';
session_start();
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$usertype = $_SESSION['usertype'];
$user_dept = $_SESSION['dept_id'] ?? '';

$usertype_sql = pg_query("SELECT type_id, type FROM usertype");

while($usertype_row = pg_fetch_assoc($usertype_sql)){
    $usertype_row['type'] == 'admin' ? $admin = $usertype_row['type_id'] : '';
    $usertype_row['type'] == 'citizen' ? $citizen = $usertype_row['type_id'] : '';
    $usertype_row['type'] == 'officer' ? $officer = $usertype_row['type_id'] : '';
}

?>