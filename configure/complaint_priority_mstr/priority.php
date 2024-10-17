<?php include '../../dashboard_header.php';
include '../../db.php';
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}

$pnameeErr='';
$pnameeCheck=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   if(empty($_POST["pnamee"])) {

	   $pnameeErr = "Please enter complaint in english";
	   $pnameeCheck=1;

   } else {

	   $pnamee = test_input($_POST["pnamee"]);

	   // check if name only contains letters and whitespace

	   if (!preg_match("/^[a-zA-Z-' ]*$/",$pnamee)) {
		   
	   $pnameeErr = "Only letters and white space allowed";
	   $pnamee = '';
	   $pnameeCheck=1;
	   }
   }
}

function test_input($data) {

$data = trim($data);

$data = stripslashes($data);

$data = htmlspecialchars($data);

return $data;

}

		$zone_sql = "SELECT status_id, snamee FROM complaint_status_mstr";
		$result1 = pg_query($conn, $zone_sql);


?>
<div class="config">
	<a class="back_btn" href="configure/complaint_priority_mstr/priority_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3>Add New Priority</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Priority</label>
                    <input type="text" id="enamep" placeholder="Priority" name="pnamee" required><br>
					<span class = "error"><?php echo $pnameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>प्राथमिकता दर्ज करें</label>
                    <input type="text" id="hnamep" placeholder="प्राथमिकता" name="pnameh" required>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>प्राधान्य एंटर करा</label>
                    <input type="text" id="mnamep" placeholder="प्राधान्य" name="pnamem" required>
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
			$pnamee	= pg_escape_string($conn,$_POST['pnamee']);
			$pnameh	= pg_escape_string($conn,$_POST['pnameh']);
			$pnamem	= pg_escape_string($conn,$_POST['pnamem']);
			
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($pnameeCheck==0) {

			$insertQuery = "INSERT INTO complaint_priority_mstr (pnamee, pnameh, pnamem, status_id, event_datetime, ip, username) VALUES ('$pnamee', '$pnameh', '$pnamem', '$status_id', '$event_datetime', '$ip', '$username')";

			$query = pg_query($conn, $insertQuery);

			if($query) {
				echo"<script>location.href = 'configure/complaint_priority_mstr/priority_list.php';</script>";
			} else {
				echo "Data insertion failed";
			}
		}}
	?>
	
	<?php
 include "../../dashboard_footer.php";
?>