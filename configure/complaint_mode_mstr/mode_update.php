<?php 
 include "../../dashboard_header.php";
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
		include '../../db.php';

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
        $status_sql = "SELECT status_id, snamee FROM complaint_status_mstr";
		$result1 = pg_query($conn, $status_sql);


       $ip = $_SERVER['REMOTE_ADDR'];
        
        if(isset($_GET['id'])){
            $mode_id = $_GET['id'];
        }

        
        
        $selectQuery = "SELECT * FROM complaint_mode_mstr where mode_id = $mode_id";
        $query = pg_query($conn, $selectQuery);

        $result = pg_fetch_assoc($query);

		if(isset($_POST['submit'])) {
			$mnamee = pg_escape_string($conn,$_POST['mnamee']);
			$mnameh = pg_escape_string($conn,$_POST['mnameh']);
            $mnamem = pg_escape_string($conn,$_POST['mnamem']);
           

            if($mnameeCheck==0) {

            $updateQuery = "UPDATE complaint_mode_mstr SET mode_id = $mode_id, mnamee = '$mnamee', mnameh = '$mnameh', mnamem = '$mnamem',  ip = '$ip', username='$username' WHERE mode_id = $mode_id";

			$query = pg_query($conn, $updateQuery);

			if($query) {
				echo"<script>location.href = 'configure/complaint_mode_mstr/mode_list.php';</script>";
			}
			else {
				echo "Data insertion failed";
			}
		}}
	?>

<div class="config">
<a class="back_btn" href="configure/complaint_mode_mstr/mode_list.php"><i class="fa-solid fa-angle-left"></i></a>
<h3>Update</h3>
		<form action="" method="POST">
			<div class="form-row">
                <div class="form-group">
                    <label>Enter complaint mode</label>
                    <input type="text" name="mnamee" value="<?php echo $result['mnamee'] ?>" required><br>
                    <span class = "error"><?php echo $mnameeErr;?></span>
                
                </div>
            </div>
			<div class="form-row">			
				<div class="form-group">
                    <label>शिकायत मोड दर्ज करें.</label>
                    <input type="text" name="mnameh"  value="<?php echo $result['mnameh'] ?>" required>
                </div>
			</div>
            <div class="form-row">			
				<div class="form-group">
                    <label>तक्रार मोड प्रविष्ट करा</label>
                    <input type="text" name="mnamem"  value="<?php echo $result['mnamem'] ?>" required>
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