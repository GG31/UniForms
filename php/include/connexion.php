<?php
session_start();
include("connect.php");
if (! empty ( $_POST )) {
/*
	$reponse = $bdd->query ( 'SELECT * FROM user' );	
	while ( $donnees = $reponse->fetch () ) {
		if ($donnees ['login'] == $_POST ['login'] and $donnees ['password'] == md5 ( $_POST ['password'] )) {
			$_SESSION['user'] = $donnees ['id'];
			$_SESSION['nom_user'] = $donnees ['nom'];
			$_SESSION['prenom_user'] = $donnees ['prenom'];
			header ( "Location: accueil.php" );
		} else {
			// Function error
		}
	}
	$reponse->closeCursor ();*/

	// LOT 2 : fake users
	if($_POST ['login'] == "admin"){
		$_SESSION['user_id'] = 1;
	}else if($_POST ['login'] == "romain"){
		$_SESSION['user_id'] = 2;
	}
	header ( "Location: php/accueil.php" );
}
?>  