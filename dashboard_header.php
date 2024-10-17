<?php
include 'db.php';
include 'session_variable.php';
$user_dept = 15;
if (!isset($_SESSION['username'])) {
  header('location:http://localhost/tms/auth/login.php');
}
$user_dept = $_SESSION['dept_id'] ?? '';
if (empty($user_dept)) {
  $recipient = "reciept_id = {$usertype}";
} else {
  $recipient = "dept_id = {$user_dept}";
}

$noti_sql = "SELECT message, reference_id FROM notification_tbl WHERE {$recipient} AND unread = true";
$submit = pg_query($noti_sql);
$noti_result = pg_fetch_all($submit);
$count = count($noti_result);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ticket Management System</title>
  <base href="http://localhost/tms/">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="configure_style.css">
  <link rel="stylesheet" href="complaint_form.css">
  <link rel="stylesheet" href="complaint_list.css">
  <link rel="stylesheet" href="complaint_view.css">
  <link rel="stylesheet" href="error/error_style.css">
  <link rel="stylesheet" href="notiTry.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="sidebar close">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">TMS</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="dashboard.php">
          <i class='bx bx-grid-alt'></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="dashboard.php">Dashboard</a></li>
        </ul>
      </li>
      <li>
        <a href="complaint_registration.php">
          <i class='bx bx-book-alt'></i>
          <span class="link_name">Complaint Registeration</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="complaint_registration.php">Complaint Registeration</a></li>
        </ul>
      </li>
      <?php if ($usertype == $admin) { ?>
        <li class="drop">
          <div class="icon-link">
            <a>
              <i class='bx bx-collection'></i>
              <span class="link_name">Configure</span>
            </a>
            <i class='bx bxs-chevron-down arrow'></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name">Configure</a></li>
            <li><a href="configure/complaint_priority_mstr/priority_list.php">Priority Master</a></li>
            <li><a href="configure/complaint_mode_mstr/mode_list.php">Mode Master</a></li>
            <li><a href="configure/zone_mstr/zone_list.php">Zone Master</a></li>
            <li><a href="configure/ward_mstr/ward_list.php">Ward Master</a></li>
            <li><a href="configure/complaint_dept_mstr/dept_list.php">Department Master</a></li>
            <li><a href="configure/complaint_time_mstr/time_list.php">Time Master</a></li>
            <li><a href="configure/status_mstr/status_list.php">Status Master</a></li>
          </ul>
        </li>
        <li class="drop">
          <div class="icon-link">
            <a>
              <i class='bx bx-edit'></i>
              <span class="link_name">Configure Employee</span>
            </a>
            <i class='bx bxs-chevron-down arrow'></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name">Configure Employee</a></li>
            <li><a href="auth/employee.php">Add Employee</a></li>
            <li><a href="configure/emp_department_map/emp_map.php">Employee Map</a></li>
            <li><a href="configure/emp_department_map/emp_list.php">Employee List</a></li>
            <li><a href="configure/emp_department_map/emp_delete.php">Employee Delete</a></li>
          </ul>
        </li>
      <?php } ?>
      <li>
        <div class="icon-link">
          <a>
            <i class='bx bx-line-chart'></i>
            <span class="link_name">Report</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name">Report</a></li>
          <li><a href="complaint_list.php">Complaint List</a></li>
          <li><a href="pending_list.php">Pending List</a></li>
          <li><a href="expired_list.php">Expired List</a></li>
        </ul>
      </li>
    </ul>
  </div>

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu'></i>
        <span class="text">Dashboard</span>
      </div>
      <!-- Dropdown Notification -->
      <a class="notify-btn" onclick="myFunction()">&#128276;<span><?php echo "{$count}"; ?></span></a>

      <div id="myDIV">
        <ul>
          <?php
          if (empty($user_dept)) {
            $reci = "{$user_id}";
          } else {
            $reci = "{$user_dept}";
          }
          foreach ($noti_result as $noti) {
            echo "<li><a href=\"complaint_view.php?id={$noti['reference_id']}&u={$reci}\">{$noti['message']}</</a></li><hr>";
          }
          ?>

        </ul>
      </div>
      <!-- Dropdown Notification End -->

      <div class="profile-details">
        <span class="admin_name"><?php echo $_SESSION['username'] ?? 'vikasOra'; ?></span>
        <span><a href="auth/logout.php">Log Out</a></span>
      </div>
    </nav>