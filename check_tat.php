<?php
include 'db.php';

$admin = 1;
//FETCHING EXPIRED status_id
function getStatusId($name)
{
    $status_query = pg_query("SELECT status_id FROM complaint_status_mstr WHERE LOWER(snamee) = LOWER('$name')");
    $status_result = pg_fetch_row($status_query);
    return $status_result[0];
}
$expired = getStatusId('expired');
//UPDATE ALL COMPLAINT STATUS TO EXPIRED WHOSE TIMEOUT HAS OCCURED 
//THEN CREATE NOTIFICATION FOR EXPIRED COMPLAINT
$tat_query = pg_query("UPDATE complaint_details SET status_id = $expired, istimeout_occured = TRUE WHERE istimeout_occured = FALSE AND timeout < NOW() RETURNING complaint_id, applicant_name, applicant_id, dept_id");

//CREATE NOTIFICATION FOR EXPIRED COMPLAINT
if (pg_affected_rows($tat_query) > 1) {
    //FETCH DETAILS OF UPDATED COMPLAINT
    $expired_rows = pg_fetch_all($tat_query);

    //NOTIFICATION QUERY STRING 
    $nStr = "INSERT INTO notification_tbl(reciept_id, sender_id, reference_id, message, dept_id) VALUES";
    
    foreach($expired_rows as $exp_row){
        $msg = "Complaint ID: {$exp_row['complaint_id']} has expired. Click to view";
        $reference = $exp_row['complaint_id'];
        $dept = $exp_row['dept_id'];
        $creator = $exp_row['applicant_id'];
        $nStr .= "($admin, $creator, $reference, '$msg', NULL),(NULL, $creator, $reference, '$msg', $dept),";
    }

    $nStr = rtrim($nStr, ',');
    $submit_notify = pg_query($nStr);
    echo $nStr;
}
