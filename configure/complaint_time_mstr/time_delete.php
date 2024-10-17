<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $tat_id=$_GET['ids'];
    }

    $deleteQuery = "UPDATE complaint_time_mstr SET status_id = '8' WHERE tat_id = $tat_id";
    
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        header('location:time_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>