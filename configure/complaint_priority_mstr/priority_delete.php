<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $priority_id=$_GET['ids'];
    }

    $deleteQuery = "UPDATE complaint_priority_mstr SET status_id = '8' WHERE  priority_id = $priority_id";
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        echo "Data deleted successfully";
        header('location:priority_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>