<?php
include('header.php'); 
include 'Rapport_mensuel_functions.php';
$Personnel = new Personnel();
$Personnel->checkLoggedIn();


?>
    <title>Home</title>
    <script type="text/javascript">
    $(document).ready(function() {
        $(function () {
          $('[data-title="tooltip"]').tooltip()
        });
      });
    </script>
  <body>
  <?php
include('menu.php');
//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
if (!in_array(1, $_SESSION['Role'])) { // search value in the array
   header("Location:RapportMensuel");
}
?> 
  	
   	<div class="content">
  	       <h3 text-align="center">Rapport Mensuel  
                    <?php if(!empty($_POST['yearselect'])){
                                $next_year = $_POST['yearselect']+1;
                                echo $_POST['yearselect'];

                            }else{
                                $current_year=date("Y");
                                $next_year = $current_year+1;
                                echo($current_year);

                            }?></h3><br/>
 
                <form action="" id="invoice-form" method="post" class="invoice-form container" role="form"> 
                    <div class="row justify-content-start">                   
                        <div class="col-4">
                            <input name="yearselect" id="yearselect" type="number" min="2018" max="2099" step="1" value=
                            <?php if(!empty($_POST['yearselect'])){
                                echo $_POST['yearselect'];
                                $current_year=$_POST['yearselect'];
                            }else{
                                $current_year=date("Y");
                                echo($current_year);
                            }?> required/>
                            <button type="submit" class="btn btn-success" >Filtre</button>
                        </div>
                    </div>
                </form>
<div class="container">  	
  	<h2>EVOLUTION MENSUELLE DE L'EFFECTIF : </h2>
  	
<table class="table table-bordered">
<thead>
  <tr><th>MOIS</th>
    <th>Dec n-1</th>
    <th>Janv</th>
    <th>Fev</th>
    <th>Mars</th>
    <th>Avril</th>
    <th>Mai</th>
    <th>Juin</th>
    <th>Juil</th>
    <th>Aout</th>
    <th>Sept</th>
    <th>Oct</th>
    <th>Nov</th>
    <th>Dec</th>
  </tr>
