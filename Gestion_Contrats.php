<?php
  $conn = mysqli_connect("localhost", "root", "root", "stipdb");
header('Content-Type: text/html; charset=utf-8');
include('header.php'); 
include 'phpfunction.php';
$Personnel = new Personnel();
$Personnel->checkLoggedIn();
if (!in_array(5, $_SESSION['Role'])) { // search value in the array
    header("Location:RapportMensuel");
}
$output='';
if(isset($_POST['Sortie'])) {    
    $Personnel->setdateSortie($_POST);
    //echo($Personnel->setdateSortie($_POST));
}


?>
    <title>Gestion Contrats </title>
<style type="text/css">
table tr.even {
 background-color: #fde9d9;
}
table tr.more {
 background-color: #fde9d9;
 display: none;
}

</style>    
<script src="js/date.format.js"></script>
<script type="text/javascript">


 




 window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    var bsAlert = new bootstrap.Toast($('#alert_toast'));//inizialize it
    bsAlert.show();//show it
    }
window.uni_modal = function($title = '' , $url='',$size=''){
    start_load()
      $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("Une erreur s'est produite")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                if($size != ''){
                    $('#uni_modal .modal-dialog').addClass($size)
                }else{
                    $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog")
                }
            }
            end_load()
        }
      })
}
window.uni_modal_F = function($title = '' , $url='',$size=''){
    start_load()
      $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("Une erreur s'est produite")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal_F .modal-title').html($title)
                $('#uni_modal_F .modal-body').html(resp)
                if($size != ''){
                    $('#uni_modal_F .modal-dialog').addClass($size)
                }else{
                    $('#uni_modal_F .modal-dialog').removeAttr("class").addClass("modal-dialog")
                }
            }
            end_load()
        }
      })
}


$( document ).ajaxComplete(function() { 

// show poppup for upload file
$('#show_cdd_btn').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
$('#previewpdf').empty();    
$('#previewpdf').append("<embed  type='application/pdf' src='uploadsContrats_Files/"+recipient+".pdf' width='400px' height='600px' style='display: inline-block;'/>");
})

// upload file function



});

//calcule date fin contrat
//function historique
    function Historique_data(Mle='')  
    {  
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=H",  
            data:{Mle:Mle},  
            method:"POST",  
            success:function(data){  
        $('#live_data').html(data); 
            }  
        });
    }
$(document).on("click", '.edit_button',function(e) {
    var name = $(this).data('name');
    var id = $(this).data('id');
    var content = $(this).data('content');
    var quote = $(this).data('quote');
    $(".business_skill_id").val(id);
    $(".business_skill_name").val(name);
    $(".business_skill_quote").val(quote);
    tinyMCE.get('business_skill_content').setContent(content);   
    
});
$(document).on( "click", '#Modif_CDD',function(e) {
		uni_modal("Modifier Contrat ","ajaxCDD.php?action=manage&IDdetail="+$(this).attr('data-id'),"mid-lg");       
	})
$(document).on( "click", '#Ajouter_CDD',function(e) {
		uni_modal("Ajouter Contrat ","ajaxCDD.php?action=manage&IDdetailp="+$(this).attr('data-id2'),"mid-lg");
	})
    $(document).on( "click", '#confirmer',function(e) {
		uni_modal("Confirmer Contrat ","ajaxCDD.php?action=confirmer&IDp="+$(this).attr('data-id2'),"mid-sm");
    })
    $(document).on( "click", '#upload_cdd_btn',function(e) {
        
        uni_modal("Upload Contrat ","ajaxCDD.php?action=upload&Mle="+$(this).attr('data-id3')+"&Ref="+$(this).attr('data-id2')+"&Date_Ref="+$(this).attr('data-id1'),"mid-sm");
    })
    $(document).on( "click", '#Ajouter_FI01',function(e) {
		uni_modal("Ajouter FI01","contrat_FI01.php?action=formFI001&Mle="+$(this).attr('data-id2'),"modal-xl");
         $("#uni_modal .modal-body").css({'overflow': 'auto'});
	})
    $(document).on( "click", '#Ajouter_ligne_T',function(e) {
		uni_modal_F("Ajouter_ligne ","contrat_FI01.php?action=formFI001ADD&id="+$(this).attr('data-id2'),"modal-xl");
        var myModalEl = document.getElementById('uni_modal_F')
myModalEl.addEventListener('shown.bs.modal', function (event) {
    fetch_item_data();
    fetch_item_data2();
    $("#uni_modal_F .modal-body").css({'overflow': 'auto'});

})
	})

    $(document).on( "click", '#Ajouter_FI02',function(e) {
		uni_modal_F("Ajouter_FI02","fiche_FI02.php?action=FI002&Mle="+$(this).attr('data-id')+"&id="+$(this).attr('data-id2'),"modal-xl");
        //console.log($(this).attr('data-id2'));
	})
    
