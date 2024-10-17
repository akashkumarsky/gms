<?php 
//data sent to ajax request
include '../db.php';

if($_POST['type'] == ""){
    $sql = "SELECT * FROM zone_mstr ORDER BY znamee ASC";
    $result = pg_query($conn, $sql);

    $str = "";

    while ($row = pg_fetch_assoc($result)) {
        $str .= "<option value=\"{$row['zone_id']}\">{$row['znamee']}</option>";
    }
    
}else if($_POST['type']=="ward"){
    $sql = "SELECT * FROM ward_mstr WHERE zone_id = {$_POST['id']} ORDER BY wnamee ASC";
    $result = pg_query($conn, $sql);

    $str = "";

    while ($row = pg_fetch_assoc($result)) {
        $str .= "<option value=\"{$row['ward_id']}\">{$row['wnamee']}</option>";
    }
}else if($_POST['type'] == 'dept'){
    $sql = "SELECT * FROM complaint_department_mstr ORDER BY dnamee ASC";
    $result = pg_query($conn, $sql);

    $str = "";

    while ($row = pg_fetch_assoc($result)) {
        $str .= "<option value=\"{$row['dept_id']}\">{$row['dnamee']}</option>";
    }
} else if ($_POST['type'] == 'mode') {
    $sql = "SELECT * FROM complaint_mode_mstr ORDER BY mnamee ASC";
    $result = pg_query($conn, $sql);

    $str = "";

    while ($row = pg_fetch_assoc($result)) {
        $str .= "<option value=\"{$row['mode_id']}\">{$row['mnamee']}</option>";
    }
}
//$str is response data
echo $str;
?>