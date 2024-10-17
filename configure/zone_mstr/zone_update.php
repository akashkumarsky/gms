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


		$status_sql = "SELECT status_id, snamee FROM complaint_status_mstr";
		$result1 = pg_query($conn, $status_sql);

?>
	<?php
		include '../../db.php';
		if(isset($_GET['id'])){
			$zone_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM zone_mstr where zone_id = $zone_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);

		if(isset($_POST['submit'])) {
			$znamee	= pg_escape_string($conn,$_POST['znamee']);
			$znameh	= pg_escape_string($conn,$_POST['znameh']);
			$znamem	= pg_escape_string($conn,$_POST['znamem']);
			
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($znameeCheck==0) {

            $updateQuery = "UPDATE zone_mstr SET zone_id = $zone_id, znamee = '$znamee', znameh = '$znameh', znamem = '$znamem', event_datetime = '$event_datetime', ip='$ip', username = '$username' WHERE zone_id = $zone_id";

			$query = pg_query($conn, $updateQuery);

			if($query) {
				echo"<script>location.href = 'configure/zone_mstr/zone_list.php';</script>";
			}
			else {
				echo "Data insertion failed";
			}
		}}
	?>

	<div class="config">
	<a class="back_btn" href="configure/zone_mstr/zone_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3> zone Update</h3>
		<form action="" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter zone</label><br>
                    <input type="text" id="enamep" placeholder="Priority" name="znamee" value="<?php echo $result['znamee'] ?>" required><br>
					<span class = "error"><?php echo $znameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>क्षेत्र</label><br>
                    <input type="text" id="hnamep" placeholder="क्षेत्र" name="znameh" value="<?php echo $result['znameh'] ?>" required>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>झोन</label><br>
                    <input type="text" id="mnamep" placeholder="झोन" name="znamem" value="<?php echo $result['znamem'] ?>" required>
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