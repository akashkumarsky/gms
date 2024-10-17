<?php include "../../dashboard_header.php";
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
$mnameeErr='';
 $mnameeCheck=0;

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(empty($_POST["mnamee"])) {

        $mnameeErr = "Please enter complaint in english";
		$mnameeCheck=1;

    } else {

        $mnamee = test_input($_POST["mnamee"]);

        // check if name only contains letters and whitespace

        if (!preg_match("/^[a-zA-Z-' ]*$/",$mnamee)) {
            
        $mnameeErr = "Only letters and white space allowed";
        $mnamee = '';
		$mnameeCheck=1;
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
	<a class="back_btn" href="configure/complaint_mode_mstr/mode_list.php"><i class="fa-solid fa-angle-left"></i></a>
    <h3>Complaint Mode</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<div class="form-row">
				<div class="form-group">
					<label>Enter complaint mode</label>
					<input type="text" name="mnamee" required><br>
					<span class = "error"><?php echo $mnameeErr;?></span>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group">
					<label>शिकायत मोड दर्ज करें.</label>
					<input type="text" name = "mnameh"  required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group">
					<label>तक्रार मोड प्रविष्ट करा</label>
					<input type="text" name="mnamem" required>
				</div>
			</div>
           
			<div class="text-center">
				<input type="submit" name="submit" value="Add">
			</div>
		</form>
    </div>
	<?php
        include '../../db.php';
		$status_id='7';
		
		
		if(isset($_POST['submit'])) {
			$mnamee = pg_escape_string($conn,$_POST['mnamee']);
			$mnameh = pg_escape_string($conn,$_POST['mnameh']);
			$mnamem = pg_escape_string($conn,$_POST['mnamem']);
           
            $event_datetime = new DateTime('now',new DateTimeZone('Asia/Kolkata'));
            $event_datetime = $event_datetime->format('Y-m-d H:i:s');
            $ip = isset($_SERVER['REMOTE_ADDR']);

			if($mnameeCheck==0) {


			$insertQuery = "INSERT INTO complaint_mode_mstr (mnamee,mnameh,mnamem,status_id,event_datetime,ip,username) VALUES ('$mnamee', '$mnameh','$mnamem','$status_id','$event_datetime','$ip','$username')";

			$query = pg_query($conn, $insertQuery);

			if($query) {
				echo"<script>location.href = 'configure/complaint_mode_mstr/mode_list.php';</script>";
			}
			else {
				echo "Data insertion failed";
			}
		}
		}
	?>
	<?php
 include "../../dashboard_footer.php";
?>
