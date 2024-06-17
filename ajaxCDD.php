<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<?php 

  header('Content-Type: text/html; charset=utf-8');
include 'Effectif_add_function.php';
  $Personnel = new Personnel();
  include 'connection.php';
        switch($_GET['action']) {
                case 'manage' :
                                if(isset($_GET['IDdetailp'])){
                                        $qry1 = ("SELECT * FROM t_contrat_parent WHERE ID='".$_GET['IDdetailp']."'");
                                        //echo($qry1)."<br>";     
                                                $result1=mysqli_query($conn, $qry1);
                                                $row= mysqli_fetch_array($result1);
                                }
                                else if (isset($_GET['IDdetail'])){
                                                $qry0=("SELECT * FROM t_contrat_details WHERE (t_contrat_details.ID='".$_GET['IDdetail']."')");   
                                                //echo($qry0)."<br>";     
                                                        $result0=mysqli_query($conn, $qry0);
                                                        $row0=mysqli_fetch_array($result0);
                                                                $qry2=("SELECT * FROM t_avancement WHERE (ID='".$row0['ID_AV']."')");   
                                                                        //echo($qry2);     
                                                                        $result2=mysqli_query($conn, $qry2);
                                                                        $row2=mysqli_fetch_array($result2);

                                                                                $qry =("SELECT * FROM t_contrat_parent WHERE ID='".$row0["ID_Contrat_parent"]."'");
                                                                                        //echo $qry;
                                                                                        $result=mysqli_query($conn, $qry);
                                                                                        $row=mysqli_fetch_array($result);
                                                                                
                                }
                               
                                        if(isset($_GET['IDdetailp'])){
                                                $qry1 = ("SELECT * FROM t_contrat_parent WHERE ID='".$_GET['IDdetailp']."'");
                                                //echo($qry1)."<br>";     
                                                        $result1=mysqli_query($conn, $qry1);
                                                        $row= mysqli_fetch_array($result1);
                                        }
                                        else if (isset($_GET['IDdetail'])){
                                                        $qry0=("SELECT * FROM t_contrat_details WHERE (t_contrat_details.ID='".$_GET['IDdetail']."')");   
                                                        //echo($qry0)."<br>";     
                                                                $result0=mysqli_query($conn, $qry0);
                                                                $row0=mysqli_fetch_array($result0);
                                                                        $qry2=("SELECT * FROM t_avancement WHERE (ID='".$row0['ID_AV']."')");   
                                                                                //echo($qry2);     
                                                                                $result2=mysqli_query($conn, $qry2);
                                                                                $row2=mysqli_fetch_array($result2);
        
                                                                                        $qry =("SELECT * FROM t_contrat_parent WHERE ID='".$row0["ID_Contrat_parent"]."'");
                                                                                                //echo $qry;
                                                                                                $result=mysqli_query($conn, $qry);
                                                                                                $row=mysqli_fetch_array($result);
                                                                                        
                                        }
        
        

  ?>
<form action="" name="myform" id="myform" > 
<div id="msg">
</div>
<div class="row g-3">
<div class="col-md-12">
        <label for="Qualification">Qualification</label> 
        <input type="text" value="<?php echo (isset($row0["Qualification"])? $row0["Qualification"] :'')?>" class="form-control" id="Qualification" name="Qualification" autocomplete="off" required>
</div>
<input type="hidden"  name="ID" id="ID" value="<?php echo (isset($row0["ID"])? $row0["ID"] :'')?>">
<input type="hidden"  name="ID_AV" id="ID_AV" value="<?php echo (isset($row0["ID_AV"])? $row0["ID_AV"] :'')?>">


<input type="hidden"  name="ID_ATMS" id="ID_ATMS" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>">
<input type="hidden"  name="ID_P" id="ID_P" value="<?php echo (isset($row0["ID_Contrat_parent"])? $row0["ID_Contrat_parent"] :'')?>">


<div class="col-md-12">
  <label for="type">Type Contrat</label>
   <select id="Type" class="form-control" name="Type">
        <option value="Contractuel">Contractuel</option>
        <option value="CIVP" <?php echo isset ($row0["Type"]) && $row0["Type"]=="CIVP"? "selected":''?>>CIVP</option>
        <option value="Essai" <?php echo isset ($row0["Type"]) && $row0["Type"]=="Essai"? "selected":''?>> Essai</option>
        <option value="SIVP" <?php echo isset ($row0["Type"]) && $row0["Type"]=="SIVP"? "selected":''?>>SIVP</option>
        <option value="CAIP" <?php echo isset ($row0["Type"]) && $row0["Type"]=="CAIP"? "selected":''?>>CAIP</option> 
        <option value="Rupture" <?php echo isset ($row0["Type"]) && $row0["Type"]=="Rupture"? "selected":''?>>Rupture</option>                  
   </select>
</div> 
<div class="row g-3">
<div class="col-md-3">
        <label for="Date Debut">Date Debut</label>
        <input type="date" class="form-control" id="selDate" name="Date_D" placeholder="2020-01-01" value="<?php echo (isset($row0["Date_D"])? $row0["Date_D"] :'')?>" required>
</div>
<div class="col-md-1">
</div>
<div class="col-md-1">
        <label for="Jours">Jours</label>
        <input type="number" min="0" max="31" value="<?php echo (isset($row0["Jours"])? $row0["Jours"] :'')?>" name="days" id="days"/>
</div>
<div class=" col-md-1">
        <label for="Mois">Mois</label>
        <input type="number" min="0" max="31" value="<?php echo (isset($row0["Mois"])? $row0["Mois"] :'')?>" name="months" id="months"/>
</div>
<div class="col-md-1">
        <label for="Jours">Années </label>
        <input type="number" min="0" max="31" value="<?php echo (isset($row0["Annee"])? $row0["Annee"] :'')?>" name="years" id="years"/>
</div>
<div class="col-md-1">
</div>
<div class="col-md-3">
        <label for="Date Fin">Date Fin</label>
        <input type="date" class="form-control"  name="Date_F" id="Date_F" placeholder="2020-01-01" value="<?php echo (isset($row0["Date_F"])? $row0["Date_F"] :'')?>"  required>
</div>
</div>
<div class="row g-3">
<div class="col-md-6">
        <label for="Ref">Ref</label>
        <input type= "text" class="form-control" value="<?php echo (isset($row0["Ref"])? $row0["Ref"] :'')?>" id="Ref" name="Ref" autocomplete="off"required>
</div>
<div class="col-md-6">
        <label for="Date Ref">Date Ref</label>
        <input type="date" class="form-control" name="Date Ref" id="Date_Ref" placeholder="2020-01-01" value="<?php echo (isset($row0["Date_Ref"])? $row0["Date_Ref"] :'')?>" required>
</div>
</div>
 
<div class="form-group">
<label for="Ajouter"><h4>Ajouter Echelon</h4></label>
</div>
<div class="row g-3">
<div class="col-md-4">
        <label for="Catégorie">Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row2["CAT"])? $row2["CAT"] :'')?>"  class="form-control" name="CAT" id="inputcat" autocomplete="off"required>
</div>
<div class="col-md-4">
<label for="Sous Catégorie">Sous Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row2["S_CAT"])? $row2["S_CAT"] :'')?>"  class="form-control" name="S_CAT" id="inputscat" autocomplete="off">

        </div>
        <div class="col-md-4">
        <label for="Echelon">Echelon</label>
        <input type="text" value="<?php echo (isset($row2["ECH"])? $row2["ECH"]:'')?>" class="form-control" name=ECH id="inputech" autocomplete="off"required>
        </div>
        </div>
        <div class="row g-3">

<div class="col-md-6">
        <label for="Taux Horaire">Taux Horaire</label>
        <input type="text"  value="<?php echo (isset($row2["TH"])? $row2["TH"] :'')?>" class="form-control"  name="TH" id="inputth" autocomplete="off">
</div>
<div class="col-md-6">
        <label for="Salaire de Base">Salaire de Base</label>
        <input type="text" value="<?php echo (isset($row2["SBASE"])? $row2["SBASE"] :'')?>" class="form-control"  name="SBASE" id="inputsbase" autocomplete="off">
        </div>
