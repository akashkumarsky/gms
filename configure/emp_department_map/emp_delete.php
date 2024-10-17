<?php
    include '../../db.php';
    if(isset($_GET['ids'])) {
        $id=$_GET['ids'];
    }

    $deleteQuery = "DELETE FROM emp_department_map WHERE id = $id";
    $query = pg_query($conn, $deleteQuery);

    if($query) {
        echo "Data deleted successfully";
        header('location:emp_list.php');
    }
    else {
        echo "Data deletion failed";
    }
?>