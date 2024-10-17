<?php 
    include "../../dashboard_header.php";
    include '../../db.php';

if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
       $ip = $_SERVER['REMOTE_ADDR'];
        
        if(isset($_GET['id'])){
            $mode_id = $_GET['id'];
        }

        $username = "Sourav";
        $selectQuery = "SELECT * FROM complaint_mode_mstr where mode_id = $mode_id";
        $query = pg_query($conn, $selectQuery);

        $result = pg_fetch_assoc($query);
	?>

<div class="config">
<a class="back_btn" href="configure/complaint_mode_mstr/mode_list.php"><i class="fa-solid fa-angle-left"></i></a>
<h3>Details</h3>
		<form class="details" action="">
        <div class="form-row">			
				<div class="form-group lg">
                    <label>Mode ID</label>
                    <input type="text" name="mode_id"  value="<?php echo $result['mode_id'] ?>" readonly>
                </div>
                
			</div>
            
			<div class="form-row">
                <div class="form-group lg">
                    <label>Complaint Mode</label>
                    <input type="text" name="mnamee"  value="<?php echo $result['mnamee'] ?>" readonly>
                </div>
            </div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>शिकायत मोड</label>
                    <input type="text" name="mnameh"  value="<?php echo $result['mnameh'] ?>" readonly>
                </div>
			</div>
            <div class="form-row">			
				<div class="form-group lg">
                    <label>तक्रार मोड</label>
                    <input type="text" name="mnamem"  value="<?php echo $result['mnamem'] ?>" readonly>
                </div>
			</div>
            <div class="form-row">			
				<div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username"  value="<?php echo $result['username'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label>IP Address</label>
                    <input type="text" name="ip"  value="<?php echo $result['ip'] ?>" readonly>
                </div>
            </div>
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Timestamp</label>
                    <input type="text" name="event_datetime"  value="<?php echo $result['event_datetime'] ?>" readonly>
                </div>
            </div>
            
		</form>
	</div>
    <?php
 include "../../dashboard_footer.php";
?>