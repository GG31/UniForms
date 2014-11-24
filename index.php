<!doctype html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="res/img/favicon.png" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
<body>

	<!--start container-->
	<div id="container">

		<!--start header-->
		<header>

			<!--start logo-->
			<a href="index.php" id="logo"><img
				src="res/img/logo_UNS_couleurs_web.png" alt="logo" /></a>
			<!--end logo-->

			<!--start menu-->

			<!--end menu-->

			<!--end header-->
		</header>

		<!--start intro-->

		<div id="intro">
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
   </div>
		<!--end intro-->
		<?php include('include/header.php'); ?>
   <!--start holder-->
		<?php include('include/connexion.php'); ?>
		<!-- fin du formulaire -->
	</div>
	<!--end container-->

	<!--start footer-->
		<?php include('include/footer.php'); ?>
   <!--end footer-->
</body>
</html>
