<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbs = "db_tracker"; 

    date_default_timezone_set('Asia/Jakarta');

    $conn = mysqli_connect($host,$user,$pass,$dbs) or die;
?>