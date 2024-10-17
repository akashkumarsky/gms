<?php include '../../dashboard_header.php';
if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}
include '../../db.php';


        $zone_sql = "SELECT zone_id, znamee FROM zone_mstr";
        $result2 = pg_query($conn, $zone_sql);

		

		$zone_sql = "SELECT status_id, snamee FROM complaint_status_mstr";
		$result1 = pg_query($conn, $zone_sql);

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
	<?php
		include '../../db.php';
		if(isset($_GET['id'])){
			$ward_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM ward_mstr where ward_id = $ward_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);

		if(isset($_POST['submit'])) {
            $zone_id = pg_escape_string($conn,$_POST['zone_id']);
			$wnamee	= pg_escape_string($conn,$_POST['wnamee']);
			$wnameh	= pg_escape_string($conn,$_POST['wnameh']);
			$wnamem	= pg_escape_string($conn,$_POST['wnamem']);
			
			$event_datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 			$event_datetime = $event_datetime->format('Y-m-d H:i:s');
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($wnameeCheck==0) {

            $updateQuery = "UPDATE ward_mstr SET ward_id = $ward_id, wnamee = '$wnamee', wnameh = '$wnameh', wnamem = '$wnamem', event_datetime = '$event_datetime', ip='$ip', username = '$username',zone_id ='$zone_id' WHERE ward_id = $ward_id";

			$query = pg_query($conn, $updateQuery);

			if($query) {
				echo"<script>location.href = 'configure/ward_mstr/ward_list.php';</script>";
			}
			else {
				echo "Data insertion failed";
			}
		}}
	?>

	<div class="config">
	<a class="back_btn" href="configure/ward/ward_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3> ward Update</h3>
		<form action="" method="POST">
        <div class="form-row">			
				<div class="form-group">
					<label>Enter zone</label><br>
					<select name="zone_id" id="zone">
						<option selected>Choose...</option>	
				 <?php while($item_row = pg_fetch_assoc($result2)){
                            echo "<option value='".$item_row['zone_id']."'>".$item_row['znamee']."</option>";
                        } ?>
				
					</select>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>Update Ward</label><br>
                    <input type="text" id="enamep" placeholder="Ward" name="wnamee" value="<?php echo $result['wnamee'] ?>" required> <br><span class = "error"><?php echo $wnameeErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>वार्ड</label><br>
                    <input type="text" id="hnamep" placeholder="वार्ड" name="wnameh" value="<?php echo $result['wnameh'] ?>" required>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>प्रभाग</label><br>
                    <input type="text" id="mnamep" placeholder="प्रभाग" name="wnamem" value="<?php echo $result['wnamem'] ?>" required>
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