//$('#element').toast('show')
    $(document).on('click', '.Modifcatech_btn', function(){  
      //alert('ici');
    $(this).closest('tr').next('tr.more').toggle();
});
    $(document).on('click','.effacer', function(event) {
            if (confirm('Supprimer De La Liste de Contracts?')) {
                ID_D=$(this).attr("data-id");
                console.log(ID_D);
                method:"POST",  
                $.ajax({  
                url:"Gestion_Contrats_Functions.php?action=effacer",
                method:"POST",  
                data:{ID_D:ID_D},  
                dataType:"text",  
                success:function(data)  
                {  
                alert(data);  
                fetch_data();

                }  
            }) 
        }
    });
   

//Filtre tableau par mois
    $(".btn-group .btn").click(function(){
        var inputValue = $(this).find("input").val();
        if(inputValue != 'all'){
            var target = $('table tr td[data-status="' + inputValue + '"]').parent();
            $("table tbody tr").not(target).hide();
            target.fadeIn();
        } else {
            $("table tbody tr").fadeIn();
        }
    });
    $('#form').validate({ // initialize the plugin
        rules: {
            // all the rules
        }
    });




//function select data
    function fetch_data()  
    {  
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=select",  
            method:"POST",  
            success:function(data){  
        $('#live_data').html(data); 
        Notifi();
            }  
        });
    }
    function fetch_data1(ID)  
    {  
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=add",
            method:"POST",  
            data:{ID:ID},
            dataType:"text",  
            success:function(data){  
        $('#live_data').html(data); 
        Notifi();
            }  
        });
    }
    function fetch_data2(ID)  
    {  
        $.ajax({  
            url:"ajaxCDD.php?action=ajout",
            method:"POST",  
            data:{ID:ID},
            dataType:"text",  
            success:function(data){  
        $('#live_data').html(data); 
        Notifi();
            }  
        });
    }

//function select notification
function Notifi()  
    {  
        $.ajax({  
            url:"Notification_Contrat.php",  
            method:"POST",  
            success:function(data){  
        $('#notifications').html(data); 
            }  
        });  
    }  
    

//Ajouter Nouveau  employe dans la liste
    $(document).on('click', '#btn_add', function(){  
        var Mle = $('#Mle').text(); 
        var Nom = $('#Nom').text();
        var Date_1er = $('#Date_1er').val();
        var Type = $('#Type').find(':selected').val(); 
        if(Mle == '')  
        {  
            alert("Enter Mle");
            $('#Nom_Article').focus();  
            return false;  
        }  
        if(Date_1er == '')  
        {  
            alert("Choisir Date");  
            return false;  
        }
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=insert",  
            method:"POST",  
            data:{ Date_1er:Date_1er, Type:Type, Nom:Nom},  
            dataType:"text",  
            success:function(data)  
            {  
                alert(data);  
                fetch_data();  
            }  
        })  
    });
//Confirmation employe titulaire
    $(document).on('click', '#btn_Finish', function(){  
        var ID_ATMS = $('#ID_ATMS').text(); 
        var Date_F = $('#Date_F').val();            
        var Ref = $('#Ref').text(); 
        var Date_Ref = $('#Date_Ref').val(); 
        var Qualification = $('#Qualification').text();
        if(Qualification == '')  
        {  
            alert("Enter une Qualification !");
            $('#Qualification').focus();  
            return false;  
        }
        if(Date_F == '')  
        {  
            alert("Enter Date debut");
            $('#Date_F').focus();  
            return false;  
        }
        if(Ref == '')  
        {  
            alert("Saissir Num Reférence !");
            $('#Ref').focus();               
            return false;  
        } 
        if(Date_Ref == '')  
        {  
            alert("Saissir Date Reférence !");
            $('#Date_Ref').focus(); 
            return false;  
        } 
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=confirmer&IDp="+$(this).attr('data-id2'),  
            method:"POST",  
            data:{ID_ATMS:ID_ATMS,Date_F:Date_F,Type:Type,Ref:Ref,Date_Ref:Date_Ref,Qualification:Qualification},  
            dataType:"text",  
            success:function(data)  
            {  
                //alert("Data Inserted");  
              fetch_data();  
                
            }  
        })  
    });

    


