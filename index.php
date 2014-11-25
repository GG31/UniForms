<!doctype html>
<?php include 'include/connexion.php'; ?>
<head>
	<meta charset="UTF-8">
	<title>UniForms</title>
	<link rel="shortcut icon" href="res/img/favicon.png" />
	<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
	<div id="container">
		<?php include('include/header.php'); ?>
		<div id="cont">
			<div id="connexion">
				<form name="connexionForm" id="connexionForm" action="index.php" method="post">
					<fieldset>
						<legend>Connexion</legend>
						<p>
							<label for="login">Login :</label> <input type="login" name="login" id="login" />
						</p>

						<p>
							<label for="passe">Mot de passe :</label> <input type="password" name="password" id="password" />
						</p>
						<p class="center">
							<input type="submit" value="Connection" class="bouton" />
						</p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
		<?php include('include/footer.php'); ?>
</body>
</html>
