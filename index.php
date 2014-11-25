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
include 'include/connexion.php';
?>  
   </div>
		<!--end intro-->
		<?php include('include/header.php'); ?>
   		<!--start holder-->
		<div id="cont">
			<div id="connexion">
				<!-- bloc contenant le formulaire -->
				<form name="connexionForm" id="connexionForm" action="index.php"
					method="post">
					<!-- début du formulaire de connexion -->
					<fieldset>
						<legend>Connexion</legend>
						<!-- titre du formulaire -->
						<p>

							<span id="erreur"></span>
							<!-- span qui contiendra les éventuels messages d'erreur -->

						</p>
						<p>
							<label for="login">Login :</label> <input type="login" name="login"
								id="login" />
							<!-- champ pour le login -->
						</p>

						<p>
							<label for="passe">Mot de passe :</label> <input type="password"
								name="password" id="password" />
							<!-- champ pour le mot de passe -->
						</p>

						<p class="center">
							<input type="submit" value=" Je me connecte" class="bouton" />
							<!-- bouton de connexion -->
						</p>
						<p color="#808080">
							<a href="#"> > Mot de passe oublié ?</a>
						</p>
					</fieldset>
				</form>
				<!-- fin du formulaire -->
			</div>
		</div>

		<!-- fin du formulaire -->
	</div>
	<!--end container-->

	<!--start footer-->
		<?php include('include/footer.php'); ?>
   <!--end footer-->
</body>
</html>
