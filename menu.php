
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

<script type="text/javascript">
   $(function () {
    setNavigation();
});

function setNavigation() {
    var path = window.location.pathname;
    path = path.replace(/\/$/, "");
    path = (path.substring(path.lastIndexOf('/') + 1));
    $(".navbar  a").each(function () {
        var href = $(this).attr('href');
        if (path.substring(0, href.length) === href) {
            $(this).closest('li').addClass('active');
        }
    });
}

</script>
<nav class="navbar navbar-expand-lg navbar-light bg-light d-print-none">
  <div class="container-fluid">
        <a class="navbar-brand" href="#">Menu </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <?php

              $id=$_SESSION['userid'];

                  $result=$Personnel->UsersRoles($id);
                  $output = '';

// print_r ($result);
if(in_array(1, array_column($result, 'Role'))) { // search value in the array
         $data[]=1;
 $output .= '
 <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="RapportMensuel">Home</a>
        </li>
     ';
   }
      if (in_array(2, array_column($result, 'Role'))) { // search value in the array
         $data[]=2;
         $myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+3 month" ) );
          $sql= "SELECT t_p.ID,t_p.Mle, t_p.Nom,t_d.Date_F,t_p.Active FROM t_contrat_parent AS t_p LEFT JOIN (SELECT t_c.ID_Contrat_parent,MAX(t_c.Date_F) AS Date_F FROM t_contrat_details AS t_c GROUP BY t_c.ID_Contrat_parent) AS t_d ON (t_p.ID=t_d.ID_Contrat_parent) WHERE t_p.Active !=0 HAVING t_d.Date_F<='".$myDate."' ORDER BY t_d.Date_F " ;
 //echo($sql);
 $result1 = mysqli_query($conn, $sql);  

 $rows = mysqli_num_rows($result1);
 $myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+0 month" ) );
 $sql3="SELECT t_p.ID,t_p.Mle, t_p.Nom,t_d.Date_F,t_p.Active FROM t_affectation_p AS t_p LEFT JOIN (SELECT t_d.ID_p,MAX(t_d.Date_F) AS Date_F FROM t_affectation_d AS t_d GROUP BY t_d.ID_p) AS t_d ON (t_p.ID=t_d.ID_p) WHERE ((t_p.Active !=0) AND (t_d.Date_F<='".$myDate."')) ORDER BY t_d.Date_F";
 //echo($sql);
 $result4 = mysqli_query($conn, $sql3);  

 $rows2 = mysqli_num_rows($result4);

$output .= '         
      <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="Effectif" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Effectif
        </a>
        <ul class="dropdown-menu" aria-labelledby="Effectif"></li>
          <li><a class="dropdown-item" href="Effectif">Effectif</a></li>
          <li><a class="dropdown-item" href="Function_qualification">Qualification / Function</a></li>
          <li><a class="dropdown-item" href="GContrats">Gestion Contrats  <span class="badge rounded-pill bg-danger">'.$rows.' </span>
          </a></li>
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="Affectation_Provisoire">Affectation Provisoire     <span class="badge rounded-pill bg-danger">'.$rows2.'</span></a></li>
          <li><a class="dropdown-item" href="Historique_Affectation">Historique Affectations</a></li>
                    <div class="dropdown-divider"></div>
                    <li><a class="dropdown-item" href="Mutations">Les Mutations</a></li>

                    <div class="dropdown-divider"></div>

                    <li><a class="dropdown-item" href="ATT_TRAVAIL">Attestation De Travail</a></li>

        </ul>
      </li>';
      }
      if (in_array(3, array_column($result, 'Role'))) { // search value in the array
         $data[]=3;
$output .= '                  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="organigramme" role="button" data-bs-toggle="dropdown"   aria-expanded="false">
          Organigramme
        </a>      
        <ul class="dropdown-menu" aria-labelledby="organigramme"></li>
        <li><a class="dropdown-item" href="org_chart">org. General</a></li>
        <li><a class="dropdown-item" href="setting_org_chart">changer ordre org.</a></li>
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="#"></a></li>
        </ul>
     </li>    ';
     }  
      if (in_array(4, array_column($result, 'Role'))) { // search value in the array
         $data[]=4;
$output .= '                  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"  aria-expanded="false">
          Pointage
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="ABSinjustifier">Absence Injustifier</a></li>        
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="Pointage">Pointage</a></li>
          <li><a class="dropdown-item" href="#">Another action</a></li>
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="Change_pointage">Changer Pointage</a></li>
        </ul>
      </li>';
   }
      if (in_array(5, array_column($result, 'Role'))) { // search value in the array
         $data[]=5;
       //  $sql1="SELECT t_a.ID,t_a.Mle,t_a.Nom,t_d.Date_F,t_a.Active FROM t_atms AS t_a LEFT JOIN (SELECT t_d.ID_ATMS,MAX(t_d.Date_F) AS Date_F FROM t_atms_details AS t_d GROUP BY t_d.ID_ATMS) AS t_d ON (t_a.ID=t_d.ID_ATMS) WHERE t_a.Active !=0 HAVING t_d.Date_F<= CURDATE() ORDER BY t_d.Date_F";
 //$result2 = mysqli_query($conn, $sql1);  

 $rows1 = 0;
 //$sql5=" SELECT t_a.ID,t_a.Mle,t_a.Nom,t_d.D_p_visite,t_a.Active FROM t_certificat_p AS t_a LEFT JOIN (SELECT t_d.ID_p,MAX(t_d.D_p_visite) AS D_p_visite FROM t_certificat_d AS t_d GROUP BY t_d.ID_p) AS t_d ON (t_a.ID=t_d.ID_p) WHERE t_a.Active !=0 HAVING t_d.D_p_visite<=CURDATE() ORDER BY D_p_visite";
 //$result5 = mysqli_query($conn, $sql5);  
 $rows5 = 0;

$output .= '                  
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"  aria-expanded="false">
          Absence
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="ATMS">AT/MS  <span class="badge rounded-pill bg-danger">'.$rows1.'</span></a></li>
          <div class="dropdown-divider"></div>
          </li><a class="dropdown-item" href="HATMS?Filtre=AT">AT Historique</a></li>
          </li><a class="dropdown-item" href="HATMS?Filtre=MS">MS Historique</a></li>
          <div class="dropdown-divider">Etat</div>
          </li><a class="dropdown-item" href="Effectif_cnss">Effectif</a></li>
          </li><a class="dropdown-item" href="EtatABSANNEE">Etat ABS/ANNEE</a></li>
          <div class="dropdown-divider"></div>
          </li><a class="dropdown-item" href="Certificat_Apptitude">Certificat Aptitude <span class="badge rounded-pill bg-danger">'.$rows5.'</span></a></li>
        </ul>        
      </li>';
}
      if (in_array(6, array_column($result, 'Role'))) { // search value in the array
        
$output .= '                  
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"  aria-expanded="false">Application</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="Avancementechlon">Avancement Normal</a></li>
        <li><a class="dropdown-item" href="Historique_Avancement">Historique Avancement</a></li>
          <div class="dropdown-divider"></div>



          <li><a class="dropdown-item" href="NoteMensuelle?action=select">Note Mensuelle</a></li>
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="CA">Congé Annuel</a></li>
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="Promotion">Promotion</a></li>

          <div class="dropdown-divider"></div>

          <li><a class="dropdown-item" href="57ans">57 ANS</a></li>          
        </ul>
      </li>';
}
      if (in_array(7, array_column($result, 'Role'))) { // search value in the array
$output .= '                  
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="ppi/docs/" id="navbarDropdown" role="button" data-bs-toggle="dropdown"  aria-expanded="false">
          PPI
        </a>
      </li>';
}

echo($output);
?>      
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"  aria-expanded="false">
          Logged in : 
          <?php
            $_SESSION['Role'] = $data;
            echo $_SESSION['user']; 
         ?>
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">Comptes</a></li>
          <div class="dropdown-divider"></div>
          <li><a class="dropdown-item" href="Action.php?action=logout">Déconnexion</a></li>
        </ul>
      </li>      
    </ul>
  </div>
  </div>
</nav>

<?php //print_r ($result); ?>