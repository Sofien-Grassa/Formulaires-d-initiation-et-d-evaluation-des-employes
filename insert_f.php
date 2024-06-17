<?php

    $connect = mysqli_connect("localhost", "root", "root", "stipdb");
    // print_r($_POST);
    
 
    if(isset($_POST["date_debut"]))
    {
        $id_p = $_POST["id_p"]; 
        $date_debut = $_POST["date_debut"];   
        $date_fin = $_POST["date_fin"];
        $objet= $_POST["objet"];
        $lieu = $_POST["lieu"];
        $formateur = $_POST["formateur"];
        $type_F = $_POST["type_F"];
     

        
        $query = '';
       
        for($count = 0; $count<count($date_debut); $count++){
            $id_clean = mysqli_real_escape_string($connect, $id_p);
            $date_debut_clean = mysqli_real_escape_string($connect, $date_debut[$count]);
            $date_fin_clean = mysqli_real_escape_string($connect, $date_fin[$count]);
            $objet_clean = mysqli_real_escape_string($connect, $objet[$count]);
           // $niveau_etude_clean = mysqli_real_escape_string($connect, $niveau_etude[$count]);
            $lieu_clean = mysqli_real_escape_string($connect, $lieu[$count]);
            $formateur_clean = mysqli_real_escape_string($connect, $formateur[$count]);
           $type_clean = mysqli_real_escape_string($connect, $type_F);
            if($date_debut_clean != '' && $date_fin_clean != '' && $objet_clean != '' && $lieu_clean != ''&& $formateur_clean != ''&& $type_clean != ''){
                $query .= 'INSERT INTO t_fi001_detail(id_p,date_debut,date_fin,objet,lieu,formateur,type_F) VALUES("'. $id_clean.'","'.$date_debut_clean.'", "'.$date_fin_clean.'", "'.$objet_clean.'","'.$lieu_clean.'","'. $formateur_clean.'","'. $type_clean.'");';
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
    }
?>