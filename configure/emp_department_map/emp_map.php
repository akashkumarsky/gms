<?php
include '../../dashboard_header.php';
if (isset($usertype)) {
    if ($usertype != $admin) {
        header('location:../dashboard.php');
    }
} else {
    header('location:../dashboard.php');
}
    include '../../db.php';

    $dept_sql = "SELECT dept_id, dnamee FROM complaint_department_mstr";
    $result1 = pg_query($conn, $dept_sql);

    $emp_sql = "SELECT emp_id, ename FROM employee";
    $result2 = pg_query($conn, $emp_sql);

    $sql = "SELECT z.znamee, z.zone_id, w.wnamee, w.ward_id FROM zone_mstr z INNER JOIN ward_mstr w ON w.zone_id = z.zone_id ORDER BY z.zone_id";
    $result = pg_query($sql);
    $rows = pg_fetch_all($result);

    $str = "INSERT INTO emp_department_map(ward_id, zone_id,emp_id, dept_id, username, ip) VALUES";

    if (isset($_POST['submit'])) {

        $temp = $_POST;
        $ip = $_SERVER['REMOTE_ADDR'];
        $emp = $_POST['emp'];
        $dept = $_POST['dept'];

        unset($temp['emp']);
        unset($temp['dept']);
        unset($temp['submit']);

        foreach ($temp as $z) {
            //for looping zone
            if (!is_array($z)) {
                $zone = $z;
            }
            //for looping ward
            if (is_array($z)) {
                foreach ($z as $w) {
                    $str .= "({$w},{$zone},{$emp},{$dept}, '$username','$ip'),";
                }
            }
        }
        //remove the last coma
        $str = rtrim($str, ",");
        $result = pg_query($conn, $str);
    }
?>

    <style>
        .check {
            width: 80%;
        }

        .mapp {


            margin-left: 30%;
        }

        .sub {
            width: 90%;
            padding: 1%;
            margin: 1% 0%;

            border-radius: 5px;
            background: #11101D;
            font-size: 1em;
            color: #fff;

        }

        .sub1 {
            width: 90%;
            padding: 1%;
            margin: 1% 0%;

            border-radius: 5px;

            font-size: 1em;
            color: #fff;

        }
    </style>
    <div class="config">
        <a class="back_btn" href="#"><i class="fa-solid fa-angle-left"></i></a>
        <h3>Employee Mapping</h3>
        <form class="mapp" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Employee</label><br>
                    <select name="emp" id="emp">
                        <option selected hidden>Choose...</option>
                        <?php while ($emp_row = pg_fetch_assoc($result2)) {
                            echo "<option value='" . $emp_row['emp_id'] . "'>" . $emp_row['ename'] . "</option>";
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Department</label><br>
                    <select name="dept" id="dept">
                        <option selected hidden>Choose...</option>
                        <?php while ($item_row = pg_fetch_assoc($result1)) {
                            echo "<option value='" . $item_row['dept_id'] . "'>" . $item_row['dnamee'] . "</option>";
                        } ?>
                    </select>
                </div>


            </div>
            <div class="check">
                <?php
                $name = '';
                $id = '';
                $i = 0;
                foreach ($rows as $k) {
                    if ($k['znamee'] != $name) {
                        ++$i;
                        if ($k['zone_id'] != $id) {
                            echo "<hr><br><input type=\"checkbox\" class=\"mapp1\" name=\"zone{$i}\" value=\"{$k['zone_id']}\"><label for=\"zone\">{$k['znamee']}</label><br>";
                            $id = $k['zone_id'];
                        }
                        $name = $k['znamee'];
                        echo "<b>Choose Ward</b><br>";
                    }
                    if ($k['wnamee']) {
                        if ($k['ward_id']) {
                            echo "<input type=\"checkbox\" class=\"mapp\" name=\"ward{$i}[]\" id=\"\" value=\"{$k['ward_id']}\"><label for=\"ward1\">{$k['wnamee']}</label><br>";
                        }
                    }
                }
                ?>
            </div>

            <br>
            <button name="submit" class="sub" type="submit" value="submit">Submit</button>
        </form>
    <?php
include "../../dashboard_footer.php";
    ?>