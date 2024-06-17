<?php
date_default_timezone_set('Africa/Tunis'); 
if(!isset($_SESSION)) 
{ 
	session_name("personnel");
	session_start(); 
} 

class Personnel{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "root";
    private $database  = "stipdb";   
	private $invoiceUserTable = 'users';	
    private $personnelTable = 't_personnels';
	private $invoiceOrderItemTable = 'invoice_order_item';
    private $depsTable = 't_departements';
    private $servicesTable = 't_services';	
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
  if (!$conn->set_charset("utf8")) {
      printf("Error loading character set utf8: %s\n", $conn->error);
  } else {
      //printf("Current character set: %s\n", $conn->character_set_name());
  }
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: ');
		}
		$data= array();
		while ($row = mysqli_fetch_array($result)) {
			$data[]=$row;
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: ');
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile 
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}
	public function checkLoggedIn(){
		if(!isset($_SESSION['userid'])) {
			header("Location:Home");
		}
	}	
	public function UsersRoles($id){
		$sqlQuery = "
			SELECT ID, ID_USER, Role, privileges
			FROM Users_roles 
			WHERE ID_USER='".$id."' ";
        return  $this->getData($sqlQuery);
	}					


	public function getPersonnelList(){
		$sqlQuery = "
			SELECT * FROM ".$this->personnelTable." 
			";
		return  $this->getData($sqlQuery);
	}

	public function getPersonnelListActive(){
		$sqlQuery = "SELECT Per.ID,Per.Mle,Per.Nom,Per.Prenom,Pos.Nom_Dep,Pos.Nom_Service,Per.Date_N,Per.Date_Anc,Per.Date_Entre_Etab  
		FROM `t_personnels` AS Per LEFT OUTER JOIN t_postes AS Pos ON Per.Mle=Pos.Mle AND Pos.Active=1 WHERE Per.Motif_Sortie IS NULL AND Per.Date_Sortie_Etab IS NULL ORDER BY CAST(`Per`.`Mle` as unsigned) ASC";
		return  $this->getData($sqlQuery);
	}
    public function getPersonnelinfo($Mle){
		$sqlQuery = "
			SELECT *,DEP.Nom_Dep AS Nom_Dep, DEP2.Nom_Dep AS Nom_Ser FROM t_personnels AS PER,t_postes AS POS 
			LEFT JOIN t_departements AS DEP ON POS.`Nom_Dep` = DEP.`Nom_Dep`
			LEFT JOIN t_departements AS DEP2 ON POS.`Nom_Service` = DEP2.`Nom_Dep`
			WHERE PER.Mle=POS.Mle AND POS.Mle =".$Mle." AND POS.Active = 1 ";
			//echo($sqlQuery);
		return  $this->getData($sqlQuery);
	}
    public function getAge($id){
		$sqlQuery = "
			SELECT ROUND((DATEDIFF(CURRENT_DATE, Date_N)/365),2) AS ageInYears,ROUND((DATEDIFF(CURRENT_DATE, Date_Anc)/365),2) AS AncInYears FROM ".$this->personnelTable." 
			WHERE ID =".$id."";
	return  $this->getData($sqlQuery);
	}
    public function getMotifSortie(){
		$sqlQuery = "
			SELECT * FROM t_motifs_sortie";
		return  $this->getData($sqlQuery);
	}
	public function setdateSortie($POST){
		$sqlInsert = "
		UPDATE `t_personnels` 
		SET `Date_Sortie_Etab` = '".$POST['Date_Sortie_Etab']."' , `Motif_Sortie` ='".$POST['Motif_Sortie']."' WHERE `t_personnels`.`Mle` = '".$POST['Mle']."';
			";
			mysqli_query($this->dbConnect, $sqlInsert);	
			return $sqlInsert;
	}

	public function getPersonnelListPartants(){
		$sqlQuery = "
			SELECT * FROM ".$this->personnelTable." 
			WHERE (Motif_Sortie IS NOT NULL) AND (Date_Sortie_Etab IS NOT NULL)";
		return  $this->getData($sqlQuery);
	}

	//functions Charts organigramme		
	public function getDeps($ID_dep_Sup,$niveau){
		$sqlQuery = "
			SELECT * FROM ".$this->depsTable."
			WHERE ID_dep_Sup=$ID_dep_Sup AND Ord_Dep=$niveau ORDER BY `Ord_Dep` ASC";
			//echo($sqlQuery);
			//echo "<br>";
		return  $this->getData($sqlQuery);
	}
	public function getServices($id){
		$sqlQuery = "
			SELECT * FROM ".$this->servicesTable." 
			WHERE (ID_Dep=".$id.")";
		return  $this->getData($sqlQuery);
	}