</div>
<div class="row g-3">

<div class="col-md-6">
        <label for="L'indemnité différentielle">L'indemnité différentielle </label>
        <input type="text" value="<?php echo (isset($row2["IND_DIFF"])? $row2["IND_DIFF"] :'')?>" class="form-control" name="IND_DIFF" id="IND_DIFF" autocomplete="off">
</div>
<div class="col-md-6">
        <label for="Date Effet">Date Effet</label>
        <input type="date"  name="D_EFFET" value="<?php echo (isset($row0["Date_D"])? $row0["Date_D"] :'')?>" class="form-control" id="D_EFFET"autocomplete="off" required>

</div> 
</div> 
        <input type="hidden"  name="MLE" id="Mle" value="<?php echo isset($row["Mle"])? $row["Mle"] :''?>">
        <input type="hidden"  name="NOM" id="Nom" value="<?php echo isset($row["Nom"])? $row["Nom"] :''?>">    
</form>
<script>

$("#Date_F").on( "focus",function(){
    calculateTotal();
  }); 
  function calculateTotal(){
        // $('#selDate').val($('#Date_D').val());
        // $('#Hidden_days').val($('#days').val());
        // $('#Hidden_Mois').val($('#months').val());
        // $('#Hidden_Annee').val($('#years').val());
        // $('#Hidden_Date_F').val($('#Date_F').val());
        // $('#Hidden_Type').val($('#Type:selected').text());
        // $('#Hidden_Ref').val($('#Ref').text());
        // $('#Hidden_Date_Ref').val($('#Date_Ref').val());
        
        // $('#inputcat').val($('#cat').val());
        // $('#inputscat').val($('#scat').val());
        // $('#inputech').val($('#ech').val());
        // $('#inputth').val($('#th').val());
        // $('#inputsbase').val($('#sbase').val());
        // $('#inputind_diff').val($('#ind_diff').val());
        // $('#inputMLE').val($('#Mle').text());
        // $('#inputNOM').val($('#Nom').text());
        // $('#inputQualification').val($('#Qualification').text());
          //send the form data to caldata.php
          $.post('caldate.php', $('#myform').serialize(),function(res){
            //display the result from caldate.php
            $('#Date_F').val(res);
          });
      };

$('#myform').submit(function(e){
        var $form = $('#myform');

if ($form.valid()) {
       
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
                    url:"Gestion_Contrats_Functions.php?action=manage",  
                    data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
                                //console.log(resp);
				if(resp){
					resp=JSON.parse(resp);
					if(resp == '1'){
						alert_toast("Data successfully saved",'success')
						setTimeout(function(){
							location.reload()
						},1500)
					}else if(resp == '2'){
						alert_toast("Data successfully Modified",'info');
						setTimeout(function(){
							location.reload()
						},1500)
					}
                                        else{
						alert_toast("Erreur",'danger')
						end_load()
                                        }
                  
                }
                
            }
           })
      }else{
         alert_toast("L'un des champs n'est pas rempli !",'danger')
          return false;
  
 }
     });
  </script>      



<form action="" name="form2" id="form2" > 
<div id="msg">
</div>
<div class="row g-3">
<div class="col-md-12">
        <label for="Qualification">Qualification</label>
        <input type="text" value="<?php echo (isset($row0["Qualification"])? $row0["Qualification"] :'')?>" class="form-control" id="Qualification" name="Qualification" autocomplete="off" required>
</div>
<input type="hidden"  name="ID" id="ID" value="<?php echo (isset($row0["ID"])? $row0["ID"] :'')?>">
<input type="hidden"  name="ID_AV" id="ID_AV" value="<?php echo (isset($row0["ID_AV"])? $row0["ID_AV"] :'')?>">


<input type="hidden"  name="ID_ATMS" id="ID_ATMS" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>">
<input type="hidden"  name="ID_P" id="ID_P" value="<?php echo (isset($row0["ID_Contrat_parent"])? $row0["ID_Contrat_parent"] :'')?>">


<div class="col-md-12">
  <label for="type">Type Contrat</label>
   <select id="Type" class="form-control" name="Type">
        <option value="Contractuel">Contractuel</option>
        <option value="CIVP" <?php echo isset ($row0["Type"]) && $row0["Type"]=="CIVP"? "selected":''?>>CIVP</option>
        <option value="Essai" <?php echo isset ($row0["Type"]) && $row0["Type"]=="Essai"? "selected":''?>> Essai</option>
        <option value="SIVP" <?php echo isset ($row0["Type"]) && $row0["Type"]=="SIVP"? "selected":''?>>SIVP</option>
        <option value="CAIP" <?php echo isset ($row0["Type"]) && $row0["Type"]=="CAIP"? "selected":''?>>CAIP</option> 
        <option value="Rupture" <?php echo isset ($row0["Type"]) && $row0["Type"]=="Rupture"? "selected":''?>>Rupture</option>                  
   </select>
</div> 
<div class="row g-3">
<div class="col-md-3">
        <label for="Date Debut">Date Debut</label>
        <input type="date" class="form-control" id="selDate" name="Date_D" placeholder="2020-01-01" value="<?php echo (isset($row0["Date_D"])? $row0["Date_D"] :'')?>" required>
</div>
<div class="col-md-1">
</div>
<div class="col-md-1">
        <label for="Jours">Jours</label>
        <input type="number" min="0" max="31" value="<?php echo (isset($row0["Jours"])? $row0["Jours"] :'')?>" name="days" id="days"/>
</div>
<div class=" col-md-1">
        <label for="Mois">Mois</label>
        <input type="number" min="0" max="31" value="<?php echo (isset($row0["Mois"])? $row0["Mois"] :'')?>" name="months" id="months"/>
</div>
<div class="col-md-1">
        <label for="Jours">Années </label>
        <input type="number" min="0" max="31" value="<?php echo (isset($row0["Annee"])? $row0["Annee"] :'')?>" name="years" id="years"/>
</div>
<div class="col-md-1">
</div>
<div class="col-md-3">
        <label for="Date Fin">Date Fin</label>
        <input type="date" class="form-control"  name="Date_F" id="Date_F" placeholder="2020-01-01" value="<?php echo (isset($row0["Date_F"])? $row0["Date_F"] :'')?>"  required>
</div>
</div>
<div class="row g-3">
<div class="col-md-6">
        <label for="Ref">Ref</label>
        <input type= "text" class="form-control" value="<?php echo (isset($row0["Ref"])? $row0["Ref"] :'')?>" id="Ref" name="Ref" autocomplete="off"required>
</div>
<div class="col-md-6">
        <label for="Date Ref">Date Ref</label>
        <input type="date" class="form-control" name="Date Ref" id="Date_Ref" placeholder="2020-01-01" value="<?php echo (isset($row0["Date_Ref"])? $row0["Date_Ref"] :'')?>" required>
</div>
</div>
 
<div class="form-group">
<label for="Ajouter"><h4>Ajouter Echelon</h4></label>
</div>
<div class="row g-3">
<div class="col-md-4">
        <label for="Catégorie">Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row2["CAT"])? $row2["CAT"] :'')?>"  class="form-control" name="CAT" id="inputcat" autocomplete="off"required>
</div>
<div class="col-md-4">
<label for="Sous Catégorie">Sous Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row2["S_CAT"])? $row2["S_CAT"] :'')?>"  class="form-control" name="S_CAT" id="inputscat" autocomplete="off">

        </div>
        <div class="col-md-4">
        <label for="Echelon">Echelon</label>
        <input type="text" value="<?php echo (isset($row2["ECH"])? $row2["ECH"]:'')?>" class="form-control" name=ECH id="inputech" autocomplete="off"required>
        </div>
        </div>
        <div class="row g-3">

<div class="col-md-6">
        <label for="Taux Horaire">Taux Horaire</label>
        <input type="text"  value="<?php echo (isset($row2["TH"])? $row2["TH"] :'')?>" class="form-control"  name="TH" id="inputth" autocomplete="off">
