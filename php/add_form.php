<?php
session_start();
include ('class/User.class.php');
include ('include/connect.php');
if (! empty ( $_POST )) {
	var_dump($_POST);
	try {
		// On se connecte à MySQL
		$bdd = new PDO ( 'mysql:host=localhost;dbname=uniforms', 'root', 'root' );
	} catch ( Exception $e ) {
		// En cas d'erreur, on affiche un message et on arrête tout
		die ( 'Erreur : ' . $e->getMessage () );
	}
	
	$user = new User($_SESSION['user_id']);
	$newForm = $user->createForm();
	if (isset($_POST['enregistrer'])) {
	   //Enregistre
   }
   if (isset($_POST['valider'])) {
     $newForm->validateForm();
   }
   
	header ( "Location: home.php" );
}
?>
