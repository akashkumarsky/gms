<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $status_id=$_GET['ids'];
    }

    $deleteQuery = "DELETE FROM complaint_status_mstr WHERE status_id = $status_id";
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        header('location:status_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>