</div>
<div class="col-md-6">
        <label for="Salaire de Base">Salaire de Base</label>
        <input type="text" value="<?php echo (isset($row2["SBASE"])? $row2["SBASE"] :'')?>" class="form-control"  name="SBASE" id="inputsbase" autocomplete="off">
        </div>
</div>
<div class="row g-3">

<div class="col-md-6">
        <label for="L'indemnité différentielle">L'indemnité différentielle </label>
        <input type="text" value="<?php echo (isset($row2["IND_DIFF"])? $row2["IND_DIFF"] :'')?>" class="form-control" name="IND_DIFF" id="IND_DIFF" autocomplete="off">
</div>
<div class="col-md-6">
        <label for="Date Effet">Date Effet</label>
        <input type="date"  name="D_EFFET" value="<?php echo (isset($row0["Date_D"])? $row0["Date_D"] :'')?>" class="form-control" id="D_EFFET"autocomplete="off" required>

</div> 
</div> 
        <input type="hidden"  name="MLE" id="Mle" value="<?php echo isset($row["Mle"])? $row["Mle"] :''?>">
        <input type="hidden"  name="NOM" id="Nom" value="<?php echo isset($row["Nom"])? $row["Nom"] :''?>">    
</form>
<script>

$("#Date_F").on( "focus",function(){
    calculateTotal();
  }); 
  function calculateTotal(){
        // $('#selDate').val($('#Date_D').val());
        // $('#Hidden_days').val($('#days').val());
        // $('#Hidden_Mois').val($('#months').val());
        // $('#Hidden_Annee').val($('#years').val());
        // $('#Hidden_Date_F').val($('#Date_F').val());
        // $('#Hidden_Type').val($('#Type:selected').text());
        // $('#Hidden_Ref').val($('#Ref').text());
        // $('#Hidden_Date_Ref').val($('#Date_Ref').val());
        
        // $('#inputcat').val($('#cat').val());
        // $('#inputscat').val($('#scat').val());
        // $('#inputech').val($('#ech').val());
        // $('#inputth').val($('#th').val());
        // $('#inputsbase').val($('#sbase').val());
        // $('#inputind_diff').val($('#ind_diff').val());
        // $('#inputMLE').val($('#Mle').text());
        // $('#inputNOM').val($('#Nom').text());
        // $('#inputQualification').val($('#Qualification').text());
          //send the form data to caldata.php
          $.post('caldate.php', $('#form2').serialize(),function(res){
            //display the result from caldate.php
            $('#Date_F').val(res);
          });
      };

$('#myform').submit(function(e){
        var $form = $('#form2');

if ($form.valid()) {
       
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
                    url:"Gestion_Contrats_Functions.php?action=manage2",  
                    data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
                                //console.log(resp);
				if(resp){
					resp=JSON.parse(resp);
					if(resp == '1'){
						alert_toast("Data successfully saved",'success')
						setTimeout(function(){
							location.reload()
						},1500)
					}else if(resp == '2'){
						alert_toast("Data successfully Modified",'info');
						setTimeout(function(){
							location.reload()
						},1500)
					}
                                        else{
						alert_toast("Erreur",'danger')
						end_load()
                                        }
                  
                }
                
            }
           })
      }else{
         alert_toast("L'un des champs n'est pas rempli !",'danger')
          return false;
  
 }
     });
  </script>      



<?php
break;
        case 'confirmer' :
                $qry1 = ("SELECT * FROM t_contrat_parent WHERE ID='".$_GET['IDp']."'");
                $result1=mysqli_query($conn, $qry1);
                $row= mysqli_fetch_array($result1);

        ?>
        <form action="" name="form" id="form" > 
<div id="msg">
</div>

<input type="hidden"  name="ID_ATMS" id="ID_ATMS" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>">
<input type="hidden"  name="Mle" id="Mle" value="<?php echo (isset($row["Mle"])? $row["Mle"] :'')?>">

<div class="row g-3">

<div class="col-md-6">

        <label for="Qualification">Qualification</label>
        <input type="text" value="" class="form-control" id="Qualification" name="Qualification" autocomplete="off"required>
     </div>   
     <div class="col-md-6">
   <label for="Type">Type</label>
        <input type= "text" class="form-control" value="Confirmation" id="Type" name="Type" readonly>
</div>
</div>

<div class="row g-3">
<div class="col-md-6">
               <label for="Date de Confirmation">Date de Confirmation</label>
        <input type="date" class="form-control" name="Date_D" id="Date_D" placeholder="2020-01-01" value="" required>


</div>
<div class="col-md-6">
<label for="Date Anc">Date Anc</label>
        <input type="date" class="form-control" name="Date_Anc" id="Date_Anc" placeholder="2020-01-01" value="" required>
</div>
</div>

<div class="row g-3">
<div class="col-md-6">
   <label for="Ref">Ref</label>
        <input type= "text" class="form-control" value="" id="Ref" name="Ref" autocomplete="off"required>
</div>
<div class=" col-md-6">
        <label for="Date Ref">Date Ref</label>
        <input type="date" class="form-control" name="Date_Ref" id="Date_Ref" placeholder="2020-01-01" value="" required>
</div>
</div>

</form>
<script>
$('#form').submit(function(e){
      
        var $form = $('#form');

if ($form.valid()) {
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
                    url:"Gestion_Contrats_Functions.php?action=confirmer",  
                    data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
                                console.log(resp);
				if(resp){

//      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
//         $('#output2').html('L un des Champs n a pas été rempli');

					resp=JSON.parse(resp);
					if(resp == '1'){
  
						alert_toast("Data successfully saved",'success')
						setTimeout(function(){
							location.reload()
						},1500)
                                        }
                                        else{
                                                alert_toast("Erreur",'danger')
						end_load()
                                        }
                  
                }
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger');
          return false;
  
  }
     });
</script>

<?php
break;


case 'ajout':
?>
<form action="" name="forma" id="forma" > 
<div id="msg">
</div>
 <div class="row g-3">
<div class="col-3">
</div>
<div class="col-6">
<label for="Matricule">Matricule</label>
<input class="form-control" list="datalistefect" placeholder="Matricule"  name="Matricule" id="Matricule" autocomplete="off">
<?php $Personnels=$Personnel->getInfo_affectation_provisoire();?></div>
</div>
<div class="col-3">
</div>
</div>
<br>
<div class="card">
  <div class="card-body" id="SActuel">
    <p class="card-text">Selectionnez une Matricule</p>
  </div>
</div>
</div>

</form>



