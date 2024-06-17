<?php

   $conn = mysqli_connect("localhost", "root", "root", "stipdb");

   extract($_POST);

   if($id_l==""){
   $qry="INSERT INTO evaluation(id_p,evaluation1,evaluation2,evaluation3,evaluation4,evaluation5,total,competence,formation_compl)VALUES('".$id_p."', '".$note1."', '".$note2."', '".$note3."', '".$note4."', '".$note5."', '".$somm."', '".$competence."', '".$formation_compl."')";
   $insert=mysqli_query($conn,$qry);}
   else{
     $sql="UPDATE `evaluation` SET `evaluation1`='$note1',`evaluation2`='$note2',`evaluation3` = '$note3',`evaluation4` = '$note4',`evaluation5` = '$note5',`total`='$somm',`competence`='$competence',`formation_compl`='$formation_compl' WHERE `evaluation`.`id` = $id_l";
    echo $sql;
     mysqli_query($conn,$sql);
   }
   
       /* 
        $query = '';
       
        for($count = 0; $count<count($note); $count++){
            $Mle_clean = mysqli_real_escape_string($connect, $Mle);
            $nom_clean = mysqli_real_escape_string($connect, $nom[$count]);
            $prenom_clean = mysqli_real_escape_string($connect, $prenom[$count]);
            $date_naissance_clean = mysqli_real_escape_string($connect, $date_naissance[$count]);
           // $niveau_etude_clean = mysqli_real_escape_string($connect, $niveau_etude[$count]);
            $date_embauche_clean = mysqli_real_escape_string($connect, $date_embauche[$count]);
            $affectation_clean = mysqli_real_escape_string($connect, $affectation[$count]);
            $qualification_clean = mysqli_real_escape_string($connect, $qualification[$count]);
            $etat_clean = mysqli_real_escape_string($connect, $etat);

            if($nom_clean != '' && $prenom_clean != '' && $date_naissance_clean != '' && $date_embauche_clean != ''&& $affectation_clean != ''&& $qualification_clean != ''){
                $query .= 'INSERT INTO t_fi001_parent(Mle,nom,prenom, date_naissance, date_embauche,affectation,qualification,etat) VALUES("'.$Mle_clean.'","'.$nom_clean.'", "'.$prenom_clean.'", "'.$date_naissance_clean.'","'.$date_embauche_clean.'","'. $affectation_clean.'","'. $qualification_clean.'","'. $etat_clean.'");';
            }
        }
       
        if($query != ''){
               
            if(mysqli_multi_query($connect, $query)){
                echo 'Users Data Inserted successfully';
            }else{
                echo 'Error';
            }
        }else{
            echo 'All Fields are Required';
        }
    }*/
?>