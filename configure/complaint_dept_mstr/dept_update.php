<?php include '../../dashboard_header.php';
include '../../db.php';

		$tat_sql = "SELECT tat_id, time_in_days FROM complaint_time_mstr";
		$result2 = pg_query($conn, $tat_sql);

if (isset($usertype)) {
	if ($usertype != $admin) {
		header('location:../dashboard.php');
	}
} else {
	header('location:../dashboard.php');
}

		
		$status_sql = "SELECT status_id, snamee FROM complaint_status_mstr";
		$result1 = pg_query($conn, $status_sql);

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
	<?php
		include '../../db.php';
		if(isset($_GET['id'])){
			$dept_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM complaint_department_mstr where dept_id = $dept_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);

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


            $updateQuery = "UPDATE complaint_department_mstr SET dept_id = $dept_id, dnamee = '$dnamee', dnameh = '$dnameh', dnamem = '$dnamem',  event_datetime = '$event_datetime', ip='$ip', username = '$username',location='$location',tat_id='$tat_id' WHERE dept_id = $dept_id";

			$query = pg_query($conn, $updateQuery);

			if($query) {
				echo"<script>location.href = 'configure/complaint_dept_mstr/dept_list.php';</script>";
			}
			else {
				echo "Data insertion failed";
			}
		}
	}
	?>

	<div class="config">
	<a class="back_btn" href="configure/complaint_dept_mstr/dept_list.php"><i class="fa-solid fa-angle-left"></i></a>
	<h3> depatment Update</h3>
		<form action="" method="POST">
			<div class="form-row">			
				<div class="form-group">
                    <label>Enter Depatment</label><br>
                    <input type="text" id="enamep" placeholder="depatment" name="dnamee" value="<?php echo $result['dnamee'] ?>" required><br>
					<span class = "error"><?php echo $dnameeErr;?></span>
                </div>
			</div>
            
			<div class="form-row">			
				<div class="form-group">
                    <label>शिकायत विभाग</label><br>
                    <input type="text" id="hnamep" placeholder="क्षेत्र" name="dnameh" value="<?php echo $result['dnameh'] ?>" required>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>तक्रार विभाग</label><br>
                    <input type="text" id="mnamep" placeholder="तक्रार विभाग" name="dnamem" value="<?php echo $result['dnamem'] ?>" required>
                </div>
			</div>
			
            <div class="form-row">
				<div class="form-group">
                    <label>location</label><br>
                    <input type="text" id="location" placeholder="झोन" name="location" value="<?php echo $result['location'] ?>" required>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
					<label>Select time in days</label><br>
					<select class="form-control" name="tat_id" >
						<option value="" hidden>choose</option>
						
				 <?php while($item_row = pg_fetch_assoc($result2)){
                            echo "<option value='".$item_row['tat_id']."'>".$item_row['time_in_days']."</option>";
                        } ?>
				</select>
                </div>
			</div>
			<div class="text-center">
                <input type="submit" name="submit" value="Update">
            </div>
		</form>
	</div>
	<?php include '../../dashboard_footer.php'; ?>