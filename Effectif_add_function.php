<?php
date_default_timezone_set('Africa/Tunis'); 
  header('Content-Type: text/html; charset=utf-8');

class Personnel{
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
			die('Error in query: ');//. mysqli_error()
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

	public function getPersonnelListActive(){
		$sqlQuery = "
			SELECT * FROM ".$this->personnelTable." 
			WHERE Motif_Sortie IS NULL AND Date_Sortie_Etab IS NULL";
		return  $this->getData($sqlQuery);
	}

	public function addNewPersonnel($POST){
			
		$sqlInsert = "
			INSERT INTO ".$this->personnelTable."(Mle, Nom, Prenom, Nom_P, Nom_M, Date_N,Lieu_N, CIN, Date_CIN, Num_CNSS, Adresse, Ville,CPostal, S_F, Sexe,Date_Entre_Etab, Date_Sortie_Etab, Motif_Sortie,Tel) 
			VALUES (
				'".$POST['Mle']."','".$POST['Nom']."','".$POST['Prenom']."','".$POST['Nom_P']."','".$POST['Nom_M']."','".$POST['Date_N']."','".$POST['Lieu_N']."','".$POST['CIN']."','".$POST['Date_CIN']."','".$POST['Num_CNSS']."','".mysqli_real_escape_string($this->dbConnect,$POST['Adresse'])."','".mysqli_real_escape_string($this->dbConnect,$POST['Ville'])."','".$POST['CPostal']."','".$POST['S_F']."','".$POST['Sexe']."','".$POST['Date_Entre_Etab']."',NULL,NULL,'".$POST['Tel']."'
			)";
			echo($sqlInsert);echo "<br>";
		mysqli_query($this->dbConnect, $sqlInsert);

		$Dep = explode(':', $POST['Dep'] );
				$id_Dep = $Dep[0]; 
				$nom_Dep = $Dep[1];
		$Serv = explode(':', $POST['Ser'] );
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