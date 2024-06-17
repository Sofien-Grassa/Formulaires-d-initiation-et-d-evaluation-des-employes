<?php
header("Content-type: text/html;charset=UTF-8");
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
//    echo($Personnel->setdateSortie($_POST));
}
?>
    <title>Gestion Qualification</title>
<style type="text/css">
        table tr.even {
            background-color: #fde9d9;
        }
.ui-widget {
  font-family: inherit;
  font-size: inherit;
}

div#MyText {
  font-family: inherit;
  font-size: inherit;
  width: 60%;
  background-color: #ECF0F1;
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.15);
  padding: 8px;
}

.ui-menu {
  margin: 0;
  padding: 0;
  top: 0;
  background-color: #FFFFFF;
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.15);
  border: 1px solid rgba(0, 0, 0, 0.15);
}

.ui-menu-item-wrapper {
  display: block;
  padding: 4px 6px;
}

.ui-menu-item-wrapper:hover,
.ui-state-active {
  background-color: #34495E;
  color: #FFFFFF;
  cursor: pointer;
}

.ui-helper-hidden-accessible {
  display: qnone;
}

.ui-helper-hidden-accessible {
  padding: 4px 0 0 0;
  font-size: smaller;
  }        
</style>    
<script src="js/date.format.js"></script>
        
<script type="text/javascript">

$( document ).ajaxComplete(function() {

  $("#Date_F").one( "focus",function(){
    calculateTotal();
  });

}); 
$(document).ready(function() {
    
function addMonths(date, months) {
    var d = date.getDate();
    date.setMonth(date.getMonth() + +months);

    //console.log(date.getDate()+"="+d);

    if (date.getDate() == d) {
      date.setDate(0);
    }
    return date;
}
});


function calculateTotal(){
        $('#selDate').val($('#Date_D').val());
        $('#Hidden_Mois').val($('#months').val());
        $('#Hidden_Annee').val($('#years').val());

          //send the form data to caldata.php
          $.post('caldate.php', $('#myform').serialize(), function(res){
            //display the result from caldate.php
            $('#Date_F').val(res);
          });


      };
      
$(document).ready(function() {
$('#element').toast('show')


    function fetch_data()  
    {  
        $.ajax({  
            url:"Function_qualification_Functions.php?action=select",  
            method:"POST",  
            dataType:"text",              
            success:function(data){  
        $('#live_data').html(data); 
            }, 
            complete: function() { 
                $('#datatable').dataTable( {
        "lengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]]
    } );

            }

        });
    }
  
    fetch_data();

//Ajouter Nouveau Accident ou maladie
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
            url:"Function_qualification_Functions.php?action=insert",  
            method:"POST",  
            data:{Mle:Mle, Date_1er:Date_1er, Type:Type, Nom:Nom},  
            dataType:"text",  
            success:function(data)  
            {  
                alert(data);  
                fetch_data();  
            }  
        })  
    });

    $(document).on('click', '#btn_Finish', function(){  
        var ID_Qualification = $('#ID_Qualification').text(); 
        var Date_F = $('#Date_F').val();            
        var Type = $('#Type').find(':selected').val(); 
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
            url:"Function_qualification_Functions.php?action=Finishquery",  
            method:"POST",  
            data:{ID_Qualification:ID_Qualification, Date_F:Date_F, Type:Type,Ref:Ref,Date_Ref:Date_Ref,Qualification:Qualification},  
            dataType:"text",  
            success:function(data)  
            {  
                alert("Data Inserted");  
                fetch_data();  
            }  
        })  
    });

    $(document).on('click', '#btn_prolongation', function(){ 
        var Mle = $(this).attr("data-id1");
        var ID_Qualification = $('#ID_Qualification').text(); 
        var Fonction = $('#Fonction').text(); 
        var Position = $('#Position').text(); 
        var Qualification = $('#Qualification').text(); 
        var College = $('#College').val();            
        var Date_Poste = $('#Date_Poste').val(); 
        var dep_select = $('#Dep').val(); 
        var service_select = $('#Ser').val(); 
        var Ref = $('#Ref').text(); 
        var numberservice = $('#Ser').length;

        console.log(dep_select);
        console.log(service_select);
        if(Qualification == '')  
        {  
            alert("Enter une Qualification !");
            $('#Qualification').focus();  
            return false;  
        }
        if(College == '')  
        {  
            alert("Enter College !");
            $('#College').focus();  
            return false;  
        }  
        if(Date_Poste == '')  
        {  
            alert("Saissir une Date Poste !"); 
            $('#Date_Poste').focus();   
            return false;  
        }
        if(dep_select == 'Click to select')  
        {  
            alert("selectionner un Département !"); 
            return false;  
        }
        if( numberservice!=1 && College=='Execution')  
        {  
            alert("selectionner un Service !"); 
            return false;  
        }        
        if(Ref == '')  
        {  
            alert("Saissir Num Reférence !");
            $('#Ref').focus();               
            return false;  
        } 
         
        $.ajax({  
            url:"Function_qualification_Functions.php?action=prolongationadd",  
            method:"POST",  
            data:{Mle:Mle,Fonction:Fonction,Position:Position,Qualification:Qualification, College:College, Date_Poste:Date_Poste, Dep:dep_select,Ser:service_select,Ref:Ref},  
            dataType:"text",  
            success:function(data)  
            {  
                alert("Data Inserted");  
                fetch_data();  
            }  
        })  
    });

