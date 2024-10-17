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
	<a class="back_btn" href="configure/complaint_time_mstr/time_list.php"><i class="fa-solid fa-angle-left"></i></a>
		<h3>Add New Turn Around Time</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Turn Around Time In Hrs</label>
                    <input type="text" id="timeInHrs" placeholder="Time In Hrs" name="time_in_hrs" required>
                </div>
			</div>
			<div class="text-center">
                <input type="submit" name="submit" value="Add">
            </div>
		</form>
	</div>
	<?php
		include '../../db.php';
		$status_id ='7';
		
		if(isset($_POST['submit'])) {
			$time_in_hrs = pg_escape_string($conn,$_POST['time_in_hrs']);
			$time_in_days = intval($time_in_hrs)/24;
			$time_in_days = ceil($time_in_days);
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);


			$insertQuery = "INSERT INTO complaint_time_mstr (time_in_hrs, time_in_days, event_datetime, ip, username,status_id) VALUES ('$time_in_hrs', '$time_in_days', '$event_datetime', '$ip', '$username','$status_id')";
			$query = pg_query($conn, $insertQuery);
			if($query) {
				echo"<script>location.href = 'configure/complaint_time_mstr/time_list.php';</script>";
			} else {
				echo "Data insertion failed";
			}
		}
	?>
<?php 
 include "../../dashboard_footer.php";
?>