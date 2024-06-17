<?php
    $connect = mysqli_connect("localhost", "root", "root", "stipdb");
    extract($_POST);
    $sql = "DELETE FROM t_fi001_detail WHERE id = '$id'";  
    (mysqli_query($connect, $sql));  
    
 
?>