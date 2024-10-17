<?php
session_start();
$phoneErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['phone_no'])) {

        $phone_no = $_POST['phone_no'];

        if (preg_match("/^[0-9]{10}$/", $phone_no)) {

                $_SESSION['phone_no'] = $phone_no;
                $_SESSION['otp'] = rand(1234, 9876);
                header('location: verify_otp.php');

        } else {

            $phoneErr = "Only 10 digit numbers allowed";
        }
    } else {
        $phoneErr = "Please enter Phone number";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grievance Model</title>
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
                <?php echo $phoneErr ?? ''; ?>
					<h2>User Login</h2>
					<form action="" method="POST">
						<div class="inputBox">
							<input type="text" placeholder="Phone No." name="phone_no" value="<?php echo $_POST['phone_no'] ?? ''; ?>" required>
						</div>
						<div class="inputBox">
							<input type="submit" value="Generate OTP" name="otp">
						</div>
						<a class="alternate" href="official_login.php">Official Login</a>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>
</html>