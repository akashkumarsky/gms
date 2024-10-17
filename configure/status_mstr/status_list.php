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
        <h3>Complaint Status List</h3>
        <a class="add_btn" href="configure/status_mstr/status.php">Add Status <i class="fa-solid fa-circle-plus"></i></a>
        <div class="center-div">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>English</th>
                        <th>Hindi</th>
                        <th>Marathi</th>
                        <th>Operations</th>
                    </thead>
                    <tbody>
                        <?php
                            include '../../db.php';
                            $selectQuery = "SELECT * FROM complaint_status_mstr ORDER BY status_id ASC";
                            $query = pg_query($conn, $selectQuery);
                            $i=0;
                            while($result = pg_fetch_assoc($query)){
                                $i++;
                        ?>

                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $result['snamee']; ?></td>
                                <td><?php echo $result['snameh']; ?></td>
                                <td><?php echo $result['snamem']; ?></td>
                                <td>
                                    <a class="op_btn" href="configure/status_mstr/status_update.php?id=<?php echo $result['status_id']; ?>"><i class="fa-solid fa-pen"></i></a>
                                    <a class="op_btn" href="configure/status_mstr/status_details.php?id=<?php echo $result['status_id']; ?>"><i class="fa-solid fa-eye"></i></a>
                                    <a class="op_btn" href="configure/status_mstr/status_delete.php?ids=<?php echo $result['status_id']; ?>" onclick="return confirm('Are you sure you want to delete this status?');"><i class="fa-solid fa-trash"></i></a>
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