<?php
/* Database connection start */
date_default_timezone_set('Europe/Paris'); 

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "stipdb";
//$dbname = "stipdb_test";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

 mysqli_set_charset($conn,"utf8");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>