<?php include '../../dashboard_header.php';
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
include '../../db.php';

        $zone_sql = "SELECT zone_id, znamee FROM zone_mstr WHERE status_id != '8'";
        $result2 = pg_query($conn, $zone_sql);


	
		$wnameeErr='';
 $wnameeCheck=0;

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(empty($_POST["wnamee"])) {

        $wnameeErr = "Please enter complaint in english";
		$wnameeCheck=1;

    } else {

        $wnamee = test_input($_POST["wnamee"]);

        // check if name only contains letters and whitespace

        if (!preg_match("/^[a-zA-Z-' ]*$/",$wnamee)) {
            
        $wnameeErr = "Only letters and white space allowed";
        $wnamee = '';
		$wnameeCheck=1;
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
	<a class="back_btn" href="configure/ward_mstr/ward_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3>Ward Master</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-row">			
				<div class="form-group">
					<label>Enter zone</label><br>
					<select name="zone_id" id="zone" required>
                                <option value="" disabled selected hidden>Choose Zone</option>
                            </select>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Ward</label><br>
                    <input type="text" id="enamep" placeholder="ward" name="wnamee" required><br><span class = "error"><?php echo $wnameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>वार्ड</label><br>
                    <input type="text" id="hnamep" placeholder="वार्ड" name="wnameh" required>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>प्रभाग</label><br>
                    <input type="text" id="mnamep" placeholder="प्रभाग" name="wnamem" required>
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
            $zone_id	= pg_escape_string($conn,$_POST['zone_id']);
			$wnamee	= pg_escape_string($conn,$_POST['wnamee']);
			$wnameh	= pg_escape_string($conn,$_POST['wnameh']);
			$wnamem	= pg_escape_string($conn,$_POST['wnamem']);
			
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($wnameeCheck==0) {

			$insertQuery = "INSERT INTO ward_mstr   (wnamee,wnameh, wnamem, status_id, event_datetime, ip, username,zone_id) VALUES  ('$wnamee', '$wnameh', '$wnamem', '$status_id', '$event_datetime', '$ip', '$username','$zone_id')"; 

			$query = pg_query($conn, $insertQuery);

			if($query) {
				echo"<script>location.href = 'configure/ward_mstr/ward_list.php';</script>";
			} else {
				echo "Data insertion failed";
			}
		}}
	?>
	
	<?php 
 include "../../dashboard_footer.php";
?>