//supprimer de la liste un partant
$(document).ready(function() {
    //execution select data
    fetch_data();
$(document).on('click', '.Supprimer', function(event) {
    if (confirm('Supprimer De La Liste Active?')) {
          $this=$(this).attr("data-id1");
          $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=delete",  
            method:"POST",  
            data:{ID:$this},  
            dataType:"text",  
            success:function(data)  
            {  
                alert("Data Supprimer");  
                fetch_data();

            }  
        }) 
        }
});
});

//executer requete confirmation titulaire
$(document).on('click', '.Finish', function(event) {
        var ID = $(this).attr('data'); 
          //alert(ID);
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=Finish&ID="+ID,  
            method:"POST",  
            data:{ID:ID},  
            dataType:"text",  
            success:function(data)  
            {  
                //alert(data);  
            $('#live_data').html(data);
            $(this).attr('data-original-title', '');
 
            }  
        })  
    });
$(document).on('click', '.prev', function(){  
fetch_data(); 
});


//Ajouter details Accident ou maladie
    $(document).on('click', '.add_details', function(){  

        var ID = $(this).attr('data'); 
          //alert(ID);
        $.ajax({  
            url:"Gestion_Contrats_Functions.php?action=add&ID="+ID,  
            method:"POST",  
            data:{ID:ID},  
            dataType:"text",  
            success:function(data)  
            {  
                //alert(data);  
            $('#live_data').html(data);
            $(this).attr('data-original-title', '');
 
            }  
        })  
    }); 


$(document).on('keyup', '#myInput', function() {
    listRecords($(this).val());
});
//$('#myModal').on('shown.bs.modal', function () {
//$('#myInput').trigger('focus')
//})

// call function RechercheNom
$(document).on('keyup', '#Mle', function() {
var Mle = $(this).text();
    //console.log(Mle);
RechercheNom(Mle);
});
//function get name by mle function
function RechercheNom(searchQuery=''){
    //console.log(searchQuery);
    $.ajax({
        url:"Gestion_Contrats_Functions.php?action=recherche",
        method:"POST",
        data:{Mle:searchQuery},
        dataType: "text",
        success:function(response) {
            $('#Nom').html(response); 
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert("Error : "+thrownError);
        }
    });
};
//scroll down input for add new function
function AddnewATMS() {
     $('html, body').animate({
                    scrollTop: $("#Mle").offset().top
                }, 2000);
$("#Mle").focus();
}
window.start_load = function(){
    if($('#preloader2').length > 0)
      return false;
    $('body').append('<div id="preloader2"></div>')
  }
  window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
  }

//Recherche function
function listRecords(searchQuery='') {
    //console.log(searchQuery);
    $.ajax({
        url:"Gestion_Contrats_Functions.php?action=select",
        method:"POST",
        data:{query:searchQuery},
        success:function(response) {
            // console.log(response.html);
            $('#live_data').html(response); 
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert("Error : "+thrownError);
        }
    });
};
function newApi(format) {
  return ExcellentExport.convert({
      anchor: 'anchorNewApi-' + format,
      filename: 'data_123.' + format,
      format: format
  }, 
  [{
      name: 'Sheet Name Here 1',
      from: {
          table: 'datatable'
      }
  }]);
};



// FI001 ALL FUNCTIONS

function fetch_data_p(mle='')  
    {  
        $.ajax({  
            url:"contrat_FI01.php?action=formFI001&Mle="+mle,  
            method:"GET",  
            success:function(data){  
        $('#uni_modal .modal-body').html(data); 
        Notifi();
            }  
        });
    }
    function myFunction()
    {

        var element = document.getElementById("myDIV");
  element.classList.add("mystyle");
    }

function fetch_item_data(){
    start_load();
var id_p=$('#id_p').val();
var mat = $("#Mle_FI001").val();
var id = $('#Ajouter_ligne_T').attr('data-id2');
var etat = $('#Ajouter_ligne_T').attr('data-id');
  $.ajax({
      url:"fetch.php",
      method:"POST",
      data:{ id_p : id_p,mat:mat, id:id, etat:etat},
          success:function(data){
              $('#inserted_item_data').html(data);
            end_load();

          }
  })
}