</thead>
<tbody>
 <tr>
  <td>EFFECTIF</td>
  <td><?php $result=$Personnel->getPersonnelListActive(12,$current_year-1); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(1,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(2,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(3,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(4,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(5,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(6,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(7,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(8,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(9,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(10,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(11,$current_year); echo $result[0];?></td>
  <td><?php $result=$Personnel->getPersonnelListActive(12,$current_year); echo $result[0];?></td>
</tr>
 <tr>
  <td>MUTATION</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
 <tr><td>RECRUTEMENT</td>
  <td><?php $result=$Personnel->getPersonnelRecrute(12,$current_year-1); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(1,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(2,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(3,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(4,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(5,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(6,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(7,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(8,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(9,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(10,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(11,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelRecrute(12,$current_year); echo $result;?></td>
</tr>
 <tr>
  <td>DEPARTS</td>
  <td><?php $result=$Personnel->getPersonnelDepart(12,$current_year-1); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(1,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(2,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(3,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(4,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(5,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(6,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(7,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(8,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(9,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(10,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(11,$current_year); echo $result;?></td>
  <td><?php $result=$Personnel->getPersonnelDepart(12,$current_year); echo $result;?></td>
</tr>
</tbody>
</table>
  	<div class="line"></div>
  <div class="row">
    <div class="col">
  	<h2>REPARTITION DE L'EFFECTIF PAR COLLEGE :</h2>
<table class="table table-bordered">
<thead><tr>
  <th>COLLEGE</th>
  <th>NBR</th>
  <th>AGE MOYEN</th>
</tr>
</thead>
<tbody>
 <tr>
  <td>CADRE</td>
  <td></td>
  <td></td>
</tr>
 <tr>
  <td>MAITRISE</td>
  <td></td>
  <td></td>
</tr>
 <tr><td>EXECUTION</td>
  <td></td>
  <td></td>
</tr>
 <tr>
  <td>TOTAL</td>
  <td></td>
  <td></td>
</tr>
</tbody>
</table>
    </div>
    <div class="col">
    <h2>REPARTITION SOCIO PROFESSIONNELLE  DE L'EFFECTIF :</h2>
<table class="table table-bordered">
<thead>
  <tr>
    <th>CONTRAT</th>
    <th>CADRE</th>
    <th> </th>
    <th>MAIT</th>
    <th>EXECU</th>
    <th>TOTAL</th>
  </tr>
</thead>
<tbody>
 <tr>
  <td>PERMANENT</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>0</td>
</tr>
 <tr>
  <td>CONTRACTUEL</td>
  <td></td>
  <td> </td>
  <td> </td>
  <td>0</td>
</tr>
 <tr>
  <td>A L'ESSAI</td>
  <td> </td>
  <td> </td>
  <td> </td>
  <td>0</td>
</tr>
 <tr>
  <td>SIVP</td>
  <td> </td>
  <td> </td>
  <td> </td>
  <td>0</td>
</tr>
 <tr>
  <td>CAIP</td>
  <td> </td>
  <td> </td>
  <td> </td>
  <td>0</td>
</tr>
 <tr>
  <td>TOTAL</td>
  <td>0</td>
  <td>0</td>
  <td>0</td>
  <td>0</td>
  <td>0</td>
</tr>
</tbody>
</table>
      </div>
  </div>

    <div class="line"></div>

  <div class="row">
    <div class="col">
  	<h2>REPARTITION DE L'EFFECTIF PAR TRANCHE D'AGE :</h2>

<table class="table table-bordered">
<thead>
  <tr>
    <th>AGE</th>
    <th>NBR</th>
  </tr>
</thead>
<tbody>
 <tr>
  <td>AGE &lt; 20 ANS</td>
    <td> </td>
  </tr>
 <tr>
  <td> 20 &lt; AGE &lt; 30 </td>
  <td> </td>
</tr>
 <tr>
  <td>30 &lt; AGE &lt; 40</td>
  <td> </td>
</tr>
 <tr>
  <td>40 &lt; AGE &lt; 50</td>
  <td> </td>
</tr>
 <tr><td> 50 &lt; AGE &lt; 55</td>
  <td> </td>
</tr>
 <tr><td> ≥ 55 ANS</td>
  <td></td>
</tr>
</tbody>
</table>
   	</div>
    <div class="col">
    <h2>REPARTITION DE L'EFFECTIF PAR ANCIENNETE :</h2>

<table class="table table-bordered">
<thead><tr><th>ANCIENNETE</th><th>NBR</th></tr></thead><tbody>
 <tr>
  <td>INF 5 ANS</td>
  <td> </td>
</tr>
 <tr>
  <td>5 &lt; ANC &lt; 10</td>
  <td> </td>
</tr>
 <tr>
  <td>10 &lt; ANC &lt; 15</td>
  <td> </td>
</tr>
 <tr><td>15 &lt; ANC &lt; 20</td><td> </td></tr>
 <tr><td>20 &lt;ANC &lt; 25</td><td> </td></tr>
 <tr><td>25 &lt; ANC &lt; 30</td><td> </td></tr>
 <tr><td> ≥ 30 ANS</td><td></td></tr>
</tbody></table>
    </div>
    <div class="col">
          <h2>AGE &  ANCIENNETE :</h2>
<table class="table table-bordered">
<thead>
  <tr>
    <th>AGE MOYEN </th>
  </tr>
</thead>
<tbody>
 <tr>
  <td></td>
</tr>
</tbody>
</table>

<table class="table table-bordered">
<thead>
  <tr>
    <th>ANCIENNETE MOY</th>
  </tr>
</thead>
<tbody>
 <tr>
  <td></td>
</tr>
</tbody>
</table>
    </div>
  </div>
   	        <div class="line"></div>
 	
   </div>


    <script>
	    $(document).ready(function(){
			$('#sidebarCollapse').on('click',function(){
				$('#sidebar').toggleClass('active');
			});
		});  
	</script>
    
    
    
    
    
  </body>
</html>