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
$output = '';
 switch($_GET['action']) {
   
      case 'select':
      if(!empty($_POST["query"])){
        $sql = "SELECT  tp.ID,tp.Mle,tp.Nom,tp.Active ,tp.Date_Entree_Etab,tc.Date_D, MAX(tc.Date_F) AS Date_F,tc.Type,duree._day,duree._months,duree._years
        FROM t_contrat_parent AS tp
        LEFT JOIN 
        (SELECT * FROM t_contrat_details as tc1 WHERE Date_F=
         (SELECT max(Date_F) FROM t_contrat_details WHERE ID_Contrat_parent=tc1.ID_Contrat_parent))
           AS tc  ON (tp.ID=tc.ID_Contrat_parent)
                   LEFT JOIN 
                   (SELECT ID_Contrat_parent,SUM(Jours) AS _day,SUM(mois) AS _months,SUM(annee) AS _years FROM t_contrat_details GROUP BY ID_Contrat_parent) as duree
                   ON (tc.ID_Contrat_parent = duree.ID_Contrat_parent)
         WHERE tp.Active !=0  AND CONCAT(tp.Mle,' ', tp.Nom) LIKE '%".$_POST["query"]."%'
         GROUP BY tp.ID
         ORDER BY `tp`.`ID` ASC";
                //echo $sql;
        }
          else{
              $sql = "SELECT  tp.ID,tp.Mle,tp.Nom,tp.Active ,tp.Date_Entree_Etab,tc.Date_D, MAX(tc.Date_F) AS Date_F,tc.Type,duree._day,duree._months,duree._years
              FROM t_contrat_parent AS tp
              LEFT JOIN 
              (SELECT * FROM t_contrat_details as tc1 WHERE Date_F=
               (SELECT max(Date_F) FROM t_contrat_details WHERE ID_Contrat_parent=tc1.ID_Contrat_parent))
                 AS tc  ON (tp.ID=tc.ID_Contrat_parent)
                         LEFT JOIN 
                         (SELECT ID_Contrat_parent,SUM(Jours) AS _day,SUM(mois) AS _months,SUM(annee) AS _years FROM t_contrat_details GROUP BY ID_Contrat_parent) as duree
                         ON (tc.ID_Contrat_parent = duree.ID_Contrat_parent)
               WHERE tp.Active !=0  
               GROUP BY tp.ID
               ORDER BY `tp`.`ID` DESC";  
               //echo $sql;              
              }

 $result = mysqli_query($conn, $sql);  
 $output .= '
      <div class="table-responsive">  
           <table class="table table-striped table-bordered no-footer " id="datatable">
           <thead>
                <tr >  
                     <th width="5%" >ID</th>  
                     <th width="5%" >Mle</th>
                     <th width="30%">Nom</th>
                     <th width="5%" >Date Entree Etab</th>
                     <th width="5%" >Date Debut</th>
                     <th width="5%" >Date Fin</th>
                     <th width="10%">Duree Total</th>
                     <th width="30%">Type</th>
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

           $output .= '  
                <tr >  
                     <td>'.$i++.'</td>  
                     <td class="Mle" data-id1="'.$row["ID"].'">
                     <a role="button" class="btn btn-primary" data-bs-original-title="tooltip" data-bs-placement="top" title="Fiche Personnel" href="Profile?Mle='.$row["Mle"].'" target="_blank">'.$row["Mle"].'</a>
                     </td>  
                     <td class="Nom" data-id1="'.$row["ID"].'">'.$row["Nom"].'</td>  
                     <td class="Date_1er" data-id1="'.$row["ID"].'">'.$row["Date_Entree_Etab"].'</td> 
                     <td class="Date_D" ><button type="button" class="btn btn-outline-primary" >'.$row["Date_D"].'</button></td>
                     ';
  $timestamp = $row["Date_F"];
$today = new DateTime(); // This object represents current date/time
  if(date('m',strtotime($row["Date_F"]))==date("m",strtotime('+1 month'))){
    $moisfiltre="01mois";
  }else if(date('m',strtotime($row["Date_F"]))==date("m",strtotime('+2 month'))){
    $moisfiltre="02mois";
  }else if(date('m',strtotime($row["Date_F"]))==date("m",strtotime('+3 month'))){
     $moisfiltre="03mois";
   }else{
    $moisfiltre=NULL;
  }
$match_date = $today->format("Y-m-d");
if ($timestamp>=$match_date) {
$output .='<td class="Date_F" data-status="'.$moisfiltre.'" data-id1="'.$row["ID"].'"><button type="button" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$row["Date_D"].'">'.$row["Date_F"].'</button></td> ';
}else{
$output .='<td class="Date_F class="btn btn-outline-danger" data-status="expired" data-id1="'.$row["ID"].'"><button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$row["Date_D"].'">'.$row["Date_F"].'</button></td> ';
}
    // convert days in year, month,day
    $days=$row["_day"]%30;
    if($days<0){$days=30+$days;}
    $month = ($row["_months"] % 12) + floor($row["_day"]/30) ; 
    $years = $row["_years"] + floor($row["_months"] / 12); // Remove all decimals
//echo $row2["_day"].'%'.'30='.$days;
    $_date =$years.' years, '.$month.' month, '.$days.' days';

                     $output .=' 
                     <td class="Type" data-id1="'.$row["ID"].'">'.$_date.'</td>  
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Type"].'</td>  
                     <td>
                         <div class="btn-group" role="group" aria-label="Basic example">
                         <a role="button" class="btn btn-outline-primary add_details" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter Nouveau Employée" href="#Prolongation" data="'.$row["ID"].'">
                         <i class="mdi mdi-note-add"></i></a>
                         <a role="button" class="btn btn-outline-success Finish" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmation" href="#Reprise" data="'.$row["ID"].'">
                         <i class="mdi mdi-done"></i></a>
                         <a role="button" class="btn btn-outline-danger Supprimer" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer" href="#Supprimer" data-id1="'.$row["ID"].'">
                         <i class="mdi mdi-delete-forever"></i></a>
                         </div>
                    </td>  
               </tr>  
           ';  
      }  
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
                  <option value="CIVP">CIVP</option>
                  <option value="Essai">Essai</option>
                  <option value="SIVP">SIVP</option>
                  <option value="CAIP">CAIP</option> 
                  <option value="Rupture">Rupture</option>                                  
                </select>
                </td>                   
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-success btn-lg btn-block">Ajouter +</button></td>  
           </tr>  
      ';  
 }  
 else  
 {  
      $output .= '
      <tr><td colspan="9">Pas de resultats pour le : " <a href="javascript:Historique_data('.$_POST["query"].');"><b>'.$_POST["query"].'</b> " Recherche dans l\'historique</a></td></tr>
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
                  <option value="CIVP">CIVP</option>
                  <option value="Essai">Essai</option>
                  <option value="SIVP">SIVP</option>
                  <option value="CAIP">CAIP</option> 
                  <option value="Rupture">Rupture</option>                                  
                </select>
                </td>                   
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-success btn-lg btn-block">Ajouter +</button></td>  
           </tr> ';  
 }  
 $output .= '</tbody></table>  
      </div>';  
 echo $output;
        break;

     case 'H':
