
<?php
/* Database connection start */
date_default_timezone_set('Europe/Paris'); 
include 'Effectif_add_function.php';
$Personnel = new Personnel();

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

$Dep ='';
$sqlDep = "SELECT * FROM `t_departements`
WHERE Type ='dep' ORDER BY ID ASC";  
 $resultDep = mysqli_query($conn, $sqlDep);  
 $Dep .='<select name="dep-select" class="dep-select">';
  $Dep .='<option value="" class="isdep"></option>';
while($rowDep = mysqli_fetch_array($resultDep))  {
  $Dep .='<option value="'.$rowDep["ID"].'" class="isdep">'.$rowDep["Nom_Dep"].'</option>';
}
 $Dep .='</select>';



$output = '';


switch($_GET['action']) {


case 'service':
$Service ='';
$sqlService = "SELECT * FROM `t_departements`
WHERE Type ='service' AND ID_dep_Sup=".$_POST["ID"]." ORDER BY ID ASC";  
 $resultService = mysqli_query($conn, $sqlService);  
 $Service .='<select name="service-select" class="service-select">';
  $Service .='<option value=""></option>';
while($rowService = mysqli_fetch_array($resultService))  {
  $Service .='<option value="'.$rowService["ID"].'">'.$rowService["Nom_Dep"].'</option>';
}
 $Service .='</select>';
  echo $Service;
        break;


      case 'select':
      if(!empty($_POST["query"])){
        $sql = "SELECT * FROM t_personnels WHERE CONCAT(Mle, ' ', Nom,' ',Prenom) LIKE '%".$_POST["query"]."%' AND Motif_Sortie IS NULL AND Date_Sortie_Etab IS NULL ORDER BY ID ASC LIMIT 10";  
        //echo $sql;
        }
          else{
              $sql = "SELECT * FROM t_personnels WHERE Motif_Sortie IS NULL AND Date_Sortie_Etab IS NULL ORDER BY ID ASC";  
              //echo $sql;              
              }
 $result = mysqli_query($conn, $sql);  
  
 $uotput .= '  

 
      <div class="table-responsive">  
      <table id="datatable" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
           <thead>
                <tr>  
                     <th width="5%" >ID</th>  
                     <th width="5%" >Mle</th>
                     <th width="10%">Nom</th>
                     <th width="5%" >Fonction</th>
                     <th width="5%" >Position</th>
                     <th width="10%">Qualification</th>
                     <th width="10%">College</th>
                     <th width="10%">Date_Poste</th>
                     <th width="10%">Dep</th>
                     <th width="10%">Service</th>
                     <th width="10%">Ref</th>
                     <th width="10%">Actions</th>                         
                </tr>
                </thead>
                <tbody>';  
                $i=1;
 $rows = mysqli_num_rows($result);
 if($rows > 0)  
 {  
      while($row = mysqli_fetch_array($result))  
      {  
         $sql2 = "SELECT p.* FROM t_postes p 
         WHERE Mle=".$row["Mle"]." AND Active='1' ORDER BY p.ID DESC"; 
         //echo($sql2)."<br>";
         $result2 = mysqli_query($conn, $sql2);
          $row2 = mysqli_fetch_array($result2);
           $output .= '  
                <tr>  
                     <td>'.$i++.'</td>  
                     <td data-id1="'.$row2["ID"].'">'.$row["Mle"].'</td>  
                     <td data-id1="'.$row2["ID"].'">'.$row["Nom"].' '.$row["Prenom"].'</td>  
                     <td data-id1="'.$row2["ID"].'">'.$row2["Fonction"].'</td> 
                     <td data-id1="'.$row2["ID"].'">'.$row2["Position"].'</td>  
                     <td data-id1="'.$row2["ID"].'"><button type="button" class="btn btn-outline" data-title="tooltip" title="'.$row2["Qualification"].'">'.$row2["Qualification"].'</button></td>  
                     <td data-id1="'.$row2["ID"].'">'.$row2["College"].'</td>  
                     <td data-id1="'.$row2["ID"].'">'.$row2["Date_Poste"].'</td>  
                     <td data-id1="'.$row2["ID"].'"><button type="button" class="btn btn-outline" data-title="tooltip" title="'.$row2["Nom_Dep"].'">'.$row2["Nom_Dep"].'</button></td>
                     <td data-id1="'.$row2["ID"].'"><button type="button" class="btn btn-outline" data-title="tooltip" title="'.$row2["Nom_Service"].'">'.$row2["Nom_Service"].'</button></td> 
                     <td data-id1="'.$row2["ID"].'">'.$row2["Ref"].'</td>
                     <td>
                     <div class="btn-group" role="group" aria-label="Basic example">
                        <a role="button" class="btn btn-outline-primary add_details" data-title="tooltip" data-placement="top" title="Ajouter Nouvelle Situation" href="#Prolongation" data="'.$row["Mle"].'">
                        <i class="mdi mdi-note-add"></i></a>
                        <a role="button" class="btn btn-outline-success Historique" data-title="tooltip" data-placement="top" title="Historique" href="#Historique" data="'.$row["Mle"].'">
                        <i class="mdi mdi-history"></i></a>
                      </div>
                      </td>  
                </tr>  
           ';  
      }  
      
 }  
 else  
 {  
      $output .= '
           <tr class="even">  
                <td></td>  
                <td id="Mle" contenteditable></td>  
                <td id="Nom" ></td> 
                <td  tabindex="-1">
                <input type="date" class="form-control" id="Date_1er" placeholder="2020-01-01" value="" required>
                </td>  
                <td id="Type" tabindex="-1">
                <select id="Type">
                  <option value="Contractuel">Contractuel</option>
                  <option value="Occasionnel">Occasionnel</option>
                  <option value="Apprenti">Apprenti</option>
                  <option value="Essai">Essai</option>
                  <option value="SIVP">SIVP</option>
                  <option value="CAIP">CAIP</option>
                </select>
                </td>                   
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-success btn-lg btn-block">+</button></td>  
           </tr> ';  
 }  
 $output .= '</tbody></table>  
      </div>';  
 echo $output;
        break;




      case 'prolongationadd':

$sql0="SELECT * FROM t_postes WHERE Mle='".$_POST["Mle"]."' AND Active='1'";
if(mysqli_query($conn, $sql0))  
{  
  $res=mysqli_query($conn, $sql0);
  while($row = mysqli_fetch_array($res)){
$sqlupdate="UPDATE `t_postes` SET `Active` = '0' WHERE `t_postes`.`ID` = '".$row["ID"]."' AND `t_postes`.`Mle` = '".$row["Mle"]."' ";
  mysqli_query($conn, $sqlupdate);
  }
    
}

$Dep = explode(':', $_POST['Dep'] );
$id_Dep = $Dep[0]; 
$nom_Dep = $Dep[1];
if(!empty($_POST['Ser'])){
$Serv = explode(':', $_POST['Ser'] );
$id_Serv = $Serv[0]; 
$nom_Serv = $Serv[1];
}else {
     $id_Serv = NULL; 
     $nom_Serv = NULL;
}
$sql = "INSERT INTO t_postes(Mle, Fonction, Position,Qualification,College,Active,Date_Poste,Id_Dep, Nom_Dep,Id_Service, Nom_Service, Ref) VALUES('".$_POST["Mle"]."', '".$_POST["Fonction"]."', '".$_POST["Position"]."', '".mysqli_real_escape_string($conn,$_POST["Qualification"])."', '".$_POST["College"]."','1', '".$_POST["Date_Poste"]."', '".$id_Dep."','".$nom_Dep."','".$id_Serv."','".$nom_Serv."','".mysqli_real_escape_string($conn,$_POST["Ref"])."')";  
//echo $sql;
if(mysqli_query($conn, $sql))  
{  
     echo 'Data Inserted';  
}
        break;

      case 'insert':
$sql = "INSERT INTO t_contrat_parent(Mle, Nom, Date_Entree_Etab, Type, Active) VALUES('".$_POST["Mle"]."', '".$_POST["Nom"]."', '".$_POST["Date_1er"]."', '".$_POST["Type"]."' , '1')";  

//echo $sql;
if(mysqli_query($conn, $sql))  
{  
     echo 'Nouveau Contractuel Ajouter';  
}
        break;


case 'delete':
$ID=$_POST["ID"];
  $sql = "UPDATE `t_contrat_parent` SET `Active` = '0' WHERE `t_contrat_parent`.`ID` = '".$ID."'";  
  if(mysqli_query($conn, $sql))  
  {  
    echo 'Data Deleted';  
  }
          break;

      case 'recherche':
      $Mle=$_POST["Mle"];
$sql = "SELECT * FROM t_personnels 
      WHERE Motif_Sortie IS NULL AND Date_Sortie_Etab IS NULL AND Mle='".$Mle."'";  
//echo $sql;
  $result=mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
     echo ($row['Nom'].' '.$row['Prenom']);  

        break;

      case 'Position':
      $Position=$_POST["Position"];
$sql = "SELECT * FROM t_qualification 
      WHERE Position='".$Position."'";  
//echo $sql;
  $result=mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $qualification=$row['Qualification'];
  $qualification=trim($qualification);
     echo ($qualification);  

        break;

      case 'prolongation':
$sql = "INSERT INTO t_contrat_parent(ID, Date_D, Date_F,Duree, Type) VALUES('".$_POST["Mle"]."', '".$_POST["Nom"]."', '".$_POST["Date_1er"]."', '".$_POST["Type"]."')";  
//echo $sql;
if(mysqli_query($conn, $sql))  
{  
     echo 'Data Inserted';  
}
        break;

      case 'Finishquery':
$sql1 = "INSERT INTO t_contrat_details(ID_Contrat_parent, Date_D, Date_F,Jours,Mois,Annee,Qualification, Type, Ref, Date_Ref) VALUES('".$_POST["ID_Qualification"]."', '".$_POST["Date_F"]."', '".$_POST["Date_F"]."', '0','0','0','".$_POST["Qualification"]."','".$_POST["Type"]."','".$_POST["Ref"]."','".$_POST["Date_Ref"]."')";   
//echo $sql1;
  $sql2 = "UPDATE `t_contrat_parent` SET `Active` = '0' WHERE `t_contrat_parent`.`ID` = '".$_POST["ID_Qualification"]."'";  

if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2))  
{  
     echo 'Data Inserted';  
}
        break;