function fetch_item_data2(){
    start_load();
    var id_p=$('#id_p').val();
    var mat = $("#Mle_FI001").val();
    var id = $('#Ajouter_ligne_T').attr('data-id2');
    var etat = $('#Ajouter_ligne_T').attr('data-id');
    $.ajax({
        url:"fetch2.php",
        method:"POST",
        data:{ id_p : id_p,mat:mat,id:id,etat:etat},
            success:function(data){
                $('#inserted_item_data2').html(data);
                end_load();
            }
    })
}
 

      $(document).ready(function(){
       // var count = 1;
      

$(document).on('click', '.enregistrer', function() {
var Mle = $("#Mle_FI001").val();
var etat = "0";
nom=$('.nom').text();
prenom=$('.prenom').text();
date_naissance=$('.date_naissance').text();
date_embauche=$('.date_embauche').text();
affectation=$('.affectation').text();
qualification=$('.qualification').text();

$.ajax({
url:"contrat_FI01.php?action=insert_p",
method:"POST",
data:{Mle:Mle,nom:nom, prenom:prenom,date_naissance :date_naissance, date_embauche:date_embauche,affectation:affectation,qualification:qualification,etat:etat},
success:function(data){
    alert("add success");

/*if(data== '1'){
fetch_data_p(Mle);
}*/
    
}

});

});

$(document).on('click', '.status', function(e) {
    $etat= $(this).attr('data-id2');
    $id= $(this).attr('data-id1');
  
 		e.preventDefault();
     
 		$.ajax({
 			url:'changer_etat.php',
 			method:'POST',
 			data:{id:$id,etat:$etat},
 			success:function(resp){
 				if(resp==1){
 					alert_toast('Etat Updated!','success');
                   
                    
 				}
 			}
 		})
 	})
     $(document).on('click', '.del1', function(e) {
    var id = $(this).attr('data-id2');
 		e.preventDefault();
 		$.ajax({
 			url:'delete_update.php',
 			method:'POST',
 			data:{id:id},
 			success:function(data){
                alert_toast('delete!','success')
                fetch_item_data();
                fetch_item_data2();
 				}
 			
 		});
 	});
     
       

          
        $(document).on('click', '.remove', function(){
     $(this).parent().parent().remove();
});



      // -------------------------fetch

   
      }) 
</script>

<body>
<?php
include('menu.php');
?>   


<div class="content">
<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
  </div>
  <div class="container"> 
            <div class="col"><hr></div>

                <h2>Gestion Contrats :</h2>
    <div class="col"><hr></div>
<div class="content">
   
    <a type="button" class="btn btn-outline-warning  dataExport" data-bs-toggle="tooltip" data-bs-placement="top" title="Export Excel"  float="Right" download="Contrats <?php echo date('d-m-Y-His'); ?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable', 'Contrats');"><i class="mdi mdi-file-download"></i></a>
    <a role="button" class="btn btn-outline-primary " data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter Contrat" href="#" onclick="return AddnewATMS();"> <i class="mdi mdi-add"></i></a>
   

    <span class="" id="notifications"></span>
    <br>

</div>
<br>
      <input class="form-control mr-sm-2" type="search" placeholder="recherche Mle / Nom" aria-label="Search" id="myInput" autocomplete="off">
    <div class="col"><hr></div>
            <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6"><h2>Filtre <b>Date Fin</b></h2></div>
                    <div class="col-sm-6">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <input type="radio" name="status" value="all" checked="checked"> All
                            </label>
                            <label class="btn btn-success">
                                <input type="radio" name="status" value="01mois">Dans 01 mois
                            </label>
                            <label class="btn btn-warning">
                                <input type="radio" name="status" value="02mois">Dans 02 mois
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="status" value="03mois">Dans 03 mois
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name="status" value="expired"> Expired
                            </label>                            
                        </div>
                    </div>
                </div>
            </div>


    <div id="live_data">aze</div>


    

 <div class="modal fade" id="uni_modal" tabindex="-1"   aria-labelledby="uni_modal"   aria-hidden="true">
    <div class="modal-dialog modal-lg " >
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      
       </div>
       
      <div class="modal-body">
      </div>
      <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-outline-success">Enregistrer</button>    -->
                    <!-- <button type="button" class="btn btn-outline-success" id='submit' onclick="$('#uni_modal form').submit()">Enregistrer</button> -->

                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                         </div>
      
      </div>
    </div>
  </div>

  <div class="modal fade" id="uni_modal_F" tabindex="-1"   aria-labelledby="uni_modal_F"   aria-hidden="true">
    <div class="modal-dialog modal-lg " >
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      
       </div>
       
      <div class="modal-body">
      </div>
      <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-outline-success">Enregistrer</button>    -->
                    <!-- <button type="button" class="btn btn-outline-success" id='save'>Enregistrer</button> -->

                    <button class="btn btn-primary" data-bs-target="#uni_modal" data-bs-toggle="modal" data-bs-dismiss="modal">Retour</button>                         </div>
      
      </div>
    </div>
  </div>
</div>

</body>
</html>
