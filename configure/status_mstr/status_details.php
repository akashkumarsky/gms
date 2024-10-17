<?php include '../../dashboard_header.php'; 
        include '../../db.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
        if(isset($_GET['id'])){
			$status_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM complaint_status_mstr where status_id = $status_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);
    ?>
    <div class="config">
    <a class="back_btn" href="configure/status_mstr/status_list.php"><i class="fa-solid fa-angle-left"></i></a>
        <h3>Complaint Status Details</h3>
		<form class="details" action="">
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Status ID</label>
                    <input type="text" id="statusid" name="status_id" value="<?php echo $result['status_id'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>Complaint Status</label>
                    <input type="text" id="enames" name="snamee" value="<?php echo $result['snamee'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>शिकायत की स्थिति</label>
                    <input type="text" id="hnames" name="snameh" value="<?php echo $result['snameh'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>तक्रारीची स्थिती</label>
                    <input type="text" id="mnames" name="snamem" value="<?php echo $result['snamem'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $result['username'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label>IP Address</label>
                    <input type="text" id="ip" name="ip" value="<?php echo $result['ip'] ?>" readonly>
                </div>
			</div>
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Timestamp</label>
                    <input type="text" id="timestamp" name="event_datetime" value="<?php echo $result['event_datetime'] ?>" readonly>
                </div>
			</div>
            <?php
 include "../../dashboard_footer.php";
?>