if(!empty($_POST["Mle"])){
        $Mle = $_POST["Mle"];
        $sql = "SELECT * FROM t_contrat_parent WHERE Mle = ".$Mle." ORDER BY ID DESC";
         $result = mysqli_query($conn, $sql);  
         $row = mysqli_fetch_array($result);           
        //echo $sql;
         $rows = mysqli_num_rows($result);
         if($rows > 0)  
         {
         $sql0 = "SELECT * FROM t_contrat_details WHERE ID_Contrat_parent =".$row['ID']." ORDER BY Date_D ASC";
         $result0 = mysqli_query($conn, $sql0);  
         //echo $sql0;              
         

 $result = mysqli_query($conn, $sql);  
 
$output .= '  
      <div class="table-responsive">
      <a role="button" class="btn btn-outline-primary prev" data-bs-original-title="tooltip" data-bs-placement="top" title="Revenir En Arrière" href="#prev">
      <i class="mdi mdi-undo"></i>
      </a>
           <table class="table table-striped table-dark" >  
                <tr>  
                     <th width="10%">ID</th>  
                     <th width="10%">Mle</th>
                     <th width="20%">Nom</th>
                     <th width="20%">Date Entre Etab</th>                         
                     <th width="20%">type</th>
                </tr>';  

           $output .= '  
                <tr>  
                     <td id="ID_ATMS">'.$row["ID"].'</td>  
                     <td class="Mle" data-id1="'.$row["ID"].'">'.$row["Mle"].'</td>  
                     <td class="Nom" data-id1="'.$row["ID"].'">'.$row["Nom"].'</td>  
                     <td class="Date_1er" data-id1="'.$row["ID"].'">'.$row["Date_Entree_Etab"].'</td>  
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Type"].'</td>  
                </tr>
            </table>';


 
            $output .= '       
           <table class="table table-striped table-bordered dataTable no-footer details" id="datatable"> 
           <thead> 
                <tr> 
                     <th width="5%">ID</th>
                     <th width="10%">Qualification</th>                                        
                     <th width="5%">Date Debut</th>
                     <th width="5%">Jours</th>
                     <th width="5%">Mois</th>
                     <th width="5%">Années</th>
                     <th width="10%">Date Fin</th>                         
                     <th width="10%">type</th>
                     <th width="10%">Ref</th>
                     <th width="10%">Date Ref</th>                     
                     <th width="10%">Actions</th>                         
                </tr>
           </thead>
           <tbody>';  
 $rows = mysqli_num_rows($result0);
 if($rows > 0)  
 {  
      while($row0 = mysqli_fetch_array($result0))  
      {  
           $output .=' 
                <tr>  
                     <td>'.$row0["ID"].'</td>  
                     <td class="Date_D" data-id1="'.$row0["ID"].'">'.$row0["Qualification"].'</td>  
                     <td class="Date_D" data-id1="'.$row0["ID"].'">'.$row0["Date_D"].'</td>  
                     <td class="Jours" data-id1="'.$row0["ID"].'">'.$row0["Jours"].'</td>  
                     <td class="Mois" data-id1="'.$row0["ID"].'">'.$row0["Mois"].'</td>  
                     <td class="Annee" data-id1="'.$row0["ID"].'">'.$row0["Annee"].'</td>  
                     <td class="Date_F" data-id1="'.$row0["ID"].'">'.$row0["Date_F"].'</td>
                     <td class="Type" data-id1="'.$row0["ID"].'">'.$row0["Type"].'</td>
                     <td class="Date_F" data-id1="'.$row0["ID"].'">'.$row0["Ref"].'</td>
                     <td class="Type" data-id1="'.$row0["ID"].'">'.$row0["Date_Ref"].'</td>                      
                     <td class="Actions">';
                     if ($row0["CDD_File"]==NULL) {
                      $output .= '  <div class="btn-group" role="group" aria-label="Basic example">
                      <a role="button" class="btn btn-outline-primary add_details" data-bs-original-title="tooltip" data-bs-placement="top" title="Ajouter Nouveau Employée" href="#Prolongation" data="'.$row["ID"].'">
                      <i class="mdi mdi-note-add"></i></a>
                      <a role="button" class="btn btn-outline-success Finish" data-bs-original-title="tooltip" data-bs-placement="top" title="Confirmation" href="#Reprise" data="'.$row["ID"].'">
                      <i class="mdi mdi-done"></i></a>
                      <a role="button" class="btn btn-outline-danger Supprimer" data-bs-original-title="tooltip" data-bs-placement="top" title="Supprimer" href="#Supprimer" data-id1="'.$row["ID"].'">
                      <i class="mdi mdi-delete-forever"></i></a>
                      </div><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#uploadModal" data-bs-original-title="tooltip" data-bs-placement="top" title="" data-original-title="Upload Contrat"   data-bs-toggle="modal" data-bs-target="#uni_modal" data-id1="'.$row0["Ref"].' '.$row0["Date_Ref"].'" data-id2="'.$row0["ID"].'" data-id3="'.$row["Mle"].'" id="upload_cdd_btn">
                          <i class="mdi mdi-cloud-upload"></i>
                        </button>';
                     }else{
                      $output .= ' <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#showModal" data-bs-original-title="tooltip" data-bs-placement="top" title="" data-original-title="Afficher Contrat"   data-bs-toggle="modal" data-bs-target="#uni_modal" data-id1="'.$row0["CDD_File"].'" data-whatever="'.$row0["CDD_File"].'" id="show_cdd_btn">
                          <i class="mdi mdi-attach-file"></i>
                        </button>';                      
                     }
                        
                     $output .= ' </td> 
                </tr>  
           ';  
      }  
}
$output .= '</tbody></table>  
      </div>';  
    }else{
$output .= '  
      <div class="table-responsive">
      <a role="button" class="btn btn-outline-primary prev" data-bs-original-title="tooltip" data-bs-placement="top" title="Revenir En Arrière" href="#prev">
      <i class="mdi mdi-undo"></i>
      </a>
           <table class="table table-striped table-dark" >  
                <tr>  
                     <th width="10%">ID</th>  
                     <th width="10%">Mle</th>
                     <th width="20%">Nom</th>
                     <th width="20%">Date Entre Etab</th>                         
                     <th width="20%">type</th>
                </tr>';  

           $output .= '  
                <tr >  
                     <td colspan"5">Pas d\'historique pour '.$_POST["Mle"].'</td>  
                </tr>
            </table>';

    }
}
 echo $output;
            break;


      case 'manage':
          extract($_POST);
          //Ajout CDD + AV
     if(empty($ID)) {
          $sql0="INSERT INTO t_avancement(MLE,NOM,CAT,S_CAT,ECH,SBASE,TH,IND_DIFF,QUALIFICATION,D_EFFET) VALUES ('".$MLE."', '".$NOM."' ,'".$CAT."' ,'".$S_CAT."' , '".$ECH."', '".$SBASE."','".$TH."' ,'".$IND_DIFF."','".$Qualification."','".$Date_D."')";
          //echo($sql0)."<br>";  
          $res0=mysqli_query($conn, $sql0);
          if ($res0)
          {
               $ID_AV=mysqli_insert_id($conn);
               //echo($ID_AV)."<br>";               

          }
               //echo '<script type="text/javascript">alert("'.$ID_AV.'");</script><br>';
          $sql="INSERT INTO t_contrat_details(ID_Contrat_parent,Date_D,Date_F,Jours,Mois,Annee,Qualification,Type, Ref, Date_Ref,ID_AV) VALUES ('".$ID_ATMS."', '".$Date_D."', '".$Date_F."', '".$days."', '".$months."', '".$years."', '".$Qualification."','".$Type."','".$Ref."','".$Date_Ref."','".$ID_AV."')";  
          //echo ($sql)."<br>";
          $res=mysqli_query($conn, $sql);

          if ($res0 && $res)
          {
               echo '1';
          }

     } 
          //Modif CDD + AV
          else
     {
          //CDD sans AV
          if($ID_AV =='0')
          {
               $sql1="INSERT INTO t_avancement (MLE,NOM,CAT,S_CAT,ECH,SBASE,TH,IND_DIFF,QUALIFICATION,D_EFFET) VALUES ('".$_POST["MLE"]."','".$_POST["NOM"]."','".$CAT."','".$S_CAT."','".$ECH."', '".$SBASE."','".$TH."' ,'".$IND_DIFF."','".$Qualification."','".$Date_D."')";
            //echo($sql1)."<br>";       
                    //$result00=mysqli_query($conn, $sql1);
                    //$row00=mysqli_fetch_array($result00);
                //echo($row00["ID"]);
                $res1=mysqli_query($conn, $sql1);
                if($res1){
               $ID_AV=mysqli_insert_id($conn);
                }
                //echo '<script type="text/javascript">alert("'.$ID_AV.'");</script>';
                  //  echo($ID_AV);
                     // echo($ID_AV);
                    // {
                    // }
          $sql3="update t_contrat_details SET Qualification='$Qualification',Date_D='$Date_D',Jours='$days',Mois='$months',Annee='$years',Date_F='$Date_F',Type='$Type',Ref='$Ref',Date_Ref='$Date_Ref',ID_AV='$ID_AV'
          WHERE (ID=$ID)";
          $res2=mysqli_query($conn, $sql3);


          //echo($sql3);
          if(($res1) && ($res2))
          {  
               echo '2';
          }
          
          }
          //CDD + AV existant
          else
          {      
               $sql4="update t_avancement SET CAT='$CAT',S_CAT='$S_CAT',ECH='$ECH',SBASE='$SBASE',TH='$TH',IND_DIFF='$IND_DIFF',QUALIFICATION='$Qualification',D_EFFET='$Date_D'
                      WHERE (ID=$ID_AV)";      
               echo($sql4)."<br>";
                    
          $sql3="update t_contrat_details SET Qualification='$Qualification',Date_D='$Date_D',Jours='$days',Mois='$months',Annee='$years',Date_F='$Date_F',Type='$Type',Ref='$Ref',Date_Ref='$Date_Ref',ID_AV='$ID_AV'
          WHERE (ID=$ID)";
          //echo($sql3);
          if(mysqli_query($conn, $sql3) &&  mysqli_query($conn, $sql4))
          {  
               echo '2';
          }
          
          }
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
case 'effacer':
          $ID_eff=$_POST["ID_D"];  
          //echo $ID ;
          $sql0="DELETE FROM t_contrat_details
               WHERE `t_contrat_details`.`ID`= '".$ID_eff."'";
               //echo ($sql0);
               if(mysqli_query($conn, $sql0))
               {
                echo 'Contrat supprimé !';
               }
          //$sql = "SELECT * FROM t_contrat_details WHERE ID_Contrat_parent ='".$ID."' ORDER BY Date_D ASC"; 
           //$result = mysqli_query($conn, $sql);  

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
  if (mysqli_num_rows($result)==1) {
     echo ($row['Nom'].' '.$row['Prenom']);  
  } else {
       echo "Mle non valide !";
  }
        break;
      case 'prolongation':
$sql = "INSERT INTO t_contrat_parent(ID, Date_D, Date_F,Duree, Type)VALUES('".$_POST["Mle"]."', '".$_POST["Nom"]."', '".$_POST["Date_1er"]."', '".$_POST["Type"]."')";  
//echo $sql;
if(mysqli_query($conn, $sql))  
{  
     echo 'Data Inserted';  
}
     break;

      case 'confirmer':
$sql1 = "INSERT INTO t_contrat_details(ID_Contrat_parent, Date_D, Date_F,Jours,Mois,Annee,Qualification, Type, Ref, Date_Ref) VALUES('".$_POST["ID_ATMS"]."', '".$_POST["Date_D"]."', '".$_POST["Date_D"]."', '0','0','0','".$_POST["Qualification"]."','Confirmation','".$_POST["Ref"]."','".$_POST["Date_Ref"]."')";   
// echo $sql1;
// echo"<br>";
$resp1=mysqli_query($conn, $sql1);
  $sql2 = "UPDATE `t_contrat_parent` SET `Active` = '0' WHERE `t_contrat_parent`.`ID` = '".$_POST["ID_ATMS"]."'";  
//   echo $sql2;
//   echo"<br>";
  $resp2=mysqli_query($conn, $sql2);

  $sql3="UPDATE `t_personnels` SET `Date_Anc` ='".$_POST["Date_Anc"]."' WHERE Mle = '".$_POST["Mle"]."'";  
//     echo $sql3;
//     echo"<br>";
  $resp3=mysqli_query($conn, $sql3);

  if($resp1 && $resp2 && $resp3)  
{  
     echo '1';  
}
        break;

case 'add':

if(!empty($_POST["query"])){
        $searchData = explode(",", $_POST["query"]);
        $searchValues = "'" . implode("', '", $searchData) . "'";
        $sql = "SELECT * FROM t_contrat_details WHERE ID_Contrat_parent IN (".$searchValues.") ORDER BY ID DESC";  
        //echo $sql;
        }
          else{
         $sql0 = "SELECT * FROM t_contrat_parent WHERE ID =".$_POST['ID']." ORDER BY ID DESC";
         $result0 = mysqli_query($conn, $sql0);  
         $row0 = mysqli_fetch_array($result0);  
         // echo $sql0;              

         $sql = "SELECT * FROM t_contrat_details WHERE ID_Contrat_parent ='".$_POST["ID"]."' ORDER BY Date_F ASC";  
              //echo $sql;              
              }
 $result = mysqli_query($conn, $sql);  
          $qry = $conn->query("SELECT * FROM t_avancement where MLE= ".$row0["Mle"]."");
          if (is_array($qry)) {
               foreach($qry->fetch_array() as $k => $val){
	          $$k=$val;
               }
          }
          ?>

<div class="content">

<a role="button" class="btn btn-outline-primary prev" data-bs-original-title="tooltip" data-bs-placement="top" title="Revenir En Arrière" href="#prev">
      <i class="mdi mdi-undo"></i>
      </a>

  

</div>
<br>
<style>
     .colL{
        /* margin-left: auto;*/
  
   padding-Left: 370px;
   padding-Bottom:40px;

   padding-Top:20px;   
     }
     </style>
<?php 
$output .= '  
      <div class="table-responsive">
      
      </a>
           <table class="table table-striped table-dark" >  
                <tr>  
                     <th width="10%">ID</th>  
                     <th width="10%">Mle</th>
                     <th width="20%">Nom</th>
                     <th width="20%">Date Entree Etab</th>                         
                     <th width="20%">type</th>
                </tr>';  

           $output .= '  
                <tr>  
                     <td id="ID_ATMS">'.$row0["ID"].'</td>  
                     <td class="Mle" ID="Mle" data-id1="'.$row0["ID"].'">'.$row0["Mle"].'</td>  
                     <td class="Nom" ID="Nom" data-id1="'.$row0["ID"].'">'.$row0["Nom"].'</td>  
                     <td class="Date_1er" data-id1="'.$row0["ID"].'">'.$row0["Date_Entree_Etab"].'</td>  
                     <td class="Type" data-id1="'.$row0["ID"].'">'.$row0["Type"].'</td>
                </tr>

            </table>
           

            <div class="row align-items-center">
            <div class="col">   
</div>
               <div class="colL">   
            <button type="button" name="Ajouter_CDD" id="Ajouter_CDD"  data-id2="'.$row0["ID"].'" class="center btn btn-outline-success  btn-lg "   title="Ajouter Nouveau Contrat" style="width:200px" text-align="center"    data-bs-toggle="modal" data-bs-target="#uni_modal" >Ajouter Contrat</button>
  
            <button type="button" name="Ajouter_FI01" id="Ajouter_FI01"   data-id2="'.$row0["Mle"].'" class="center btn btn-outline-success  btn-lg "   title="Ajouter fiche de formation f.I.001" style="width:200px" text-align="center"    data-bs-toggle="modal" data-bs-target="#uni_modal" >Formation initial</button>

            </div>
            
            <div class="col">   
</div>
            </div>
            ';
            $output .= '       
           <table class="table table-striped table-bordered dataTable no-footer details" id="datatable"> 
           <thead> 
                <tr> 
                     <th width="5%">ID</th>
                     <th width="10%">Qualification</th>                                        
                     <th width="5%">Date Debut</th>
                     <th width="5%">Jours</th>
                     <th width="5%">Mois</th>
                     <th width="5%">Années</th>
                     <th width="10%">Date Fin</th>                         
                     <th width="10%">type</th>
                     <th width="10%">Ref</th>
                     <th width="10%">Date Ref</th>                     
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
                     <td class="Date_D" data-id1="'.$row["ID"].'">'.$row["Qualification"].'</td>  
                     <td class="Date_D" data-id1="'.$row["ID"].'">'.$row["Date_D"].'</td>  
                     <td class="Jours" data-id1="'.$row["ID"].'">'.$row["Jours"].'</td>  
                     <td class="Mois" data-id1="'.$row["ID"].'">'.$row["Mois"].'</td>  
                     <td class="Annee" data-id1="'.$row["ID"].'">'.$row["Annee"].'</td>  
                     <td class="Date_F" data-id1="'.$row["ID"].'">'.$row["Date_F"].'</td>
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Type"].'</td>
                     <td class="Date_F" data-id1="'.$row["ID"].'">'.$row["Ref"].'</td>
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Date_Ref"].'</td>                      
                     <td class="Actions">';
                     if ($row["CDD_File"]==NULL) {
                      $output .= ' 
                      <div class="btn-group" role="group" aria-label="Basic example">
                         <a role="button" class="btn btn-outline-primary"  data-bs-original-title="tooltip" data-bs-placement="top" title="" data-original-title="Upload Contrat" data-id1="'.$row["Ref"].' '.$row["Date_Ref"].'" data-id2="'.$row["ID"].'" data-id3="'.$row0["Mle"].'"  data-bs-target="#uni_modal" data-bs-toggle="modal"  id="upload_cdd_btn">
                           <i class="mdi mdi-cloud-upload"></i></a>
                         <a role="button" class="btn btn-outline-secondary" data-bs-placement="top" data-original-title="Modifier Contrat"  id="Modif_CDD" name="Modif_CDD"  data-bs-toggle="modal" data-id="'.$row["ID"].'" data-id2="'.$row0["ID"].'"  data-bs-target="#uni_modal">
                         <i class="mdi mdi-create"></i>
                          <a role="button" class="btn btn-outline-danger effacer" data-bs-original-title="tooltip" data-bs-placement="top" title="effacer" href="#effacer" data-id="'.$row["ID"].'" >
                           <i class="mdi mdi-delete-forever"></i></a>
                        
                        </div>';
                     }else{
                      $output .= ' 
               <div class="btn-group" role="group" aria-label="Basic example">
                         <a role="button" class="btn btn-outline-primary" data-bs-original-title="tooltip" data-bs-placement="top" title="" data-original-title="Afficher Contrat"   data-id1="'.$row["CDD_File"].'" data-whatever="'.$row["CDD_File"].'" id="show_cdd_btn">
                             <i class="mdi mdi-attach-file"></i></a>
                         <a role="button" class="btn btn-outline-secondary" data-bs-placement="top" data-original-title="Modifier Contrat"  id="Modif_CDD" name="Modif_CDD" data-id="'.$row["ID"].'"  data-bs-target="#uni_modal"  data-bs-toggle="modal"  >
                             <i class="mdi mdi-create"></i></a>
                          <a role="button" class="btn btn-outline-danger" data-bs-original-title="tooltip" data-bs-placement="top" title="effacer" href="#" data-id="'.$row["ID"].'" >
                             <i class="mdi mdi-delete-forever"></i></a>
                    </div>';                      
                     }
                        
                     $output .= ' </td> 
                </tr>  
           ';  
      }  
      
     
 }  
 $output .= '</tbody></table>  ';
          
 echo $output;
            break;


