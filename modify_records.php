<?php
    $connect = mysqli_connect("localhost", "root", "root", "stipdb");
    
    if(isset($_POST['edit_row']))
{
    extract($_POST);
 mysql_query("update t_fi001_detail set date_debut	='$debut',date_fin='$fin',objet='$objet' ,lieu	='$lieu',formateur	='$formateur'   where id='$row_id'");
 echo "success";
 exit();
}
 
?>