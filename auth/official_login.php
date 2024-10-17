<?php
    
     include '../db.php';
    
    date_default_timezone_set('Asia/Kolkata');
    $event_datetime = date('Y-m-d H:i:s');

    $ip = $_SERVER['REMOTE_ADDR'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['login'])){

            $login_name = pg_escape_string($_POST['login_name']);
            $pw = pg_escape_string($_POST['pw']);

            $sql = "SELECT * FROM employee WHERE login_name = '$login_name'";
            $result = pg_query($conn, $sql);
            
            if(pg_num_rows($result)){
                $result = pg_fetch_assoc($result);
                if($pw == $result['password']){
                    
                    //UPDATE EMPLOYEE TABLE and START SESSION 
                    $update_sql = "UPDATE employee SET event_datetime = '$event_datetime', ip = '$ip' WHERE emp_id = {$result['emp_id']}";
                    $update_result = pg_query($update_sql);

                    if(pg_affected_rows($update_result)){
                        //get employee dept
                         if($result['usertype'] == 3){
                            $emp_dept_sql = "SELECT dept_id FROM emp_department_map WHERE emp_id = {$result['emp_id']} limit 1";
                            $emp_dept = pg_query($conn, $emp_dept_sql);
                            $emp_dept = pg_fetch_row($emp_dept);
                         }
                        session_start();
                        $_SESSION['usertype'] = $result['usertype'];
                        $_SESSION['user_id'] = $result['emp_id'];
                        $_SESSION['username'] = $result['ename'];
                        $_SESSION['dept_id'] = $emp_dept[0];
                        
                        //direct to dashboard
                        header('location: ../dashboard.php');
                    }


                }

            }else {
            echo "invalid credentials";
             }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <section>
		<div class="color"></div>
		<div class="color"></div>
		<div class="color"></div>
		<div class="box">
			<div class="square" style="--i:0;"></div>
			<div class="square" style="--i:1;"></div>
			<div class="square" style="--i:2;"></div>
			<div class="square" style="--i:3;"></div>
			<div class="square" style="--i:4;"></div>
			<div class="container">
				<div class="form">
					<h2>Official Login</h2>
					<form action="" method="POST">
						<div class="inputBox">
							<input type="text" name="login_name" placeholder="Username" required>
						</div>
                        <div class="inputBox">
							<input type="password" name="pw" placeholder="Password" required>
						</div>
						<div class="inputBox">
							<input type="submit" name="login" value="Submit">
						</div>
                        <?php echo $msg ?? '' ?>
                        <a class="alternate" href="login.php">Citizen Login</a>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>

</html>
