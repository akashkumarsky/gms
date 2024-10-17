<?php include '../dashboard_header.php';
include '../db.php';
if(isset($usertype)){
	if($usertype != $admin){
		header('location:../dashboard.php');
	}
}else{
	header('location:../dashboard.php');
}
$enameErr=$loginErr=$phoneErr=$emailErr='';
$enameCheck=$loginCheck=$phoneCheck=$emailCheck=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   if(empty($_POST["ename"])) {

	   $enameErr = "Please enter complaint in english";
	   $enameCheck=1;

   } else {

	   

	   $ename = test_input($_POST["ename"]);

	   // check if name only contains letters and whitespace

	   if (!preg_match("/^[a-zA-Z-' ]*$/",$ename)) {
		   
	   $enameErr = "Only letters and white space allowed";
	   $ename = '';
	   $enameCheck=1;
	   }
   }

   if(empty($_POST["login_name"])) {

	$loginErr = "Please enter complaint in english";
	$loginCheck=1;

} else {

	

	$login_name = test_input($_POST["login_name"]);

	// check if name only contains letters and whitespace

	if (!preg_match("/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/",$login_name)) {
		
	$loginErr = "Enter valid login name";
	$login_name = '';
	$loginCheck=1;
	}
}

if (!empty($_POST['phone_no'])) {

	$phone_no = $_POST['phone_no'];

	if (preg_match("/^[0-9]{10}$/", $phone_no)) {

			$_SESSION['phone_no'] = $phone_no;
			$_SESSION['otp'] = rand(1234, 9876);
			header('location: verify_otp.php');

	} else {

		$phoneErr = "Only 10 digit numbers allowed";
		$phone_no='';
		$phoneCheck=1;
	}
} else {
	$phoneErr = "Please enter Phone number";
	$phoneCheck=1;
}

if (empty($_POST["email"])) {

	$emailErr = "valid Email address";
	$emailCheck=1;

} else {

	$email = $_POST["email"];

	// check if e-mail address is well-formed

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

	$emailErr = "The email address is incorrect";
	$email = '';
	$emailCheck=1;
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
<div class="config">
	<a class="back_btn" href="dashboard.php" ><i class="fa-solid fa-angle-left"></i></a>
	<h3>Employee Master</h3>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			
            <div class="form-row">
				<div class="form-group">
                    <label>Employee Name</label><br>
                    <input type="text" id="emp" placeholder="Name" name="ename" required> <br>
					<span class = "error"><?php echo $enameErr;?></span>
                </div>
			</div>
			<div class="form-row">			
				<div class="form-group">
                    <label>Login Name</label><br>
                    <input type="text" id="login" placeholder="Login Name" name="login_name" required><br>
					<span class = "error"><?php echo $loginErr;?></span>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>Phone No</label><br>
                    <input type="text" id="num" placeholder="phone no" name="phone_no" value="<?php echo $_POST['phone_no'] ?? ''; ?>" required><br>
					<span class = "error"><?php echo $phoneErr;?></span>
                </div>
			</div>
			
            <div class="form-row">
				<div class="form-group">
                    <label>Email</label><br>
                    <input type="text" id="email" placeholder="email" name="email" required><br>
					<span class = "error"><?php echo $emailErr;?></span>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>Password</label><br>
                    <input type="password" id="pass" placeholder="password" name="password" required>
                </div>
			</div>
			<div class="form-row">
				<div class="form-group">
                    <label>User Type</label><br>
                    <select name="usertype" id="" >
						<option value="0" hidden>choose</option>
						<option value="1">admin</option>

						<option value="3">officer</option>
					</select>
                </div>
			</div>
			<div class="text-center">
                <input type="submit" name="submit" value="Add">
            </div>
		</form>
	</div>
	<?php
		
		if(isset($_POST['submit'])) {
			$ename	= pg_escape_string($conn,$_POST['ename']);
            $login_name = pg_escape_string($conn,$_POST['login_name']);
			$phone_no = pg_escape_string($conn,$_POST['phone_no']);
			$email	= pg_escape_string($conn,$_POST['email']);
			$usertype	= pg_escape_string($conn,$_POST['usertype']);
			$password	= pg_escape_string($conn,$_POST['password']);
			$ip = isset($_SERVER['REMOTE_ADDR']);

			if($enameCheck==0&&$loginCheck==0&&$phoneCheck==0) {

			$insertQuery = "INSERT INTO employee (ename,  login_name, phone_no, email, password, ip,usertype) VALUES ('$ename', '$login_name', '$phone_no', '$email', '$password', '$ip', '$usertype')";

			$query = pg_query($conn, $insertQuery);
		}
		}

	?>
	
	<?php 
 include "../dashboard_footer.php";
?>