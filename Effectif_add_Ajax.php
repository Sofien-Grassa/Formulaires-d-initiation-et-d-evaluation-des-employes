<?php
include 'Effectif_add_function.php';
$Personnel = new Personnel();
		if (isset($_POST['Mat'])){

			if(isset($_POST)) {
				$bird_name_id = $_POST['Mat'];
				$new_data = explode(":", $bird_name_id);
				$birdName = $new_data[1];
				$birdId = $new_data[0];
				$a="'";
				$Nam =$a . $birdName;
				$Namedep =$Nam . $a;
				$Personnel = new Personnel();
				$result=$Personnel->getService($birdId);

				return 	$result;
			}

		}
?>