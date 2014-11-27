<?php
session_start();
include ('include/includes.php');
if (! empty ( $_POST )) {
	var_dump($_POST);
	$destinataires = array();
	foreach ($_POST as $key => $value) {
	   $first = explode("_", $key);
	   if ($first[0] == "checkboxDestinataire") {
	      array_push($destinataires, $value);
	   }
   }
   
   try {
		// On se connecte à MySQL
		$bdd = new PDO ( 'mysql:host=localhost;dbname=uniforms', 'root', 'root' );
	} catch ( Exception $e ) {
		// En cas d'erreur, on affiche un message et on arrête tout
		die ( 'Erreur : ' . $e->getMessage () );
	}
	
	$user = new User($_SESSION['user_id']);
	$newForm = $user->createForm();
	$newForm->setDest($destinataires);
	if (isset($_POST['enregistrer'])) {
	   //Enregistre
   }
   if (isset($_POST['valider'])) {
     $newForm->validateForm();
   }
   
	header ( "Location: home.php" );
}
?>
