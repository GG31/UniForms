<?php
session_start();
if (! empty ( $_POST )) {
	// var_dump($_POST);
	try {
		// On se connecte à MySQL
		$bdd = new PDO ( 'mysql:host=localhost;dbname=uniforms', 'root', 'root' );
	} catch ( Exception $e ) {
		// En cas d'erreur, on affiche un message et on arrête tout
		die ( 'Erreur : ' . $e->getMessage () );
	}
	
	$req = $bdd->prepare('INSERT INTO forms  SET id_user = :user');
	
	$req->bindValue(':user', $_SESSION['user'], PDO::PARAM_INT);
	$req->execute() or die(print_r($req->errorInfo()));
	
	header ( "Location: accueil.php" );
}
?>