public function organigrame($Nom,$lev){
$sqlQuerylev1 = "
SELECT t1.`ID` AS ID1, t1.`Nom_Dep` AS lev1,t2.`ID` AS ID2, t2.`Nom_Dep` as lev2,t3.`ID` AS ID3, t3.`Nom_Dep` as lev3,t4.`ID` AS ID4, t4.`Nom_Dep` as lev4
FROM t_departements AS t1
LEFT JOIN t_departements AS t2 ON t2.`ID_dep_Sup` = t1.`ID`
LEFT JOIN t_departements AS t3 ON t3.`ID_dep_Sup` = t2.`ID`
LEFT JOIN t_departements AS t4 ON t4.`ID_dep_Sup` = t3.`ID`
WHERE t1.`Nom_Dep` = '$Nom' GROUP BY lev1";
$sqlQuerylev2 = "
SELECT t1.`Nom_Dep` AS lev1, t2.`Nom_Dep` as lev2, t3.`Nom_Dep` as lev3, t4.`Nom_Dep` as lev4
FROM t_departements AS t1
LEFT JOIN t_departements AS t2 ON t2.`ID_dep_Sup` = t1.`ID`
LEFT JOIN t_departements AS t3 ON t3.`ID_dep_Sup` = t2.`ID`
LEFT JOIN t_departements AS t4 ON t4.`ID_dep_Sup` = t3.`ID`
WHERE t1.`Nom_Dep` = '$Nom' GROUP BY lev2";
$sqlQuerylev3 = "
SELECT t1.`Nom_Dep` AS lev1, t2.`Nom_Dep` as lev2, t3.`Nom_Dep` as lev3, t4.`Nom_Dep` as lev4
FROM t_departements AS t1
LEFT JOIN t_departements AS t2 ON t2.`ID_dep_Sup` = t1.`ID`
LEFT JOIN t_departements AS t3 ON t3.`ID_dep_Sup` = t2.`ID`
LEFT JOIN t_departements AS t4 ON t4.`ID_dep_Sup` = t3.`ID`
WHERE t1.`Nom_Dep` = '$Nom' GROUP BY lev3";
$sqlQuerylev4 = "
SELECT t1.`Nom_Dep` AS lev1, t2.`Nom_Dep` as lev2, t3.`Nom_Dep` as lev3, t4.`Nom_Dep` as lev4
FROM t_departements AS t1
LEFT JOIN t_departements AS t2 ON t2.`ID_dep_Sup` = t1.`ID`
LEFT JOIN t_departements AS t3 ON t3.`ID_dep_Sup` = t2.`ID`
LEFT JOIN t_departements AS t4 ON t4.`ID_dep_Sup` = t3.`ID`
WHERE t1.`Nom_Dep` = '$Nom' GROUP BY lev4";


$lev1 = $this->getData($sqlQuerylev1);
$lev2 = $this->getData($sqlQuerylev2);
$lev3 = $this->getData($sqlQuerylev3);
$lev4 = $this->getData($sqlQuerylev4);

// lev1
	echo($sqlQuerylev1);
	foreach($lev1 as $Depname1){
     echo '<ul><li><a href="#">'.$Depname1["lev1"].'</a>';
     $this->services($Depname1["ID1"]);
     // lev2
     if (isset($Depname1["lev2"])) {
     	  echo '<ul >';
			//echo($sqlQuerylev2);
     	  	foreach($lev2 as $Depname2){
     	 	echo '<li class="'.$Depname2["lev2"].'"><a href="#">'.$Depname2["lev2"].'</a>';
     		$this->services($Depname1["ID2"]);
				// lev3	
				if (isset($Depname2["lev3"])) { 	 	
     	 			foreach($lev2 as $Depname2){
     	 				if (isset($Depname2["lev3"])) {
				     	  echo '<ul>';
							//echo($sqlQuerylev3);
				     	  	foreach($lev3 as $Depname3){
				     	  		if(isset($Depname3["lev3"])){
				     	 		echo '<li class="'.$Depname3["lev3"].'"><a href="#">'.$Depname3["lev3"].'</a>';
		     						if (isset($Depname3["lev4"])) {
		     							echo '<ul>';	
		     							foreach($lev4 as $Depname4){
		     							if(isset($Depname4["lev4"]) && ($Depname3["lev3"]==$Depname4["lev3"]))
		     								echo '<li class="'.$Depname4["lev4"].'"><a href="#">'.$Depname4["lev4"].'</a>';
		     							}echo '</ul>';
		     						}
     							}echo '</li>';
     						}
     						echo '</ul>';
     					}
     				}
     				echo '</li>';
     			}
     		}
    	}
    }

}


