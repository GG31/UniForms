<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UniForms</title>
		<link rel="shortcut icon" href="res/img/favicon.png" />
		<link rel="stylesheet" href="lib/bootstrap-3.3.1/min.css" type="text/css" />
		<!--<link rel="stylesheet" href="css/styles.css" type="text/css" />-->

		<script src="lib/jquery-2.1.1/min.js"></script>
		<script src="lib/bootstrap-3.3.1/min.js"></script>
	</head>
	<body>
	<?php include 'include/connexion.php'; ?>
	<?php include('include/header.php'); ?>

	<form action="index.php" method="post">
		<div class="form-group">
			<label for="login">Identifiant</label>
			<input type="text" class="form-control" id="login" name="login" placeholder="Login">
		</div>
		<div class="form-group">
			<label for="password">Mot de Passe</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Mot de Passe">
		</div>
		<button type="submit" class="btn btn-default">Connection</button>
	</form>

	<!--
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
	-->
			<?php include('include/footer.php'); ?>
	</body>
</html>
