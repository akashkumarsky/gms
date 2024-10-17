<?php include '../../dashboard_header.php';

		$tat_sql = "SELECT tat_id, time_in_days FROM complaint_time_mstr";
		$result1 = pg_query($conn, $tat_sql);

if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
include '../../db.php';

$dnameeErr='';
$dnameeCheck=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   if(empty($_POST["dnamee"])) {

	   $dnameeErr = "Please enter complaint in english";
	   $dnameeCheck=1;

   } else {

	   $dnamee = test_input($_POST["dnamee"]);

	   // check if name only contains letters and whitespace

	   if (!preg_match("/^[a-zA-Z-' ]*$/",$dnamee)) {
		   
	   $dnameeErr = "Only letters and white space allowed";
	   $dnamee = '';
	   $dnameeCheck=1;
	   }
   }
}

function test_input($data) {

$data = trim($data);

$data = stripslashes($data);

$data = htmlspecialchars($data);

return $data;

}
		


?>
<div class="config">
	<a class="back_btn" href="configure/complaint_dept_mstr/dept_list.php" ><i class="fa-solid fa-angle-left"></i></a>
	<h3>Depatment Master</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			
            <div class="form-row">
				<div class="form-group">
                    <label>Enter complaint department</label><br>
                    <input type="text" id="dept" placeholder="department" name="dnamee" required> <br>
					<span class = "error"><?php echo $dnameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>शिकायत विभाग दर्ज करें</label><br>
                    <input type="text" id="hnamep" placeholder="विभाग" name="dnameh" required>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>तक्रार विभाग प्रविष्ट करा</label><br>
                    <input type="text" id="mnamep" placeholder="झोन" name="dnamem" required>
                </div>
			</div>
			
            <div class="form-row">
				<div class="form-group">
                    <label>location</label><br>
                    <input type="text" id="location" placeholder="झोन" name="location" required>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
					<label>Select time in days</label><br>
					<select class="form-control" name="tat_id" >
						<option value="" hidden>choose</option>
						
				 <?php while($item_row = pg_fetch_assoc($result1)){
                            echo "<option value='".$item_row['tat_id']."'>".$item_row['time_in_days']."</option>";
                        } ?>
				</select>
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
			$dnamee	= pg_escape_string($conn,$_POST['dnamee']);
            $location = pg_escape_string($conn,$_POST['location']);
			$dnameh	= pg_escape_string($conn,$_POST['dnameh']);
			$dnamem	= pg_escape_string($conn,$_POST['dnamem']);
			$tat_id	= pg_escape_string($conn,$_POST['tat_id']);
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($dnameeCheck==0) {

			$insertQuery = "INSERT INTO complaint_department_mstr (dnamee, dnameh, dnamem, status_id, event_datetime, ip, username,location,tat_id) VALUES ('$dnamee', '$dnameh', '$dnamem', '$status_id', '$event_datetime', '$ip', '$username','$location','$tat_id')";

			$query = pg_query($conn, $insertQuery);

			if($query) {
				echo"<script>location.href = 'configure/complaint_dept_mstr/dept_list.php';</script>";
			} else {
				echo "Data insertion failed";
			}
		}
		}

	?>
	
	<?php include '../../dashboard_footer.php'; ?>