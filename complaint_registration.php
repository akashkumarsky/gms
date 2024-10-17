<?php include 'dashboard_header.php';
 //session start();
include 'db.php';

if (!isset($usertype)) {
    header('location:dashboard.php');
}

date_default_timezone_set('Asia/Kolkata');
$event_datetime = date('Y-m-d H:i:s');

//CALCULATE TIMEOUT DATE RELATIVE TO DEPT
function timeout($id, $today)
{
    $tat_result = pg_query("SELECT t.time_in_days FROM complaint_department_mstr c INNER JOIN complaint_time_mstr t ON c.tat_id = t.tat_id WHERE dept_id = $id");

    $tat_row = pg_fetch_row($tat_result);
    $days = $tat_row[0];

    //$end_date = date("Y-m-d 23:59:59", strtotime('+3 days', strtotime($start_date)));
    $day = "+{$days} days";
    return date("Y-m-d 23:59:59", strtotime($day, strtotime($today)));
    
}
function getStatusId($name)
{
    $status_query = pg_query("SELECT status_id FROM complaint_status_mstr WHERE LOWER(snamee) = LOWER('$name')");
    $status_result = pg_fetch_row($status_query);
    return $status_result[0];
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['submit'])){
        $applicant_name = $_POST['applicant_name'];
        $phone_no = $_POST['phone_no'];
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $mode = $_POST['mode'];
        $zone = $_POST['zone'];
        $ward = $_POST['ward'];
        $dept = $_POST['dept'];
        $timeout = timeout($dept, $event_datetime);
        $status = getStatusId('registered');
        //user_id according to uertype
        if($usertype == 2){
            $applicant = "applicant_id";
        }else{
            $applicant = "agent_id";
        }

        function GetImageExtension($imagetype)
        {
            if (empty($imagetype)) return false;
            switch ($imagetype) {
                case 'application/docx':
                    return '.docx';
                case 'application/doc':
                    return '.doc';
                case 'image/jpeg':
                    return '.jpg';
                case 'image/png':
                    return '.png';
                case 'application/pdf':
                    return '.pdf';
                default:
                    return false;
            }
        }
        if (!empty($_FILES["file"]["name"])) {

            $file_name = $_FILES["file"]["name"];
            $temp_name = $_FILES["file"]["tmp_name"];
            $imgtype = $_FILES["file"]["type"];
            $ext = GetImageExtension($imgtype);
            $imagename = date("d-m-Y") . "-" . time() . $ext;
            $target_path = "files/" . $imagename;
            if (move_uploaded_file($temp_name, $target_path)) {
                $sql = "INSERT INTO complaint_details(applicant_name,phone_no, {$applicant}, complaint_head, complaint_body, mode_id, zone_id, ward_id, event_datetime, file,timeout,dept_id, status_id)
                VALUES('$applicant_name','$phone_no', $user_id, '$subject', '$description', $mode, $zone, $ward, '$event_datetime', '$imagename', '$timeout', $dept, $status) RETURNING complaint_id";
                
                $result = pg_query($conn, $sql);

                //if query failed delete file
            }
        }else{
            $sql = "INSERT INTO complaint_details(applicant_name,phone_no, {$applicant}, complaint_head, complaint_body, mode_id, zone_id, ward_id, event_datetime, timeout, dept_id, status_id)
                VALUES('$applicant_name','$phone_no', $user_id, '$subject', '$description', $mode, $zone, $ward, '$event_datetime', '$timeout', $dept, $status) RETURNING complaint_id";
            
            $result = pg_query($conn, $sql);
        }
    }
    //--------NOTIFICATION CREATION----------
    //check for succesfull insertion
    if (pg_affected_rows($result) == 1) {

        // get insert id from comaplaint insert query
        $row = pg_fetch_row($result);
        $reference = $row[0];

        //get department name
        $dept_sql = "SELECT dnamee FROM complaint_department_mstr WHERE dept_id = $dept";
        $dept_result = pg_query($dept_sql);
        $dept_row = pg_fetch_assoc($dept_result);
        $dept_name = $dept_row['dnamee'];

        $msg = "{$applicant_name} lodged a new complaint in {$dept_name}";

        $notify_sql = "INSERT INTO notification_tbl(reciept_id, sender_id, reference_id, message, dept_id)
        VALUES(1, $user_id, $reference, '$msg', NULL),(NULL, $user_id, $reference, '$msg', $dept)";

        $submit = pg_query($notify_sql);
        header('location:complaint_list.php');
    }
}
?>
        <div class="reg_wrapper">
        <div class="form-container">
            <div class="form">
                <!-- Heading -->
                <div class="heading">
                    <h2>Complaint Registration</h2>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Form Input -->

                    <div class="form-wrap">
                        <div class="form-item">
                            <label>Enter Applicant name</label>
                            <input type="text" name="applicant_name" placeholder="ex. Sourav Das" required>
                        </div>
                    </div>

                    <div class="form-wrap">
                        <div class="form-item">
                            <label>Enter Phone number</label>
                            <input type="text" name="phone_no" placeholder="phone number" required>
                        </div>
                    </div>

                    <div class="form-wrap">
                        <div class="form-item">
                            <label>Enter Subject</label>
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-wrap">
                        <div class="form-item">
                            <label>Description</label>
                            <!-- <textarea rows="6"></textarea> -->
                            <input type="text" name="description" placeholder="Description" required>
                        </div>
                    </div>

                    <!-- Select Box -->
                    <div class="form-wrap select-box">
                        <div class="form-item">
                            <label>Mode</label>
                            <select name="mode" id="mode" required>
                                <option value="" selected hidden>Mode</option>
                            </select>
                        </div>

                        <div class="form-item">
                            <label>Zone</label>
                            <select name="zone" id="zone" required>
                                <option value="" selected hidden>Zone</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-wrap select-box">
                        <div class="form-item">
                            <label>Ward</label>
                            <select name="ward" id="ward" required>
                                <option value="" selected hidden>Ward</option>
                            </select>
                        </div>

                        <div class="form-item">
                            <label>Department</label>
                            <select name="dept" id="dept" required>
                                <option value="" selected hidden>Department</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-wrap">
                        <div class="form-item">
                            <input type="file" name="file">
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="btn">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>    
    
    
<?php include 'dashboard_footer.php'; ?>