public function services($id){

$sqlQuerylev = "SELECT * FROM t_departements AS t LEFT JOIN t_services AS s ON t.ID=s.ID_Dep WHERE t.ID=$id";
 //echo($sqlQuerylev);
//echo'<ul>';
 for ($i=0; $i <(4-$id) ; $i++) { 
 //echo '<ul><li></li></ul> ';
 }
 //echo'</ul>';
}



public function organigrame2($Nom){
$sqlQuerylev1 = "
SELECT t1.`ID` AS ID1, t1.`Nom_Dep` AS lev1,t2.`ID` AS ID2, t2.`Nom_Dep` as lev2,t3.`ID` AS ID3, t3.`Nom_Dep` as lev3,t4.`ID` AS ID4, t4.`Nom_Dep` as lev4
FROM t_departements AS t1
LEFT JOIN t_departements AS t2 ON t2.`ID_dep_Sup` = t1.`ID`
LEFT JOIN t_departements AS t3 ON t3.`ID_dep_Sup` = t2.`ID`
LEFT JOIN t_departements AS t4 ON t4.`ID_dep_Sup` = t3.`ID`
WHERE t1.`Nom_Dep` = '$Nom' GROUP BY lev2";
echo ($sqlQuerylev1);
$lev1 = $this->getData($sqlQuerylev1);
$result = mysqli_query($this->dbConnect, $sqlQuerylev1);	
$row = mysqli_fetch_array($result);

if (!empty($row["lev2"]) || !empty($row["lev3"]) || !empty($row["lev3"])) {
	echo "<ul>";
	foreach($lev1 as $Depname1){
     echo '<li><a href="#">'.$Depname1["lev1"].'</a>';
      $this->organigrame2($row["lev2"]);
 }
}
	
}


public function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
//echo'<br>';
//echo($currentParent.' '. $currLevel.' '.$prevLevel);
echo'<br>';
foreach ($array as $categoryId => $category) {

if ($currentParent == $category['parent_id']) {                       
    if ($currLevel > $prevLevel)
    		echo ' <button type="button" class="plus btn btn-outline-success btn-xs">+</button><ul class="ul_submenu"> '; 

    if ($currLevel == $prevLevel) echo " </li> ";
    
    if ($category['Type']=="dep")
    echo '<li> <a href="org_chart?dep='.$category['id'].'">'.$category['name'].'</a>';
	else
		echo '<li> <a class="service" href="org_chart?service'.$category['id'].'">'.$category['name'].'</a>';
    if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

    $currLevel++; 

    $this->createTreeView ($array, $categoryId, $currLevel, $prevLevel);

    $currLevel--;               
    }   

}

if ($currLevel == $prevLevel) echo " </li>  </ul> ";

}   

public function queryTreeView($dep=1){
	if ($dep!=1){
		$qry="SELECT * FROM t_departements";
			}
			else{
			$qry="SELECT * FROM t_departements";
	}
echo($qry);
$result=mysqli_query($this->dbConnect, $qry);
return $result;

}

