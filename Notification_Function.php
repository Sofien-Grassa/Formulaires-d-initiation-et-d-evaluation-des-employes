
<?php
/* Database connection start */
date_default_timezone_set('Europe/Paris'); 

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "stipdb";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
 mysqli_set_charset($conn,"utf8");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="css/notifi.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	
</head>
<?php

     

$output = '';

 //$sql = "SELECT T.`ID`,T.Mle,T.Nom,T2.Date_F,T.Active FROM t_atms T,t_atms_details T2 WHERE T2.`Date_F` IN (SELECT MAX(D.Date_F) Date_max FROM t_atms_details D WHERE T.ID=D.ID_ATMS) AND T.Active!=0 AND Date_F < CURDATE() GROUP BY T.`ID`";
//query optimiser
 $sql="SELECT `ID_ATMS`,t_atms.Mle,t_atms.Nom,MAX(`Date_F`) Date_F ,t_atms.Active FROM `t_atms_details`,t_atms WHERE ID_ATMS=t_atms.ID AND t_atms.Active !=0  GROUP BY t_atms.Mle,t_atms.Nom HAVING Date_F < CURDATE()";
 //echo($sql);
 $result = mysqli_query($conn, $sql);  

 $rows = mysqli_num_rows($result);
 
 $output .='
 <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
 <span class="badge "></span><i class="fas fa-bell"></i> <span class="num ">'.$rows.'</span>

</button>
 
<ul class="dropdown-menu danger" aria-labelledby="dropdownMenuButton1">
<div class="list-group">

';
              while($row = mysqli_fetch_array($result))  
      {
        $output .='  
        <li>
  <a href="#" class="list-group-item list-group-item-action" aria-current="true">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">L'.$row['Nom'] .'</h5>
      <small>'.$row['Mle'].'</small>
    </div>
    <p class="mb-1">'.$row['Date_F'].'</p>
    <small>Expirée</small>
  </a>
       

                </li>  
                ';
    }
    
    //<a class="dropdown-item " href="#"><span class="badge bg-danger ">'.$row['Mle'].': '.$row['Nom'] .'- '.$row['Date_F'].'</span></a>
 $output .='   </div>
    </ul>
    ';
    echo $output;
?>
       

</body>
</html>