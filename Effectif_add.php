<?php
  header('Content-Type: text/html; charset=utf-8');
include('header.php'); 
include 'Effectif_add_function.php';
$Personnel = new Personnel();
$Personnel->checkLoggedIn();
if (!in_array(2, $_SESSION['Role'])) { // search value in the array
    header("Location:Home");
}
if(!empty($_POST['Mle']) && $_POST['Nom']) {    
    $a = $Personnel->addNewPersonnel($_POST);
    //echo $a;
    header("Location:Effectif");  
}





$output = '';


$output='';
?>
    <title>Ajouter Emp</title>
    <script src="js/autocomplete_Script.js"></script>
        <script type="text/javascript">

        
function  afiche() {
	Mat = $("#Dep").val();
	$i=0;
	//	window.alert("ok");
		console.log(Mat)				

			// window.alert("ok1");
			$.ajax({
				url: "Effectif_add_Ajax.php",
				type: "POST",
				data: {Mat:Mat},
				dataType: 'text',
				async: true,
				success: function(data){
				    $('#Ser').val("");
					console.log(data);				
                    $('#Ser').html(data);
				}
			})
	}
	



	   $(document).on('change', "#Dep",function() {	
		afiche();
	});

/*        $(document).ready(function() {
            $('.datatable').dataTable({
                "sPaginationType": "full",
               "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ]

            }); 
            $('.datatable').each(function(){
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.addClass('form-control input-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.addClass('form-control input-sm');
            });

            $(".dataExport").click(function() {
                var exportType = $(this).data('type');      
                $('#datatable').tableExport({
                    type : exportType,          
                    escape : 'false',
                    ignoreColumn: []
                });     
            });
        });
*/
        </script>


<body>
<?php
include('menu.php');
?>    

<div class="content">
<div class="container">

<div class="col"><hr></div>
    <h2>Ajouter Personnel STIP :</h2>
<div class="col"><hr></div>

<form class="needs-validation" novalidate method="POST" autocomplete="off">
  <div class="row">
    <div class="col">
      <label for="inputMle">Matricule</label>
      <input type="text" class="form-control" name="Mle" placeholder="Matricule" required>
    </div>
    <div class="col">
      <label for="inputNom">Nom</label>
      <input type="text" class="form-control" name="Nom" placeholder="Nom" required>
    </div>
    <div class="col">
      <label for="inputPrenom">Prenom</label>
      <input type="text" class="form-control" name="Prenom" placeholder="Prenom" required>
    </div>    
  </div>
  <br>
  <div class="row">
  <div class="col">
      <label for="inputNomP">Nom Pere</label>
      <input type="text" class="form-control" name="Nom_P" placeholder="Nom pere">
    </div>
    <div class="col">
      <label for="inputNomM">Nom mère</label>
      <input type="text" class="form-control" name="Nom_M" placeholder="Nom mere">
    </div>
  </div>  
  <br>
  <div class="row">
    <div class="col">
      <label for="inputDateN">Date Naissance</label>
      <input type="date" class="form-control" name="Date_N" placeholder="2020-01-01" required>
    </div>
    <div class="col">
      <label for="inputDateN">Lieu de Naissance</label>
      <input type="text" class="form-control" name="Lieu_N" placeholder="Lieu de Naissance" required>
    </div>
    <div class="col">
      <label class="col-form-label col-sm-2 pt-0">Sexe</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="Sexe" id="gridRadios1" value="Homme" checked required>
          <label class="form-check-label" for="gridRadios1">
            Homme
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="Sexe" id="gridRadios2" value="Femme" >
          <label class="form-check-label" for="gridRadios2">
            Femme
          </label>
        </div>  
    </div> 
  </div>
  <br>
  <div class="row">
    <div class="col">
      <label for="inputAddress">Address</label>
      <input type="text" class="form-control" name="Adresse" placeholder="34, Msaken - Sousse" required>
    </div>
    <div class="col">
      <label for="inputVille">Ville</label>
      <input type="text" class="form-control" name="Ville" required>
    </div>
    <div class="col">
      <label for="inputVille">Code Postal</label>
      <input type="number" class="form-control" name="CPostal" required>
    </div>
    <div class="col">
      <label for="inputTel">Tel</label>
      <input type="text" class="form-control" name="Tel" placeholder="Telephone" required>
    </div>
  </div>
  <br>
  <div class="row">
  <div class="col">
      <label for="inputCIN">CIN</label>
      <input type="text" class="form-control" name="CIN" placeholder="09999999" required>
    </div>
    <div class="col">
      <label for="inputDateN">Date CIN</label>
      <input type="date" class="form-control" name="Date_CIN" placeholder="2020-01-01" required>
    </div>
    <div class="col">
      <label for="inputCNSS">N° CNSS</label>
      <input type="text" class="form-control" name="Num_CNSS" placeholder="99999999-99">
    </div>
    <div class="col">
      <label for="inputState">S. Familial</label>
      <select name="S_F" class="form-control" required>
        <option value="Celibataire" selected>Célibataire</option>
        <option value="Marie">Marié</option>
        <option value="Divorce">Divorcé</option>
        <option value="Veuf">Veuf</option>        
      </select>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col">
      <label for="inputDate_Entre_Etab">Date Entre Etablissement</label>
      <input type="date" class="form-control" name="Date_Entre_Etab" placeholder="2020-01-01" required>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col">
      <label for="inputFonction">Fonction</label>
      <input type="text" class="form-control" name="Fonction" placeholder="Fonction">
    </div>
    <div class="col">
      <label for="inputPosition">Position</label>
      <input type="text" class="form-control" name="Position" placeholder="Position" >
    </div>
    <div class="col">
      <label for="inputQualification">Qualification</label>
      <input type="text" class="form-control" name="Qualification" placeholder="Qualification" required>
    </div>
    <div class="col">
      <label for="inputCollege">College</label>
      <select name="College" class="form-control" required>
        <option value="Execution" selected>Exécution</option>
        <option value="Maitrise">Maitrise</option>
        <option value="Cadre">Cadre</option>
      </select>
    </div>
  </div>  
  <br>
  <div class="row">
    <div class="col">
      <label class="col-form-label col-sm-2 pt-0">Département</label>
				<input class="form-control" list="datalistdep" placeholder="Departement"  name="Dep" id="Dep" >
							<?php $Personnels=$Personnel->getDep();?>
		</div>
    <div class="col">
        <label class="col-form-label col-sm-2 pt-0">Service</label>
				<input class="form-control" list="datalistser" placeholder="Service"  name="Ser" id="Ser" autocomplete="off">
						<option value=""></option>	
			</div>
  </div>  
  <br>
  <div class="row">
    <div class="col">
      <label for="inputFonction">Niveau scolaire</label>
      <input type="text" class="form-control" name="Nscolaire" placeholder="Niveau scolaire">
    </div>
    <div class="col">
      <label for="inputPosition">Diplôme</label>
      <input type="text" class="form-control" name="Diplome" placeholder="Diplome" >
    </div>
  </div>
<br>
  <div class="row">  
   <div class="col align-self-end">
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
  </div>
</form>
<br>

</div>  
</div>
</body>
</html>