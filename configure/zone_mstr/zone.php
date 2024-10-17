<?php include '../../dashboard_header.php';
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
include '../../db.php';

$znameeErr='';
$znameeCheck=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   if(empty($_POST["znamee"])) {

	   $znameeErr = "Please enter complaint in english";
	   $znameeCheck=1;

   } else {

	   $znamee = test_input($_POST["znamee"]);

	   // check if name only contains letters and whitespace

	   if (!preg_match("/^[a-zA-Z-' ]*$/",$znamee)) {
		   
	   $znameeErr = "Only letters and white space allowed";
	   $znamee = '';
	   $znameeCheck=1;
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
	<a class="back_btn" href="configure/zone_mstr/zone_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3>Zone Master</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Zone</label><br>
                    <input type="text" id="enamep" placeholder="Zone" name="znamee" required><br>
					<span class = "error"><?php echo $znameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>क्षेत्र</label><br>
                    <input type="text" id="hnamep" placeholder="क्षेत्र" name="znameh" required>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>झोन</label><br>
                    <input type="text" id="mnamep" placeholder="झोन" name="znamem" required>
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
			$znamee	= pg_escape_string($conn,$_POST['znamee']);
			$znameh	= pg_escape_string($conn,$_POST['znameh']);
			$znamem	= pg_escape_string($conn,$_POST['znamem']);

			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($znameeCheck==0) {

			$insertQuery = "INSERT INTO zone_mstr (znamee, znameh, znamem, status_id, event_datetime, ip, username) VALUES ('$znamee', '$znameh', '$znamem', '$status_id', '$event_datetime', '$ip', '$username')";

			$query = pg_query($conn, $insertQuery);

			if($query) {
				echo"<script>location.href = 'configure/zone_mstr/zone_list.php';</script>";
			} else {
				echo "Data insertion failed";
			}
		}}
	?>
	
	<?php 
 include "../../dashboard_footer.php";
?>