$(document).on('click', '.Supprimer', function(event) {
    if (confirm('Supprimer De La Liste Active?')) {
          $this=$(this).attr("data-id1");
          $.ajax({  
            url:"Function_qualification_Functions.php?action=delete",  
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

$(document).on('click', '.Historique', function(event) {
        var Mle = $(this).attr('data'); 
          //alert(ID);
        $.ajax({  
            url:"Function_qualification_Functions.php?action=Historique&Mle="+Mle,  
            method:"POST",  
            data:{Mle:Mle},  
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
                $('#datatable').dataTable( {
        "lengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]]
    } );

            
});
//Ajouter details Accident ou maladie
    $(document).on('click', '.add_details', function(){  

        var Mle = $(this).attr('data'); 
          //alert(ID);
        $.ajax({  
            url:"Function_qualification_Functions.php?action=add&Mle="+Mle,  
            method:"POST",  
            data:{Mle:Mle},  
            dataType:"text",  
            success:function(data)  
            {  
                //alert(data);  
            $('#live_data').html(data);
            $(this).attr('data-original-title', '');
 
            }  
        })  
    }); 

var $input = $('#myInput');
    $input.on('keyup', function () {
       // alert($(this).val());
  listRecords($(this).val());
});

$(document).on('blur', '#Mle', function() {
var Mle = $(this).text();
    //console.log(Mle);
RechercheNom(Mle);
});

$(document).on('blur', '#Position', function() {
var Position = $(this).text();
    //console.log(Position);
RechercheQualification(Position);
});
});

function RechercheQualification(searchQuery=''){
    //console.log(searchQuery);
    $.ajax({
        url:"Function_qualification_Functions.php?action=Position",
        method:"POST",
        data:{Position:searchQuery},
        dataType: "text",
        success:function(response) {
            $('#Qualification').html(response); 
                console.log(response);

        },
        error:function (xhr, ajaxOptions, thrownError){
            alert("Error : "+thrownError);
        }
    });
};
function AddnewATMS() {
     $('html, body').animate({
                    scrollTop: $("#Mle").offset().top
                }, 2000);
$("#Mle").focus();
}

function listRecords(searchQuery='') {
    //console.log(searchQuery);
    $.ajax({
        url:"Function_qualification_Functions.php?action=select",
        method:"POST",
        data:{query:searchQuery},
        dataType: "text",       
        success:function(response) {
            //console.log(response.html);
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
  }, [{
      name: 'Sheet Name Here 1',
      from: {
          table: 'datatable'
      }
  }]);
};

function  afiche_d() {
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
		afiche_d();
	});
 




// function RechercheNom(searchQuery=''){
//     console.log(searchQuery);
//     $.ajax({
//         url:"ATMSfunctions.php?action=recherche",
//         method:"POST",
//         data:{Mle:searchQuery},
//         dataType: "text",
//         success:function(response) {
//             $('#Nom').html(response); 
//         },
//         error:function (xhr, ajaxOptions, thrownError){
//             alert("Error : "+thrownError);
//         }
//     });
// };

</script>


<body>
<?php
include('menu.php');
?>    

<div class="content">
    <div class="container"> 
            <div class="col"><hr></div>

                <h2>Gestion Qualifications / Fonctions :</h2>
 
    <div class="col"><hr></div>
<div class="content">
   
    <a type="button" class="btn btn-outline-warning dataExport" data-title="tooltip" data-placement="top" title="Export Excel" download="Qualification <?php echo date('d-m-Y-His'); ?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable', 'Qualification');"><i class="mdi mdi-file-download"></i></a>
    <a role="button" class="btn btn-outline-primary" data-title="tooltip" data-placement="top" title="Ajouter Nouveau" href="#" onclick="return AddnewATMS();">
    <i class="mdi mdi-add"></i></a>
</div>
<br>
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="recherche Mle / Nom" aria-label="Search" id="myInput" autocomplete="off"> -->
    <!-- <div class="col"><hr></div> -->
    <div id="live_data"></div>



</div>
</div>
</body>
</html>