<?php
    include '../../db.php';
    if(isset($_GET['ids'])){
        $mode_id = $_GET['ids'];
    }

    $deleteQuery = "UPDATE complaint_mode_mstr SET status_id = '8' where mode_id = $mode_id";
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        header('location:mode_list.php');
    } else {
        echo "Data deletion failed";
    }
?>