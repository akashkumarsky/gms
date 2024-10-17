<?php 
 include "../../dashboard_header.php";
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
        <h3>List</h3>
        <a class="add_btn" href="configure/complaint_mode_mstr/mode.php">Add Mode <i class="fa-solid fa-circle-plus"></i></a>
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

                            $selectQuery = "SELECT * FROM complaint_mode_mstr  where   status_id !='8';";
                            $query = pg_query($conn, $selectQuery);
                            $i=0;
                            while($result = pg_fetch_assoc($query)){
                                $i++;
                        ?>      
                        
                                <tr>
                                <td><?php echo $i ?></td>
                                    <td><?php echo $result['mnamee']; ?></td>
                                    <td><?php echo $result['mnameh']; ?></td>
                                    <td><?php echo $result['mnamem']; ?></td>
                                    <td>
                                        <a class="op_btn" href="configure/complaint_mode_mstr/mode_update.php?id=<?php echo $result['mode_id']; ?>"><i class="fa-solid fa-pen"></i></a>
                                        <a class="op_btn" href="configure/complaint_mode_mstr/mode_details.php?id=<?php echo $result['mode_id']; ?>"><i class="fa-solid fa-eye"></i></a>
                                        <a class="op_btn" href="configure/complaint_mode_mstr/mode_delete.php?ids=<?php echo $result['mode_id']; ?>" onclick="return confirm('Are you sure you want to delete this mode?');"><i class="fa-solid fa-trash"></i></a>
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