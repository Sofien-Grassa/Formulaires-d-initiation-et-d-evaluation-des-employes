<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="plzz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
.modal-place{
    overflow-x:auto;
}
.largercheckbox{

            width: 60px;
            height: 30px;
            padding-left:150px;
        }
</style>
</html>
<?php


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "stipdb";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
 mysqli_set_charset($conn,"utf8");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());

}
  header('Content-Type: text/html; charset=utf-8');
include 'Effectif_add_function.php';
  $Personnel = new Personnel();
  include 'connection.php';
        switch($_GET['action']) {
            case 'FI002':

                $mat=$_GET['Mle'];
                $id_p=$_GET['id'];
                $q="SELECT Per.ID,Per.Mle,Per.Nom,Per.Prenom,Pos.Nom_Dep,Per.Date_N,Per.Date_Entre_Etab,Pos.Qualification,Pos.Nom_Dep
                FROM t_personnels AS Per LEFT OUTER JOIN t_postes AS Pos ON Per.Mle=Pos.Mle AND Pos.Active=1 WHERE Per.Motif_Sortie IS NULL AND Per.Date_Sortie_Etab IS NULL AND Per.Mle = $mat ORDER BY CAST(Per.`Mle` as unsigned) ASC";
                $res=mysqli_query($conn, $q);
                 $row = mysqli_fetch_array($res);
                 $output ='
                 <div class="modal-place">
                 <table class="table text-center table-striped table-bordered" id="crud_table">
                 <tr>

                     <th>Nom</th>
                     <th>Prenom</th>
                     <th>Matricule</th>
                     <th>date_naissance</th>
                     <th>date_Entre_Etab</th>
                     <th>Nom departement</th>
                     <th>qualification</th>
                 </tr>
                 <tr>
                 <td >'.  $row["Mle"]. '</td>
                 <td >'. $row["Nom"] . '</td>
                 <td >'. $row["Prenom"]. '</td>
                 <td >'. $row["Date_N"]. '</td>
                 <td >'. $row["Date_Entre_Etab"]. '</td>
                 <td >' . $row["Nom_Dep"]. '</td>
                 <td >' . $row["Qualification"] . '</td>
             </tr>
             </table>
             </div>
             ';
             $q3="SELECT etat from t_fi001_parent where id=$id_p";
             $res3=mysqli_query($conn,$q3);
             $row3= mysqli_fetch_array($res3);
             $q2="SELECT * FROM evaluation WHERE id_p= $id_p";
             $res2=mysqli_query($conn,$q2);
             $num_rows = mysqli_num_rows($res2);
             $row = mysqli_fetch_array($res2);

             if($num_rows > 0) {
               echo"<input type='hidden' id='id_l' value= ".$row['id']."> ";
             $output.="<h3>Cocher la case correspondante:</h3>";
             $output.='
             <div class="modal-place">
             <table class="table text-center table-striped table-bordered" id="crud_table">
             <tr>
             <th >CRITERES D APPRECIATION</th>
             <th>Tres Satisfaisant<br>20pts</th>
             <th>Satisfaisant<br>15pts</th>
             <th>Passable<br>10pts</th>
             <th>Faible<br>5pts</th>
         </tr>
         <tr>
         <th >Degre de maitrise des moyens de travail et des technique mis à la disposition de l agent</th>';
         if ($row['evaluation1']==20){
            $output.=' <th><input type="radio" name="hi1" class="note" value="20"  checked/></th>';
         }
         else
         {     $output.='   <th><input type="radio" name="hi1" class="note" value="20" /></th>';
         }
         if ($row['evaluation1']==15){
            $output.=' <th><input type="radio" name="hi1" class="note" value="15"  checked/></th>';
         }
         else
         {     $output.='   <th><input type="radio" name="hi1" class="note" value="15" /></th>';
         }
         if ($row['evaluation1']==10){
            $output.=' <th><input type="radio" name="hi1" class="note" value="10" checked/></th>';
         }
         else
         {     $output.='   <th><input type="radio" name="hi1" class="note" value="10" /></th>';
         }
         if ($row['evaluation1']==5){
            $output.=' <th><input type="radio" name="hi1" class="note" value="5" checked/></th>';
         }
         else
         {     $output.='   <th><input type="radio" name="hi1" class="note" value="5" /></th>';
         }


         $output.=' </tr>
     <tr>
     <th >Appreciation de la qualite de travail</th>';
     if ($row['evaluation2']==20){
        $output.=' <th><input type="radio" name="hi2" class="note" value="20"  checked/></th>';
     }
     else
     {     $output.='   <th><input type="radio" name="hi2" class="note" value="20" /></th>';
     }
     if ($row['evaluation2']==15){
        $output.=' <th><input type="radio" name="hi2" class="note" value="15" checked/></th>';
     }
     else
     {     $output.='   <th><input type="radio" name="hi2" class="note" value="15" /></th>';
     }
     if ($row['evaluation2']==10){
        $output.=' <th><input type="radio" name="hi2" class="note" value="10"  checked/></th>';
     }
     else
     {     $output.='   <th><input type="radio" name="hi2" class="note" value="10" /></th>';
     }
     if ($row['evaluation2']==5){
        $output.=' <th><input type="radio" name="hi2" class="note" value="5"  checked/></th>';
     }
     else
     {     $output.='   <th><input type="radio" name="hi2" class="note" value="5" /></th>';
     }

     $output.=' <tr>
 <th >Capacite decoute et d assimilation</th>';
 if ($row['evaluation3']==20){
    $output.=' <th><input type="radio" name="hi3" class="note" value="20"  checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi3" class="note" value="20" /></th>';
 }
 if ($row['evaluation3']==15){
    $output.=' <th><input type="radio" name="hi3" class="note" value="15" checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi3" class="note" value="15" /></th>';
 }
 if ($row['evaluation3']==10){
    $output.=' <th><input type="radio" name="hi3" class="note" value="10"  checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi3" class="note" value="10" /></th>';
 }
 if ($row['evaluation3']==5){
    $output.=' <th><input type="radio" name="hi3" class="note" value="5"  checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi3" class="note" value="5" /></th>';
 }

 $output.='</tr>
<tr>
<th >Capacite damelioration</th>';
if ($row['evaluation4']==20){
    $output.=' <th><input type="radio" name="hi4" class="note" value="20" checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi4" class="note" value="20" /></th>';
 }
 if ($row['evaluation4']==15){
    $output.=' <th><input type="radio" name="hi4" class="note" value="15" checked/></th>';
  } else
 {     $output.='   <th><input type="radio" name="hi4" class="note" value="15" /></th>';
 }
 if ($row['evaluation4']==10){
    $output.=' <th><input type="radio" name="hi4" class="note" value="10" checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi4" class="note" value="10" /></th>';
 }

 if ($row['evaluation4']==5){
    $output.=' <th><input type="radio" name="hi4" class="note" value="5" checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi4" class="note" value="5" /></th>';
 }

 $output.=' </tr>
<tr>
<th >Evolution de lapprentissage</th>';
if ($row['evaluation5']==20){
    $output.=' <th><input type="radio" name="hi5" class="note" value="20"   checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi5" class="note" value="20" /></th>';
 }
 if ($row['evaluation5']==15){
    $output.=' <th><input type="radio" name="hi5" class="note" value="15" checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi5" class="note" value="15" /></th>';
 }
 if ($row['evaluation5']==10){
    $output.=' <th><input type="radio" name="hi5" class="note" value="10"  checked/></th>';
 }
 else
 {     $output.='   <th><input type="radio" name="hi5" class="note" value="10" /></th>';
 }
 if ($row['evaluation5']==5){
 $output.=' <th><input type="radio" name="hi5" class="note" value="5"   checked/></th>';
  } else
 {     $output.='   <th><input type="radio" name="hi5" class="note" value="5"  /></th>';
 }

 $output.='</tr>
<tr>
<th > TOTAL</th>
<th><p id="affiplz">'.$row['total'].'</p></th>
<th colspan="3">seuil acceptable:60</th>
</tr>
</table>';
echo"<input name='Mle'  id='Mle_FI001' value='$mat'type='hidden'> ";
$output.='<h4>L interesse doit il developper autre competences liees a ses taches ? </h4>';
if ($row['competence']=="oui"){
   $output.= ' <label>OUI</label> <input type="radio" id="caseoui" data-id2="oui" name="a" checked >';
}
else{
   $output.= ' <label>OUI</label> <input type="radio" id="caseoui" data-id2="oui" name="a"  >';
}
if ($row['competence']=="non"){
   $output.='<label>NON</label> <input type="radio" id="casenon" data-id="non" name="a" checked >';
}
else{
   $output.='<label>NON</label> <input type="radio" id="casenon" data-id="non" name="a"  >';
}
$output.='<h4>L une période de formation complémentaire lui est-il indispensable ? </h4>';
if ($row['formation_compl']=="oui"){
   $output.='<label>OUI</label> <input type="radio" id="caseoui2" data-id3="oui" name="b" checked >';
}
else{
   $output.='<label>OUI</label> <input type="radio" id="caseoui2" data-id3="oui" name="b"  >';
}

if ($row['formation_compl']=="non"){
   $output.=' <label>NON</label><input type="radio" id="casenon2" data-id4="non" name="b" checked >';
}
else{
   $output.=' <label>NON</label><input type="radio" id="casenon2" data-id4="non" name="b"  >';
}


$output.='<br/><button id="save2" data-id="'.$row3[0].'">save</button>
</div>';
 echo $output;
        }
        else{
         echo"<input name='Mle'  id='Mle_FI001' value='$mat'type='hidden'> ";
            $output.="<h3>Cocher la case correspondante:</h3>";
            $output.='
            <div class="modal-place">
            <table class="table text-center table-striped table-bordered" id="crud_table">
            <tr>
            <th >CRITERES D APPRECIATION</th>
            <th>Tres Satisfaisant<br>20pts</th>
            <th>Satisfaisant<br>15pts</th>
            <th>Passable<br>10pts</th>
            <th>Faible<br>5pts</th>

        </tr>
        <tr>

        <th >Degre de maitrise des moyens de travail et des technique mis à la disposition de l agent</th>
        <th><input type="radio" name="hi1" class="note" value="20"/></th>
        <th><input type="radio" name="hi1" class="note" value="15"/></th>
        <th><input type="radio" name="hi1"  class="note" value="10" /></th>
        <th><input type="radio" name="hi1"  class="note"  value ="5"/></th>

    </tr>
    <tr>

    <th >Appreciation de la qualite de travail</th>
    <th><input type="radio" name="hi2" value="20" class="note"  /></th>
    <th><input type="radio" name="hi2" value="15" class="note"   /></th>
    <th><input type="radio" name="hi2"  value="10" class="note"  /></th>
    <th><input type="radio" name="hi2"  value ="5" class="note"/></th>

</tr>
<tr>

<th >Capacite decoute et d assimilation</th>
<th><input type="radio" name=hi3 value="20" class="note" /></th>
<th><input type="radio" name=hi3  value="15" class="note"  /></th>
<th><input type="radio" name=hi3 value="10"  class="note" /></th>
<th><input type="radio" name=hi3  value ="5" class="note" /></th>

</tr>
<tr>

<th >Capacite damelioration</th>
<th><input type="radio" name="hi4" class="note"  value="20"/></th>
<th><input type="radio" name="hi4" class="note" value="15" /></th>
<th><input type="radio" name="hi4" class="note"  value="10"/></th>
<th><input type="radio" name="hi4"  class="note" value ="5" /></th>

</tr>
<tr>

<th >Evolution de lapprentissage</th>
<th><input type="radio"  name="hi5" class="note"  value="20"/></th>
<th><input type="radio"  name="hi5" class="note"  value="15"/></th>
<th><input type="radio"  name="hi5" value="10" class="note" /></th>
<th><input type="radio" name="hi5"  value ="5" class="note" /></th>

</tr>
<tr>
<th > TOTAL</th>
<th><p id="affiplz"></p></th>
<th colspan="3">seuil acceptable:60</th>
</tr>
</table>';

       $output.='<h4>L interesse doit il developper autre competences liees a ses taches ? </h4>
     <label>OUI</label>  <input type="radio" id="caseoui" data-id2="oui" name="a">
     <label>NON</label>  <input type="radio" id="casenon"   data-id="non" name="a">';


       $output.='<h4>L une période de formation complémentaire lui est-il indispensable ? </h4>
     <label>OUI</label>  <input type="radio" id="caseoui2"   data-id3="oui" name="b">
     <label>NON</label>  <input type="radio" id="casenon2"   data-id4="non"  name="b"></br>
     <button id="save2" data-id="'.$row3[0].'">save</button>';





            echo $output;
       }

break;

    }
    echo"<input  id='id_p' value='$id_p'type='hidden'> ";


