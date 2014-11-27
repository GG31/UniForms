<?php
include_once ('include/includes.php');
if (! empty ( $_POST )) {
	var_dump($_POST);
	$destinataires = array();
	foreach ($_POST as $key => $value) {
	   $first = explode("_", $key);
	   if ($first[0] == "checkboxDestinataire") {
	      array_push($destinataires, new User($value));
	   }
   }
   
   try {
		// On se connecte à MySQL
		$bdd = new PDO ( 'mysql:host=localhost;dbname=uniforms', 'root', 'root' );
	} catch ( Exception $e ) {
		// En cas d'erreur, on affiche un message et on arrête tout
		die ( 'Erreur : ' . $e->getMessage () );
	}
	
	
	$newForm = new Form();
	$newForm->setCreator(new User($_SESSION["user_id"]));
	$newForm->setRecipient($destinataires);
	if (isset($_POST['enregistrer'])) {
	   //Enregistre
	   $newForm->setState(0);
   }
   if (isset($_POST['valider'])) {
      $newForm->setState(1);
     //$newForm->validateForm();
   }
   echo 'save<br>';
   $newForm->save();
   echo "YOUPI !!!";
	//header ( "Location: home.php" );
}
?>
