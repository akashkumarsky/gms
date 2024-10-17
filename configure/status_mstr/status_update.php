<?php include '../../dashboard_header.php';
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
$snameeErr='';
	$snameeCheck=0;
   
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	   
	   if(empty($_POST["snamee"])) {
   
		   $snameeErr = "Please enter complaint in english";
		   $snameeCheck=1;
   
	   } else {
   
		   $snamee = test_input($_POST["snamee"]);
   
		   // check if name only contains letters and whitespace
   
		   if (!preg_match("/^[a-zA-Z-' ]*$/",$snamee)) {
			   
		   $snameeErr = "Only letters and white space allowed";
		   $snamee = '';
		   $snameeCheck=1;
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
	<?php
		include '../../db.php';
		if(isset($_GET['id'])){
			$status_id = $_GET['id'];
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		
        $selectQuery = "SELECT * FROM complaint_status_mstr where status_id = $status_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);

		if(isset($_POST['submit'])) {
			$snamee	= pg_escape_string($conn,$_POST['snamee']);
			$snameh	= pg_escape_string($conn,$_POST['snameh']);
			$snamem	= pg_escape_string($conn,$_POST['snamem']);
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);
			
			if($snameeCheck==0) {

            $updateQuery = "UPDATE complaint_status_mstr SET status_id = $status_id, snamee = '$snamee', snameh = '$snameh', snamem = '$snamem', event_datetime = '$event_datetime', ip = '$ip', username = '$username' WHERE status_id = $status_id";

			$query = pg_query($conn, $updateQuery);

			if($query) {
				echo"<script>location.href = 'configure/status_mstr/status_list.php';</script>";
			} else {
				echo "Data insertion failed";
			}
		}}
	?>

	<div class="config">
	<a class="back_btn" href="configure/status_mstr/status_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3>Complaint Status Update</h3>
		<form action="" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Complaint Status</label>
                    <input type="text" id="enames" name="snamee" value="<?php echo $result['snamee'] ?>" required> <br>
					<span class = "error"><?php echo $snameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>शिकायत की स्थिति दर्ज करें</label>
                    <input type="text" id="hnames" name="snameh" value="<?php echo $result['snameh'] ?>" required>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>तक्रारीची स्थिती एंटर करा</label>
                    <input type="text" id="mnames" name="snamem" value="<?php echo $result['snamem'] ?>" required>
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