<?php
date_default_timezone_set('Africa/Tunis'); 

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
	public function UsersRoles($id){
		$sqlQuery = "
			SELECT ID, ID_USER, Role
			FROM users_roles 
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

	public function getPersonnelListActive($mois,$annee){
		$date = $annee."-".$mois."-01";
		//echo$date."<br>";
		$date_Anc=date("Y-m-t", strtotime($date));
		$sqlQuery = "
			SELECT count(*) FROM ".$this->personnelTable." 
			WHERE Date_Entre_Etab <= '$date_Anc' AND (Date_Sortie_Etab IS NULL or Date_Sortie_Etab >= '$date_Anc') ";
			//echo $sqlQuery."<br>";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$row = mysqli_fetch_array($result);
			return  $row;
	}

	public function getPersonnelRecrute($mois,$annee){
		$date = $annee."-".$mois."-01";
		//echo$date."<br>";
		$date_Anc=date("Y-m-t", strtotime($date));
		$sqlQuery = "
			SELECT count(*) FROM ".$this->personnelTable." 
			WHERE Date_Entre_Etab <= '$date_Anc' AND Date_Entre_Etab>= '$date' ";
			//echo $sqlQuery."<br>";
		$sqlQuery2 = "
			SELECT * FROM ".$this->personnelTable." 
			WHERE Date_Entre_Etab <= '$date_Anc' AND Date_Entre_Etab>= '$date' ";
		$recrute=$this->getData($sqlQuery2);

			//echo $sqlQuery."<br>";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$row = mysqli_fetch_array($result);
			$output='<a role="button" class="btn btn-outline-primary" data-title="tooltip" data-html="true" data-placement="top" title="<ul>';
	foreach($recrute as $recrutedetails){
		$output.='<li>'.$recrutedetails['Mle'].'-'.$recrutedetails['Nom'].' '.$recrutedetails['Prenom'].'</li>';
		}
			$output.='</ul>">'.$row[0].'</a>';

			return  $output;
	}

	public function getPersonnelDepart($mois,$annee){
		$date = $annee."-".$mois."-01";
		//echo$date."<br>";
		$date_Anc=date("Y-m-t", strtotime($date));
		$sqlQuery = "
			SELECT count(*) FROM ".$this->personnelTable." 
			WHERE Date_Sortie_Etab <= '$date_Anc' AND Date_Sortie_Etab>= '$date' ";
		$sqlQuery2 = "
			SELECT * FROM ".$this->personnelTable." 
			WHERE Date_Sortie_Etab <= '$date_Anc' AND Date_Sortie_Etab>= '$date' ";
		$departs=$this->getData($sqlQuery2);

			//echo $sqlQuery."<br>";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$row = mysqli_fetch_array($result);
			$output='<a role="button" class="btn btn-outline-primary" data-title="tooltip" data-html="true" data-placement="top" title="<ul>';
	foreach($departs as $departdetails){
		$output.='<li>'.$departdetails['Mle'].'-'.$departdetails['Nom'].' '.$departdetails['Prenom'].'</li>';
		}
			$output.='</ul>">'.$row[0].'</a>';

			return  $output;
	}

	public function getPersonnelinfo($Mle){
		$sqlQuery = "
			SELECT *,DEP.Nom_Dep AS Nom_Dep, DEP2.Nom_Dep AS Nom_Ser FROM t_personnels AS PER,t_postes AS POS 
			LEFT JOIN t_departements AS DEP ON POS.`ID_Dep` = DEP.`ID`
			LEFT JOIN t_departements AS DEP2 ON POS.`ID_Service` = DEP2.`ID`
			WHERE PER.Mle=POS.Mle AND POS.Mle =".$Mle." AND POS.Active = 1 ";
			//echo($sqlQuery);
		return  $this->getData($sqlQuery);
	}

	public function getAge($id){
		$sqlQuery = "
			SELECT ROUND((DATEDIFF(CURRENT_DATE, Date_N)/365),2) AS ageInYears,ROUND((DATEDIFF(CURRENT_DATE, Date_Entre_Etab)/365),2) AS AncInYears FROM ".$this->personnelTable." 
			WHERE ID =".$id."";
		return  $this->getData($sqlQuery);
	}

	public function addNewPersonnel($POST){
		$sqlInsert = "
			INSERT INTO ".$this->personnelTable."(Mle, Nom, Prenom, Nom_P, Nom_M, Date_N, CIN, Num_CNSS, Adresse, Ville, S_F, Sexe,Date_Entre_Etab, Date_Sortie_Etab, Motif_Sortie) 
			VALUES (
				'".$POST['Mle']."','".$POST['Nom']."','".$POST['Prenom']."','".$POST['Nom_P']."','".$POST['Nom_M']."','".$POST['Date_N']."','".$POST['CIN']."','".$POST['Num_CNSS']."','".mysqli_real_escape_string($this->dbConnect,$POST['Adresse'])."','".$POST['Ville']."','".$POST['S_F']."','".$POST['Sexe']."','".$POST['Date_Entre_Etab']."',NULL,NULL
			)";
			echo($sqlInsert);
		mysqli_query($this->dbConnect, $sqlInsert);
		
	}

	public function getMotifSortie(){
		$sqlQuery = "
			SELECT * FROM t_motifs_sortie 
			";
		return  $this->getData($sqlQuery);
	}



	public function getPersonnelListPartants(){
		$sqlQuery = "
			SELECT * FROM ".$this->personnelTable." 
			WHERE (Motif_Sortie IS NOT NULL) AND (Date_Sortie_Etab IS NOT NULL)";
		return  $this->getData($sqlQuery);
	}

	public function getCollege(){
		$sqlQuery = "		
SELECT 
COUNT(*) AS TOTAL,
sum(case when POS.College = 'Exécution' then 1 else 0 end) as E,
sum(case when POS.College = 'Cadre' then 1 else 0 end) as C,
sum(case when POS.College = 'Maîtrise' then 1 else 0 end) as M
FROM t_personnels AS PER
LEFT JOIN t_postes AS POS ON POS.`Mle` = PER.`Mle`
WHERE PER.Date_Sortie_Etab IS NULL AND POS.Active=1";
		return  $this->getData($sqlQuery);
}


}
?>