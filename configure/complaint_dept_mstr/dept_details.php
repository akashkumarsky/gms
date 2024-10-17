<?php include '../../dashboard_header.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
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
    ?>
    <div class="config">
    <a class="back_btn" href="configure/complaint_dept_mstr/dept_list.php"><i class="fa-solid fa-angle-left"></i></a>
        <h3>depatment Details</h3>
		<form class="details" action="">
            <div class="form-row ">			
				<div class="form-group ">
                    <label>depatment ID</label>
                    <input type="text" id="zoneid" name="dept_id" value="<?php echo $result['dept_id'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label>tat id</label>
                    <input type="text" id="tat" name="tat_id" value="<?php echo $result['tat_id'] ?>" readonly>
                </div>
                </div>
               
			
                <div class="form-row ">	
				<div class="form-group lg">
                    <label>location</label>
                    <input type="text" id="location" name="location" value="<?php echo $result['location'] ?>" readonly>
                </div>
                </div>
                
				<div class="form-row ">	
				<div class="form-group lg">
                    <label>depatment</label><br>
                    <input type="text" id="enamep" name="dnamee" value="<?php echo $result['dnamee'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>शिकायत विभाग</label>
                    <input type="text" id="hnamep" name="dnameh" value="<?php echo $result['dnameh'] ?>" readonly>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group lg">
                    <label>तक्रार विभाग</label><br>
                    <input type="text" id="mnamep" name="dnamem" value="<?php echo $result['dnamem'] ?>" readonly>
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
            <?php include '../../dashboard_footer.php'; ?>