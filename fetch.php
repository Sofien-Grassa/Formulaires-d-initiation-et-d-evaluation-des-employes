<?php
    $connect = mysqli_connect("localhost", "root", "root", "stipdb");
    extract($_POST);
    $query = "SELECT * FROM t_fi001_detail where id_p=$id_p and type_F='theorique'";
    $result = mysqli_query($connect, $query);
    $q3="SELECT etat from t_fi001_parent where id=$id_p";
    $res3=mysqli_query($connect,$q3);
    $row3= mysqli_fetch_array($res3);
    $etat=$row3[0];
    

?>
<!DOCTYPE html>
<html>
<style>
.modal-place{
    overflow-x:auto;
}
 .editbox
{
display:none
}
        </style>
<script>
     $(document).ready(function()
    {
      $(".edit_tr").click(function()
    {
        var eta=$(this).attr('data-id');
        var ID=$(this).attr('data-id2');
        if(eta==2)
        alert_toast("IMPOSSIBLE DE MODIFIER",'danger');
if(eta!=2)
{

    //how do i get outtttttt



    $("#format1"+ID).hide();
    $("#format2"+ID).show();
    $("#objet1"+ID).hide();
    $("#objet2"+ID).show();
    $("#lieu1"+ID).hide();
    $("#lieu2"+ID).show();
    $("#datefin1"+ID).hide();
    $("#datefin2"+ID).show();
    $("#datedebut1"+ID).hide();
    $("#datedebut2"+ID).show();
     } }).change(function()
    {
        var ID=$(this).attr('data-id2');
  //  var oldformat=$("#format1"+ID).val();
    var newformat=$("#format2"+ID).val();
  //  var oldobjet=$("#objet1"+ID).val();
    var newobjet=$("#objet2"+ID).val();
 //  var oldlieu=$("#lieu1"+ID).val();
    var newlieu=$("#lieu2"+ID).val();
 //   var olddatefin=$("#datefin1"+ID).val();
    var newdatefin=$("#datefin2"+ID).val();
 //   var olddatedebut=$("#datedebut1"+ID).val();
    var newdatedebut=$("#datedebut2"+ID).val();

 $.ajax({

    url: "update.php",
    method: "POST",
    data:{id:ID,newformat:newformat,newobjet:newobjet,newlieu:newlieu,newdatedebut:newdatedebut,newdatefin:newdatefin},

    success: function(data)
    {
    $("#format1"+ID).html(newformat);
    $("#objet1"+ID).html(newobjet);
    $("#lieu1"+ID).html(newlieu);
    $("#datefin1"+ID).html(newdatefin);
    $("#datedebut1"+ID).html(newdatedebut);
    }
    });
    });
   $(document).mouseup(function()
    {
    $(".editbox").hide();
    $(".text").show();
    });



    });
     $('#add2').click(function(){
           var count =1;
        count = count + 1;
            var html_code = "<tr id='row"+count+"'>";
            html_code += "<td  ><input type='date'class='date_debut'/></td>";
            html_code += "<td ><input type='date'class='date_fin'/></td>";
            html_code += "<td contenteditable='true' class='objet'></td>";
            html_code += "<td contenteditable='true' class='lieu'></td>";
            html_code += "<td contenteditable='true' class='formateur'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
            html_code += "<td><button type='button' onclick='save_dataa()' data-id2='<?php echo $id_p ?>' class=' save_f btn btn-success'>Save</button></td>"
            html_code += "</tr>";
            $('#tab2 tr:first').after(html_code);
        });
        function save_dataa(){
   var id_p = $('#hiddeninp').val();
var date_debut = [];
var date_fin = [];
var objet = [];
var lieu = [];
var formateur = [];
$('.date_debut').each(function(){
date_debut.push($(this).val());
});
$('.date_fin').each(function(){
date_fin.push($(this).val());
});
$('.objet').each(function(){
objet.push($(this).text());
});
$('.lieu').each(function(){
lieu.push($(this).text());
});
$('.formateur').each(function(){
formateur.push($(this).text());
});
var type_F = "theorique";
console.log(type_F);
if(date_debut>date_fin){
    alert("erreur ");
}else
{


$.ajax({
url:"insert_f.php",
method:"POST",
data:{id_p:id_p, date_debut:date_debut, date_fin:date_fin, objet :objet, lieu:lieu, formateur:formateur, type_F:type_F},
success:function(data){
alert(data);
 fetch_item_data();
  //fetch_item_data2();
}
});
}}
</script>
<body>
    <div class="container">
        <?php


    //    extract($_POST);
    //    $e = (int)$etat;
//echo $etat;
        if($etat == '2'){
        echo'
        <div class="modal-place">
        <table class="table text-center table-striped table-bordered" id="tab2">
            <tr>
                <th>date_debut</th>
                <th>date_fin</th>
                <th>objet</th>
                <th>lieuee</th>
                <th>formateur</th>
                <th>Action</th>
            </tr>
          </div>
            ';
        }
        else{
            echo'
            <div class="modal-place">
            <table class="table text-center table-striped table-bordered" id="tab2">
            <tr>
                <th>date_debut</th>
                <th>date_fin</th>
                <th>objet</th>
                <th>lieu</th>
                <th>formateur</th>
                <th><button type="button" name="add" id="add2" class="btn btn-success" >+</button></th>
                <th colspan="2" >Action</th>
            </tr>
         </div>
            ';
        }



        if (mysqli_num_rows($result)>0) {
                while($row = mysqli_fetch_array($result)){

                    echo "<tr class='edit_tr' data-id='".$etat."' data-id2='".$row["id"]."'>";

                //    echo "<div class='edit_tr' data-id2='".$row["id"]."'>";
                    echo" <td  ><span id='datedebut1".$row["id"]."' class='text' type='text'>".$row["date_debut"]."</span>
                    <input type='date' value='".$row["date_debut"]."' class='editbox' id='datedebut2".$row["id"]."'  /&gt;
                    </td>";
                     //
                     echo" <td  ><span id='datefin1".$row["id"]."' class='text' type='text'>".$row["date_fin"]."</span>
                    <input type='date' value='".$row["date_fin"]."' class='editbox' id='datefin2".$row["id"]."'  /&gt;
                    </td>";
                     //
                     echo" <td  ><span id='objet1".$row["id"]."' class='text'>".$row["objet"]."</span>
                     <input type='text' value='".$row["objet"]."' class='editbox' id='objet2".$row["id"]."'  /&gt;
                     </td>";
                    //
                     echo" <td  ><span id='lieu1".$row["id"]."' class='text'>".$row["lieu"]."</span>
                     <input type='text' value='".$row["lieu"]."' class='editbox' id='lieu2".$row["id"]."'  /&gt;
                     </td>";

                     //
                     echo" <td  ><span id='format1".$row["id"]."' class='text'>".$row["formateur"]."</span>
                        <input type='text' value='".$row["formateur"]."' class='editbox' id='format2".$row["id"]."'  /&gt;
                     </td>";


          //buttons stuff
          echo "<td><i class='far fa-edit' style='font-size:36px'></i></td>";

       if($etat!=2)
                        {echo "<td><button type='button' class='del1'  data-id2='".$row["id"]."' class='btn-danger'>Delete</button></td>";}

                        echo "</tr>";
                }
        }
echo "</table>";
        ?>
    </div>
    <input type="hidden" id='hiddeninp'value='<?php echo $id_p ?>'>

</body>
</html>