public function gotoTreenode($dep){
	$qry="SELECT * FROM t_departements WHERE ID='$dep'";
	$result=mysqli_query($this->dbConnect, $qry);
		$row = mysqli_fetch_array($result);
		echo($qry);
echo'<ul><li> <a href="org_chart?dep='.$row['ID'].'">'.$row['Nom_Dep'].'</a>';
}
  public function Attestation_Travail($Mle){
		$sqlQuery = "
			SELECT * FROM t_personnels p,t_postes pos
			WHERE p.Mle=pos.Mle AND p.Mle=".$Mle." AND pos.Active='1'";
		return  $this->getData($sqlQuery);
	}

	public function Attestation_Travail_ref(){
		$year=date("Y");
		$sqlQuery = "
			SELECT  *  FROM t_attestation_travail 
			WHERE YEAR(Date_le)=".$year."
			ORDER BY Date_le DESC LIMIT 3 ";
		return  $this->getData($sqlQuery);
	}

	public function saveAttestation_Travail($POST) {
		if (!isset($POST['Num_CNSS'])) {
			$POST['Num_CNSS']=NULL;
		}
		$sqlInsert = "
			INSERT INTO t_attestation_travail (Ord_ref, Mle, Nom, Num_CNSS, Qualification) 
			VALUES ('".$POST['Ord_ref']."', '".$POST['mle_att']."', '".$POST['Nom']."', '".$POST['Num_CNSS']."', '".mysqli_real_escape_string($this->dbConnect,$POST['Qualification'])	."') ";		
		mysqli_query($this->dbConnect, $sqlInsert);
		//echo $sqlInsert;
	}

	public function Attestation_Travail_history($Mle,$ref='',$datele=''){
		$year=date("Y");
		if ($ref!='') {
		$sqlQuery = "
			SELECT  t.*,p.Sexe FROM t_attestation_travail t,t_personnels p
			WHERE t.Mle=p.Mle AND p.Mle=".$Mle." AND t.Ord_ref=".$ref."
			ORDER BY Date_le DESC LIMIT 1
			";
		}elseif ($datele!='') {
		$sqlQuery = "
			SELECT  t.*,p.Sexe FROM t_attestation_travail t,t_personnels p
			WHERE t.Mle=p.Mle AND p.Mle=".$Mle." AND t.Ord_ref=".$ref." AND Date_le='".$datele."'
			ORDER BY Date_le DESC
			";
		}else{
		$sqlQuery = "
			SELECT  * FROM t_attestation_travail 
			WHERE Mle=".$Mle." 
			ORDER BY Date_le DESC
			LIMIT 5

			";
			}
			//echo $sqlQuery;
		return  $this->getData($sqlQuery);
	}


//////
	//
	//
	//
	//function exemples		
	//
	//
	//
//////

	
	public function saveInvoice($POST) {
	
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."(user_id, order_BC, order_Date_BC, nom_fournisseur, order_total_before_tax, order_total_tax, order_total_amount_due, note) 
			VALUES ('".$POST['userId']."', '".$POST['BC']."', '".$POST['Date_bc']."', '".mysqli_real_escape_string($this->dbConnect,$POST['Fournisseurs'])."', '".$POST['subTotal']."', '".$POST['Timbre']."', '".$POST['totalAfterTimbre']."', '".mysqli_real_escape_string($this->dbConnect,$POST['notes'])."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
				$subcheck = (isset($_POST['Coutrepas'][$i])) ? 1 : 0;

			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, PixHTVA, order_item_price,TVA, Remise, order_item_final_amount, CR) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".mysqli_real_escape_string($this->dbConnect,$POST['productName'][$i])."', '".$POST['quantity'][$i]."', '".$POST['PixHTVA'][$i]."', '".$POST['price'][$i]."', '".$POST['taxUT'][$i]."', '".$POST['Remise'][$i]."','".$POST['total'][$i]."','".$subcheck."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
			//echo $sqlInsert;
			//echo "<br>";
			//echo $sqlInsertItem;
			//echo "<br>";
		}       	
	}	
	public function updateInvoice($POST) {

		if($POST['invoiceId']) {	
			$sqlInsert = "
				UPDATE ".$this->invoiceOrderTable." 
				SET order_BC = '".$POST['BC']."', order_Date_BC= '".$POST['Date_bc']."', nom_fournisseur= '".$POST['Fournisseurs']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['Timbre']."', order_total_amount_due = '".$POST['totalAfterTimbre']."', note = '".mysqli_real_escape_string($this->dbConnect,$POST['notes'])."' 
				WHERE  order_id = '".$POST['invoiceId']."'";		
				//echo $sqlInsert;
				//echo("<br>");				
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {		
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, PixHTVA, order_item_price,TVA, Remise, order_item_final_amount, CR) VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".mysqli_real_escape_string($this->dbConnect,$POST['productName'][$i])."', '".$POST['quantity'][$i]."', '".$POST['PixHTVA'][$i]."', '".$POST['price'][$i]."', '".$POST['taxUT'][$i]."', '".$POST['Remise'][$i]."','".$POST['total'][$i]."','".$_POST['Coutrepas'][$i]."')";
			//echo($sqlInsertItem);
			//echo("<br>");
			//echo($_POST['Coutrepas'][$i]);
			//echo("<br>");
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}	
	public function getInvoiceList(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			";
		return  $this->getData($sqlQuery);
	}

	public function search_invoice($search){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE order_BC LIKE '%".$search."%'";
		return  $this->getData($sqlQuery);
	
	}		
	public function getInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result);
		return $row;
	}	
	public function getInvoiceItems($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}
	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}
	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return 1;
	}
		public function Availability (){
		$sql= "SELECT order_BC FROM invoice_order WHERE order_BC='".$_POST['user']."'";
		return  $this->getNumRows($sql);
	}
}

