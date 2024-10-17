


<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $dept_id=$_GET['ids'];
    }

   
    
    $deleteQuery = "UPDATE complaint_department_mstr SET status_id = '8' WHERE dept_id=$dept_id ";
 

    $query = pg_query($conn, $deleteQuery);

    if($query) {
        echo "Data deleted successfully";
        header('location:dept_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>