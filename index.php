<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UniForms</title>
		<link rel="shortcut icon" href="res/img/favicon.png" />
		<link rel="stylesheet" href="lib/bootstrap-3.3.1/min.css" type="text/css" />
		<link rel="stylesheet" href="css/styles.css" type="text/css" />

		<script src="lib/jquery-2.1.1/min.js"></script>
		<script src="lib/bootstrap-3.3.1/min.js"></script>
	</head>
	<body>
		<?php include 'php/include/connexion.php'; ?>
		<div class="container">
			<div class="row">
				<?php include('php/include/header.php'); ?>
			</div>
			<form class="form-horizontal" role="form" action="index.php" method="post"> <!-- No need for .row with .form-horizontal-->
				<div class="form-group">
					<label for="login" class="col-sm-2 control-label">Identifiant</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="login" name="login" placeholder="Identifiant">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Mot de Passe</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="password" name="password" placeholder="Mot de Passe">
					</div>
				</div>
				<div class="form-group">
   					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Connection</button>
					</div>
				</div>
			</form>
			<div class="row">
				<?php include('php/include/footer.php'); ?>
			</div>
		</div>
	</body>
</html>