class Personnel1{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "root";
    private $database  = "stipdb";
	//private $database  = "stipdb_test";      
	private $invoiceUserTable = 'users';	
    private $personnelTable = 't_personnels';
	private $invoiceOrderItemTable = 'invoice_order_item';
    private $depsTable = 't_departements';
    private $servicesTable = 't_services';	
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
  if (!$conn->set_charset("utf8")) {
      printf("Error loading character set utf8: %s\n", $conn->error);
  } else {
      //printf("Current character set: %s\n", $conn->character_set_name());
  }
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: ');
		}
		$data= array();
		while ($row = mysqli_fetch_array($result)) {
			$data[]=$row;
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: ');//. mysqli_error()
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile 
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}
	public function UsersRoles($id){
		$sqlQuery = "
			SELECT ID, ID_USER, Role, privileges
			FROM Users_roles 
			WHERE ID_USER='".$id."' ";
        return  $this->getData($sqlQuery);
	}					
	public function checkLoggedIn(){
		if(!isset($_SESSION['userid'])) {
			header("Location:Home");
		}
	}	

public function getPersonnelList(){
		$sqlQuery = "
			SELECT * FROM ".$this->personnelTable." 
			";
		return  $this->getData($sqlQuery);
	}

	// public function getPersonnelListActive(){
	// 	$sqlQuery = "
	// 		SELECT * FROM ".$this->personnelTable." 
	// 		WHERE Motif_Sortie IS NULL AND Date_Sortie_Etab IS NULL";
	// 	return  $this->getData($sqlQuery);
	// }

	public function addNewPersonnel($POST){
			
		$sqlInsert = "
			INSERT INTO ".$this->personnelTable."(Mle, Nom, Prenom, Nom_P, Nom_M, Date_N, CIN, Num_CNSS, Adresse, Ville, S_F, Sexe,Date_Entre_Etab, Date_Sortie_Etab, Motif_Sortie,Tel) 
			VALUES (
				'".$POST['Mle']."','".$POST['Nom']."','".$POST['Prenom']."','".$POST['Nom_P']."','".$POST['Nom_M']."','".$POST['Date_N']."','".$POST['CIN']."','".$POST['Num_CNSS']."','".mysqli_real_escape_string($this->dbConnect,$POST['Adresse'])."','".mysqli_real_escape_string($this->dbConnect,$POST['Ville'])."','".$POST['S_F']."','".$POST['Sexe']."','".$POST['Date_Entre_Etab']."',NULL,NULL,'".$POST['Tel']."'
			)";
			echo($sqlInsert);echo "<br>";
		mysqli_query($this->dbConnect, $sqlInsert);

		$Dep = explode(':', $POST['Dep'] );
				$id_Dep = $Dep[0]; 
				$nom_Dep = $Dep[1];
		$Serv = explode(':', $POST['Dep'] );
				$id_Serv = $Serv[0]; 
				$nom_Serv = $Serv[1];	
        		 
		
		$sql = "INSERT INTO t_postes(Mle, Fonction, Position,Qualification,College,Active,Date_Poste, Id_Dep, Nom_Dep, Id_Service, Nom_Service, Ref) VALUES('".$_POST["Mle"]."', '".$_POST["Fonction"]."', '".$_POST["Position"]."', '".$_POST["Qualification"]."', '".$_POST["College"]."','1', '".$_POST["Date_Entre_Etab"]."','".$id_Dep."' ,'" .mysqli_real_escape_string($this->dbConnect,$nom_Dep)."','".$id_Serv."','".mysqli_real_escape_string($this->dbConnect,$nom_Serv)."','Recrutement')"; 
		echo $sql;echo "<br>";
		mysqli_query($this->dbConnect, $sql);
		
		if (isset($POST['Nscolaire']) || isset($POST['Diplome'])) {
			isset($POST['Nscolaire']) ? $Nscolaire=$POST['Nscolaire'] : $Nscolaire=NULL;
			isset($POST['Diplome']) ? $Diplome=$POST['Diplome'] : $Diplome=NULL;
			$sql = "INSERT INTO t_info_p(Mle, NIVEAU_SCOLAIRE, DIPLOME) VALUES( '".$_POST["Mle"]."','".$Nscolaire."', '".$Diplome."')"; 
		echo $sql;
		mysqli_query($this->dbConnect, $sql);
		}
		
	}

	public function SelectDep(){
	$Dep ='';
	$sqlDep = "SELECT * FROM `t_departements`
	WHERE Type ='dep' ORDER BY ID ASC";  
	 $resultDep = mysqli_query($this->dbConnect, $sqlDep);  
	 $Dep .='<select name="dep-select" class="dep-select" required>';
	  $Dep .='<option value="" class="isdep"></option>';
	while($rowDep = mysqli_fetch_array($resultDep))  {
	  $Dep .='<option value="'.$rowDep["ID"].'" class="isdep">'.$rowDep["Nom_Dep"].'</option>';
	}
	 $Dep .='</select>';
	 echo $Dep;
	}
	

	public function getDep(){
		$sqlQuery = "SELECT ID As Id , Nom_Dep
		FROM t_departements
		WHERE Type= 'Dep'
		   GROUP BY  ID";
			 $result=  $this->getData($sqlQuery);
		
	$output='';
	$output .='<datalist id="datalistdep">';
	foreach($result as $resultItem){
		$output .='<option value="'.$resultItem["Id"]. ':' .$resultItem["Nom_Dep"].'"  >';
	}
		$output .='</datalist>';
		echo $output;
	}


	public function getService($id_dep){
		$sqlQuery = "SELECT ID As Id, Nom_Dep 
			 FROM t_departements 
			 WHERE Type='service'
			 AND  ID_dep_Sup ='".$id_dep."'
			 GROUP BY  ID "; 
			 $result=  $this->getData($sqlQuery);
		
	$output='';
	$output .='<datalist id="datalistser">';
	foreach($result as $resultItem){
		$output .='<option value="'.$resultItem["Id"]. ':' .$resultItem["Nom_Dep"].'"  >';
	}
		$output .='</datalist>';
		echo $output;
			//echo $sqlQuery;
	
	}
	
	public function getInfo_affectation_provisoire(){
		$sqlQuery = "SELECT Per.ID,Per.Mle,Per.Nom,Per.Prenom,Pos.Nom_Dep,Pos.Fonction,Pos.Nom_Service,Per.Date_N,Per.Date_Anc,Per.Date_Entre_Etab  
		FROM `t_personnels` AS Per LEFT OUTER JOIN t_postes AS Pos ON Per.Mle=Pos.Mle AND Pos.Active=1 WHERE Per.Motif_Sortie IS NULL AND Per.Date_Sortie_Etab IS NULL ORDER BY CAST(`Per`.`Mle` as unsigned) ASC";
			 $result=  $this->getData($sqlQuery);
		
	$output='';
	$output .='<datalist id="datalistefect">';
	foreach($result as $resultItem){
		$output .='<option value="'.$resultItem["Mle"]. ':' .$resultItem["Prenom"].' ' .$resultItem["Nom"].'">';
	}
		$output .='</datalist>';
		echo $output;
	}


}
?>