<?php include '../../dashboard_header.php'; 
		include '../../db.php';
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
		$status_sql = "SELECT status_id, snamee FROM complaint_status_mstr";
		$result1 = pg_query($conn, $status_sql);

		if(isset($_GET['id'])){
			$tat_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM complaint_time_mstr where tat_id = $tat_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);

		if(isset($_POST['submit'])) {
			$time_in_hrs = pg_escape_string($conn,$_POST['time_in_hrs']);
			$time_in_days = intval($time_in_hrs)/24;
			$time_in_days = ceil($time_in_days);
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
			
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

            $updateQuery = "UPDATE complaint_time_mstr SET tat_id = $tat_id, time_in_hrs = '$time_in_hrs', time_in_days = '$time_in_days', event_datetime = '$event_datetime', ip = '$ip', username = '$username' WHERE tat_id = $tat_id";

			$query = pg_query($conn, $updateQuery);

			if($query) {
				echo"<script>location.href = 'configure/complaint_time_mstr/time_list.php';</script>";
			}
			else {
				echo "Data insertion failed";
			}
		}
	?>

	<div class="config">
	<a class="back_btn" href="configure/complaint_time_mstr/time_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3>Complaint Turn Around Time Update</h3>
		<form action="" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Turn Around Time In Hrs</label>
                    <input type="text" id="timeInHrs" name="time_in_hrs" value="<?php echo $result['time_in_hrs'] ?>" required>
                </div>
			</div>
			
			<div class="text-center">
                <input type="submit" name="submit" value="Update">
            </div>
		</form>
	</div>
	<?php 
 include "../../dashboard_footer.php";
?>