<?php
    $connect = mysqli_connect("localhost", "root", "root", "stipdb");
    extract($_POST);
$sql="UPDATE `t_fi001_detail` SET `formateur`='$newformat',`objet`='$newobjet',`lieu` = '$newlieu',`date_debut` = '$newdatedebut',`date_fin` = '$newdatefin' WHERE `t_fi001_detail`.`id` = $id";
   mysqli_query($connect, $sql);
   
?>