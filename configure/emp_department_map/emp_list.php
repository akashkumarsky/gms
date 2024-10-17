<?php include '../../dashboard_header.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
?>
<div class="config">
    <a class="back_btn" href="dashboard.php"><i class="fa-solid fa-angle-left"></i></a>
    <h3>Employee List</h3>
    <a class="add_btn" href="configure/emp_department/emp_map.php">Add Employee <i class="fa-solid fa-circle-plus"></i></a>
    <div class="center-div">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-head">
                    <th>#</th>
                    <th>Emp ID</th>
                    <th>Emp Name</th>
                    <th>Dept ID</th>
                    <th>Zone ID</th>
                    <th>Ward ID</th>
                    <th>Operations</th>
                </thead>
                <tbody>
                    <?php
                    include '../../db.php';

                    $selectQuery = "SELECT e.*, m.* FROM emp_department_map m INNER JOIN employee e ON m.emp_id = e.emp_id ORDER BY m.id ASC";
                    $query = pg_query($conn, $selectQuery);
                    $i = 0;
                    while ($result = pg_fetch_assoc($query)) {
                        $i++;
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['emp_id']; ?></td>
                            <td><?php echo $result['ename']; ?></td>
                            <td><?php echo $result['dept_id']; ?></td>
                            <td><?php echo $result['zone_id']; ?></td>
                            <td><?php echo $result['ward_id']; ?></td>
                            <td>
                                <a class="op_btn" href="configure/emp_department_map/emp_delete.php?ids=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure you want to delete this row?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "../../dashboard_footer.php";
?>