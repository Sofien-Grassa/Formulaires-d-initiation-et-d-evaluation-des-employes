<?php      
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "stipdb";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
 mysqli_set_charset($conn,"utf8");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    
}
  header('Content-Type: text/html; charset=utf-8');
include 'Effectif_add_function.php';
  $Personnel = new Personnel();
  include 'connection.php';
        switch($_GET['action']) {
     
         
            case 'formFI001ADD':
              $id=$_GET['id'];
              echo "<input type='hidden' id='id_p' value='".$id."'>";
 ?>           <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                     
                            <h2 class="text-center">Formation Theorique </h2>        
                        </div>
                        <div class="col-md-1 mt-2">                        
                        </div>
                    </div>
                </div>
               
                <div class="card-body">        
                    <div id="inserted_item_data" class="mt-2"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h2 class="text-center">Formation Pratique </h2>        
                        </div>
                        <div class="col-md-1 mt-2">
                        </div>
                    </div>
                </div>
               
                <div class="card-body">        
                    <div id="inserted_item_data2" class="mt-2"></div>
                </div>
            </div>
        </div>
        <style>
            .modal-place{
  overflow-x: auto;
}
            </style>
<?php        
            break;
            case 'formFI001' :
                $output='';

                $output .='
                
                <table class="table text-center table-striped table-bordered" id="crud_table">    
                <tr>
                    <th>Mle</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>date_naissance</th>
                    <th>date_Entre_Etab</th>
                    <th>Nom departement</th>
                    <th>qualification</th>
                    <th colspan="2">Action</th>
                </tr>'
                ;
                    $mat= isset($_GET['Mle'])?$_GET['Mle'] :$_POST['Mle'];
                //print_r($_POST);
                $q="SELECT Per.ID,Per.Mle,Per.Nom,Per.Prenom,Pos.Nom_Dep,Per.Date_N,Per.Date_Entre_Etab,Pos.Qualification,Pos.Nom_Dep
                FROM t_personnels AS Per LEFT OUTER JOIN t_postes AS Pos ON Per.Mle=Pos.Mle AND Pos.Active=1 WHERE Per.Motif_Sortie IS NULL AND Per.Date_Sortie_Etab IS NULL AND Per.Mle = $mat ORDER BY CAST(Per.`Mle` as unsigned) ASC";
            //   echo $q;
                $res=mysqli_query($conn, $q);
$row = mysqli_fetch_array($res);
session_name("personnel");
session_start();
    $output .="
    
    <tr>
        <td contenteditable='true' >".$row["Mle"]."</td>
        <td contenteditable='true' class='nom'>".$row["Nom"]."</td>
        <td contenteditable='true' class='prenom'>".$row["Prenom"]."</td>
        <td contenteditable='true'class='date_naissance'>".$row["Date_N"]."</td>
        <td contenteditable='true' class=' date_embauche text-start'>".$row["Date_Entre_Etab"]."</td>
        <td contenteditable='true' class=' affectation text-start'>".$row["Nom_Dep"]."</td>
        <td contenteditable='true' class=' qualification text-start'>".$row["Qualification"]."</td>
        <td colspan='2'><button type='button' class='btn btn-success enregistrer'  data-id2='$mat'>save</button></td>
    </tr>";
$q2="SELECT * FROM t_fi001_parent WHERE Mle = $mat";
$res2=mysqli_query($conn,$q2);
$num_rows = mysqli_num_rows($res2);

if($num_rows > 0) {
    while($row2 = mysqli_fetch_array($res2)){
        

    $output .="<tr>
            <td  >".$row2["Mle"]."</td>
            <td  >".$row2["nom"]."</td>
            <td  >".$row2["prenom"]."</td>
            <td >".$row2["date_naissance"]."</td>
            <td  class='text-start'>".$row2["date_embauche"]."</td>
            <td  class=' text-start'>".$row2["affectation"]."</td>
            <td  class=' text-start'>".$row2["qualification"]."</td>";
     
        
            $user = $_SESSION['user'];
            if(  $user === "Amani Nasr" || $user === "Youssef Ghezal"){     
           $output.=
        "<td> <div class='btn-group'>";
        
        if($row2['etat']=='0'){
            $output.="
        <button type='button' class='btn btn-danger' class='btn btn-success ' id='Ajouter_ligne_T' data-bs-dismiss='modal' data-bs-toggle=modal data-bs-target='#uni_modal_F'  data-id='$row2[etat]' data-id2='$row2[id]' disabled >FIOO1</button>";
       
    
    }
       else{
        $output.="<button type='button' class='btn btn-danger' class='btn btn-success ' id='Ajouter_ligne_T' data-bs-dismiss='modal' data-bs-toggle=modal data-bs-target='#uni_modal_F'  data-id='$row2[etat]' data-id2='$row2[id]' >FIOO1</button>
       ";}


    if($row2['etat']=='1'){
    $style1="style='background-color: pink'";
    $style2="";
    $style3="";
    $status="Active";
    }
    else if($row2['etat']=='0')
    {
        $style2="style='background-color: pink'";
        $style1="";
        $style3="";
        $status="En Attente";
    }
    else{
        $style3="style='background-color: pink'";
        $style2="";
        $style1="";
        $status="Cloturer";    
    }
        $output.=" 
        <button type='button' class='btn btn-danger dropdown-toggle dropdown-toggle-split' data-bs-toggle='dropdown' aria-expanded='false'>
        <span class='visually-hidden'>Toggle Dropdown</span>
        </button>
      <ul class='dropdown-menu'>
      <li><button ".$style1."  class='status dropdown-item' data-id2='1' data-id1=".$row2['id']." >Actif</button></li>
      <li><button ".$style2." class='status dropdown-item' data-id2='0' data-id1=".$row2['id']." >en attente</button></li>
      <li><button ".$style3." class='status dropdown-item' data-id2='2' data-id1=".$row2['id'].">cloturé</button></li>
    </ul>
    
    
      
  </div> 
</div>
</td>";      
    }
    else {

        $output.=
        "<td> <div class='btn-group'>";
        
        if($row2['etat']=='0'){
            $output.="
        <button type='button' class='btn btn-danger' class='btn btn-success ' id='Ajouter_ligne_T' data-bs-dismiss='modal' data-bs-toggle=modal data-bs-target='#uni_modal_F'  data-id='$row2[etat]' data-id2='$row2[id]' disabled >FIOO1</button>";
       
    
    }
       else{
        $output.="<button type='button' class='btn btn-danger' class='btn btn-success ' id='Ajouter_ligne_T' data-bs-dismiss='modal' data-bs-toggle=modal data-bs-target='#uni_modal_F'  data-id='$row2[etat]' data-id2='$row2[id]' >FIOO1</button>
       ";}
        if($row2['etat']=='1'){
            $status="<span class='badge bg-primary'><i class='fas fa-edit'></i></span>";
            }
            else if($row2['etat']=='0')
            {
                $status="<span title='en attente ' class='badge bg-warning text-dark'><i class='fas fa-clock'></i></span>";
            }
            else{
                $status="<span class='badge bg-success'><i class='fas fa-lock' style='color:red' ></i></span>";    
            }
        $output.="<td>".$status."</td>";
    }
    

$today = date("Y-m-d ");
$nbexpired=0;
$req="SELECT d.date_fin from `t_fi001_detail` AS d join `t_fi001_parent` as p where p.id=d.id_p ";
$res = mysqli_query($conn, $req);
while($row = mysqli_fetch_array($res)){
   if($row['date_fin']<$today)
$nbexpired++;
}
$q4="SELECT date_fin FROM t_fi001_detail WHERE id_p=".$row2['id'];
$res4=mysqli_query($conn,$q4);
$num_rows4 = mysqli_num_rows($res4);
$row4 = mysqli_fetch_array($res4);
$q5="SELECT * FROM evaluation WHERE id_p=".$row2['id'];
$res5=mysqli_query($conn,$q5);
$num_rows5 = mysqli_num_rows($res5);
$row5 = mysqli_fetch_array($res5);
if($nbexpired>0 or !$row2['etat']=='0'){
$output.="<td>
<div class='btn-group' role='group' aria-label='Basic example'>";
if($row2['etat']=='0'or $num_rows4 < 1){
$output.="
<button type='button' class='btn btn-primary' class='btn btn-success' id='Ajouter_FI02' data-bs-dismiss='modal' data-bs-toggle=modal data-bs-target='#uni_modal_F'  data-id='$row2[Mle]'  data-id2='$row2[id]' disabled >FIOO2</button> ";
}else 
$output.="<button type='button' class='btn btn-primary' class='btn btn-success' id='Ajouter_FI02' data-bs-dismiss='modal' data-bs-toggle=modal data-bs-target='#uni_modal_F'  data-id='$row2[Mle]'  data-id2='$row2[id]'  >FIOO2</button> ";

if($num_rows5 > 0) {
    if($row5['total']>60){
        $icons="<span  class='btn btn-primary' class='badge bg-success'><i class='fas fa-lock'style='color:green' ></i></span>"; 
        $output.=$icons."</div></td>";
    }
    else{
        $icons="<span class='btn btn-primary' class='badge bg-success'><i class='fas fa-lock' style='color:red' ></i></span>"; 
        $output.=$icons."</div></td>";
    }}

    
}
else $output.="";



$output.="</tr>";
    }
}
   
$output .='</table>';
echo $output;

echo"<input name='Mle'  id='Mle_FI001' value='$mat'type='hidden'> ";

                break;

    case "insert_p" :
        extract($_POST);
// print_r($_POST);
    
                if($nom != '' && $prenom != '' && $date_naissance != '' && $date_embauche != '' && $affectation != '' && $qualification != ''){
                    $query = 'INSERT INTO t_fi001_parent(Mle,nom,prenom, date_naissance, date_embauche,affectation,qualification,etat) VALUES("'.$Mle.'","'.$nom.'", "'.$prenom.'", "'.$date_naissance.'","'.$date_embauche.'","'. $affectation.'","'. $qualification.'","'. $etat.'");';
                }
        //    echo $query;
            if($query != ''){
                   
                if(mysqli_multi_query($conn, $query)){
                    echo '1';
                }else{
                    echo '0';
                }
            }else{
                echo '2';
            }

    
        
        break;
        }
  
?>