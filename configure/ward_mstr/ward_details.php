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
			$ward_id = $_GET['id'];
		}   
		$ip = $_SERVER['REMOTE_ADDR'];    
		
        $selectQuery = "SELECT * FROM ward_mstr where ward_id = $ward_id";
        $query = pg_query($conn, $selectQuery);
        $result = pg_fetch_assoc($query);
    ?>
    <div class="config">
    <a class="back_btn" href="configure/ward_mstr/ward_list.php"><i class="fa-solid fa-angle-left"></i></a>
        <h3>Ward Details</h3>
		<form class="details" action="">
            <div class="form-row">			
				<div class="form-group ">
                    <label>Zone ID</label>
                    <input type="text" id="zoneid" name="zone_id" value="<?php echo $result['zone_id'] ?>" readonly>
                </div>
                
			
			
            <div class="form-group">
                    <label>ward id</label>
                    <input type="text" id="ward_id" name="ward_id" value="<?php echo $result['ward_id'] ?>" readonly>
                </div>	</div>
                <div class="form-row">		
				<div class="form-group lg">
                    <label>Ward</label><br>
                    <input type="text" id="enamep" name="wnamee" value="<?php echo $result['wnamee'] ?>" readonly>
                </div>   
			</div>
			
            <div class="form-row">			
				<div class="form-group lg">
                    <label>वार्ड</label><br>
                    <input type="text" id="wnameh" name="wnameh" value="<?php echo $result['wnameh'] ?>" readonly>
                </div>
			</div>
            
            <div class="form-row">			
				<div class="form-group lg">
                    <label>प्रभाग</label><br>
                    <input type="text" id="wnameh" name="wnamem" value="<?php echo $result['wnamem'] ?>" readonly>
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