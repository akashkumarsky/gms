<?php
session_start();

include '../db.php';

echo $_SESSION['otp'] ?? '';
$otpErr = "";

$phone =  $_SESSION['phone_no'] ?? '';
$phone = intval($phone);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['submit'])) {

			unset($_POST['submit']);
			$user_otp = intval(join("", $_POST));
			
			if (preg_match("/^\d{4}$/", $user_otp)) {

				if ($user_otp == $_SESSION['otp']) {

					unset($_SESSION['otp']);

					$sql = "SELECT user_id,name, usertype FROM users WHERE phone_no = '$phone'";
					$result = pg_query($conn, $sql);
					$result = pg_fetch_assoc($result);

					if ($result['user_id']) {
						//redirect user to user dashboard
						$_SESSION['username'] = $result['name'];
						$_SESSION['user_id'] = $result['user_id'];
						$_SESSION['usertype'] = $result['usertype'];
						header('location: ../dashboard.php');
					} else {

						//redirect user to user detail form
						header('location:user_detail.php');
					}
				}
			}
	} else {
		$otpErr = "Please enter otp!";
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
					<h2>Enter OTP</h2>
					<form action=""  method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
						<div class="inputgrp">
							<input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
							<input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
							<input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
							<input type="text" id="digit-4" name="digit-4" data-previous="digit-3" />
						</div>
						<div class="inputBox center">
							<input type="submit" name="submit" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="script.js"></script>
</body>

</html>