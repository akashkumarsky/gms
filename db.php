<?php
    $server="localhost";
    $uname="postgres";
    $password="123";
    $dbname="gmsdb";

    $dns = "host=$server dbname=$dbname user=$uname password=$password";
    $conn=pg_connect($dns);

    if(!$conn) {
        echo "Connection Failed";
    }
?>