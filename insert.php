<?php

    $connect = mysqli_connect("localhost", "root", "root", "stipdb");

    if(isset($_POST["nom"]))
    {
        $Mle = $_POST["Mle"];   
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $date_naissance = $_POST["date_naissance"];
        $date_embauche = $_POST["date_embauche"];
        $affectation = $_POST["affectation"];
        $qualification= $_POST["qualification"];
        $etat = $_POST["etat"];
        
        $query = '';
       
        for($count = 0; $count<count($nom); $count++){
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
    }
?>