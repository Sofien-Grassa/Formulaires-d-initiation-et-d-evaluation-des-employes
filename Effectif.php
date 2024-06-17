<?php
include('header.php'); 
include 'phpfunction.php';
$Personnel = new Personnel();
 $Personnel->checkLoggedIn();
 if (!in_array(2, $_SESSION['Role'])) { // search value in the array
       header("Location:RapportMensuel");
 }
if(isset($_POST['Sortie'])) {    
    $Personnel->setdateSortie($_POST);
//    echo($Personnel->setdateSortie($_POST));
}
$output='';
?>
<style type="text/css">
  table {
    font-size: 12px;
}

</style>
    <title>Effectif</title>
        <script type="text/javascript">

      $(document).ready(function() {
          $(function () {
              $('[data-title="tooltip"]').tooltip()
            });

            $('#datatable').dataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    }); 

            $('#FormSortieModal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var recipient = button.data('whatever') // Extract info from data-* attributes
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              var modal = $(this)
              modal.find('.modal-title').text('Formulaire de sortie de l\'agent : ' + recipient)
              modal.find('.modal-body input').val(recipient)
            })
            $('#ForminfoModal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var recipient = button.data('whatever') // Extract info from data-* attributes
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              var modal = $(this)
              modal.find('.modal-title').text('Fiche de l\'agent : ' + recipient)
              modal.find('.modal-body input').val(recipient)

            $.ajax({  
            url:"Fiche_info.php?action=info",  
            method:"POST",
            data:{Mle:recipient},
            success:function(data){  
                $('#infoModal').html(data); 
            }  
        });  
    
            })

        });

function newApi(format) {
  return ExcellentExport.convert({
      anchor: 'anchorNewApi-' + format,
      filename: 'data_123.' + format,
      format: format
  }, [{
      name: 'Sheet Name Here 1',
      from: {
          table: 'datatable'
      }
  }]);
};
        </script>


<body>
<?php
include('menu.php');
?>    

<div class="content">
    <div class="container"> 
            <div class="col"><hr></div>

                <h2>EFFECTIF STIP :</h2>

            <div class="row">
                <div class="col-md-3">
                <input type="text" name="Date_D" id="date_D" class="form-control " readonly="" placeholder="Filtre Date Debut" minlength="2" required>
                </div>
                <div class="col-md-3">
                <input type="text" name="Date_F" id="date_F" class="form-control " readonly="" placeholder="Filtre Date Fin" minlength="2" required>
                </div>
                <!-- <button type="button" class="btn btn-success">Filtre</button> -->
            </div>  
    <div class="col"><hr></div>
<div class="content">
<div class="btn-group" role="group" aria-label="Basic example">    
    <a role="button" class="btn btn-outline-primary" data-title="tooltip" data-placement="top" title="Nouveau Personnel" href="Effectif_Add"><i class="mdi mdi-note-add"></i></a>
    <a role="button" class="btn btn-outline-primary" data-title="tooltip" data-placement="top" title="Les Partants" href="Partants"><i class="mdi mdi-delete-sweep"></i></a> 
    <a role="button" class="btn btn-outline-primary" data-title="tooltip" data-placement="top" title="Parametre"><i class="mdi mdi-settings"></i></a>
</div>
    <a type="button" class="btn btn-success dataExport" data-title="tooltip" data-placement="top" title="Export Excel" download="Effectif <?php echo date('d-m-Y-His'); ?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable', 'Effectif');"><i class="mdi mdi-file-download"></i></a>

</div>
    <div class="col"><hr></div>

      <table id="datatable" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th>Ord</th>
            <th>Mle</th>
            <th>Nom</th>
            <th>Département</th>            
            <th>Service</th>
            <th>Date N</th>            
            <th>Age</th>            
            <th>Date Entree Etab</th>
            <th>Date Anc</th>            
            <th>Anc</th>            
            <th>Action</th>            
        </tr>
    </thead>
    <tbody>

        <?php
        $i=1;     
        $Personnels = $Personnel->getPersonnelListActive();
        foreach($Personnels as $PersonnelsDetails){
            $Age = $Personnel->getAge($PersonnelsDetails["ID"]);
            foreach($Age as $age)
            echo '
              <tr>
                <td>'.$i++.'</td>
                <td>'.$PersonnelsDetails["Mle"].'</td>
                <td>'.$PersonnelsDetails["Nom"]." ".$PersonnelsDetails["Prenom"].'</td>
                <td>'.$PersonnelsDetails["Nom_Dep"].'</td>
                <td>'.$PersonnelsDetails["Nom_Service"].'</td>
                <td>'.$PersonnelsDetails["Date_N"].'</td>                
                <td>'.$age["ageInYears"].'</td>
                <td>'.$PersonnelsDetails["Date_Entre_Etab"].'</td>                
                <td>'.$PersonnelsDetails["Date_Anc"].'</td>
                <td>'.$age["AncInYears"].'</td>
                <td>
                <div class="btn-group" role="group" aria-label="Basic example">    
                <a role="button" class="btn btn-primary" data-title="tooltip" data-placement="top" title="Fiche Personnel" href="Profile?Mle='.$PersonnelsDetails["Mle"].'" target="_blank"><i class="mdi mdi-account-box"></i></a>
                 <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ForminfoModal" data-whatever="'.$PersonnelsDetails["Mle"].'" data-title="tooltip" data-placement="top" title="Info Rapide"><i class="mdi mdi-info-outline"></i></button>
                <a type="button" class="btn btn-secondary" data-title="tooltip" data-bs-toggle="modal" href="Effectif_Add?Mle='.$PersonnelsDetails["Mle"].'" data-placement="top" title="Edit"><i class="mdi mdi-edit"></i></a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#FormSortieModal" data-whatever="'.$PersonnelsDetails["Mle"].'" data-title="tooltip" data-placement="top" title="Partant"><i class="mdi mdi-delete-forever" ></i></button>
                    </div>
                </td>
              </tr>
            ';
        }       
        ?>

    </tbody>
</table>
    <div class="line"></div>
    </div>
</div>  

<!-- Formulaire Sortie -->
<div class="modal fade" id="FormSortieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
      </div>
        <form class="needs-validation" method="POST" autocomplete="off" novalidate>
      <div class="modal-body">
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="recipient-name" name="Mle" readonly >
            </div>
            <div class="form-group col-md-6">
              <label for="inputDateSortie">Date Sortie Etab</label>
              <input type="date" class="form-control" name="Date_Sortie_Etab" placeholder="2020-01-01" required>
            </div>
            <div class="form-group col-md-6">
                <label for="inputState">Motif De Sortie</label>
                  <select name="Motif_Sortie" class="form-control" required>
                    <option></option>
            <?php
                $Motif_Sorties = $Personnel->getMotifSortie();
                foreach($Motif_Sorties as $Motif_Sortie){
                    echo '<option value="'.($Motif_Sortie['Motif_Sortie']).'">'.($Motif_Sortie['Motif_Sortie']).'</option>';
                }
            ?>
                  </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="Sortie">Enregistrer</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- fiche Fiche de carrière Ajax-->
<div class="modal fade" id="ForminfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content" id="infoModal">

  </div>
</div>
</div>
</body>
</html>