case 'Finish':
if(!empty($_POST["query"])){
        $searchData = explode(",", $_POST["query"]);
        $searchValues = "'" . implode("', '", $searchData) . "'";
        $sql = "SELECT * FROM t_contrat_details WHERE ID_Contrat_parent IN (".$searchValues.") ORDER BY ID DESC";  
        //echo $sql;
        }
          else{
         $sql0 = "SELECT * FROM t_contrat_parent WHERE ID =".$_GET['ID']." ORDER BY ID DESC";
         $result0 = mysqli_query($conn, $sql0);  
         $row0 = mysqli_fetch_array($result0);  
                    
         $sql = "SELECT * FROM t_contrat_details WHERE ID_Contrat_parent ='".$_POST["ID"]."' ORDER BY Date_D";  
              //echo $sql;              
              }
 $result = mysqli_query($conn, $sql);  
 
$output .= '  
      <div class="table-responsive">
      <a role="button" class="btn btn-outline-primary prev" title="tooltip" data-bs-placement="top" title="Revenir En Arrière" href="#prev">
      <i class="mdi mdi-undo"></i>
      </a>
           <table class="table table-striped table-dark" >  
                <tr>  
                     <th width="10%">ID</th>  
                     <th width="10%">Mle</th>
                     <th width="20%">Nom</th>
                     <th width="20%">Date Debut</th>                         
                     <th width="20%">type</th>
                </tr>

                ';
                
           $output .= '  
                <tr>  
                     <td id="ID_ATMS">'.$row0["ID"].'</td>  
                     <td class="Mle" data-id1="'.$row0["ID"].'">'.$row0["Mle"].'</td>  
                     <td class="Nom" data-id1="'.$row0["ID"].'">'.$row0["Nom"].'</td>  
                     <td class="Date_1er" data-id1="'.$row0["ID"].'">'.$row0["Date_Entree_Etab"].'</td>  
                     <td class="Type" data-id1="'.$row0["ID"].'">'.$row0["Type"].'</td>  
                </tr>
            </table>';
            $output .= '
            <div class="row align-items-center">
            <div class="col">   
                    </div>
               <div class="col"> 
                    <button type="button" name="confirmer" id="confirmer"  data-id2="'.$row0["ID"].'" class="center btn btn-outline-success  " data-bs-target="#uni_modal"  data-bs-toggle="modal" title="Confirmer  " style="width:200px" text-align="center"  >Confirmer Contrat</button>
                    </div>
                    <div class="col">
                    </div>
                    
                    ';


          $output .= '       
           <table class="table table-striped table-bordered dataTable no-footer details" id="datatable"> 
           <thead> 
                <tr> 
                     <th width="10%">ID</th>                   
                     <th width="20%">Date debut</th>
                     <th width="20%">Durée</th>
                     <th width="20%">Date Fin</th>
                     <th width="20%">Qualification</th>
                     <th width="20%">type</th>
                     <th width="20%">Ref</th>
                     <th width="20%">Date_Ref</th>
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
                     <td class="Date_D" data-id1="'.$row["ID"].'">'.$row["Date_D"].'</td>  
                     <td class="Duree" data-id1="'.$row["ID"].'">'.$row["Annee"].'Années, '.$row["Mois"].'mois, '.$row["Jours"].'jours</td>  
                     <td class="Date_F" data-id1="'.$row["ID"].'">'.$row["Date_F"].'</td>
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Qualification"].'</td>
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Type"].'</td>
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Ref"].'</td>  
                     <td class="Type" data-id1="'.$row["ID"].'">'.$row["Date_Ref"].'</td>  
  
                </tr>';  
      }  
}  
 $output .= '</tbody></table>  
      </div>';  
 echo $output;
          break;
}






?>