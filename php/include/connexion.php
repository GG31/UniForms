<?php
session_start();
if (! empty ( $_POST )) {
	/*try {
		// On se connecte à MySQL
		//$bdd = new PDO ( 'mysql:host=localhost;dbname=uniforms', 'root', 'root' );
	} catch ( Exception $e ) {
		// En cas d'erreur, on affiche un message et on arrête tout
		die ( 'Erreur : ' . $e->getMessage () );
	}

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
	if($_POST ['login'] == "u1"){
		$_SESSION['user_id'] = 1;
		header ( "Location: php/home.php" );
	}else if($_POST ['login'] == "u2"){
		$_SESSION['user_id'] = 2;
		header ( "Location: php/home.php" );
	}else{
		header ( "Location: index.php" );
	}
}
?>  