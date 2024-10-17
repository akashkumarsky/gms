<?php include '../../dashboard_header.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
        include '../../db.php';
      

        if(isset($_GET['id'])){
			$zone_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM zone_mstr where zone_id = $zone_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);
    ?>
    <div class="config">
    <a class="back_btn" href="configure/zone_mstr/zone_list.php"><i class="fa-solid fa-angle-left"></i></a>
        <h3>Zone Details</h3>
		<form class="details" action="">
            <div class="form-row">			
				<div class="form-group lg">
                    <label>Zone ID</label>
                    <input type="text" id="zoneid" name="zone_id" value="<?php echo $result['zone_id'] ?>" readonly>
                </div>
                
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>Zone</label><br>
                    <input type="text" id="enamep" name="znamee" value="<?php echo $result['znamee'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>प्राथमिकता</label>
                    <input type="text" id="hnamep" name="znameh" value="<?php echo $result['znameh'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>प्राधान्य</label><br>
                    <input type="text" id="mnamep" name="znamem" value="<?php echo $result['znamem'] ?>" readonly>
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