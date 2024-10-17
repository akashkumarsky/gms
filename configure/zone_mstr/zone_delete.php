


<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $zone_id=$_GET['ids'];
    }

    
    
    $deleteQuery = "UPDATE zone_mstr SET status_id = '8' WHERE zone_id=$zone_id ";
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        echo "Data deleted successfully";
        header('location:zone_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>