


<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $ward_id=$_GET['ids'];
    }

    
    
    $deleteQuery = "UPDATE ward_mstr SET status_id = '8' WHERE ward_id=$ward_id ";
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        echo "Data deleted successfully";
        header('location:ward_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>