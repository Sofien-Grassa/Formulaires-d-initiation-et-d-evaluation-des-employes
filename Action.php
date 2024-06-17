<?php
include 'phpfunction.php';
$Personnel = new Personnel();
if(isset($_POST['action']) == 'delete_invoice' && isset($_POST['id'])) {
	$Personnel->deleteInvoice($_POST['id']);	
	$jsonResponse = array(
		"status" => 1	
	);
	echo json_encode($jsonResponse);
}
elseif(isset($_GET['action']) == 'logout') {
session_unset();
session_destroy();
header("Location:Home");
}
?>