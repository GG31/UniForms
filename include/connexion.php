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
	$reponse = $bdd->query ( 'SELECT * FROM user' );
	while ( $donnees = $reponse->fetch () ) {
		if ($donnees ['login'] == $_POST ['login'] and $donnees ['password'] == md5 ( $_POST ['password'] )) {
			$_SESSION['user'] = $donnees ['id'];
			$_SESSION['nom_user'] = $donnees ['nom'];
			$_SESSION['prenom_user'] = $donnees ['prenom'];
			// echo "<center><B>Bienvenue Monsieur ".$donnees['nom']."</B></center>";
			header ( "Location: accueil.php" );
		} else {
			echo "<b><center style='color: red;'>Erreur : Login ou Mot de passe</center></B>";
		}
	}
	$reponse->closeCursor ();
}
?>  