case 'add':
if(!empty($_POST["query"])){
        $searchData = explode(",", $_POST["query"]);
        $searchValues = "'" . implode("', '", $searchData) . "'";
        $sql = "SELECT * FROM t_postes WHERE Mle IN (".$searchValues.") ORDER BY ID DESC";  
        //echo $sql;
        }
          else{
         $sql0 = "SELECT * FROM t_personnels WHERE Mle =".$_GET['Mle']." ORDER BY ID DESC";
          //echo $sql0;
         $result0 = mysqli_query($conn, $sql0);  
         $row0 = mysqli_fetch_array($result0);  
                    
         $sql = "SELECT * FROM t_postes WHERE Mle ='".$_GET['Mle']."' ORDER BY ID ASC";  
              //echo $sql;              
              }
 $result = mysqli_query($conn, $sql);  
 
$output .= '  
<div class="col"><hr></div>

      <div class="table-responsive">
      <a role="button" class="btn btn-outline-primary prev" data-title="tooltip" data-placement="top" title="Revenir En Arrière" href="#prev">
      <i class="mdi mdi-undo"></i>
      </a>
           <table class="table table-striped table-dark" >  
                <tr>  
                     <th width="5%" >ID</th>  
                     <th width="5%" >Mle</th>
                     <th width="10%">Nom</th>
                     <th width="5%" >Date Entre Etab</th> 
                </tr>';  

           $output .= '  
                <tr>  
                     <td id="ID_Qualification">'.$row0["ID"].'</td>  
                     <td class="Mle" data-id1="'.$row0["ID"].'">'.$row0["Mle"].'</td>  
                     <td class="Nom" data-id1="'.$row0["ID"].'">'.$row0["Nom"].'</td>  
                     <td class="Date_1er" data-id1="'.$row0["ID"].'">'.$row0["Date_Entre_Etab"].'</td>  
                </tr>
            </table>';


 
            $output .= '       
           <table class="table table-striped table-bordered dataTable no-footer details" "> 
           <thead> 
                <tr> 
                     <th width="5%" >ID</th>  
                     <th width="5%" >Mle</th>
                     <th width="10%">Nom</th>
                     <th width="5%" >Fonction</th>
                     <th width="5%" >Position</th>
                     <th width="10%">Qualification</th>
                     <th width="5%">College</th>
                     <th width="10%">Date_Poste</th>
                     <th width="10%">Dep</th>
                     <th width="10%">Service</th>
                     <th width="10%">Ref</th>
                     <th width="10%">Actions</th>                        
                </tr>
           </thead>
           <tbody>';  
 $rows = mysqli_num_rows($result);
 if($rows > 0)  
 {  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["ID"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Mle"].'</td> 
                     <td data-id1="'.$row["ID"].'">'.$row0["Nom"].' '.$row0["Prenom"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Fonction"].'</td> 
                     <td data-id1="'.$row["ID"].'">'.$row["Position"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Qualification"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["College"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Date_Poste"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Nom_Dep"].'</td>
                     <td data-id1="'.$row["ID"].'">'.$row["Nom_Service"].'</td>
                     <td data-id1="'.$row["ID"].'">'.$row["Ref"].'</td>                      
                     <td class="Actions"></td>  
                </tr>  
           ';  
      }  
      $output .= '  
           <tr class="even">  
                <td></td>
                <td>'.$row0["Mle"].'</td>
                <td>'.$row0["Nom"].' '.$row0["Prenom"].'</td>
                <td id="Fonction" contenteditable></td>
                <td id="Position" contenteditable></td>
                <td id="Qualification" contenteditable></td>
                <td >
                <select name="College" id="College">
                <option value="Execution">Execution</option>
                <option value="Maitrise">Maitrise</option>
                <option value="Cadre">Cadre</option>
                </td>                
                <td  tabindex="-1" id="blur_Date_F">
                <input type="date" class="form-control" id="Date_Poste" placeholder="2020-01-01" value="" style="width:170px" required>
                </td>                 
                <td> 
               <input class="form-control" list="datalistdep" placeholder="Département"  name="Dep" id="Dep" autocomplete="off">';
                                        $Personnels=$Personnel->getDep();
                                        
               $output.='               
               </td>
                <td>
               <input class="form-control" list="datalistser" placeholder="Service"  name="Ser" id="Ser" autocomplete="off">
               <option value=""></option>	
                </td>
                <td id="Ref" contenteditable></td>
                <td><button type="button" name="btn_add" id="btn_prolongation" class="btn btn-success btn-lg btn-block" data-id1="'.$row0["Mle"].'">+</button></td>  
           </tr>';  
 }  
 else  
 {  
      $output .= '
      <tr class="even">  
      <td></td>
      <td>'.$row0["Mle"].'</td>
      <td>'.$row0["Nom"].' '.$row0["Prenom"].'</td>
      <td id="Fonction" contenteditable></td>
      <td id="Position" contenteditable></td>
      <td id="Qualification" contenteditable></td>
      <td >
      <select name="College" id="College">
      <option value="Execution">Execution</option>
      <option value="Maitrise">Maitrise</option>
      <option value="Cadre">Cadre</option>
      </td>                
      <td  tabindex="-1" id="blur_Date_F">
      <input type="date" class="form-control" id="Date_Poste" placeholder="2020-01-01" value="" style="width:170px" required>
      </td>                 
      <td> 
     <input class="form-control" list="datalistdep" placeholder="Département"  name="Dep" id="Dep" >';
                              $Personnels=$Personnel->getDep();
                              
     $output.='               
     </td>
      <td>
     <input class="form-control" list="datalistser" placeholder="Service"  name="Ser" id="Ser">
     <option value=""></option>	
      </td>
      <td id="Ref" contenteditable></td>
      <td><button type="button" name="btn_add" id="btn_prolongation" class="btn btn-success btn-lg btn-block" data-id1="'.$row0["Mle"].'">+</button></td>  
 </tr>';  
 }  
 $output .= '</tbody></table>  
      </div>'
      ;  
 echo $output;
            break;
