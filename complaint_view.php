<?php
include 'dashboard_header.php';
//session variables
if (!isset($usertype)) {
    header('location:dashboard.php');
}
include 'db.php';
//datetime
date_default_timezone_set('Asia/Kolkata');
$event_datetime = date('Y-m-d H:i:s');

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    //update NOTIFICATION table if 
    //u == usertype id or dept_id
    if (!empty($_GET['u']) && !empty($_GET['n'])) {
        //for recipient according to usertype
        if(empty($user_dept)){
            $recipient = "reciept_id = {$_GET['u']}";
        }else{
            $recipient = "dept_id = {$user_dept}";
        }
        $n = $_GET['n'];
        $noti_update = "UPDATE notification_tbl SET unread = false WHERE reference_id = $id AND id=$n AND {$recipient}";
        $submit = pg_query($noti_update);
    }

    $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE complaint_id = $id";
    $result = pg_query($sql);
    $complaint = pg_fetch_assoc($result);

    $applicant_name = $complaint['applicant_name'];
    $dept_id = $complaint['dept_id'];
    $zone_id = $complaint['zone_id'];
    $ward_id = $complaint['ward_id'];
    $dept_id = $complaint['dept_id'];
    $mode_id = $complaint['mode_id'];
    $emp_id = $user_id;

    $zone_sql = "SELECT zone_id, znamee FROM zone_mstr WHERE zone_id = $zone_id";
    $zone_result = pg_query($zone_sql);
    $zone = pg_fetch_assoc($zone_result);

    $ward_sql = "SELECT ward_id, wnamee FROM ward_mstr WHERE ward_id = $ward_id";
    $ward_result = pg_query($ward_sql);
    $ward = pg_fetch_assoc($ward_result);

    $dept_sql = "SELECT dept_id, dnamee FROM complaint_department_mstr WHERE dept_id = $dept_id";
    $dept_result = pg_query($dept_sql);
    $dept = pg_fetch_assoc($dept_result);

    $mode_sql = "SELECT mode_id, mnamee FROM complaint_mode_mstr WHERE mode_id = $mode_id";
    $mode_result = pg_query($mode_sql);
    $mode = pg_fetch_assoc($mode_result);

    //print_r($complaint);
} else {
    header('location: complaint_list.php');
}

//remark submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['submit'])) {
        $remark = $_POST['remark'];
        $status_id = $_POST['status'];

        $insert_sql = "INSERT INTO complaint_suggestion(complaint_id, applicant_name, status_id, remark, emp_id, update_datetime, dept_id) VALUES($id, '$applicant_name', $status_id, '$remark', $emp_id, '$event_datetime', $dept_id)";
        $exe_sql = pg_query($conn, $insert_sql);

        if (pg_affected_rows($exe_sql)) {
            //-------------UPDATE COMPLAINT DETAIL------------
            $update_complain = "UPDATE complaint_details SET status_id = $status_id WHERE complaint_id = $id";
            $update_result = pg_query($update_complain);

            //-------------NOTIFICATION CREATION------------
            $msg = "{$username} responded to complain";
            $notify_sql = "INSERT INTO notification_tbl(reciept_id, sender_id, reference_id, message, dept_id)
            VALUES(1, $user_id, $id, '$msg', NULL),(NULL, $user_id, $id, '$msg', $dept_id)";

            $submit = pg_query($notify_sql);
            //------------------------------------

            $update_complain = "UPDATE complaint_details SET status_id = '$status_id' WHERE complaint_id = $id";
            $exe_update = pg_query($update_complain);

        }
    }
}
?>
    <div class="complain_view">
        <div class="view_wrapper">
            <table>
                <thead>
                    <th style="width:300px"></th>
                    <th></th>
                </thead>
                <tbody>
                    <tr class="heading">
                        <td class="bold"><h4>Subject: </h4></td>
                        <td><h4><?php echo $complaint['complaint_head'] ?? ''; ?></h4></td>
                    </tr>
                    <tr>
                        <td class="bold"><h4>Applicant Name: </h4></td>
                        <td><h5><?php echo $complaint['applicant_name'] ?? ''; ?></h5></td>
                    </tr>
                    <tr>
                        <td class="bold"><h4>Applicant Phone No.: </h4></td>
                        <td><h5><?php echo $complaint['phone_no'] ?? ''; ?></h5></td>
                    </tr>
                    <tr>
                        <td class="bold"><h4>User Name: </h4></td>
                        <td><h5><?php echo $complaint['applicant_name'] ?? ''; ?></h5></td>
                    </tr>
                    <tr>
                        <td class="bold"><h4>Description: </h4></td>
                        <td><h5><?php echo $complaint['complaint_body'] ?? ''; ?></h5></td>  
                    </tr>
                    <tr>
                        <td class="bold"><h4>Complaint Datetime: </h4></td>
                        <td><h5><?php echo $complaint['event_datetime'] ?? ''; ?></h5></td>
                    </tr>
                    <tr>
                        <td class="bold"><h4>Zone: </h4></td>
                        <td><h5><?php echo $zone['znamee'] ?></h5></td>  
                    </tr>
                    <tr>
                        <td class="bold"><h4>Ward: </h4></td>
                        <td><h5><?php echo $ward['wnamee'] ?></h5></td>  
                    </tr>
                    <tr>
                        <td class="bold"><h4>Department: </h4></td>
                        <td><h5><?php echo $dept['dnamee'] ?></h5></td>  
                    </tr>
                    <tr>
                        <td class="bold"><h4>Mode: </h4></td>
                        <td><h5><?php echo $mode['mnamee'] ?></h5></td>  
                    </tr>
                    <tr>
                        <td class="bold"><h4>File: </h4></td>
                        <td>
                            <a href="files/<?php echo $complaint['file'] ?? 'No file'; ?>" target="_blank" rel="noopener noreferrer">File</a>
                        </td>
                    </tr>
                    <tr>
                        <?php $r = pg_query("SELECT remark FROM complaint_suggestion WHERE complaint_id='$id' ORDER BY update_datetime DESC LIMIT 1");
                        $r = pg_fetch_row($r); ?>
                        <td class="bold"><h4>Remarks: </h4></td>
                        <td><h5><?php echo $r[0] ?? 'No remarks yet'; ?></h5></td>  
                    </tr>
                    <tr>
                        <td class="bold"><h4>Status: </h4></td>
                        <td><h5><?php echo $complaint['snamee']; ?></h5></td>  
                    </tr>
                </tbody>
            </table>
            <?php if($usertype==$admin || $usertype==$officer){ ?>
            <form action="" method="POST">
                <textarea name="remark" id="" cols="100" rows="6" placeholder="Write Remark"></textarea><br>
                <select name="status" id="">
                    <option value="" selected hidden>Status</option>
                    <option value="4">Pending</option>
                    <option value="5">Close</option>
                    <option value="9">In Progress</option>
                </select>
                <button type="submit" name="submit" value="submit">Submit</button>
            </form>
            <?php } ?>
        </div>
    </div>
<?php include 'dashboard_footer.php'; ?>