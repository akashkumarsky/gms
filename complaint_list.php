<?php 
include 'dashboard_header.php';
include 'db.php';
//SHOW STATUS JOIN TABLE WITH STATUS
//CHECK TAT
include 'check_tat.php';

switch ($usertype) {
    case $admin :
        $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id";
        break;
    case $officer :
        $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.dept_id = $user_dept";
        break;
    case $citizen :
        $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.applicant_id = $user_id";
        break;
}
$result = pg_query($conn, $sql);
//for search 
if (isset($_POST['search'])) {
    $key = pg_escape_string($_POST['key']);
    $key = strtolower($key);
    $key = "%{$key}%";
    switch ($usertype) {
        case $admin:
            $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE LOWER(c.applicant_name) LIKE '$key' OR LOWER(c.complaint_head) LIKE '$key' OR LOWER(c.complaint_body) LIKE '$key'";
            break;
        case $officer :
            $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.dept_id = $user_dept AND LOWER(c.applicant_name) LIKE '$key' OR LOWER(c.complaint_head) LIKE '$key' OR LOWER(c.complaint_body) LIKE '$key'";
            break;
        case $citizen :
            $sql = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.applicant_id = $user_id AND LOWER(c.applicant_name) LIKE '$key' OR LOWER(c.complaint_head) LIKE '$key' OR LOWER(c.complaint_body) LIKE '$key'";
            break;
    }
    $result = pg_query($sql);
}

if (isset($_POST['submit'])) {
    //for Date and Dept query
    if (!empty($_POST['dept']) && !empty($_POST['dateTo'])) {
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        $dept_id = $_POST['dept'];
        switch ($usertype) {
            case $admin :
                $sql_date_dept = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.dept_id = $dept_id AND c.event_datetime BETWEEN '$dateFrom' AND '$dateTo'";
                break;
                // case 2: $sql_date = "SELECT * FROM complaint_details WHERE dept_id = $user_dept AND event_datetime BETWEEN '$dateFrom' AND '$dateTo'";
                break;
            case $citizen :
                $sql_date_dept = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.applicant_id = $user_id AND c.dept_id = $dept_id AND c.event_datetime BETWEEN '$dateFrom' AND '$dateTo'";
                break;
        }
        $result = pg_query($conn, $sql_date_dept);
    }
    //for date query
    if (!empty($_POST['dateTo'])) {
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        switch ($usertype) {
            case $admin :
                $sql_date = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.event_datetime BETWEEN '$dateFrom' AND '$dateTo'";
                break;

            case $officer :
                $sql_date = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.dept_id = $user_dept AND c.event_datetime BETWEEN '$dateFrom' AND '$dateTo'";
                break;
            case $citizen :
                $sql_date = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.applicant_id = $user_id AND c.event_datetime BETWEEN '$dateFrom' AND '$dateTo'";
                break;
        }
        $result = pg_query($conn, $sql_date);
    }
    //for department query
    if (!empty($_POST['dept'])) {

        $dept_id = $_POST['dept'];
        switch ($usertype) {
            case $admin :
                $sql_dept = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.dept_id = $dept_id";
                break;

            case $officer :
                $sql_dept = "";
                break;
            case $citizen :
                $sql_dept = "SELECT c.*, s.snamee FROM complaint_details c INNER JOIN complaint_status_mstr s ON c.status_id = s.status_id WHERE c.applicant_id = $user_id AND c.dept_id = '$dept_id'";
                break;
        }
        $result = pg_query($conn, $sql_dept);
    }
}
?>
    <div class="list_main">
    <h1>Complaint List</h1>
        <div class="register">
            <form action="" method="POST">
                <input class="search" type="text" name="key" placeholder="Type keyword...">
                <button class="searchBtn" type="submit" name="search" value="search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <form action="" method="POST">
                <!-- <label class="lbl" for="dateFrom">Date From : </label> -->
                <input class="mini-bar" type="text" name="dateFrom" placeholder="Date From" onfocus="(this.type='date')" onblur="(this.type='text')">
                <!-- <label class="lbl" for="dateTo">Date To : </label> -->
                <input class="mini-bar" type="text" name="dateTo" placeholder="Date To" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
                <?php if ($user_dept == null) { ?>
                <!-- <label class="lbl" for="dept">Department</label> -->
                    <select style="color:grey;" class="bar" name="dept" id="">
                        <option value="" selected>Choose Department...</option>
                        <?php
                        $dept_sql = "SELECT dept_id, dnamee FROM complaint_department_mstr ORDER BY dnamee ASC";
                        $dept_result = pg_query($conn, $dept_sql);
                        while ($dept_row = pg_fetch_assoc($dept_result)) {
                            echo "<option value=\"{$dept_row['dept_id']}\">{$dept_row['dnamee']}</option>";
                        }
                    }
                        ?>
                    </select>
                <br>
                <button class="submit" type="submit" name="submit" value="submit">Find</button>
            </form>
        </div>
        
            <table>
                <thead id="header">
                    <th>#</th>
                    <th>Applicant Name</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>View</th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                    while($row = pg_fetch_assoc($result)) {
                        
                        echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['applicant_name']}</td>
                            <td>{$row['complaint_head']}</td>
                            <td>{$row['event_datetime']}</td>
                            <td>{$row['snamee']}</td>
                            <td><a href=\"complaint_view.php?id={$row['complaint_id']}\">View</a></td>
                        </tr>";
                        $i++;
                    }
                ?>
                </tbody>
                
            </table>    
                </div>
<?php include 'dashboard_footer.php'; ?>
