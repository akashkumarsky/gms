<?php include '../../dashboard_header.php'; 
        include '../../db.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
        if(isset($_GET['id'])){
			$tat_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM complaint_time_mstr where tat_id = $tat_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);
    ?>
    <div class="config">
    <a class="back_btn" href="configure/complaint_time_mstr/time_list.php"><i class="fa-solid fa-angle-left"></i></a>
        <h3>Complaint Turn Around Time Details</h3>
		<form class="details" action="">
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Turn Around Time ID</label>
                    <input type="text" id="tatid" name="tat_id" value="<?php echo $result['tat_id'] ?>" readonly>
                </div>
                
			</div>
			<div class="form-row">			
                <div class="form-group lg">
                    <label>Turn Around Time In Hrs</label>
                    <input type="text" id="timeInHrs" name="time_in_hrs" value="<?php echo $result['time_in_hrs'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>Turn Around Time In Days</label>
                    <input type="text" id="timeInDays" name="time_in_days" value="<?php echo $result['time_in_days'] ?>" readonly>
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