?>


<script>

        $(document).on('change', '.note', function(){
            plz();
        })
function plz(){
        $note1=0,$note2=0,$note3=0,$note4=0,$note5=0;
        $somm=0;
        $note1 = parseInt($('input[name="hi1"]:checked').val());
        $note2 = parseInt($('input[name="hi2"]:checked').val());
        $note3 = parseInt($('input[name="hi3"]:checked').val());
        $note4 = parseInt($('input[name="hi4"]:checked').val());
        $note5 = parseInt($('input[name="hi5"]:checked').val());

    if ($note1&&$note2&&$note3&&$note4&&$note5) {
        $somm=$note1+$note2+$note3+$note4+$note5;
                $('#affiplz').text($somm);
    }
}


$('#save2').click(function(){


   var etat=$(this).attr('data-id');
   if(etat!=2){
   var id_l= $("#id_l").val();
    $mat= $("#Mle_FI001").val();
    var id_p= $("#id_p").val();

    if($('#caseoui').is(':checked')){
   $competence="oui";
}
else{
   $competence="non"
}
if($('#caseoui2').is(':checked')){
   $formation_compl="oui";
}
else{
   $formation_compl="non"
}
$note1 = parseInt($('input[name="hi1"]:checked').val());
        $note2 = parseInt($('input[name="hi2"]:checked').val());
        $note3 = parseInt($('input[name="hi3"]:checked').val());
        $note4 = parseInt($('input[name="hi4"]:checked').val());
        $note5 = parseInt($('input[name="hi5"]:checked').val());
        $somm=$note1+$note2+$note3+$note4+$note5;
    $.ajax({
    url:"insert-fi02.php",
    method:"POST",
    data:{id_l:id_l,competence:$competence,formation_compl:$formation_compl,id_p:id_p,mat:$mat, note1:$note1, note2:$note2, note3:$note3, note4:$note4, note5:$note5, somm:$somm},
        success:function(data){
            alert('inserted');
        }
        })

      }
      else{
         alert_toast("IMPOSSIBLE DE MODIFIER LES DONNEES",'danger')
      }

      });

 </script>