<script>
$('#forma').submit(function(e){
        var $form = $('#forma');

if ($form.valid()) {
       // a= $("#forma").serialize();

      e.preventDefault()
      start_load()
      $('#msg').html('')
      $.ajax({
                url:"Certificat_Function.php?action=ajout",  
                data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          success:function(resp){
               //console.log(a);
              if(resp){

//      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
//         $('#output2').html('L un des Champs n a pas été rempli');

                  resp=JSON.parse(resp);
                  if(resp == '1'){

                      alert_toast("Data successfully saved",'success')
                      setTimeout(function(){
                         location.reload()
                      },1500)
                      //end_load();
                      
                } 
              }  else{
                alert_toast("Erreur",'danger');
                //end_load();

                    
        }
                  
                
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger');
          return false;
  
  }
     })
  </script>
<?php 
break;
case 'Modif_Aff':
        $_GET['ID_Aff'];
        $query = ("SELECT * FROM t_affectation_d WHERE ID='".$_GET['ID_Aff']."'");
       
  
        //echo($query);       
        $result1=mysqli_query($conn, $query);
                $row= mysqli_fetch_array($result1);


        ?>
        <form action="" name="formaa" id="formaa" > 
        <div id="msg">
        </div>
        <div class="row g-3">
<div class="col-4">
</div>
<div class="col-4">
<label for="Type" class="form-label">Type</label>
<input type="text" class="form-control"  id="Type" name="Type" autocomplete="off" value="<?php echo (isset($row["Type"])? $row["Type"] :'')?>" readonly>
<input type="hidden" class="form-control"  id="ID" name="ID" autocomplete="off" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>" >

</div>
</div>
<div class="row g-3">

<div class="col-4">
<label for="Date_D" class="form-label">Date Début</label>
<input type="date" class="form-control"  id="seldate" name="Date_D" value="<?php echo (isset($row["Date_D"])? $row["Date_D"] :'')?>" autocomplete="off" required>
</div>

<div class="col-1">
</div>
<div class="col-1">
<label for="days" class="form-label">Jours</label>
<input type="number" min="0" max="31"  name="days" value="<?php echo (isset($row["days"])? $row["days"] :'')?>" >
</div>


<div class="col-1">
<label for="months" class="form-label">Mois</label>
<input type="number" min="0" max="12"  name="months" value="<?php echo (isset($row["months"])? $row["months"] :'')?>" >
</div>
<input type="hidden" min="0" max="12"  name="years" value="0" >

<div class="col-1">
</div>
<div class="col-4">
<label for="Date_F" class="form-label">Date Fin</label>
<input type="date" class="form-control" id="Date_F" name="Date_F" value="<?php echo (isset($row["Date_F"])? $row["Date_F"] :'')?>" required>
</div>
</div>
<div class="row g-3">
<div class="col-1">
</div>

<div class="col-4">
<label for="Ref" class="form-label">Ref</label>
<input type="text" class="form-control"   name="Ref" value="<?php echo (isset($row["Ref"])? $row["Ref"] :'')?>" autocomplete="off" required>
</div>
<div class="col-2">
</div>

<div class="col-5">
<label for="Date_Ref" class="form-label">Date_Ref</label>
<input type="date" class="form-control"   name="Date_Ref" value="<?php echo (isset($row["Date_Ref"])? $row["Date_Ref"] :'')?>" required>
</div>
</div>
</div>
</div>

        
                
               </form>
            
               <script>
               $("#Date_F").on("focus",function(){
    calculateTotall();
  });
               function calculateTotall(){
          $.post('caldate.php', $('#formaa').serialize(),function(res){
            //display the result from caldate.php
            $('#Date_F').val(res);
          });
      };
      

$('#formaa').submit(function(e){
        var $form = $('#formaa');

if ($form.valid()) {
      
//a= $("#forma").serialize();

      e.preventDefault()
      start_load()
      $('#msg').html('')
      $.ajax({
                url:"Affectation_Provisoire_Function.php?action=Modif_Aff",  
                data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          success:function(resp){
         //console.log(a);
              if(resp){



//      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
//         $('#output2').html('L un des Champs n a pas été rempli');

                  resp=JSON.parse(resp);
                  if(resp == '1'){

                      alert_toast("Data successfully modified",'info')
                      setTimeout(function(){
                        location.reload()
                      },1500)
                                      }
                                      else{
                                        alert_toast("Erreur",'danger')
                      end_load()
                }
                  
                }
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger')
  
  }
     })

  </script>
<?php
       break;  
       
case 'Ajout_Aff_d': 
        $_GET['ID1'];

        $qry1 ="SELECT * FROM t_affectation_p WHERE (ID='".$_GET['ID1']."')";
        //echo($qry1)."<br>";     
                $result1=mysqli_query($conn, $qry1);
                $row= mysqli_fetch_array($result1);
     
?>

<form action="" name="form1" id="form1" > 
<div id="msg">
</div>
<div class="row g-3">
<div class="col-4">
</div>
<div class="col-4">
<label for="Type" class="form-label">Type</label>
<input type="text" class="form-control"  id="Type" name="Type" autocomplete="off" value="Prolongation" readonly required>
<input type="hidden" class="form-control"  id="ID_p" name="ID_p" autocomplete="off" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>">

</div>
</div>
<div class="row g-3">

<div class="col-4">
<label for="Date_D" class="form-label">Date Début</label>
<input type="date" class="form-control"  id="seldate" name="Date_D" value=""autocomplete="off" required>
</div>

<div class="col-1">
</div>
<div class="col-1">
<label for="days" class="form-label">Jours</label>
<input type="number" min="0" max="31"  name="days" value="" >
</div>


<div class="col-1">
<label for="months" class="form-label">Mois</label>
<input type="number" min="0" max="12"  name="months" value="" >
</div>
<input type="hidden" min="0" max="12"  name="years" value="0" >

<div class="col-1">
</div>
<div class="col-4">
<label for="Date_F" class="form-label">Date Fin</label>
<input type="date" class="form-control" id="Date_F" name="Date_F" value="" required>
</div>
</div>
<div class="row g-3">
<div class="col-1">
</div>

<div class="col-4">
<label for="Ref" class="form-label">Ref</label>
<input type="text" class="form-control"   name="Ref" value="" autocomplete="off" required>
</div>
<div class="col-2">
</div>

<div class="col-5">
<label for="Date_Ref" class="form-label">Date_Ref</label>
<input type="date" class="form-control"   name="Date_Ref" value="" required>
</div>
</div>
</div>
</div>
</form>

      
            
            <script>
           $("#Date_F").on("focus",function(){
                calculateTotal();
                });  
        function calculateTotal(){
          $.post('caldate.php', $('#form1').serialize(),function(res){
            //display the result from caldate.php
            $('#Date_F').val(res);
          });
      };
     $('#form1').submit(function(e){
        var $form = $('#form1');

if ($form.valid()) {     
//a= $("#forma").serialize();

   e.preventDefault()
   start_load()
   $('#msg').html('')
   $.ajax({
             url:"Affectation_Provisoire_Function.php?action=Ajout_Aff_d",  
             data: new FormData($(this)[0]),
       cache: false,
       contentType: false,
       processData: false,
       method: 'POST',
       success:function(resp){
    //  console.log(a);
           if(resp){



//      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
//         $('#output2').html('L un des Champs n a pas été rempli');

               resp=JSON.parse(resp);
               if(resp == '1'){

                   alert_toast("Data successfully saved",'success')
                   setTimeout(function(){
                 location.reload()
                   },1500)
                                   }
                                   else{       
                                             alert_toast("Erreur",'danger');
                //end_load();

                    
        }
           }     
                
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger');
          return false;
  
  }
     
     });
</script>
        <?php
        break;
        case 'Rejeter':
                $_GET['ID2'];
                $qry ="SELECT * FROM t_affectation_p WHERE (ID='".$_GET['ID2']."')";
                $result=mysqli_query($conn, $qry);
                $row= mysqli_fetch_array($result);
               
               
               ?>

<form action="" name="formR" id="formR" > 
<div id="msg">
</div>

        <div class="row g-3">
        <div class="col-3">
        </div>
        <div class="col-6">
        <label for="Date_F" class="form-label">Date de Décision</label>
        <input type="date" class="form-control"  name="Date_F"  id="Date_F" placeholder="2020-01-01" value="" required >
        <input type="hidden" class="form-control"  name="ID_p"  id="ID_p"  value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>" >

        </div>
        <div class="col-3">
        </div>
        </div>
        <div class="row g-3">
        <div class="col-1">
        </div>
        <div class="col-3">
        <label for="Ref" class="form-label">Ref</label>
        <input type="text" class="form-control"   name="Ref" value="" autocomplete="off" required>
        </div>

        <div class="col-3">
        </div>
        <div class="col-4">
        <label for="Date_Ref" class="form-label">Date_Ref</label>
        <input type="date" class="form-control"   name="Date_Ref" value="" autocomplete="off" required>
        </div>
        
        <input type="hidden" class="form-control"  name="Date_D"  id="Date_F" placeholder="2020-01-01" value="" >

       


        
        <input type="hidden"  name="days" id="days" value="" >
        <input type="hidden"  name="months" id="months" value="" >
        <input type="hidden" name="years" id="years" value="0" >

      
        <input type="hidden" id="Type" class="form-control" name="Type" value="Rejeter">
       
        
        </div>
        </form>
        <script>
      
        $('#formR').submit(function(e){
                var $form = $('#formR');

if ($form.valid()) {
   
   //a= $("#forma").serialize();
   
      e.preventDefault()
      start_load()
      $('#msg').html('')
      $.ajax({
                url:"Affectation_Provisoire_Function.php?action=Rejeter",  
                data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          success:function(resp){
         //console.log(a);
              if(resp){
   
   
   
   //      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
   //         $('#output2').html('L un des Champs n a pas été rempli');
   
                  resp=JSON.parse(resp);
                  if(resp == '1'){
   
                      alert_toast("Data successfully saved",'success')
                      setTimeout(function(){
                      location.reload()
                      },1500)
                                      }
                                      else{
                                        alert_toast("Erreur",'danger')

                      end_load()
                }
                  
                }
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger')
          return false;
  
  }
     });
   </script>
        <?php

               

                break;
                case 'confirm':
        $_GET['ID'];
$sql="SELECT * FROM t_affectation_p WHERE (ID='".$_GET['ID']."')";
$result=mysqli_query($conn, $sql);
$row= mysqli_fetch_array($result);



                        ?>
                        <form action="" name="formC" id="formC" > 
                                        <div id="msg">
                                        </div>

                        <div class="card">
                        <div class="card-header"><h4>
                        Affectation confirmée
                        </h4></div>
                        <div class="card-body" >

                        <div class="row g-3">
                        <input type="hidden" class="form-control"   name="Mle" id="Mle" value="<?php echo (isset($row["Mle"])? $row["Mle"] :'')?>">
                        <input type="hidden" class="form-control"   name="Nom" id="Nom" value="<?php echo (isset($row["Nom"])? $row["Nom"] :'')?>">

                        <div class="col-6">
                        <label for="Département" class="form-label">Département</label>
                        <input class="form-control"   name="Departement" id="Departement" value="<?php echo (isset($row["Departement"])? $row["Departement"] :'')?>" required>
                                                 
                        </div>
                        <div class="col-6">
                        <label for="Service" class="form-label">Service</label>
                        <input class="form-control"  name="Ser" id="Service" value="<?php echo (isset($row["Service"])? $row["Service"] :'')?>" >
                        <option value=""></option>	
                        </div>
                        </div>
                        <div class="row g-3">
                        <div class="col-6">
                        <label for="Position" class="form-label">Position</label>
                        <input type="text" class="form-control"   name="Position" value="<?php echo (isset($row["Position"])? $row["Position"] :'')?>"  >
                        </div>
                        <div class="col-6">
                        <label for="Qualification" class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="Qualification" value="<?php echo (isset($row["Qualification"])? $row["Qualification"] :'')?>" required>
                        </div>
                        </div>
                        </div>
                        </div>
                        <br>
                        <div class="card">
                        <div class="card-header"><h4>
                        Paramètre Avancement
                        </h4></div>
                        <div class="card-body" >

                        <div class="row g-3">
<div class="col-md-4">
        <label for="Catégorie">Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row["CAT"])? $row["CAT"] :'')?>"  class="form-control" name="CAT" id="inputcat" autocomplete="off" required>
</div>
<div class="col-md-4">
<label for="Sous Catégorie">Sous Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row["S_CAT"])? $row["S_CAT"] :'')?>"  class="form-control" name="S_CAT" id="inputscat" autocomplete="off" >

        </div>
        <div class="col-md-4">
        <label for="Echelon">Echelon</label>
        <input type="text" value="<?php echo (isset($row["ECH"])? $row["ECH"]:'')?>" class="form-control" name=ECH id="inputech" autocomplete="off" required>
        </div>
        </div>
        <div class="row g-3">

<div class="col-md-6">
        <label for="Taux Horaire">Taux Horaire</label>
        <input type="text"  value="<?php echo (isset($row["TH"])? $row["TH"] :'')?>" class="form-control"  name="TH" id="inputth" autocomplete="off" >
</div>
<div class="col-md-6">
        <label for="Salaire de Base">Salaire de Base</label>
        <input type="text" value="<?php echo (isset($row["SBASE"])? $row["SBASE"] :'')?>" class="form-control"  name="SBASE" id="inputsbase" autocomplete="off" >
        </div>
</div>
<div class="row g-3">

<div class="col-md-6">
        <label for="L'indemnité différentielle">L'indemnité différentielle</label>
        <input type="text" value="<?php echo (isset($row["IND_DIFF"])? $row["IND_DIFF"] :'')?>" class="form-control" name="IND_DIFF" id="IND_DIFF" autocomplete="off">
</div>
<div class="col-md-6">
        <label for="Date Effet">Date Effet</label>
        <input type="date"  name="D_EFFET" value="<?php echo (isset($row["D_EFFET"])? $row["D_EFFET"] :'')?>" class="form-control" id="D_EFFET"autocomplete="off" required>

</div> 

</div> 
</div>
  <input type="hidden"  name="D_P_AV" value="<?php echo (isset($row["D_P_AV"])? $row["D_P_AV"] :'')?>" class="form-control" id="D_P_AV" autocomplete="off" >
          </div>
</div> 
</div> 
<br>
<div class="card">
               <div class="card-header"><h4>
               ##### 
               </h4></div>
               <div class="card-body" >

                <div class="row g-3">
                <div class="col-1">
                        </div>

                        <div class="col-4">
                        <label for="Ref" class="form-label">Ref</label>
                        <input type="text" class="form-control"   name="Ref" value="" autocomplete="off" required>
                        </div>
                        <div class="col-2">
                        </div>

                        <div class="col-5">
                        <label for="Date_Ref" class="form-label">Date_Ref</label>
                        <input type="date" class="form-control"   name="Date_Ref" value="" required>
                        </div>
                        </div>
                        <div class="row g-3">
                        <div class="col-3">
                        </div>
                        <div class="col-6">
                        <label for="Date de Confirmation">Date de Confirmation</label>
                         <input type="date" class="form-control" name="Date_D" id="Date_D" placeholder="2020-01-01" value="" required>

                        </div>
                        <div class="col-3">
                        </div>
                        </div>
                       
                        </div> 
                        </div> 
                        <div>
                        </div>

                        </form>
                        <script>
            
        $('#formC').submit(function(e){
   
                var $form = $('#formC');

if ($form.valid()) {   
      e.preventDefault()
      start_load()
      $('#msg').html('')
      $.ajax({
                url:"Affectation_Provisoire_Function.php?action=confirmer",  
                data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          success:function(resp){
         //console.log(a);
              if(resp){
   
   
   
   //      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
   //         $('#output2').html('L un des Champs n a pas été rempli');
   
                  resp=JSON.parse(resp);
                  if(resp == '1'){
   
                      alert_toast("Data successfully saved",'success')
                      setTimeout(function(){
                      location.reload()
                      },1500)
                                      }
                                      else{
                                        alert_toast("Erreur",'danger')
                     end_load()
                  }
                  
              }
              
          }
      })
}else{         alert_toast("L'un des champs n'est pas rempli !",'danger')
        return false;

}
   });
   </script>

                        <?php  
                        break;
                                           case 'Modif_Aff_p':
                                                $_GET['ID1'];
                                                $sql="SELECT * FROM t_affectation_p WHERE (ID='".$_GET['ID1']."')";
                                                $result=mysqli_query($conn, $sql);
                                                $row= mysqli_fetch_array($result);
                                               
                                                ?>
                                                     <form action="" name="formM" id="formM" > 
                                        <div id="msg">
                                        </div>

                                                <div class="card" >
                                                <h5 class="card-header">Paramètre Affectation </h5>
                                            <div class="card-body">
                                            <div class="row g-3">
                                            <div class="col-6">
                        <label for="Département" class="form-label">Département</label>
               <input class="form-control" list="datalistdep" placeholder="Département"  name="Departement" id="Departement" value="<?php echo (isset($row["Departement"])? $row["Departement"] :'')?>" autocomplete="off" required>
                                       <?php $Personnels=$Personnel->getDep();?>
                        </div>
                        <input type="hidden" class="form-control"   name="ID" id="ID" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>" > 
                        <input type="hidden" class="form-control"   name="D_P_AV" id="D_P_AV" value="<?php echo (isset($row["D_P_AV"])? $row["D_P_AV"] :'')?>" > 

                        <div class="col-6">
                        <label for="Service" class="form-label">Service</label>
                        <input class="form-control" list="datalistser" placeholder="Service"  name="Ser" id="Service" autocomplete="off" value="<?php echo (isset($row["Service"])? $row["Service"] :'')?>" >
               <option value=""></option>	
                        </div>
                        </div>
                        <div class="row g-3">
                        <div class="col-6">
                        <label for="Position" class="form-label">Position</label>
                        <input type="text" class="form-control"   name="Position" value="<?php echo (isset($row["Position"])? $row["Position"] :'')?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                        <label for="Qualification" class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="Qualification" value="<?php echo (isset($row["Qualification"])? $row["Qualification"] :'')?>" autocomplete="off" required> 
                        </div>
                        </div>
                        <div class="row g-3">
               <div class="col-md-4">
                       <label for="Catégorie">Catégorie</label>
                       <input type= "text"  value="<?php echo (isset($row["CAT"])? $row["CAT"] :'')?>"  class="form-control" name="CAT" id="inputcat"  autocomplete="off" required>
               </div>
               <div class="col-md-4">
               <label for="Sous Catégorie">Sous Catégorie</label>
               <input type= "text"  value="<?php echo (isset($row["S_CAT"])? $row["S_CAT"] :'')?>"  class="form-control" name="S_CAT" id="inputscat" autocomplete="off">

                       </div>
                       <div class="col-md-4">
                       <label for="Echelon">Echelon</label>
                       <input type="text" value="<?php echo (isset($row["ECH"])? $row["ECH"] :'')?>" class="form-control" name=ECH id="inputech" autocomplete="off" required>
                       </div>
                       </div>
                       <div class="row g-3">
               
               <div class="col-md-6">
                       <label for="Taux Horaire">Taux Horaire</label>
                       <input type="text"  value="<?php echo (isset($row["TH"])? $row["TH"] :'')?>" class="form-control"  name="TH" id="inputth" autocomplete="off">
               </div>
               <div class="col-md-6">
                       <label for="Salaire de Base">Salaire de Base</label>
                       <input type="text" value="<?php echo (isset($row["SBASE"])? $row["SBASE"] :'')?>" class="form-control"  name="SBASE" id="inputsbase" autocomplete="off">
                       </div>
               </div>
               <div class="row g-3">
               
               <div class="col-md-6">
                       <label for="indemnité différentielle">Indemnité différentielle </label>
                       <input type="text" value="<?php echo (isset($row["IND_DIFF"])? $row["IND_DIFF"] :'')?>" class="form-control" name="IND_DIFF" id="IND_DIFF" autocomplete="off">
               </div>
               <div class="col-md-6">
                       <label for="Date Effet">Date Effet</label>
                       <input type="date"  name="D_EFFET" value="<?php echo (isset($row["D_EFFET"])? $row["D_EFFET"] :'')?>" class="form-control" id="D_EFFET" autocomplete="off" required>
                       </div>
                      
                        </div> 
              
                                             </div>
                                             </div>






                                             </form>
                        <script>
            
        $('#formM').submit(function(e){
                var $form = $('#formM');

if ($form.valid()) {

   
   //a= $("#forma").serialize();
   
      e.preventDefault()
      start_load()
      $('#msg').html('')
      $.ajax({
                url:"Affectation_Provisoire_Function.php?action=Modif_Aff_p",  
                data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          success:function(resp){
         //console.log(a);
              if(resp){
   
   
   
   //      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
   //         $('#output2').html('L un des Champs n a pas été rempli');
   
                  resp=JSON.parse(resp);
                  if(resp == '1'){
   
                      alert_toast("Data successfully modified",'info')
                      setTimeout(function(){
                      location.reload()
                      },1500)
                                      }
                                      else{
                                        alert_toast("Erreur",'danger')

                      end_load()
                }
                  
                }
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger')
          return false;
  
  }
     });
   </script>
                                             <?php
break;
case 'ajoutMut':
        ?>
        <form action="" name="forms" id="forms" > 
        <div id="msg">
        </div>
         <div class="row g-3">
        <div class="col-3">
        </div>
        <div class="col-6">
        <label for="Matricule">Matricule</label>
        <input class="form-control" list="datalistefect" placeholder="Matricule"  name="Matricule" id="Matricule" >
        <?php $Personnels=$Personnel->getInfo_affectation_provisoire();?></div>
        </div>
        <div class="col-3">
        </div>
        </div>
        <br>
        <div class="card">
          <div class="card-body" id="SActuel">
            <p class="card-text">Selectionnez une Matricule</p>
          </div>
        </div>
        </div>
        
        </form>
        
        
        
        <script>
        $('#forms').submit(function(e){
                var $form = $('#forms');
        
        if ($form.valid()) {
               // a= $("#forma").serialize();
        
              e.preventDefault()
              start_load()
              $('#msg').html('')
              $.ajax({
                        url:"Mutations_Functions.php?action=ajout",  
                        data: new FormData($(this)[0]),
                  cache: false,
                  contentType: false,
                  processData: false,
                  method: 'POST',
                  success:function(resp){
                       //console.log(a);
                      if(resp){
        
        //      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
        //         $('#output2').html('L un des Champs n a pas été rempli');
        
                          resp=JSON.parse(resp);
                          if(resp == '1'){
        
                              alert_toast("Data successfully saved",'success')
                              setTimeout(function(){
                                 location.reload()
                              },1500)
                              //end_load();
                              
                        
                      }  else{
                        alert_toast("Erreur",'danger');
                        //end_load();
        
                      }   
                }
                          
                        
                        
                    }
                })
          }else{
                  alert_toast("L'un des champs n'est pas rempli !",'danger');
                  return false;
          
          }
             })
          </script>
        <?php 
        
                                                                                  
break;
case 'ModifierMut':

        $_GET['ID'];
        $sql="SELECT * FROM t_postes WHERE (ID='".$_GET['ID']."')";
        //echo ($sql);
        $result=mysqli_query($conn, $sql);
        $row= mysqli_fetch_array($result);
        $sql11="SELECT * FROM t_avancement WHERE ((MLE='".$row['Mle']."') AND (Active='1'))";
        //echo ($sql11);
        $result11=mysqli_query($conn, $sql11);
        $row11= mysqli_fetch_array($result11);

        ?>
        <form action="" name="formis" id="formis" > 
        <div id="msg"></div>

        <div class="card">
        <div class="card-header"><h4>
        Affectation 
        </h4></div>
        <div class="card-body" >

        <div class="row g-3">
        <div class="col-6">
        <label for="Département" class="form-label">Département</label>
        <input class="form-control" list="datalistdep" placeholder="Département"  name="Nom_Dep" id="Departement" value="<?php echo (isset($row["Nom_Dep"])? $row["Nom_Dep"] :'')?>" autocomplete="off" required>
                                 <?php $Personnels=$Personnel->getDep(); ?>
                                 
        </div>
        <input type="hidden" class="form-control" placeholder="ID"  name="ID" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>" >
        <input type="hidden" class="form-control" placeholder="Nom"  name="Nom" value="'.$row['Prenom'].' '.$row['Nom'].'">


        <div class="col-6">
        <label for="Service" class="form-label">Service</label>
        <input class="form-control" list="datalistser" placeholder="Service"  name="Ser" id="Service" value="<?php echo (isset($row["Nom_Service"])? $row["Nom_Service"] :'')?>" autocomplete="off">
        <option value=""></option>	
        </div>
        </div>
        <div class="row g-3">
        <div class="col-6">
        <label for="Position" class="form-label">Position</label>
        <input type="text" class="form-control" placeholder="Position"  name="Position" value="<?php echo (isset($row["Position"])? $row["Position"] :'')?>" >
        </div>
        <div class="col-6">
        <label for="Qualification" class="form-label">Qualification</label>
        <input type="text" class="form-control" placeholder="Qualification"  name="Qualification" value="<?php echo (isset($row["Qualification"])? $row["Qualification"] :'')?>" required>
        </div>
        </div>
        <div class="row g-3">
         <div class="col-4">
         <label for="Fonction" class="form-label">Fonction</label>
        <input type="text" class="form-control" placeholder="Fonction"  name="Fonction" value="<?php echo (isset($row["Fonction"])? $row["Fonction"] :'')?>" >
        </div>
         <div class="col-4">
        <label for="Ref" class="form-label">Ref</label>
        <input type="text" class="form-control"   name="Ref" value="<?php echo (isset($row["Ref"])? $row["Ref"] :'')?>" required>
        </div>

          <div class="col-4">
         <label for="College" class="form-label">College</label>
        <select id="College" class="form-control" name="College">
             <option value="Exécution" <?php echo isset ($row["College"]) && $row["College"]=="Exécution"? "selected":''?>>Exécution</option>
             <option value="Cadre" <?php echo isset ($row["College"]) && $row["College"]=="Cadre"? "selected":''?>>Cadre</option>
             <option value="Maîtrise" <?php echo isset ($row["College"]) && $row["College"]=="Maîtrise"? "selected":''?>  > Maîtrise</option>
             </select>
             </div>
             </div>

             <div class="row g-3">

             <div class="col-3">
             </div>
      

        <div class="col-5">
        <label for="Date_D" class="form-label">Date Poste</label>
        <input type="date" class="form-control" id="Date_Poste" name="Date_Poste" value="<?php echo (isset($row["Date_Poste"])? $row["Date_Poste"] :'')?>" required>
        </div>
        <div class="col-2">
        </div>

        </div>
        </div>
        </div>
        <br>
        <div class="card">
        <div class="card-header"><h4>
        ##### 
        </h4></div>
        <div class="card-body" >
        <div class="row g-3">
        <div class="col-md-4">
                <label for="Catégorie">Catégorie</label>
                <input type= "text"  value="<?php echo (isset($row11["CAT"])? $row11["CAT"] :'')?>"  class="form-control" name="CAT" id="inputcat"  autocomplete="off" required>
        </div>
        <div class="col-md-4">
        <label for="Sous Catégorie">Sous Catégorie</label>
        <input type= "text"  value="<?php echo (isset($row11["S_CAT"])? $row11["S_CAT"] :'')?>"  class="form-control" name="S_CAT" id="inputscat" autocomplete="off">

                </div>
                <div class="col-md-4">
                <label for="Echelon">Echelon</label>
                <input type="text" value="<?php echo (isset($row11["ECH"])? $row11["ECH"] :'')?>" class="form-control" name="ECH" id="inputech" autocomplete="off" required>
                </div>
                </div>
                <div class="row g-3">
        
        <div class="col-md-4">
                <label for="Taux Horaire">Taux Horaire</label>
                <input type="text"  value="<?php echo (isset($row11["TH"])? $row11["TH"] :'')?>" class="form-control"  name="TH" id="inputth" autocomplete="off">
        </div>
        <div class="col-md-3">
</div>
        <div class="col-md-5">
                <label for="Salaire de Base">Salaire de Base</label>
                <input type="text" value="<?php echo (isset($row11["SBASE"])? $row11["SBASE"] :'')?>" class="form-control"  name="SBASE" id="inputsbase" autocomplete="off">
                </div>
        </div>
        <div class="row g-3">
        <div class="col-md-2">
        </div>
        <div class="col-md-4">
                <label for="indemnité différentielle">Indemnité différentielle </label>
                <input type="text" value="<?php echo (isset($row11["IND_DIFF"])? $row11["IND_DIFF"] :'')?>" class="form-control" name="IND_DIFF" id="IND_DIFF" autocomplete="off">
        </div>
        <div class="col-md-1">
        </div>
        
        <div class="col-md-4">
                <label for="Date Effet">Date Effet</label>
                <input type="date"  name="D_EFFET" value="<?php echo (isset($row11["D_EFFET"])? $row11["D_EFFET"] :'')?>" class="form-control" id="D_EFFET" autocomplete="off" required>
                <input type="hidden"  name="D_P_AV" value="<?php echo (isset($row11["D_P_AV"])? $row11["D_P_AV"] :'')?>" class="form-control" id="D_P_AV" autocomplete="off" >
                <input type="hidden"  name="Mle" value="<?php echo (isset($row11["MLE"])? $row11["MLE"] :'')?>" class="form-control" id="MLE" autocomplete="off" >
                <input type="hidden"  name="NOM" value="<?php echo (isset($row11["NOM"])? $row11["NOM"] :'')?>" class="form-control" id="NOM" autocomplete="off" >
        </div> 
        <div class="col-md-1">
        </div>
        </div> 
        </div>

        </div>
        </form>
        
        
        
       
        <script>
        $('#formis').submit(function(e){
                var $form = $('#formis');
        
        if ($form.valid()) {
               // a= $("#forma").serialize();
        
              e.preventDefault()
              start_load()
              $('#msg').html('')
              $.ajax({
                        url:"Mutations_Functions.php?action=Modif_Mut",  
                        data: new FormData($(this)[0]),
                  cache: false,
                  contentType: false,
                  processData: false,
                  method: 'POST',
                  success:function(resp){
                       //console.log(a);
                      if(resp){
        
        //      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
        //         $('#output2').html('L un des Champs n a pas été rempli');
        
                          resp=JSON.parse(resp);
                          if(resp == '1'){
        
                              alert_toast("Data successfully modified",'info')
                              setTimeout(function(){
                                 location.reload()
                              },1500)
                              //end_load();
                              
                      }  else{
                        alert_toast("Erreur",'danger');
                        //end_load();
                      }
                            
                }
                          
                        
                        
                    }
                })
          }else{
                  alert_toast("L'un des champs n'est pas rempli !",'danger');
                  return false;
          
          }
             })
             
          </script>
        <?php 
         break;




         case 'Modif_cer_d':
                $_GET['ID_Aff'];
                $query = ("SELECT * FROM t_certificat_d WHERE ID='".$_GET['ID_Aff']."'");
               
          
                //echo($query);       
                $result1=mysqli_query($conn, $query);
                        $row= mysqli_fetch_array($result1);
        
        
                ?>
                <form action="" name="formaa" id="formaa" > 
                <div id="msg">
                </div>
                <div class="row g-3">
        <div class="col-4">
        </div>
        <div class="col-4">
        <label for="Type" class="form-label">Type</label>
        <select id="Type" class="form-control" name="Type">

        <option value="Aptitude" <?php echo isset ($row0["Type"]) && $row0["Type"]=="Reprise MO-AT-MP"? "selected":''?>> Reprise MO-AT-MP </option>

        <option value="Aptitude" <?php echo isset ($row0["Type"]) && $row0["Type"]=="Aptitude"? "selected":''?>>Aptitude</option>
        </select>
        <input type="hidden" class="form-control"  id="ID" name="ID" autocomplete="off" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>" >
        
        </div>
        </div>
        <div class="row g-3">
        
        <div class="col-4">
        <label for="Date_D" class="form-label">Date de visite</label>
        <input type="date" class="form-control"  id="seldate" name="Date_D" value="<?php echo (isset($row["D_visite"])? $row["D_visite"] :'')?>" autocomplete="off" required>
        </div>
        
        <div class="col-1">
        </div>
        <div class="col-1">
        <label for="days" class="form-label">Jours</label>
        <input type="number" min="0" max="31"  name="days" value="<?php echo (isset($row["days"])? $row["days"] :'')?>" >
        </div>
        
        
        <div class="col-1">
        <label for="months" class="form-label">Mois</label>
        <input type="number" min="0" max="12"  name="months" value="<?php echo (isset($row["months"])? $row["months"] :'')?>" >
        </div>
        <input type="hidden" min="0" max="12"  name="years" value="0" >
        
        <div class="col-1">
        </div>
        <div class="col-4">
        <label for="Date_F" class="form-label">Date de prochaine visite</label>
        <input type="date" class="form-control" id="Date_F" name="Date_F" value="<?php echo (isset($row["D_p_visite"])? $row["D_p_visite"] :'')?>" required>
        </div>
        </div>
        <div class="row g-3">
        <div class="col-1">
        </div>
        
       
        <div class="col-2">
        </div>
        
        <div class="col-5">
        <label for="Date_Ref" class="form-label">Date de Reprise</label>
        <input list="datalistdep" class="form-control"   name="Date_R" value="<?php echo (isset($row["D_reprise"])? $row["D_reprise"] :'')?>" required>
        </div>
        </div>
        </div>
        </div>
        
                
                        
                       </form>
                    
                       <script>
                       $("#Date_F").on("focus",function(){
            calculateTotall();
          });
                       function calculateTotall(){
                  $.post('caldate.php', $('#formaa').serialize(),function(res){
                    //display the result from caldate.php
                    $('#Date_F').val(res);
                  });
              };
              
        
        $('#formaa').submit(function(e){
                var $form = $('#formaa');
        
        if ($form.valid()) {
              
        //a= $("#forma").serialize();
        
              e.preventDefault()
              start_load()
              $('#msg').html('')
              $.ajax({
                        url:"Certificat_Function.php?action=Modif_cer",  
                        data: new FormData($(this)[0]),
                  cache: false,
                  contentType: false,
                  processData: false,
                  method: 'POST',
                  success:function(resp){
                 //console.log(a);
                      if(resp){
        
        
        
        //      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
        //         $('#output2').html('L un des Champs n a pas été rempli');
        
                          resp=JSON.parse(resp);
                          if(resp == '1'){
        
                              alert_toast("Data successfully modified",'info')
                              setTimeout(function(){
                                location.reload()
                              },1500)
                                              }
                                              else{
                                                alert_toast("Erreur",'danger')
                              end_load()
                        }
                          
                        }
                        
                    }
                })
          }else{
                  alert_toast("L'un des champs n'est pas rempli !",'danger')
          
          }
             })
        
          </script>
        <?php
               break;  
               case 'Modif_cer_p':
                $_GET['ID1'];
                $sql="SELECT * FROM t_certificat_p WHERE (ID='".$_GET['ID1']."')";
                $result=mysqli_query($conn, $sql);
                $row= mysqli_fetch_array($result);
               
                ?>
                     <form action="" name="formM" id="formM" > 
        <div id="msg">
        </div>

                <div class="card" >
                <h5 class="card-header">Paramètre Certificat </h5>
            <div class="card-body">
            <div class="row g-3">
            <div class="col-6">
<label for="Département" class="form-label">Département</label>
<input class="form-control" list="datalistdep" placeholder="Département"  name="Departement" id="Departement" value="<?php echo (isset($row["Departement"])? $row["Departement"] :'')?>" autocomplete="off" required>
       <?php $Personnels=$Personnel->getDep();?>
</div>
<input type="hidden" class="form-control"   name="ID" id="ID" value="<?php echo (isset($row["ID"])? $row["ID"] :'')?>" > 
<input type="hidden" class="form-control"   name="D_P_AV" id="D_P_AV" value="<?php echo (isset($row["D_P_AV"])? $row["D_P_AV"] :'')?>" > 

<div class="col-6">
<label for="Service" class="form-label">Service</label>
<input class="form-control" list="datalistser" placeholder="Service"  name="Ser" id="Service" autocomplete="off" value="<?php echo (isset($row["Service"])? $row["Service"] :'')?>" >
<option value=""></option>	
</div>
</div>
<div class="row g-3">
<div class="col-3">
</div>
<div class="col-6">
<label for="Qualification" class="form-label">Qualification</label>
<input type="text" class="form-control" name="Qualification" value="<?php echo (isset($row["Qualification"])? $row["Qualification"] :'')?>" autocomplete="off" required> 
</div>
<div class="col-2">
</div>
</div>
             </div>






             </form>
<script>

$('#formM').submit(function(e){
var $form = $('#formM');

if ($form.valid()) {


//a= $("#forma").serialize();

e.preventDefault()
start_load()
$('#msg').html('')
$.ajax({
url:"Certificat_Function.php?action=Modif_cer_p",  
data: new FormData($(this)[0]),
cache: false,
contentType: false,
processData: false,
method: 'POST',
success:function(resp){
//console.log(a);
if(resp){



//      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
//         $('#output2').html('L un des Champs n a pas été rempli');

resp=JSON.parse(resp);
if(resp == '1'){

alert_toast("Data successfully modified",'info')
setTimeout(function(){
location.reload()
},1500)
      }
      else{
        alert_toast("Erreur",'danger')

end_load()
}

}

}
})
}else{
alert_toast("L'un des champs n'est pas rempli !",'danger')
return false;

}
});
</script>
             <?php
break;
    
case 'Ajout_cer_d': 
        $_GET['ID1'];

        $qry1 ="SELECT * FROM t_certificat_p WHERE (ID='".$_GET['ID1']."')";
        //echo($qry1)."<br>";     
                $result1=mysqli_query($conn, $qry1);
                $row= mysqli_fetch_array($result1);
     
?>

<form action="" name="form1" id="form1" > 
<div id="msg">
</div>
<div class="row">
                    <div class="col">
                         <label for="Type" class="form-label">Type </label>
                         <select id="Type" class="form-control" name="Type">
                              <option value="Aptitude" selected >Aptitude</option>
                              <option value="Reprise" >Reprise MO/AT/MP</option>
                         </select>
                    </div>
                    <div class="col" id="D_rep">
                    </div>
               </div>
               <br>
               <div class="row g-3">

               <div class="col">
               <label for="Date_D" class="form-label">Date Début de Visite</label>
               <input type="date" class="form-control" placeholder=""  id="selDate" name="Date_D" value="" required>
               </div>
               <div class="col">
               <label for="days" class="form-label">Jours</label>
               <input type="number" class="form-control" min="0" max="31"  name="days" value="" >
               </div>
               
               
               <div class="col">
               <label for="months" class="form-label">Mois</label>
               <input type="number" min="0" max="12" class="form-control" name="months" value="" >
               </div>
               <input type="hidden" min="0" max="12" class="form-control" name="years" value="0" >

               <div class="col">
               <label for="Date_F" class="form-label">Date de Prochaine visite</label>
               <input type="date" class="form-control" id="Date__F" name="Date_F" value="" required readonly>
               </div>
               </div>
               <br>
               <div class="row">
                    <div class="col">
                         <label for="Type" class="form-label">Avis</label>
                         <select id="apte" class="form-control" name="apte">
                              <option value="Apte" selected >Apte</option>
                              <option value="Changement" >Changement</option>
                              <option value="Amenagement" >Aménagement</option>
                              <option value="Apte_Temporaire" >Apte Temporaire</option>
                              <option value="Inapte_Temporaire" >Inapte Temporaire</option>
                              <option value="Reprise" >Reprendre</option>
                         </select>
                    </div>
               </div>
               <br>
               <div class="row g-3">

              
               <div class="col">
               <label for="Avis"  name="Avis" class="form-label">Avis Médecin</label>
               <textarea class="form-control"  name="Avis" rows="3" cols="55"> </textarea>
               </div>
               </div>   
         </form>

<script>           
$("#Date__F").on("focus",function(){
        calculateTotal();
});  
function calculateTotal(){
        $.post('caldate.php', $('#form1').serialize(),function(res){
        //display the result from caldate.php
        $('#Date__F').val(res);
        });
};
$('#form1').submit(function(e){
var $form = $('#form1');

if ($form.valid()) {     
//a= $("#forma").serialize();

   e.preventDefault()
   start_load()
   $('#msg').html('')
   $.ajax({
             url:"Certificat_Function.php?action=Ajout_cer_d",  
        data: new FormData($(this)[0]),
       cache: false,
       contentType: false,
       processData: false,
       method: 'POST',
       success:function(resp){
    //  console.log(a);
           if(resp){



//      if ($.trim($("").val()) === "" || $.trim($("").val() )==="" ) {
//         $('#output2').html('L un des Champs n a pas été rempli');

               resp=JSON.parse(resp);
               if(resp == '1'){

                   alert_toast("Data successfully saved",'success')
                   setTimeout(function(){
                 location.reload()
                   },1500)
                                   }
                                   else{       
                                             alert_toast("Erreur",'danger');
                //end_load();

                    
        }
           }     
                
                
            }
        })
  }else{
          alert_toast("L'un des champs n'est pas rempli !",'danger');
          return false;
  
  }
     
     });
</script>
    <?php     
break;
        }
?>