case 'Historique':
$sql0 = "SELECT * FROM t_personnels WHERE Mle =".$_GET['Mle']." ORDER BY ID DESC";
//echo $sql0;
$result0 = mysqli_query($conn, $sql0);  
$row0 = mysqli_fetch_array($result0);  

$sql = "SELECT p.* FROM t_postes p 
         WHERE Mle=".$_POST["Mle"]." ORDER BY p.ID DESC"; 
 $result = mysqli_query($conn, $sql);  
          $output .= '       
          <div class="col"><hr></div>

           <table class="table table-striped table-bordered dataTable no-footer details"> 
           <a role="button" class="btn btn-outline-primary prev" data-title="tooltip" data-placement="top" title="Revenir En Arrière" href="#prev">
           <i class="mdi mdi-undo"></i>
           </a>
          
           <thead> 
                <tr> 
                     <th width="5%" >ID</th>  
                     <th width="5%" >Mle</th>
                     <th width="10%">Nom</th>
                     <th width="5%" >Fonction</th>
                     <th width="5%" >Position</th>
                     <th width="15%">Qualification</th>
                     <th width="5%">College</th>
                     <th width="10%">Date_Poste</th>
                     <th width="10%">Dep</th>
                     <th width="10%">Service</th>
                     <th width="15%">Ref</th>
                </tr>
           </thead>
           <tbody>';  
 $rows = mysqli_num_rows($result);
 if($rows > 0)  
 {  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["ID"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Mle"].'</td> 
                     <td data-id1="'.$row["ID"].'">'.$row0["Nom"].' '.$row0["Prenom"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Fonction"].'</td> 
                     <td data-id1="'.$row["ID"].'">'.$row["Position"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Qualification"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["College"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Date_Poste"].'</td>  
                     <td data-id1="'.$row["ID"].'">'.$row["Nom_Dep"].'</td>
                     <td data-id1="'.$row["ID"].'">'.$row["Nom_Service"].'</td>
                     <td data-id1="'.$row["ID"].'">'.$row["Ref"].'</td>                      
                     <td class="Actions"></td>  
                </tr> 
           ';  
      }  
 
 }  
 else  
 {  
      $output .= '
           <tr class="even">  
                <td></td>  
                <td  tabindex="-1">
                <input type="date" class="form-control" id="Date_D" placeholder="2020-01-01" value="" required>
                </td>
                <td id="Duree" contenteditable></td>                 
                <td  tabindex="-1">
                <input type="date" class="form-control" id="Date_F" placeholder="2020-01-01" value="" required>
                </td>                 
                <td id="Type" tabindex="-1">
                <select id="Type">
                  <option value="Initial">Initial</option>
                </select>
                </td>                   
                <td><button type="button" name="btn_add" id="btn_prolongation" class="btn btn-success btn-lg btn-block">+</button></td>  
           </tr>';  
 }  
 $output .= '</tbody></table>  
      </div>';  
 echo $output;
            break;


}
?>