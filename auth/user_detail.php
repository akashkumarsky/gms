<?php
include '../db.php';
session_start();
$nameErr=$emailErr=$dobErr=$zoneErr=$wardErr='';
$nameCheck=$emailCheck=$dobCheck=$zoneCheck=$wrdErr=0;
if(!isset($_SESSION['phone_no'])){
    header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST["name"])){

        $nameErr="Please enter name in english";
        $nameCheck=1;
    }else{
        $name=test_input($_POST["name"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            
            $nameErr = "Only letters and white space allowed";
            $name = '';
            $nameCheck=1;
            }
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
    if (empty($_POST["dob"])) {

        $dobErr = "Enter DOB";
        $dobCheck=1;

    } else {
        $date = $_POST['dob'];
        if(validateAge($date)){
            $dob = $date;
        }else{
            $dobErr="Applicant must be 18+";
            $dob='';
            $dobCheck=1;
        }
    }
    if (empty($_POST["zone"])) {

        $zoneErr = "Please enter a valid zone";
        $zoneCheck=1;

    } else {

        $zone = test_input($_POST["zone"]);

        // check if name only contains letters and whitespace

        if (!preg_match('/^\d*$/i',$zone)){
            
        $zoneErr = "Invalid zone";
        $zone = '';
        $zoneCheck=1;

        }
    }
    if (empty($_POST["ward"])) {

        $wardErr = "Please enter a valid ward";
        $wardCheck=1;

    } else {

        $ward = test_input($_POST["ward"]);

        // check if name only contains letters and whitespace

        if (!preg_match('/^\d*$/i',$ward)){
            
        $wardErr = "Invalid ward";
        $ward = '';
        $wardCheck=1;

        }
    }
}

function test_input($data) {

    $data = trim($data);
    
    $data = stripslashes($data);
    
    $data = htmlspecialchars($data);
    
    return $data;
    
    }

    function validateAge($birthday, $age = 18)
    {
        // $birthday can be UNIX_TIMESTAMP or just a string-date.
        if (is_string($birthday)) {
            $birthday = strtotime($birthday);
        }
    
        // check
        // 31536000 is the number of seconds in a 365 days year.
        if (time() - $birthday < $age * 31536000) {
            return false;
        }
    
        return true;
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
					<h2>User Login</h2>
					<form action="" method="POST">
						<div class="inputBox">
							<input type="text" name="name" placeholder="Name" required>
                            <span class = "error"><?php echo $nameErr;?></span>
						</div>
                        <div class="inputBox">
							<input type="text" name="email" placeholder="Email Id" required>
                            <span class = "error"><?php echo $emailErr;?></span>
						</div>
                        <div class="inputBox">
							<input type="text" name="phone" value="<?php echo $_SESSION['phone_no'] ?? '' ?>" placeholder="Phone No." required>
						</div>
                        <div class="inputBox">
							<input type="text" name="dob" placeholder="Date of Birth" onfocus="(this.type='date')"
                            onblur="(this.type='text')" max="<?php echo date('Y-m-d',strtotime('18 years ago'));?>" required>
                            <span class = "error"><?php echo $dobErr;?></span>
						</div>
                        <div class="inputBox">
                            <select name="zone" id="zone" required>
                                <option value="" disabled selected hidden>Zone</option>
                            </select>
                            <select name="ward" id="ward">
                                <option value="" disabled selected hidden>Ward</option>
                            </select>
                            <span class = "error"><?php echo $zoneErr;?></span>
                            <span class = "error"><?php echo $wardErr;?></span>

                        </div>
						<div class="inputBox">
							<input type="submit" name="register" value="Submit">
						</div>
                        <small><?php echo $msg ?? '' ?></small>                        
					</form>
				</div>
                <?php
                include '../db.php';
                function getId($name)
{
    $id_query = pg_query("SELECT type_id FROM usertype WHERE LOWER(type) = LOWER('$name')");
    $id_result = pg_fetch_row($id_query);
    return $id_result[0];
}
    if (isset($_POST['register'])) {
        //print_r($_POST);
        //usertype id for citizen = 3 ; officer = 2 ; admin = 1
        $citizen = getId('citizen');
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $zone = $_POST['zone'];
        $ward = $_POST['ward'];
        //system
        date_default_timezone_set('Asia/Kolkata');
        $event_datetime = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];

        if($nameCheck==0&&$emailCheck==0&&$dobCheck==0&&$zoneCheck==0&&$wardCheck==0){
        $insert_sql = "INSERT INTO users (name, phone_no, email, zone_id, ward_id, dob, event_datetime, ip, usertype) 
        VALUES('$name', '$phone', '$email', '$zone', '$ward', '$dob', '$event_datetime', '$ip', 
        $citizen) RETURNING user_id";

        $result = pg_query($conn, $insert_sql);
        $insert_row = pg_fetch_row($result);
        if($insert_row[0]) {
            $_SESSION['user_id'] = $insert_row[0];
            $_SESSION['usertype'] = $citizen;
            $_SESSION['username'] = $name;
            header('location:../dashboard.php');
        }
    }
}
                ?>
			</div>
		</div>
	</section>

    <script>
        $(document).ready(function() {
            function loadData(type, cat_id) {
                $.ajax({
                    url: "data.php",
                    type: "POST",
                    data: {
                        type: type,
                        id: cat_id
                    },
                    success: function(data) {
                        if (type == 'ward') {
                            $("#ward").append(data);
                        } else {
                            $("#zone").append(data);
                        }
                    }
                });
            }

            loadData();

            $("#zone").on("change", function() {
                var zone = $("#zone").val();

                loadData('ward', zone);
            });
        });
    </script>
</body>
</html>