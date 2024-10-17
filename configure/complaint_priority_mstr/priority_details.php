<?php include '../../dashboard_header.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
        include '../../db.php';
        if(isset($_GET['id'])){
			$priority_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM complaint_priority_mstr where priority_id = $priority_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);
    ?>
    <div class="config">
    <a class="back_btn" href="configure/complaint_priority_mstr/priority_list.php"><i class="fa-solid fa-angle-left"></i></a>
        <h3>Complaint Priority Details</h3>
		<form class="details" action="">
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Priority ID</label>
                    <input type="text" id="priorityid" name="priority_id" value="<?php echo $result['priority_id'] ?>" readonly>
                </div>
                
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>Complaint Priority</label>
                    <input type="text" id="enamep" name="pnamee" value="<?php echo $result['pnamee'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>प्राथमिकता</label>
                    <input type="text" id="hnamep" name="pnameh" value="<?php echo $result['pnameh'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>प्राधान्य</label><br>
                    <input type="text" id="mnamep" name="pnamem" value="<?php echo $result['pnamem'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $result['username'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label>IP Address</label>
                    <input type="text" id="ip" name="ip" value="<?php echo $result['ip'] ?>" readonly>
                </div>
			</div>
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Timestamp</label>
                    <input type="text" id="timestamp" name="event_datetime" value="<?php echo $result['event_datetime'] ?>" readonly>
                </div>
			</div>
            <?php
 include "../../dashboard_footer.php";
?>